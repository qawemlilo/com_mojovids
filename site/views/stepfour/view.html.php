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
		$title = JRequest::getString('title', '', 'POST');
		
		if(empty($music))
		    $music = JRequest::getString('musictwo', '', 'POST');
		
		if(!empty($music) && !empty($title))
		{
		    $name = $this->session->get('clientname');
			$qawe = 'qawemlilo@gmail.com';
			$scott = 'info@scottwebdesigns.co.za';
			$surname = $this->session->get('clientsurname');
			$email = $this->session->get('clientemail');
			$package = $this->session->get('clientpackage');
			$folder = $this->session->get('clientfolder');
			$base = JURI::base();
			
			$body = "NEW ORDER FROM WEBSITE";
            $body .= "\n---------------------------------------------------";			
            $body .= "\n Name: " . $name;	
            $body .= "\n Surname: " . $surname;	
			$body .= "\n Email: " . $email;
			$body .= "\n Package: " . $package;
			$body .= "\n Title: " . $title;
			$body .= "\n Music: " . $music;
			/*
			if(!empty($comments))
			{
			    $body .= "\n Notes: " . $comments;
			}*/
            $body .= "\n---------------------------------------------------";
            $body .= "\n\nPlease go to {$base}index.php?option=com_mojovids&view=download&f={$folder} to download files.";			
			
			$savedOk = $this->save($name, $surname, $email, $package, $folder, $music);
			
			if($savedOk) 
			{
			    $this->sendMail("auto-responder@mojo.co.za", $scott, "New order from website", $body);
				
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
		$headers .= "Bcc: qawemlilo@gmail.com\n";
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
       $session =& JFactory::getSession();	
	    if (isset($_POST['import']))
		{
		    $form = new appForm();
			$formOk = $form->processForm();
			
			if($formOk) 
			{
				$msg = "success";
			    $this->assignRef('msg', $msg);
			}
			else
			{
			    $msg = "fail";
			    $this->assignRef( 'msg', $msg);
			}
		}
		else 
		{
		    $msg = "default";
		    $this->assignRef('msg', $msg);
		}
		parent::display($tpl);
	}
}