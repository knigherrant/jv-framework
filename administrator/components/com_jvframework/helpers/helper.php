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
-------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class FrameworkHelper{
    
    static function addSubmenu($view){
    	JSubMenuHelper::addEntry(JText::_('COM_JVFRAMEWORK_MANAGER_CPANEL'), 'index.php?option=com_jvframework&view=cpanel', ($view == '' || $view == 'cpanel') ? 1 : 0);
    	JSubMenuHelper::addEntry(JText::_('COM_JVFRAMEWORK_MANAGER_STYLES'), 'index.php?option=com_templates&view=styles', (($view == 'styles') ? 1 : 0));
       // JSubMenuHelper::addEntry(JText::_('COM_JVFRAMEWORK_MANAGER_THEMES'), 'index.php?option=com_jvframework&view=themes', ($view == 'themes') ? 1 : 0);
        JSubMenuHelper::addEntry(JText::_('COM_JVFRAMEWORK_MANAGER_TYPOGRAPHIES'), 'index.php?option=com_jvframework&view=typographies', ($view == 'typographies') ? 1 : 0);
        JSubMenuHelper::addEntry(JText::_('COM_JVFRAMEWORK_MANAGER_EXTENSIONS'), 'index.php?option=com_jvframework&view=extensions', (($view == 'extensions') ? 1 : 0));
     }
    
    public static function getJVFrameworkTemplate(){
    	$templates = JFolder::folders(JPATH_ROOT.'/templates');
    	
    	$tpl = array();
    	
    	foreach ($templates as $template){
    		if(file_exists(JPATH_ROOT.'/templates/'.$template.'/themes')){
    			$tpl[$template] = JFolder::folders(JPATH_ROOT.'/templates/'.$template.'/themes');
    		}
    	
    	}
    	
    	return $tpl;
    }
    
}

class JVForm extends JForm{
    
    protected $xml;
    protected $data;
    protected $options = array();


    function __construct($xml,$data) {
        $this->xml = $xml;
        $this->data = new JRegistry ($data) ;
        $this->options['control'] = isset($options['control']) ? $options['control'] : false;
    }
    
    public function getFieldset($set = null) {
        $fields = array();

        // Get all of the field elements in the fieldset.
        if ($set)
        {
                $elements = $this->findFieldsByFieldset($set);
        }

        // If no field elements were found return empty.
        if (empty($elements))
        {
                return $fields;
        }

        // Build the result array from the found field elements.
        foreach ($elements as $element)
        {
                // Get the field groups for the element.
                $attrs = $element->xpath('ancestor::fields[@name]/@name');
                $groups = array_map('strval', $attrs ? $attrs : array());
                $group = implode('.', $groups);

                // If the field is successfully loaded add it to the result array.
                if ($field = $this->loadField($element, $group))
                {
                        $fields[$field->id] = $field;
                }
        }

        return $fields;
    }
    protected function loadFieldType($type, $new = true) {
        return JFormHelper::loadFieldType($type, $new);
    }
    protected function loadField($element, $group = null, $value = null) {
            // Make sure there is a valid SimpleXMLElement.
            if (!($element instanceof SimpleXMLElement))
            {
                    return false;
            }

            // Get the field type.
            $type = $element['type'] ? (string) $element['type'] : 'text';

            // Load the JFormField object for the field.
            $field = $this->loadFieldType($type);

            // If the object could not be loaded, get a text field object.
            if ($field === false)
            {
                    $field = $this->loadFieldType('text');
            }

            /*
                * Get the value for the form field if not set.
                * Default to the translated version of the 'default' attribute
                * if 'translate_default' attribute if set to 'true' or '1'
                * else the value of the 'default' attribute for the field.
                */
            if ($value === null)
            {
                    $default = (string) $element['default'];

                    if (($translate = $element['translate_default']) && ((string) $translate == 'true' || (string) $translate == '1'))
                    {
                            $lang = JFactory::getLanguage();

                            if ($lang->hasKey($default))
                            {
                                    $debug = $lang->setDebug(false);
                                    $default = JText::_($default);
                                    $lang->setDebug($debug);
                            }
                            else
                            {
                                    $default = JText::_($default);
                            }
                    }

                    $value = $this->getValue((string) $element['name'], $group, $default);
            }

            // Setup the JFormField object.
            $field->setForm($this);

            if ($field->setup($element, $value, $group))
            {
                    return $field;
            }
            else
            {
                    return false;
            }
	}
    
    public function getValue($name, $group = null, $default = null)
    {
            // If a group is set use it.
            if ($group)
            {
                    $return = $this->data->get($group . '.' . $name, $default);
            }
            else
            {
                    $return = $this->data->get($name, $default);
            }

            return $return;
    }
        
    function &findFieldsByFieldset($name) {
            $false = false;

            // Make sure there is a valid JForm XML document.
            if (!($this->xml instanceof SimpleXMLElement))
            {
                    return $false;
            }

            /*
                * Get an array of <field /> elements that are underneath a <fieldset /> element
                * with the appropriate name attribute, and also any <field /> elements with
                * the appropriate fieldset attribute. To allow repeatable elements only immediate
                * field descendants of the fieldset are selected.
                */
            $fields = $this->xml->xpath('//fieldset[@name="' . $name . '"]//field | //field[@fieldset="' . $name . '"]');

            return $fields;
    }
}