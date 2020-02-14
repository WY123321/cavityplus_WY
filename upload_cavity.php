<?php

// Only accept files with these extensions
$whitelist = array('pdb');
$name = null;
$error = 'No file uploaded.';
session_start();
$sessname = $_SESSION['sessws'];
//system("mkdir ".$sessionname);

if (isset($_FILES)) {
    if (isset($_FILES['cavityfile'])) {
        $tmp_name = $_FILES['cavityfile']['tmp_name'];
        $name = basename($_FILES['cavityfile']['name']);
        $error = $_FILES['cavityfile']['error'];

        if ($error === UPLOAD_ERR_OK) {
            $extension = pathinfo($name, PATHINFO_EXTENSION);

            if (!in_array($extension, $whitelist)) {
                $error = 'Invalid file type uploaded.';
            } else {
                move_uploaded_file($tmp_name, $sessname . '/thiscavity.pdb');
                $cavityname = $sessname . "/thiscavity.pdb";
                $targetname = $sessname . "/Corrsite_1.0";
                system("
                    rm -rf " . $sessname . "/Corrsite_1.0;
                    mkdir " . $sessname . "/Corrsite_1.0;
                    mkdir " . $sessname . "/Corrsite_1.0/1T49;
                    cp " . $cavityname . " " . $targetname . "/1T49/substrate_5.pdb;
                    cp " . $sessname . "/example/AA/thischains.pdb" . " " . $targetname . "/1T49/1T49.pdb;
                    echo -n '-1' > $targetname/orthonum.txt;

                    
                ");
                foreach (scandir($sessname . "/example/AA/") as $d) {
                    if (preg_match('/_cavity_/', $d)) {
                        $restring = str_replace("thischains", "1T49", $d);
                        copy($sessname . "/example/AA/" . $d, $targetname . "/1T49/" . $restring);
                    }
                }


            }
        }
    }
}

echo json_encode(array(
    'name' => $name,
    'sname' => $sessname,
    'error' => $error,
));
die();
