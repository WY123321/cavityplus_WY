<?php
header("Content-Type: application/x-www-form-urlencoded;charset=utf-8");
$filename = $_POST["filename"];
$txt=$_POST['text'];

$tmpdir=explode("/",$filename);
if(file_exists($tmpdir[0])){
    echo "file exist!";
}else{
    system("mkidr ".$tmpdir[0]);
}


$myfile = fopen($filename, "w") or die("Unable to open file!");
fwrite($myfile, $txt);
fclose($myfile);
echo "good";

?>
