<?php

session_start();
$sessname = $_SESSION['sessws'];

system("
    cp runpdb2string.sh runpdb2string_apache.sh;
    sh runpdb2string_apache.sh $sessname/thiscavity.pdb");


?>
