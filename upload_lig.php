<?php

// Only accept files with these extensions
$whitelist = array('mol2');
$name      = null;
$error     = 'No file uploaded.';
session_start();
$sessionname=$_SESSION['sessws'];
//system("mkdir ".$sessionname);

if (isset($_FILES)) {
	if (isset($_FILES['ligfile'])) {
		$tmp_name = $_FILES['ligfile']['tmp_name'];
		$name     = basename($_FILES['ligfile']['name']);
		$error    = $_FILES['ligfile']['error'];
		
		if ($error === UPLOAD_ERR_OK) {
			$extension = pathinfo($name, PATHINFO_EXTENSION);

			if (!in_array($extension, $whitelist)) {
				$error = 'Please upload the ligand format (.mol2)!';
			} else {
				move_uploaded_file($tmp_name, $sessionname.'/thisligand.mol2');
			}
		}
	}
}

echo json_encode(array(
    'name'=>$name,
	'sname'  => $sessionname,
	'error' => $error,
));
die();
