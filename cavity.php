<?php
/**
 * Created by PhpStorm.
 * User: wangsw
 * Date: 2017/12/13
 * Time: 15:00
 */



session_start();
$sessname=$_SESSION['sessws'];
set_time_limit(0);
// $counter=$_SESSION['counter'];

// session_write_close();

$counter=intval(file_get_contents("resource/counter/counter.log"));
$counter++;
$fp = fopen("resource/counter/counter.log","w");
fwrite($fp, $counter);
fclose($fp);







$sessionsplit = explode("/",$sessname);
$sessiondir = $sessionsplit[0];
$sessionid = $sessionsplit[1];

//$inputType=$_POST["inputType"];
//$proteinID=$_POST["proteinID"];
$proteinfile=$sessname."/thischains.pdb";
$cmode=$_POST["cmode"];

$SMD=$_POST["SMD"];
$MAL=$_POST["MAL"];
$SML=$_POST["SML"];
$MAD=$_POST["MAD"];
$R1=$_POST["R1"];
$OR=$_POST["OR"];


$allowedExts = array("pdb","mol2");


if ($_POST["cmode"]==1)
{
    $ligfile_name=$sessname."/thisligand.mol2";
}
else
{
    $ligfile_name=$sessname."/none.mol2";
}

$proteinfilepath= $proteinfile;
$ligfilepath= $ligfile_name;
$ligname1=$sessname."/thisligand_bak.mol2";
$tmp=$sessionid." ".$cmode." ".$proteinfilepath." ".$ligfilepath." ".$SMD." ".$MAL." ".$SML." ".$MAD." ".$R1." ".$OR;
$filetarget=$sessname."/". $sessionid."_cavity.tar.gz";
$filesource= $sessname."/example/AA/*";

system("
cd $sessname;
ls | grep -v -E \"pdb|mol2\" | xargs rm -rf;
cd ../..;
cp runcavity.sh runcavity_apache.sh;
ulimit -c unlimited;
sh runcavity_apache.sh ".$tmp." >".$sessname."/outputtmp.txt;
mv $ligfile_name $ligname1;
cd ".$sessname."/example/AA;
tar -zcf ../../".$sessionid."_cavity.tar.gz ./*; 
");


$filename=$sessname."/example/AA/outputcavity.txt";
$file = fopen($filename, "r") or exit("Unable to open file!");
$arr=array();
$tmp="";
$i=0;

while(!feof($file)) {
    $eachline = fgets($file);
    //fgets() Read row by r
    if (preg_match('/^Number/', $eachline)) {
        $element = explode(":", $eachline);
        $tmp=str_replace("\n","",$element[1]);

    }
}
fclose($file);

echo $tmp

?>
