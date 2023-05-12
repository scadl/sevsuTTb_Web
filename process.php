<?php

error_reporting(E_ERROR);

require 'vendor/autoload.php';

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
$reader->setReadDataOnly(TRUE);

$ss = $reader->load("ionmo_22_o_m.xlsx");

// response struct php object
// https://www.php.net/manual/en/language.oop5.basic.php
class resPonseStruct {
    public $pages = array();
    public $groups = array();
    public $timetable = array();
    public $weekDays = array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота");
}
$resPonse = new resPonseStruct;

// Calc coordibates
const GP_ROW = 4;       // Group names row number
const DAY_COLS = 7;     // How many cols in one day
Const DAY_ROWS = 8;     // How many rows in one day
const HEAD_PAD = 3;     // Margin rows between groups and ttimttable 

// https://phpoffice.github.io/PhpSpreadsheet/classes/PhpOffice-PhpSpreadsheet-Spreadsheet.html#method_getWorksheetIterator
foreach($ss->getWorksheetIterator() as $Sh){
    $resPonse->pages[] = $Sh->getTitle();
}

if(isset($_GET['weekN'])){
    $ws = $ss->getSheetByName($_GET['weekN']);
    $topCol = $ws->getHighestColumn();
    $resPonse->groups = 
        $ws->rangeToArray("A".GP_ROW.":A".$topCol.GP_ROW, "", false, false, true)[GP_ROW];
    // https://phpoffice.github.io/PhpSpreadsheet/classes/PhpOffice-PhpSpreadsheet-Worksheet-Worksheet.html#method_rangeToArray
}

if(isset($_GET['gpN']) && isset($_GET['gpColS']) && isset($_GET['weekN'])){
    $ws = $ss->getSheetByName($_GET['weekN']);
    $wkStep = $_GET["wkDay"]*DAY_ROWS;
    $resPonse->timetable = $ws->rangeToArray(
            $_GET['gpColS'].(GP_ROW+HEAD_PAD+$wkStep).":".$_GET['gpColE'].(GP_ROW+HEAD_PAD+$wkStep+DAY_ROWS), 
            "", false, false, false);
}

print(json_encode($resPonse));

?>