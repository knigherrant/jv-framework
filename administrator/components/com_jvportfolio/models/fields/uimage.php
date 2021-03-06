<?php
/**
 * @version     1.0.0
 * @package     com_jvportfolio
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldUimage extends JFormField
{
    /**
     * The form field type.
     *
     * @var        string
     * @since    1.6
     */
    protected $type = 'uimage';

    /**
     * Method to get the field input markup.
     *
     * @return    string    The field input markup.
     * @since    1.6
     */
    protected function getInput()
    {
        return "<input id='{$this->id}' type='hidden' value='{$this->value}' name='{$this->name}'>";
    }
}