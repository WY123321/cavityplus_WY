<?php


session_start();
$sessname=$_SESSION['sessws'];
$cavity_id = $_POST['cavityname'];



$corroutname= $sessname."/Corrsite_1.0/output.txt";

$corroutdir= $sessname."/Corrsite_1.0_".$cavity_id;
$corrtargetname=$sessname."/Corrsite_1.0_".$cavity_id."/output.txt";


system("rm -rf  $corroutdir;
mkdir $corroutdir;
cp $corroutname $corrtargetname;
");

?>
