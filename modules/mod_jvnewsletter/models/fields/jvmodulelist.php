<?php
/**
 # mod_jvnewsletter - JV NEWSLETTER
 # @version        1.0
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 -------------------------------------------------------------------------*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
                         
defined('_JVNSEXEC') or require (dirname(__FILE__). "/../../services/_services.php"); 

jimport('joomla.form.formfield');
jimport('Joomla.form.fields.checkboxes');
if(!class_exists('JFormFieldCheckboxes')){
class JFormFieldCheckboxes extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Checkboxes';

	/**
	 * Flag to tell the field to always be in multiple values mode.
	 *
	 * @var    boolean
	 * @since  11.1
	 */
	protected $forceMultiple = true;

	/**
	 * The comma seprated list of checked checkboxes value.
	 *
	 * @var    mixed
	 * @since  3.2
	 */
	public $checkedOptions;

	/**
	 * Method to get certain otherwise inaccessible properties from the form field object.
	 *
	 * @param   string  $name  The property name for which to the the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   3.2
	 */
	public function __get($name)
	{
		switch ($name)
		{
			case 'forceMultiple':
			case 'checkedOptions':
				return $this->$name;
		}

		return parent::__get($name);
	}

	/**
	 * Method to set certain otherwise inaccessible properties of the form field object.
	 *
	 * @param   string  $name   The property name for which to the the value.
	 * @param   mixed   $value  The value of the property.
	 *
	 * @return  void
	 *
	 * @since   3.2
	 */
	public function __set($name, $value)
	{
		switch ($name)
		{
			case 'checkedOptions':
				$this->checkedOptions = (string) $value;
				break;

			default:
				parent::__set($name, $value);
		}
	}

	/**
	 * Method to attach a JForm object to the field.
	 *
	 * @param   SimpleXMLElement  $element  The SimpleXMLElement object representing the <field /> tag for the form field object.
	 * @param   mixed             $value    The form field value to validate.
	 * @param   string            $group    The field name group control value. This acts as as an array container for the field.
	 *                                      For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                      full field name would end up being "bar[foo]".
	 *
	 * @return  boolean  True on success.
	 *
	 * @see     JFormField::setup()
	 * @since   3.2
	 */
	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		$return = parent::setup($element, $value, $group);

		if ($return)
		{
			$this->checkedOptions = (string) $this->element['checked'];
		}

		return $return;
	}

	/**
	 * Method to get the field input markup for check boxes.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		$html = array();

		// Initialize some field attributes.
		$class          = !empty($this->class) ? ' class="checkboxes ' . $this->class . '"' : ' class="checkboxes"';
		$checkedOptions = explode(',', (string) $this->checkedOptions);
		$required       = $this->required ? ' required aria-required="true"' : '';
		$autofocus      = $this->autofocus ? ' autofocus' : '';

		// Including fallback code for HTML5 non supported browsers.
		JHtml::_('jquery.framework');
		JHtml::_('script', 'system/html5fallback.js', false, true);

		// Start the checkbox field output.
		$html[] = '<fieldset id="' . $this->id . '"' . $class . $required . $autofocus . '>';

		// Get the field options.
		$options = $this->getOptions();

		// Build the checkbox field output.
		$html[] = '<ul>';

		foreach ($options as $i => $option)
		{
			// Initialize some option attributes.
			if (!isset($this->value) || empty($this->value))
			{
				$checked = (in_array((string) $option->value, (array) $checkedOptions) ? ' checked' : '');
			}
			else
			{
				$value = !is_array($this->value) ? explode(',', $this->value) : $this->value;
				$checked = (in_array((string) $option->value, $value) ? ' checked' : '');
			}

			$checked = empty($checked) && $option->checked ? ' checked' : $checked;

			$class = !empty($option->class) ? ' class="' . $option->class . '"' : '';
			$disabled = !empty($option->disable) || $this->disabled ? ' disabled' : '';

			// Initialize some JavaScript option attributes.
			$onclick = !empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';
			$onchange = !empty($option->onchange) ? ' onchange="' . $option->onchange . '"' : '';

			$html[] = '<li>';
			$html[] = '<input type="checkbox" id="' . $this->id . $i . '" name="' . $this->name . '" value="'
				. htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . $class . $onclick . $onchange . $disabled . '/>';

			$html[] = '<label for="' . $this->id . $i . '"' . $class . '>' . JText::_($option->text) . '</label>';
			$html[] = '</li>';
		}

		$html[] = '</ul>';

		// End the checkbox field output.
		$html[] = '</fieldset>';

		return implode($html);
	}

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		$options = array();

		foreach ($this->element->children() as $option)
		{
			// Only add <option /> elements.
			if ($option->getName() != 'option')
			{
				continue;
			}

			$disabled = (string) $option['disabled'];
			$disabled = ($disabled == 'true' || $disabled == 'disabled' || $disabled == '1');

			$checked = (string) $option['checked'];
			$checked = ($checked == 'true' || $checked == 'checked' || $checked == '1');

			// Create a new option object based on the <option /> element.
			$tmp = JHtml::_('select.option', (string) $option['value'], trim((string) $option), 'value', 'text', $disabled);

			// Set some option attributes.
			$tmp->class = (string) $option['class'];
			$tmp->checked = $checked;

			// Set some JavaScript option attributes.
			$tmp->onclick = (string) $option['onclick'];
			$tmp->onchange = (string) $option['onchange'];

			// Add the option object to the result set.
			$options[] = $tmp;
		}

		reset($options);

		return $options;
	}
}

}


class JFormFieldJvModuleList extends JFormFieldCheckboxes
{
    protected $type = 'JvModuleList';
    
    protected $filter = 'mod_jvnewsletter';
    
    protected function getOptions()
    {
        $doc = JFactory::getDocument();
        $doc->addStyleDeclaration("
        .jv-checkbox li{
            line-height: 26px;
            list-style: none;
            height: 26px;
        }
        .jv-checkbox li input.lb-cb{
            float: left;
            margin: 3px 10px 0 0;
        }
        .jv-checkbox li label.lb-cb{
        
        }
        ");
        $this->filter = ($ftl = $this->element['mod'])? $ftl : 'mod_jvnewsletter';
        $modules = getParamsList($this->filter);        
        $options = array();

        foreach ($modules as $option)
        {
            // Create a new option object based on the <option /> element.
            $tmp = JHtml::_(
                'select.option', 
                (string) $option->id, 
                trim((string) $option->title."[".$option->params->get('chose')."]"), 
                'value', 
                'text',
                false
            );
            $tmp->class="lb-cb";
            $tmp->checked = '';            
            // Add the option object to the result set.
            $options[] = $tmp;
        }

        reset($options);

        return $options;
    }
}
?>
