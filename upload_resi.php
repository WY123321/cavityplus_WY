<?php
/**
 * This is just an example of how a file could be processed from the
 * upload script. It should be tailored to your own requirements.
 */

// Only accept files with these extensions
$whitelist = array('pdb');
$name      = null;
$error     = 'No file uploaded.';


$sessionname=$_SESSION['sessws'];

if (isset($_FILES)) {
	if (isset($_FILES['file'])) {
		$tmp_name = $_FILES['file']['tmp_name'];
		$name     = basename($_FILES['file']['name']);
		$error    = $_FILES['file']['error'];
		
		if ($error === UPLOAD_ERR_OK) {
			$extension = pathinfo($name, PATHINFO_EXTENSION);

			if (!in_array($extension, $whitelist)) {
				$error = 'Invalid file type uploaded.';
			} else {
				move_uploaded_file($tmp_name, $sessionname.'/'.$name);
				copy($sessionname.'/'.$name, $sessionname.'/thisresidues.pdb');
			}
		}
	}
}



echo json_encode(array(
    'name'  => $name,
    'sname' => $sessionname,
    'error' => $error,
));

die();
