<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class MojovidsModelStepone extends JModel
{
    protected $results;
	
	function getData()
	{
		$db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__price";
        $db->setQuery($query); 
        
        $results = $db->loadAssocList();

		return $results;
    }
}