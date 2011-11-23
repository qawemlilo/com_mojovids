<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

/**
   HTML View class for the Mojovids Component
**/
class MojovidsViewStepthree extends JView
{
	function display($tpl = null)
	{
        if(isset($_POST['import'])) 
		{
		    $session =& JFactory::getSession();
			$session->set('stepthreecomplete', true);
			
            header("Location: index.php?option=com_mojovids&view=stepfour");
        }		
		else 
		    parent::display($tpl);
	}
}