<?php
/**
 * Created by PhpStorm.
 * User: wangsw
 * Date: 2017/12/13
 * Time: 15:00
 */



session_start();
$sessname=$_SESSION['sessws'];
set_time_limit(0);
session_write_close();

$filename=$sessname."/example/AA/outputcavity.txt";
$file = fopen($filename, "r") or exit("Unable to open file!");
$arr=array();
$tmp="";
$i=0;

while(!feof($file)) {
    $eachline = fgets($file);
    if (preg_match('/^Number/', $eachline)) {
        $element = explode(":", $eachline);
        $tmp=str_replace("\n","",$element[1]);

    }
}
fclose($file);

echo $tmp

?>
