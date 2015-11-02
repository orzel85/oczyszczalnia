<?php

$path = dirname(__FILE__) . '\\excel_reader2.php';
require_once($path);

$path = dirname(__FILE__) . '\\cols.php';
require_once($path);

class countInvoice {

    private $xls;
    private $cols;
    private $dataArray;

    public function __construct($filename) {
        $this->xls = new Spreadsheet_Excel_Reader($filename);
        $this->cols = new cols();
//        echo $this->xls->val(2, $this->getColLetterByNumber(45));
    }

    public function startCount() {
//        echo "<pre>";
        $objectNamesList = array();
        for($sheetIndex = 0; $sheetIndex <= 1 ; $sheetIndex++) {
            for ($row = 4; $row <= 113; $row++) {
                $colNumber = 5;
                $nextStop = false;
                $counter = 0;
                $objectName = $this->xls->val($row, 'B') . '-' . $this->xls->val($row, 'D', $sheetIndex);
                $objectNamesList[] = $objectName;
                while (!$nextStop) {
                    $counter++;
                    $columnLetter = $this->getColLetterByNumber($colNumber);
                    $invoiceData = $this->createStructure($row, $columnLetter, $colNumber, $sheetIndex);
                    if ( !is_null($invoiceData['sum']) ) {
                        $this->dataArray[$objectName]['baseList'][] = $invoiceData;
                    }
                    $colNumber += 4;
                    if ($columnLetter === 'io' || $counter > 1000) {
                        $nextStop = true;
                    }
                }
            }
        }
        $this->setBaseInvoices();
        $this->setCorrections();
//        var_dump($this->dataArray);
//        foreach($this->dataArray as $objectName => $object) {
//            var_dump('================================================');
//            var_dump($objectName, $object['baseInvoices']);
//        }
        $preaparedArray = $this->prepareReturn();
//        $this->searchDoubled($objectNamesList);
        return $preaparedArray;
    }

    private function searchDoubled($objectNames) {
//        var_dump(count($objectNames));
        $unique = array_unique($objectNames);
//        var_dump(count($unique));
        $countArray = array();
        foreach ($objectNames as $objectName) {
            if (!key_exists($objectName, $countArray)) {
                $countArray[$objectName] = 1;
            } else {
                $countArray[$objectName] ++;
            }
        }
//        var_dump($countArray);
        foreach ($countArray as $name => $count) {
            if ($count > 1) {
//                var_dump($name, $count);
            }
        }
    }

    private function prepareReturn() {
        $return = array();
        foreach ($this->dataArray as $objectName => $object) {
//            var_dump($object['baseInvoices']);
            $totalInvoice = array(
                'sum' => 0 ,
                'tarif1' => 0 ,
                'tarif2' => 0 ,
                'tarif3' => 0 ,
            );
            foreach ($object['baseInvoices'] as $invoicesList) {
                $lastInvoice = end($invoicesList);
                $totalInvoice['sum'] += $lastInvoice['sum'];
                $totalInvoice['tarif1'] += $lastInvoice['tarif1'];
                $totalInvoice['tarif2'] += $lastInvoice['tarif2'];
                $totalInvoice['tarif3'] += $lastInvoice['tarif3'];
            }
            $return[$objectName] = $totalInvoice;
        }
        return $return;
    }

    private function setCorrections() {
        foreach ($this->dataArray as $objectName => &$object) {
            foreach ($object['baseInvoices'] as $baseInvoiceNumber => $invoicesList) {
                $found = false;
                $lastInvoiceNumberFound = $baseInvoiceNumber;
                do {
                    foreach ($object['baseList'] as $invoice) {
                        if ($invoice['invoiceCorrectionTo'] == $lastInvoiceNumberFound) {
                            $this->dataArray[$objectName]['baseInvoices'][$baseInvoiceNumber][] = $invoice;
                            $lastInvoiceNumberFound = $invoice['invoiceNumber'];
                            $found = true;
//                            return;
                            continue;
                        }
                    }
                    $found = false;
                } while ($found);
            }
        }
    }

    private function setBaseInvoices() {
        foreach ($this->dataArray as $objectName => $object) {
            foreach ($object['baseList'] as $invoice) {
                if (is_null($invoice['invoiceCorrectionTo'])) {
                    $this->dataArray[$objectName]['baseInvoices'][$invoice['invoiceNumber']][] = $invoice;
                }
            }
        }
    }

    private function createStructure($row, $columnLetter, $colNumber, $sheetIndex) {
        $invoiceName = $this->getValLetterVersion(2, $columnLetter, $sheetIndex);
        $return = array(
            'invoiceName' => $invoiceName,
            'invoiceDate' => $this->getValLetterVersion(1, $columnLetter, $sheetIndex),
            'invoiceNumber' => $this->getInvoiceNumber($invoiceName),
            'invoiceCorrectionTo' => $this->getInvoiceCorrectionToNumber($invoiceName),
            'sum' => $this->getVal($row, $colNumber, $sheetIndex),
            'tarif1' => $this->getVal($row, $colNumber + 1, $sheetIndex),
            'tarif2' => $this->getVal($row, $colNumber + 2, $sheetIndex),
            'tarif3' => $this->getVal($row, $colNumber + 3, $sheetIndex),
        );
        return $return;
    }

    private function getInvoiceCorrectionToNumber($invoiceName) {
        if (strpos($invoiceName, 'korekta') !== false) {
            $tab = explode('korekta', $invoiceName);
            $fakturaTab = explode('/', $tab[1]);
            $last = $fakturaTab[count($fakturaTab) - 1];
            $last = trim($last);
            $last = (int) $last;
            return $last;
        }
        return null;
    }

    private function getInvoiceNumber($invoiceName) {
        if (strpos($invoiceName, 'korekta') !== false) {
            $tab = explode('korekta', $invoiceName);
            $fakturaTab = explode('/', $tab[0]);
            $last = $fakturaTab[count($fakturaTab) - 1];
            $last = str_ireplace(',', '', $last);
            $last = trim($last);
            $last = (int) $last;
            return $last;
        }
        $fakturaTab = explode('/', $invoiceName);
        $last = $fakturaTab[count($fakturaTab) - 1];
        $last = trim($last);
        $last = (int) $last;
        return $last;
    }

    private function getVal($row, $colNumber, $sheetIndex) {
        $return = $this->xls->val($row, $this->getColLetterByNumber($colNumber), $sheetIndex);
        if($return == "") {
            return null;
        }
        if($return == "0" || $return == 0) {
            return 0;
        }
        return $return;
    }

    private function getValLetterVersion($row, $colLetter, $sheetIndex) {
        return $this->xls->val($row, $colLetter, $sheetIndex);
    }

    private function getColLetterByNumber($number) {
        return $this->cols->getColNameByNumber($number);
    }

}
