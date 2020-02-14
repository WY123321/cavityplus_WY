<?php



session_start();
$sessname=$_SESSION['sessws'];
$cavno=$_POST['cavid'];
$sessnamedir=$sessname."/Pocket_on_cavity".$cavno;


$filename=$sessnamedir."/pkout-atoms.txt";
$file = fopen($filename, "r") or exit("Unable to open file!");
$arr1=array();
$arr2=array();
$tmp="";
$ii=0;
$iii=0;

while(!feof($file)) {
    $eachline = fgets($file);
    $eachline=preg_replace('/\n/','',$eachline);
   

    if (preg_match('/3 F/', $eachline)) {
        $element = explode(" ", $eachline);
        $tmp= $element[0]." and ".$element[1].".".$element[2]." and atomno=".$element[3];
        $arr2[$iii]=array('atom'=> $tmp, 'label' => $element[2]);
        $iii++;

    }
    if(preg_match('/2 O/', $eachline)){
        $element = explode(" ", $eachline);
        $tmp= $element[0]." and ".$element[1].".".$element[2]." and atomno=".$element[3];
        $arr1[$ii]=array('atom'=> $tmp, 'label' => $element[2]);
        $ii++;
    }
    if(preg_match('/2 N/', $eachline)){
        $element = explode(" ", $eachline);
        $tmp= $element[0]." and ".$element[1].".".$element[2]." and atomno=".$element[3];
        $arr1[$ii]=array('atom'=> $tmp, 'label' => $element[2]);
        $ii++;
    }


}
fclose($file);


echo json_encode(array($arr2, $arr1));
die();
// echo $filename;



?>