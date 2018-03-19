<?php
/**
# com_jvframework - JV Framework
# @version		1.5.x
# ------------------------------------------------------------------------
# author    Open Source Code Solutions Co
# copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
# Websites: http://www.joomlavi.com
# Technical Support:  http://www.joomlavi.com/my-tickets.html
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldTitle extends JFormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  11.1
     */
    protected $type = 'Title';

    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     * @since   11.1
     */
    protected function getInput()
    {
        // Initialize variables.
        $html = array();
        $html[] = '<h3 class="'.$this->element['class'].'"><span>'.JText::_($this->element['label']).'</span></h3>';

        //jf($this->element);
        return ''; //implode($html);
    }

    function getLabel()  {
        $html = array();
        $html[] = '<h3 class="'.$this->element['class'].'"><span>'.JText::_($this->element['label']).'</span></h3>';
        return implode($html);

    }
}
