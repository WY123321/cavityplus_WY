<?php
/**
 * Created by PhpStorm.
 * User: yjxu
 * Date: 12/23/17
 * Time: 7:10 AM
 */


session_start();
$sessname=$_SESSION['sessws'];

$cav_id = $_POST['id'];

$cavityname=$sessname."/example/AA/thischains_cavity_".$cav_id.".pdb";
$vacantname=$sessname."/example/AA/thischains_vacant_".$cav_id.".pdb";
$targetname= $sessname."/Pocket_on_cavity".$cav_id;
system("
rm -rf ".$targetname.";
mkdir ".$targetname.";
cp ".$cavityname." ".$targetname."/;
cp ".$vacantname." ".$targetname."/;
");




?>