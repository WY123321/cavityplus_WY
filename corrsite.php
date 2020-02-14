<?php
/**
 * Created by PhpStorm.
 * User: yjxu
 * Date: 12/23/17
 * Time: 7:51 PM
 */


session_start();
$sessname=$_SESSION['sessws'];

$workspacedir=$sessname."/Corrsite_1.0/";

system("
cp runcorrsite.sh runcorrsite_apache.sh;
sh runcorrsite_apache.sh $workspacedir > $workspacedir"."corrsiteoutput.txt;
");


$filename=$workspacedir."corrsiteoutput.txt";
$file = fopen($filename, "r") or exit("Unable to open file!");
//$output="";
$arr=array();
$tmp="";
$i=0;

while(!feof($file)) {
    $eachline = fgets($file);
    //fgets() Read row by r
    if (preg_match('/^Cavity\d+\||^OrthSite\|/', $eachline)) {
        $element = explode("|", $eachline);
        $tmp=preg_replace('/ /',',',$element[2]);
        $tmp=preg_replace('/\n/','',$tmp);
        if(preg_match('/^Cavity/', $element[1])){
            $arr[$i]=array('cavity'=>$element[0],'score'=>$element[1],'residues'=>$tmp);
        }else{
            $arr[$i]=array('cavity'=>$element[0],'score'=>sprintf("%.2f",$element[1]),'residues'=>$tmp);
        }
        $i++;
    }
}
fclose($file);

echo json_encode($arr);

?>