<?php


$filename="user_sess/2018_04_02_04_17_49pm_testusers/thisligand.pdb";
$thismol="user_sess/2018_04_02_04_17_49pm_testusers/thisligand.mol2";
$shellscript="obabel $filename -omol2 -O $thismol";
system($shellscript);
// system();
// system();


?>