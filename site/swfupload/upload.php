<?php
// Work-around for setting up a session because Flash Player doesn't send the cookies
if (isset($_POST["PHPSESSID"])) 
{
    session_id($_POST["PHPSESSID"]);
}
session_start();

$filevar = 'Filedata';
$userfolder = $_POST["userfolder"];
$fileType = $_FILES['Filedata']["type"];
$fileName = $_FILES['Filedata']["name"];
$fileSize = $_FILES['Filedata']["size"]; 

$uploadFolder = "../orders/{$userfolder}/";  

$fileName = ereg_replace("[^A-Za-z0-9.]", "-", $fileName);
$dest = $uploadFolder . $fileName;

$ext = end(explode('.', $fileName));

$validFiles = array(
    'jpeg',
	'jpg',
	'jpe',
	'gif',
	'png',
	'bmp',
	'wav',
	'x-wav',
	'mpeg',
	'mpg',
	'wmv',
	'mpe',
	'mov',
	'mp3',
	'avi',
	'tiff',
	'flv'
);

$fileError = $_FILES['Filedata']["error"];

if ($fileError > 0)
{
    switch ($fileError)
	{
	    case 1:
		    echo 'FILE TO LARGE THAN PHP INI ALLOWS';
		return;
		 
		case 2:
		    echo 'FILE TO LARGE THAN HTML FORM ALLOWS';
		return;
		 
		case 3:
		    echo 'ERROR PARTIAL UPLOAD';
		return;
		 
		case 4:
		    echo 'ERROR NO FILE';
		return;
	}
}

if (in_array($ext, $validFiles) || in_array(strtoupper($ext), $validFiles))
{
    move_uploaded_file($_FILES['Filedata']["tmp_name"], $dest);
}
exit(0);

?>