<?php
/**
 * Created by PhpStorm.
 * User: yjxu
 * Date: 12/24/17
 * Time: 8:48 AM
 */

session_start();
$sessname=$_SESSION['sessws'];
//$sessname="user_sess/2017.12.20XuYoujun";
$sessionsplit = explode("/",$sessname);
$sessiondir = $sessionsplit[0];
$sessionid = $sessionsplit[1];
//

$workspacedir = $sessname;
system("
source /work01/home/yjxu/.bashrc;
rm -rf $sessname/script;
rm -rf $sessname/CysCov;
cp ./script $sessname -r;
cp 111run-CysCov.py $sessname/runCyscov.py;
cd $sessname; python runCyscov.py  thischains.pdb $sessionid"."_cavity > mycyscovoutput.txt;
");


function delete_protein($element){
    if (strpos($element, 'thischains_') !== false){
        preg_match('/thischains_(.*).pdb/', $element, $arr);
        $element = $arr[1];
    }
    return $element;

}

$file = fopen($sessname."/CysCov/svmResult.csv",'r');
$csv_result = array();

while (($data = fgetcsv($file)) ) {

//    print_r($data);
    $data = array_slice($data, 1);
    $data[1] = delete_protein($data[1]);
    array_push($csv_result, $data);

}
fclose($file);

//echo count($csv_result);
echo json_encode(array_slice($csv_result, 1));

?>