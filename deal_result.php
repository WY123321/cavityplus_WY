<?php
/**
 * Created by PhpStorm.
 * User: lisui
 * Date: 2017/12/20
 * Time: 15:14
 * for (var index=0; index<sur_num; index++){
sur_result[index] = new Array();
for (var result=0; result<result_num; result++){
sur_result[index][result] = obj[index][result];
}
}
 */

function get_surfacepdb($dir){
    if(!file_exists($dir)||!is_dir($dir)){
        return '';
    }

    $surface_fn = array();
    foreach (glob("$dir*") as $d){
        if(strpos($d, 'surface_') !== false){
            preg_match('/surface_(\d*)/', $d, $arr);
            $surface_fn[$arr[1]] = $d;
        }
    }
    return $surface_fn;
}

ini_set('memory_limit', '256M');
$jobid = $_POST['jobid'];



$sessionsplit = explode("/",$jobid);
$sessiondir = $sessionsplit[1];
//$sessionid = $sessionsplit[1];
$path = './'.$jobid.'/';

$result_fn = $sessionsplit[1].'_cavity.tar.gz';
//$result_fn_split = preg_split('/\./', $result_fn);


$result_path = $path.$sessiondir."_cavity/";
system("rm -rf ".$result_path.";");


$result_phar = new PharData($path.$result_fn);
$result_phar->extractTo($result_path, null, true);
$surface_fn = get_surfacepdb($result_path);

$sur_num = count($surface_fn);
$sur_results = array();

for ($i=1; $i<=$sur_num; $i++){
    $sur_con = file_get_contents($surface_fn[$i]);
    preg_match('/Predict Maximal pKd: +([\.\d]*)/', $sur_con, $pmp);
    preg_match('/Predict Average pKd: +([\.\d]*)/', $sur_con, $pap);
    preg_match('/DrugScore : +([\-\.\d]*)/', $sur_con, $ds);
    preg_match('/Druggability: +([a-zA-Z]*)/', $sur_con, $da);

    $sur_result = array(
        'pmp' => $pmp[1],
        'pap' => $pap[1],
        'ds' => $ds[1],
        'da' => $da[1],
    );

    $sur_results[$i] = $sur_result;
}


echo json_encode($sur_results);
?>

