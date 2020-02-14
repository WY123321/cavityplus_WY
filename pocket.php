<?php
/**
 * Created by PhpStorm.
 * User: wangsw
 * Date: 2017/12/12
 * Time: 15:50
 */


session_start();
$sessname=$_SESSION['sessws'];
$cavno=$_POST['cavid'];

$sessnamedir=$sessname."/Pocket_on_cavity".$cavno;
$cavityfile_name="";
$vacantfile_name= "";


$sessionsplit = explode("/",$sessname);
$sessiondir = $sessionsplit[0];
$sessionid = $sessionsplit[1];



foreach (scandir($sessnamedir) as $d){
        if(preg_match('/cavity/',$d)){
            $cavityfile_name=$d;
        }
    if(preg_match('/vacant/',$d)){
        $vacantfile_name=$d;
    }
}

$cmode=$_POST["cmodePoc"];
//echo $cmode;
$ligfile_name="thisligand.mol2";
$allowedExts = array("pdb","mol2");

$sessionid = "sess".$_SESSION['views'];

$cavityfilepath= $sessnamedir. "/".$cavityfile_name;
$vacantfilepath= $sessnamedir. "/".$vacantfile_name;
$ligfilepath="";
//echo "File has been stored in: ".$cavityfilepath . "<br>";
//echo "File has been stored in: ".$vacantfilepath . "<br>";
if ($_POST["cmodePoc"]==1)
{
    $ligfilepath=$sessnamedir."/".$ligfile_name;
    rename($sessname."/".$ligfile_name, $ligfilepath);
//    echo "File has been stored in: ".$ligfilepath . "<br>";
}
else
{
    $ligfilepath=$sessnamedir."/"."none.mol2";
}
$ligname1=$sessnamedir."/theligand_poc.mol2";
$tmp= $sessnamedir." ".$cavityfilepath." ".$vacantfilepath." ".$cmode." ".$ligfilepath;
//echo $tmp."<br>";
system("
cp runpocket.sh runpocket_apache.sh;
sh runpocket_apache.sh $tmp;
mv $ligfilepath $ligname1;
");




// $filename=$sessnamedir."/pkout-atoms.txt";
// $file = fopen($filename, "r") or exit("Unable to open file!");
// $arr1=array();
// $arr2=array();
// $tmp="";
// $i1=0;
// $i2=0;

// // while(!feof($file)) {
// //     $eachline = fgets($file);
// //     if (preg_match('/N|O/', $eachline)) {
// //         $element = explode(" ", $eachline);
// //         $tmp= $element[0]." and ".$element[1]."."$element[2]." and atomno=".$element[3];
// //         $arr1[$i1]=array('atom'=> $tmp, 'label' => $element[2]);
// //         $i1++;
// //     }

// //     if (preg_match('/F/', $eachline)) {
// //         $element = explode(" ", $eachline);
// //         $tmp= $element[0]." and ".$element[1]."."$element[2]." and atomno=".$element[3];
// //         $arr2[$i2]=array('atom'=> $tmp, 'label' => $element[2]);
// //         $i2++;
// //     }


// // }
// // fclose($file);

// // $arr=array("start"=> $arr2, "end" => $arr1);
// // echo $arr;
// // echo json_encode($arr);


?>
