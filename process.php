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


const GPROW = 4;

foreach($ss->getWorksheetIterator() as $Sh){
    //$page->title = $Sh->getTitle();
    $resPonse->pages[] = $Sh->getTitle();
}

if(isset($_GET['weekN'])){
    $ws = $ss->getSheetByName($_GET['weekN']);
    $topCol = $ws->getHighestColumn();
    $resPonse->groups = $ws->rangeToArray("A".GPROW.":".$topCol.GPROW, "", false, false, false)[0];
}

if(isset($_GET['gpN']) && isset($_GET['gpCol']) && isset($_GET['weekN'])){
    $ws = $ss->getSheetByName($_GET['weekN']);
    $resPonse->timetable = $ws->rangeToArray("A1:A3", "", false, false, false)
}

print(json_encode($resPonse));

?>