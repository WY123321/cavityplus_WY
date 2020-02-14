<?php
/**
 * Created by PhpStorm.
 * User: Lunarly
 * Date: 2017/2/19
 * Time: 21:55
 */

$fp = "resource/counter/counter.log";
if(file_exists($fp)){
    $file = fopen($fp,"a+");
    $content = file_get_contents($fp);
    $counter = preg_match('/[0-9]+/', $content, $result);
    $new = $result[0];
    $content = preg_replace("/$result[0]/", "$new", $content);
    fclose($file);
    $file = fopen($fp,"w");
    fwrite($file, $content);
    fclose($file);
    echo $new;
}
else{
    $file = fopen($fp,"w");
    $content = "There has been 1 visitors !";
    $flag = fwrite($file, $content);
    fclose($file);
    echo "1";
    }

?>