<?php
/**
 * @version		$Id: spacer.php 20206 2011-01-09 17:11:35Z chdemko $
 * @package		Joomla.Framework
 * @subpackage	Form
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');
class JFormFieldPosition extends JFormField{

    protected $type = 'Position';


    protected function getInput(){
        $clientId = 0;

        // Load the modal behavior script.
        JHtml::_ ( 'behavior.modal', 'a.modal' );

        // Build the script.
        $script = array ();
        $script [] = '	function jSelectPosition_' . $this->id . '(name) {';
        //$script [] = '		$(\':'.$this->id.'\').set(\'html\', name);';
        $script [] = '		$(\'#'.$this->id.'\').val(name);';
        $script [] = '		SqueezeBox.close();';
        $script [] = '	}';

        // Add the script to the document head.
        JFactory::getDocument ()->addScriptDeclaration ( implode ( "\n", $script ) );

        // Setup variables for display.
        $html = array ();
        $link = 'index.php?option=com_modules&amp;view=positions&amp;layout=modal&amp;tmpl=component&amp;function=jSelectPosition_' . $this->id . '&amp;client_id=' . $clientId;

        // The current user display field.
        $html [] = '<div class="fltlft input-append">';
        $html [] = '<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . ' value="' . htmlspecialchars ( $this->value, ENT_COMPAT, 'UTF-8' ) . '" class="inputbox medium input-small"/>';
        // The user select button.
        $html [] = '<a class="modal btn" id=":'.$this->id.'" title="' . JText::_ ( 'Select' ) . '"  href="' . $link . '" rel="{handler: \'iframe\', size: {x: 800, y: 450}}">' . JText::_ ( 'Select' ) . '</a>';
        $html [] = '</div>';

        return implode ( "\n", $html );
    }

    protected function getOptions(){
        jimport('joomla.application.component.model');
        require_once JPATH_ADMINISTRATOR.'/components/com_modules/helpers/modules.php';
        JModel::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_modules/models');

        $model = JModel::getInstance('Positions', 'ModulesModel');
        $model->setState('filter.type', 'template');
        $model->setState('filter.template', $this->getSiteTemplate());


        $items = $model->getItems();

    }

    protected function getSiteTemplate(){
        $query = 'SELECT template FROM #__template_styles  WHERE client_id = 0 AND home=1';
        $db = JFactory::getDbo();
        $db->setQuery($query);

        return $db->loadResult();
    }
}

