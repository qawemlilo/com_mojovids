<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class appForm {
    public $session;
	
	public function __construct()
	{
	    $this->session =& JFactory::getSession();
	}
	
	public function processForm()
	{
	    $music = JRequest::getString('music', '', 'POST');
		
		if(!empty($music))
		{
		    $name = $this->session->get('clientname');
			$surname = $this->session->get('clientsurname');
			$email = $this->session->get('clientemail');
			$package = $this->session->get('clientpackage');
			$folder = $this->session->get('clientfolder');
			
			$body = "New order from website";
            $body .= "\n---------------------------------------------------";			
            $body .= "\n Name: \t " . $name;	
            $body .= "\n Username: \t " . $surname;	
			$body .= "\n Email: \t " . $email;
            $body .= "\n---------------------------------------------------";
            $body .= "\n\nPlease go to http://demos.rflab.co.za/index.php?option=com_mojovids&view=download&f={$folder}/ to download files.";			
			
			$savedOk = $this->save($name, $surname, $email, $package, $folder, $music);
			
			if($savedOk) 
			{
			    $this->sendMail("no-reply@mojo.co.za", "qawemlilo@gmail.com", "New order from website", $body);
				
				return true;
			}
			else
			{
			    return false;
			}
		}
	}
	
	
    private function save($name, $surname, $email, $package, $folder, $music) 
	{
	    $db =& JFactory::getDBO();
        $query = "INSERT INTO #__mojo_orders(`name`, `surname`, `email`, `pack`, `foldername`, `music`) 
		          VALUES('".$name."', '".$surname."', '".$email."', '".$package."', '".$folder."', '".$music."')";
        $db->setQuery($query);
		
		return $db->query();
    }	

	
    private function sendMail($from, $to, $subject, $body) 
	{
	    $headers = '';
	    $headers .= "From: $from\n";
	    $headers .= "Reply-to: $from\n";
	    $headers .= "Return-Path: $from\n";
	    $headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
	    $headers .= "MIME-Version: 1.0\n";
	    $headers .= "Date: " . date('r', time()) . "\n";

	    $sentOk = mail($to,$subject,$body,$headers);
		
		return $sentOk;
    }
}
/**
   HTML View class for the Mojovids Component
**/

class MojovidsViewStepfour extends JView
{
	function display($tpl = null)
	{ 
	    if (isset($_POST['import']))
		{
		    $form = new appForm();
			$formOk = $form->processForm();
			
			if($formOk) die("Success!");
			else die("Fail!");
		}
		parent::display($tpl);
	}
}