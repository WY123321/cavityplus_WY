<?php
/**
 * Created by PhpStorm.
 * User: yjxu
 * Date: 12/28/17
 * Time: 5:42 AM
 */


session_start();
$sessname=$_SESSION['sessws'];

$checkstr= $_POST['checklabels'];
// echo $checkstr;


$checkstrsplit = explode(":",$checkstr);
// //$sessname="user_sess/2017.12.20XuYoujun";
$sessionsplit = explode("/",$sessname);
$sessiondir = $sessionsplit[0];
$sessionid = $sessionsplit[1];


$downloadstr="tar -zcf $sessionid"."_results.tar.gz ";
// echo count($checkstrsplit);
// echo $checkstrsplit[1];
for ($i=1; $i<count($checkstrsplit); ++$i){
    if( strcmp($checkstrsplit[$i],"downcavity")==0 ){
        $downloadstr =$downloadstr.$sessionid."_cavity.tar.gz ";

    }
    if( preg_match('/^downpocket/',$checkstrsplit[$i]) ){
        $tempcavity =  str_replace("downpocket","", $checkstrsplit[$i]);
        $downloadstr =$downloadstr."./Pocket_on_".$tempcavity."/pkout-pharmacophore-free.pdb ";

    }
    if(preg_match('/^downcorrsite/',$checkstrsplit[$i])){
        $tempcavity =  str_replace("downcorrsite","", $checkstrsplit[$i]);
        $downloadstr = $downloadstr."./Corrsite_1.0_".$tempcavity."/output.txt ";
    }
    if( strcmp($checkstrsplit[$i],"downcovcys") ==0){
        $downloadstr =$downloadstr."./CysCov/svmResul*.csv";
    }
//     echo $checkstrsplit[$i]."<br>";
    
}
// echo $downloadstr;

$downloadstr .=";mv $sessionid"."_results.tar.gz ../../tmpspace;";
// echo $downloadstr;





// $tempcmd="tar -zcf $sessionid"."_pharmacophore+corrsite+covcys.tar.gz $sessionid"."_cavity.tar.gz ./Pocket/pkout-pharmacophore-free.pdb ./Corrsite_1.0/corrsiteoutput.txt ./CysCov/svmResul*.csv;
// mv $sessionid"."_pharmacophore+corrsite+covcys.tar.gz ../../tmpspace;";

// //echo $tempcmd;
system("
cd $sessname;
$downloadstr
");

echo "tmpspace/".$sessionid."_results.tar.gz";
//die();

?>