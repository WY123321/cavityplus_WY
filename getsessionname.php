<?php
/**
 * Created by PhpStorm.
 * User: yjxu
 * Date: 12/28/17
 * Time: 7:36 AM
 */


session_start();
$sessionname=$_SESSION['sessws'];
session_write_close();

echo $sessionname;

?>