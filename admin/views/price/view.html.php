<?php
/**
 * Hello View for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Hello View
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class PricesViewPrice extends JView
{
	/**
	 * display method of Hello view
	 * @return void
	 **/
	function display($tpl = null)
	{
		//get the hello
		$price =& $this->get('Data');

		$text = JText::_( 'Edit' );
		JToolBarHelper::title(JText::_( 'Price' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		
		JToolBarHelper::cancel('cancel', 'Close' );

		$this->assignRef('price', $price);

		parent::display($tpl);
	}
}