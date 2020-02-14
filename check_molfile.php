<?php
/**
 * Created by PhpStorm.
 * User: wangsw
 * Date: 2017/12/13
 * Time: 15:00
 */



session_start();
$sessname=$_SESSION['sessws'];
// $counter=$_SESSION['counter'];
session_write_close();

$filename=$sessname.'/thisligand.mol2';
if (file_exists($filename)) {
    echo False;
} else {
    echo True;
}

?>
