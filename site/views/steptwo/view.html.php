<?php
// No direct access
defined('_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


// SUBSCRIBE TO MAILING LIST OPTION - ADD TO MAILCHIMP USING API
function subscribe($name, $surname, $email, $base)
{
    // Include Mailchimp API class
    require_once($base);
 
    // Your API Key: http://admin.mailchimp.com/account/api/
    $api = new MCAPI('ecd9831a9e52f8a914a0d01329472da5-us2');
 
    // Your List Unique ID: http://admin.mailchimp.com/lists/ (Click "settings")
    $list_id = "6bb69a886b";
 
    // Variables in your form that match up to variables on your subscriber
    // list. You might have only a single 'name' field, no fields at all, or more
    // fields that you want to sync up.
    $merge_vars = array(
        'FNAME' => $name,
        'LNAME' => $surname
    );
 
    // SUBSCRIBE TO LIST
    if ($api->listSubscribe($list_id, $email, $merge_vars) === true){
        $mailchimp_result = 'Success! Check your email to confirm sign up.';
    } else {
        $mailchimp_result = 'Error: ' . $api->errorMessage;
    }
	
	return $mailchimp_result;
}


/**
   *Class appForm: handles the submited form on step two
   * #(member variable)
   * @(member function)
   * -------------------------------------------------------
   *
   * #(array)  user - holds user info that is used to update database
   * #(string) path - holds file system path
   * #(object) session - holds session object
   *
   * @(public) processForm() - validates the form and handles the logic and creates a folder for the order
   * @(private) save() - saves data in session object 
**/
class appForm
{
    public $user = array();
	public $path;
	public $session;
	
	public function __construct()
	{
	    $this->session =& JFactory::getSession(); // instantiate user session
		$this->session->clear('errors'); // clear old error reports
	    $this->path = JPATH_SITE . DS . 'components' . DS . 'com_mojovids' . DS . 'orders'. DS; // save the file system path
	}	
	
    public function processForm() 
	{
	    $errors = array();
		/*
		   Basic validation
		*/
	    $this->user['name'] = JRequest::getString('name', '', 'POST');
		$this->user['surname'] = JRequest::getString('surname', '', 'POST');
		$this->user['email'] = JRequest::getString('email', '', 'POST');
		$this->user['package'] = JRequest::getString('p', '', 'GET');
		
		if (empty($this->user['name']))
		    $errors['name'] = 'Please fill in the your name';			
		if (empty($this->user['surname']))
		    $errors['surname'] = 'Please fill in the your surname';			
		if (!preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $this->user['email'])) 
		    $errors['email'] = 'Email is not valid';
		if (empty($this->user['package']))
		    $errors['package'] = 'Please select your package';				
		
        //if everything is ok		
        if (count($errors) < 1) 
		{
		    $folder = md5(uniqid(time())); //create a unique folder name
			$path = $this->path . $folder;
			
			$this->user['clientfolder'] = $folder;
			
			$creat_folder = JFolder::create($path); //create the order folder on the server
			
			if($creat_folder) 
			{  
			    $folder_url =  JURI::base() . 'components/com_mojovids/orders/' . $folder; //where the files will be save
			    $this->user['folderurl'] = $folder_url; // add user array for easy database insertion later
				
				$this->save(); // save data in session object
				
				//$b_ase = JPATH_SITE . DS . 'components' . DS . 'com_mojovids' . DS . 'mailchimp' . DS . 'MCAPI.class.php';
				//$sub = subscribe($this->user['name'], $this->user['surname'], $this->user['email'], $b_ase);
				
				return true;
			}
			else 
			{
			     //Folder not created
			     $errors['folder'] = 'Folder not created';
				 $this->session->set('errors', $errors);
				 return false;
            }       	   
	    } 
		else 
		{
	       $this->session->set('errors', $errors);
		   return false;	
	   }
    }
	
	//Saves data in session object
    private function save() 
	{
	    $this->session->set('clientname', $this->user['name']);
		$this->session->set('clientsurname', $this->user['surname']);
		$this->session->set('clientemail', $this->user['email']);
		$this->session->set('clientpackage', $this->user['package']);
		$this->session->set('folderurl', $this->user['folderurl']);
		$this->session->set('clientfolder', $this->user['clientfolder']);
	
	    return true;
    }		
}

class MojovidsViewSteptwo extends JView
{
	function display($tpl = null)
	{
	    $session =& JFactory::getSession();
		
		/**If the user has already competed this step
		if ($session->has('steptwocomplete')) {
		    header("Location: index.php?option=com_mojovids&view=stepthree");
		}**/
		
	    if (isset($_POST['import']))
		{		    
		    $form = new appForm();
			$formOk = $form->processForm();
			
			if($formOk) {
			    $session->set('steptwocomplete', true);
			    header("Location: index.php?option=com_mojovids&view=stepthree");
			}
			else {
			    print_r($session->get('errors'));
			    //parent::display($tpl);
			}
		}
		else
		    parent::display($tpl);
	}
}