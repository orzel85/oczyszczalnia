<?php


require_once './lib/countInvoice.php';
$cols = new cols();
//echo "<pre>";

$countInvoice = new countInvoice('faktury.xls');
$results = $countInvoice->startCount();
//var_dump($results);
//die();
require_once './view/excelHeaders.php.ctp';
//var_dump('===================================');
//var_dump($results);
