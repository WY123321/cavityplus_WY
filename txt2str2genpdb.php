<?php
/**
 * Created by PhpStorm.
 * User: yjxu
 * Date: 12/27/17
 * Time: 2:47 AM
 */

session_start();
$sessionname=$_SESSION['sessws'];


$fp = $sessionname."/thisresidueno.txt";
$resstr=shell_exec("echo `cat $fp`;");


$result = preg_replace("/(\s+)|(;+)/",",", $resstr);

echo rtrim($result,",");

?>