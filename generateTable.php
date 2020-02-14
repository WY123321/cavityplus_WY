<?php



//session_start();
$sessname=$_POST['filenamedir'];
$cavno=$_POST['cavid'];
$sessnamedir=$sessname."/Pocket_on_cavity".$cavno;


$filename=$sessnamedir."/pkout-pharmacophore-free.pdb";
$file = fopen($filename, "r") or exit("Unable to open file!");
$arr1=array();
$arr2=array();
$tablediv="";
$ii=0;
$iii=0;

while(!feof($file)) {
    $eachline = fgets($file);
    $eachline=preg_replace('/\n/','',$eachline);
    $tmp="";


    if (preg_match('/N  POK     2/', $eachline)) {
        $element = preg_split("/[\s]+/", $eachline);
//        $element=array_filter($element);
//        $tmp= $element[0]." and ".$element[1].".".$element[2]." and atomno=".$element[3];
        $tmp= '<tr><td><label style="background-color: blue;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> H-bond donor center (POK 2.N) </td><td>'.sprintf("%.2f",$element[5]).'</td><td>'.sprintf("%.2f",$element[6]).'</td><td>'.sprintf("%.2f",$element[7]).'</td><td>1.00</td></tr> ';


    }
    if (preg_match('/F  POK     3/', $eachline)) {
        $element = preg_split("/[\s]+/", $eachline);
//        $element = explode(" ", $eachline);
//        $element=array_filter($element);
//        $tmp= $element[0]." and ".$element[1].".".$element[2]." and atomno=".$element[3];
        $tmp= '<tr><td><label style="background-color: cyan;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> H-bond root (POK 3.F) </td><td>'.sprintf("%.2f",$element[5]).'</td><td>'.sprintf("%.2f",$element[6]).'</td><td>'.sprintf("%.2f",$element[7]).'</td><td>1.50</td></tr> ';


    }
    if (preg_match('/H  POK     4/', $eachline)) {
//        $element = explode(" ", $eachline);
//        $element=array_filter($element);
        $element = preg_split("/[\s]+/", $eachline);
//        $tmp= $element[0]." and ".$element[1].".".$element[2]." and atomno=".$element[3];
        $tmp= '<tr><td><label style="background-color: lightblue;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>Positive electrostatic center (POK 4.H) </td><td>'.sprintf("%.2f",$element[5]).'</td><td>'.sprintf("%.2f",$element[6]).'</td><td>'.sprintf("%.2f",$element[7]).'</td><td>2.00</td></tr> ';


    }
    if (preg_match('/O  POK     2/', $eachline)) {
//        $element = explode(" ", $eachline);
//        $element=array_filter($element);
        $element = preg_split("/[\s]+/", $eachline);
//        $tmp= $element[0]." and ".$element[1].".".$element[2]." and atomno=".$element[3];
        $tmp= '<tr><td><label style="background-color: red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> H-bond acceptor center (POK 2.O) </td><td>'.sprintf("%.2f",$element[5]).'</td><td>'.sprintf("%.2f",$element[6]).'</td><td>'.sprintf("%.2f",$element[7]).'</td><td>1.00</td></tr> ';


    }
    if (preg_match('/C  POK     2/', $eachline)) {
//        $element = explode(" ", $eachline);
//        $element=array_filter($element);
        $element = preg_split("/[\s]+/", $eachline);
//        $tmp= $element[0]." and ".$element[1].".".$element[2]." and atomno=".$element[3];
        $tmp= '<tr><td><label style="background-color: lawngreen;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> Hydrophobic center (POK 2.C) </td><td>'.sprintf("%.2f",$element[5]).'</td><td>'.sprintf("%.2f",$element[6]).'</td><td>'.sprintf("%.2f",$element[7]).'</td><td>1.50</td></tr> ';


    }
    if (preg_match('/S  POK     4/', $eachline)) {
//        $element = explode(" ", $eachline);
//        $element=array_filter($element);
        $element = preg_split("/[\s]+/", $eachline);
//        $tmp= $element[0]." and ".$element[1].".".$element[2]." and atomno=".$element[3];
        $tmp= '<tr><td><label style="background-color: gold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> Negative electrostatic center (POK 4.S) </td><td>'.sprintf("%.2f",$element[5]).'</td><td>'.sprintf("%.2f",$element[6]).'</td><td>'.sprintf("%.2f",$element[7]).'</td><td>2.00</td></tr> ';

    }

    $tablediv =$tablediv.$tmp;
}
fclose($file);


echo $tablediv;
die();
// echo $filename;



?>