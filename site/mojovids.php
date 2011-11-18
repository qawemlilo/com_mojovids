<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Mojovids Component index file
 * Containst standard template code
**/
 
 
// Require the base controller i.e controller.php in the current directory
require_once( JPATH_COMPONENT.DS.'controller.php' );

// Require specific controller if requested
if ($controller = JRequest::getWord('controller')) 
{
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) 
	{
		require_once $path;
	} else {
		$controller = '';
	}
}

// Create the controller
$classname	= 'MojovidsController'.$controller;
$controller	= new $classname();

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();