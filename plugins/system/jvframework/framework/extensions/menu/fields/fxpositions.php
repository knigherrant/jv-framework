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

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldFXPositions extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'FXPositions';

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
		$attr = '';

		// Initialize some field attributes.
		$attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';

		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ( (string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true') {
			$attr .= ' disabled="disabled"';
		}

		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';

		// Initialize JavaScript field attributes.
		$attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		// Get the field options.
		$options = (array) $this->getOptions();

		// Create a read-only list (no name) with a hidden input to store the value.
		if ((string) $this->element['readonly'] == 'true') {
			$html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);
			$html[] = '<input type="hidden" name="'.$this->name.'" value="'.$this->value.'"/>';
		}
		// Create a regular list.
		else {
			$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		}

		return implode($html);
	}

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 * @since   11.1
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();
		
		$db = JFactory::getDBO ();
		$query = "SELECT DISTINCT position FROM #__modules ORDER BY position ASC";
		$db->setQuery ( $query );
		$result = $db->loadObjectList ();
		
		if (! count ( $result ))
			return false;
		
		$options = array ();
            $clientId = 0;
            $client = JApplicationHelper::getClientInfo($clientId);

            $tmp = array();
            // Load the positions from the installed templates.
            foreach (self::getTemplates($clientId) as $template)
            {
                $path = JPath::clean($client->path.'/templates/'.$template->element.'/templateDetails.xml');

                if (file_exists($path))
                {
                    $xml = simplexml_load_file($path);
                    if (isset($xml->positions[0]))
                    {
                        foreach ($xml->positions[0] as $position)
                        {
                            $item = new stdClass();
                            $item->position = (string)$position;

                            if(in_array($item->position, $tmp)){

                            }else{
                                $tmp[] = $item->position;
                            }

                        }
                    }
                }
            }
            foreach ( $tmp as $value => $item ) {
                    $options [] = JHTML::_ ( 'select.option', $item, @$item->position );
            }

            return $options;
	}

    public static function getTemplates($clientId = 0, $state = '', $template='')
    {
        $db = JFactory::getDbo();
        // Get the database object and a new query object.
        $query	= $db->getQuery(true);

        // Build the query.
        $query->select('element, name, enabled');
        $query->from('#__extensions');
        $query->where('client_id = '.(int) $clientId);
        $query->where('type = '.$db->quote('template'));
        if ($state!='') {
            $query->where('enabled = '.$db->quote($state));
        }
        if ($template!='') {
            $query->where('element = '.$db->quote($template));
        }

        // Set the query and load the templates.
        $db->setQuery($query);
        $templates = $db->loadObjectList('element');
        return $templates;
    }
}
