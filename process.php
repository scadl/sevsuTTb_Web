<?php

error_reporting(E_ERROR);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls\Worksheet;

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
$reader->setReadDataOnly(TRUE);

$ss = $reader->load("ionmo_22_o_m.xlsx");

class resPonseStruct {
    public $pages = array();
    public $groups = array();
    public $timetable = array();
    public $weekDays = array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота");
}
$resPonse = new resPonseStruct;

// Group names row number
const GP_ROW = 4;
const DAY_COLS = 7;
Const DAY_ROWS = 8;

foreach($ss->getWorksheetIterator() as $Sh){
    $resPonse->pages[] = $Sh->getTitle();
}

if(isset($_GET['weekN'])){
    $ws = $ss->getSheetByName($_GET['weekN']);
    $topCol = $ws->getHighestColumn();
    $resPonse->groups = 
        $ws->rangeToArray("A".GP_ROW.":A".$topCol.GP_ROW, "", false, false, true)[GP_ROW];
}

if(isset($_GET['gpN']) && isset($_GET['gpCol']) && isset($_GET['weekN'])){
    $ws = $ss->getSheetByName($_GET['weekN']);
    //GP_ROW + 1 + $_GET["wkDay"]*DAY_ROWS
    $colNumDem = $ws->getColumnDimension($_GET['gpCol']);
    $colNum = $colNumDem->getXfIndex();
    //$colEnd = $ws->getColumnDimensionByColumn($colNum + DAY_COLS)->getColumnIndex();
    $resPonse->timetable = array($colNum, $colEnd);
        //$ws->rangeToArray($_GET['gpCol'].(GP_ROW+1).":".$_GET['gpCol'].(GP_ROW+9), "", false, false, true);
}

print(json_encode($resPonse));

?>