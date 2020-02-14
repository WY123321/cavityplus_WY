<?php
/**
 * Created by PhpStorm.
 * User: clinux
 * Date: 2017/2/24
 * Time: 23:55
 */


session_start();
$sessname = $_SESSION['sessws'];



$fp = $filedir."/".$filename;
$file = fopen($fp, "r") or exit("Unable to open file!");
$cmd_select_resides = "";
$tmp="";
while(!feof($file)) {
    $eachline = fgets($file);
    $tmp=str_replace("\r\n","",$eachline);
    $cmd_select_resides = $cmd_select_resides.$tmp.",";
}
fclose($file);
echo $cmd_select_resides;


?>