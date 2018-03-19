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
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
JFormHelper::loadFieldClass('list');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */

class JFormFieldListlayout extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Listlayout';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 * @since   11.1
	 */
	protected function getOptions() {	
		// Initialize variables.
		$options = array();
		
		$path = JV::helper('path');		
		$paths = $path->getPath('layouts');		
		
		foreach ($paths as $path) {
			$path = $path.'/'.$this->element['layout'];
			if(is_dir($path)){
				$files = JFolder::files($path, '\.php$', false, true);
				foreach ($files as $file){
					$info = pathinfo($file);
					$options[] = JHtml::_('select.option', $info['filename'], ucfirst($info['filename']));
				}
			}
		}
		
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);
		
		return $options;
	}
}


