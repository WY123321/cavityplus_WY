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
$targetname= $sessname."/Corrsite_1.0";
system("
rm -rf ".$sessname."/Corrsite_1.0;
mkdir ".$sessname."/Corrsite_1.0;
mkdir ".$sessname."/Corrsite_1.0/1T49;
cp ".$cavityname." ".$targetname."/1T49/substrate_5.pdb;
cp ".$sessname."/example/AA/thischains.pdb"." ".$targetname."/1T49/1T49.pdb;
echo -n $cav_id > $targetname/orthonum.txt;
");

foreach (scandir($sessname."/example/AA/") as $d){
    if(preg_match('/_cavity_/',$d)){
        $restring=str_replace("thischains","1T49", $d);
        copy($sessname."/example/AA/".$d,  $targetname."/1T49/".$restring);
    }
}



?>