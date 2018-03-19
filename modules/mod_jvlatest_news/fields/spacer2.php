<?php
/**
 # MOD_JVLATEST_NEWS - JV Latest News
 # @version		3.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2013 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldSpacer2 extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Spacer2';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		return  '<div style="width: 345px; float: left; display: block; font-weight:normal;font-size:12px;color:#fff;padding:3px;margin:0px;background:#6db03c;">
        		  '.JText::_($this->value).'
        		</div>';
	}

	
	/**
	 * Method to get the field title.
	 *
	 * @return	string	The field title.
	 * @since	1.6
	 */
	protected function getTitle()
	{
		return $this->getLabel();
	}
}

