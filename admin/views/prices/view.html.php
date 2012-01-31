<?php
/**
 * Hellos View for Hello World Component
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
 * Hellos View
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class PricesViewPrices extends JView
{
	/**
	 * Hellos view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Mojo Vids App' ), 'generic.png' );
		//JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		//JToolBarHelper::addNewX();

		// Get data from the model
		$items = & $this->get('Data');

		$this->assignRef('items', $items);

		parent::display($tpl);
	}
}