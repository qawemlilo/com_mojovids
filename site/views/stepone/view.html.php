<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
   HTML View class 
**/

class MojovidsViewStepone extends JView
{
	function display($tpl = null)
	{
	    $session =& JFactory::getSession();
		
		if ($session->has('steponecomplete')) {
		    header("Location: index.php?option=com_mojovids&view=steptwo");
		}
		
		if (isset($_POST['import']))
		{	            
            $session->set('steponecomplete', true);
			
		    if (isset($_POST['economy']) && !empty($_POST['economy']))
			    $url = 'index.php?option=com_mojovids&view=steptwo&p=economy';
		    if (isset($_POST['premium']) && !empty($_POST['premium']))
			    $url = 'index.php?option=com_mojovids&view=steptwo&p=premium';
			
			header("Location: $url");		  
		}
		else
		    parent::display($tpl);
	}
}