<?php
/**
 # com_jvframework - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport('joomla.application.component.modeladmin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class JVFrameworkManagerModelTheme extends JModelAdmin {
	protected $option = 'com_jvframework';
	
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 *
	 * @return	mixed	A JVFrameworkForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_jvframework.theme', 'theme', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}	
		return $form;
	}
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_jvframework.edit.theme.data', array());
	
		if (empty($data)) {
			$data = $this->getItem();
		}
	
		return $data;
	}
	
	public function getItem($pk = null)
	{
		// Initialise variables.
		$pk = JFactory::getApplication()->input->get('id', 0, 'int');
		$table = $this->getTable();
	
		if ($pk > 0)
		{
			// Attempt to load the row.
			$return = $table->load($pk);
	
			// Check for a table object error.
			if ($return === false && $table->getError())
			{
				$this->setError($table->getError());
				return false;
			}
		}
	
		// Convert to the JObject before adding other data.
		$properties = $table->getProperties(1);
		$item = JArrayHelper::toObject($properties, 'JObject');
	
		if (property_exists($item, 'params'))
		{
			$registry = new JRegistry;
			$registry->loadString($item->params);
			$item->params = $registry->toArray();
		}
		
		return $item;
	}
}