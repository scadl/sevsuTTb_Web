<?php

error_reporting(E_ERROR);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls\Worksheet;

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
$reader->setReadDataOnly(TRUE);

$ss = $reader->load("ionmo_22_o_m.xlsx");
$resPonse[] = array();

foreach($ss->getWorksheetIterator() as $Sh){
    $resPonse[] = $Sh->getTitle();
}

print(json_encode($resPonse));

?>