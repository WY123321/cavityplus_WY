<?php


$filename=$_POST['fileid']."/example/AA/outputcavity.txt";
$file = fopen($filename, "r") or exit("Unable to open file!");
$arr=array();
$tmp="";
$i=0;
while(!feof($file)) {
    $eachline = fgets($file);
    if (preg_match('/^Cavity/', $eachline)) {
        $element = explode("|", $eachline);
        $tmp = preg_replace('/ /', ',', $element[1]);
        $tmp=str_replace("\n", "", $tmp);
        $arr[$i] = array('residue' => $tmp);
        $i++;
    }
}
fclose($file);

echo json_encode($arr);

?>