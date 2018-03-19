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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class JFormFieldSource extends JFormField{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Source';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput(){
            $class = ( $this->element['class'] ? 'class="'.$this->element['class'].'"' : 'class="inputbox"' );
            $options =  $this->getOptions();
            $doc = JFactory::getDocument();
            if(version_compare(JVERSION,'3.0')<0){
                $doc->addScript(JURI::root().'modules/mod_jvlatest_news/fields/source.js');
            }else{
                $doc->addScript(JURI::root().'modules/mod_jvlatest_news/fields/source_j30.js');
            }
            return JHTML::_('select.genericlist',  $options, $this->name, $class, 'value', 'text', $this->value, $this->id);
	}

    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   11.1
     */
    protected function getOptions(){
        $options = array();
        foreach ($this->element->children() as $option){
            // Only add <option /> elements.
            if ($option->getName() != 'option'){   continue; }
            // Create a new option object based on the <option /> element.
            $tmp = JHtml::_(
                'select.option', (string) $option['value'],
                JText::alt(trim((string) $option), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text',
                ((string) $option['disabled'] == 'true')
            );
            $tmp->class = (string) $option['class'];
            $tmp->onclick = (string) $option['onclick'];
            $options[] = $tmp;
        }
        reset($options);
        return $options;
    }
}
