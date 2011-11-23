<?php
// No direct access
defined('_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

// http://www.travisberry.com/2010/09/use-php-to-zip-folders-for-download/
// This function outputs a zipped folder
function downloadZipped($folder, $files)
{
    $filename_no_ext= $folder;
    $dir = JPATH_SITE . DS . 'components' . DS . 'com_mojovids' . DS . 'orders'. DS . $folder . DS . $files;
    // we deliver a zip file
    header("Content-Type: archive/zip");

    // filename for the browser to save the zip file
    header("Content-Disposition: attachment; filename=$filename_no_ext".".zip");

    // get a tmp name for the .zip
    $tmp_zip = tempnam ("tmp", "tempname") . ".zip";

    //change directory so the zip file doesnt have a tree structure in it.
    chdir($dir);
   
    // zip the stuff (dir and all in there) into the tmp_zip file
    exec('zip '.$tmp_zip.' *');
   
    // calc the length of the zip. it is needed for the progress bar of the browser
    $filesize = filesize($tmp_zip);
    header("Content-Length: $filesize");

    // deliver the zip file
    $fp = fopen("$tmp_zip","r");
    echo fpassthru($fp);

    // clean up the tmp zip file
    unlink($tmp_zip);
	
	return true;
}


class MojovidsViewDownload extends JView
{
	function display($tpl = null)
	{
	    if (isset($_GET['f']) )
		{
		    downloadZipped($_GET['f']);
			return;
		}		
		else 
		    header("Location: index.php");
	}
}