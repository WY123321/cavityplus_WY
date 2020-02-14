<?php
header("Content-Type: application/x-www-form-urlencoded;charset=utf-8");
$filename = $_POST["filename"];
$txt=$_POST['text'];

$tmpdir=explode("/",$filename);
if(file_exists($tmpdir[0])){
//    echo "file exist!";
}else{
    system("mkidr ".$tmpdir[0]);
}

$shellscript="";
$myfile = fopen($filename, "w") or die("Unable to open file!");
fwrite($myfile, $txt);
fclose($myfile);

$output = "";

if ($tmpdir[2]=="thisligand.pdb"){
    $thismol= $tmpdir[0]."/".$tmpdir[1]."/thisligand.mol2";
    $shellscript="/root/anaconda3/envs/py35/bin/obabel $filename -omol2 -O $thismol";
    system($shellscript);
}else{
    system("cp runpdb2resnum.sh runpdb2resnum_apache.sh;");
    $output = shell_exec("sh runpdb2resnum_apache.sh $filename");

}

echo $output;

?>
