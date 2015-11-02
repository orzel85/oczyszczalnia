<?php

$path = dirname(__FILE__) . '\\excelReader\\Excel\\reader.php';
require_once($path);
$path = dirname(__FILE__) . '\\EnergyForSpreadSheet.php';
require_once($path);

class lib_LoadFile {
    
    private $filePath;
    
    private $xls;
    
    private $sheetArray = array();
    
    public function __construct($filePath) {
        $this->filePath = $filePath;
        $xls = new Spreadsheet_Excel_Reader();
        $xls->setOutputEncoding('cp1250');
        $xls->read($filePath);
        $this->xls = $xls;
//        echo "<pre>";
//        var_dump($this->xls);
    }
    
    public function countMonthlyEnergyUsage() {
        $sheetCounter = 0;
        foreach($this->xls->sheets as $sheet) {
            $sheetCounter++;
            if($sheetCounter < 6) {
                continue;
            }
//            $title = 'Odczyt energii elektrycznej Balice P5';
//            if($sheet['cells'][1][1] != $title) {
//                continue;
//            }
//            echo "<h4>".$sheet['cells'][1][1]."</h4>";
//            var_dump($sheet);
            $sheetArray = $this->convertSheetArray($sheet['cells']);
            $sheetObject = new lib_EnergyForSpreadSheet($sheetArray); 
            $sheetObject->setTitle($sheet['cells'][1][1]);
            $sheetObject->calculateUsagePerMonth();
            $sheetObject->printMonthlyAverageUsage();
            $this->sheetArray[] = $sheetObject;
            
        }
    }
    
    private function convertSheetArray($sheet) {
        $rowCounter = 0;
        $returnArray = array();
        $isOneTariff = $this->isOneTariff($sheet);
//        var_dump('$isOneTariff',$isOneTariff);
        foreach($sheet as $row) {
            $rowCounter++;
            if($rowCounter < 7) {
                continue;
            }
            if(empty($sheet[$rowCounter][2])) { // stop for empty rows
                break;
            }
            $dateFrom = $this->convertDate($sheet[$rowCounter - 1][2]);
            $dateTo = $this->convertDate($row[2]);
            $returnArray[] = array(
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'numberOfDays' => $this->getNumberOfdays($row, $isOneTariff), 
                'energyUsagePerDay' => $this->getEnergyUsagePerDay($row, $isOneTariff),
            );
        }
        return $returnArray;
    }
    
    private function getEnergyUsagePerDay($row, $isOneTariff) {
        if($isOneTariff) {
            return $this->getRow($row, 6);
        }
        return $this->getRow($row, 8);
    }
    
    private function getRow($row, $index) {
        if(isset($row[$index])) {
            return $row[$index];
        }else{
            return 0;
        }
    }
    
    private function getNumberOfdays($row, $isOneTariff) {
        if($isOneTariff) {
            return $this->getRow($row, 5);
        }
        return $this->getRow($row, 7);
    }
    
    private function isOneTariff($sheet) {
        if((isset($sheet[3][6])) && ($sheet[3][6] == 'II taryfa')) {
            return false;
        }
        return true;
    }
    
    private function convertDate($dateInteger) {
        $date1 = $this->xls->createDate($dateInteger);
        $date = date("Y-m-d", $date1[1] - 24*3600);
        return $date;
    }
    
    
}
