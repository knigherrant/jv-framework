<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

/**
 * Supports a modal article picker.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class JFormFieldModal_Article extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Modal_Article';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		// Load the modal behavior script.
		JHtml::_('behavior.modal', 'a.modal');

		// Build the script.
		$script = array();
		$script[] = '	function jSelectArticle_'.$this->id.'(id, title, catid, object) {';
		$script[] = '
		            var itemlist = document.id("items_'.$this->id.'");
		            if(!document.id("item_"+id)){
                        var item = new Element("li");
                        item.id = "item_"+id;
                        item
                            .adopt(
                                new Element("a", {"href": "javascript:void(0)"}).addEvent("click", function(){this.getParent().dispose()})
                                .adopt(  new Element("img", {"src": "'.JURI::base(true).'/templates/bluestork/images/admin/publish_x.png"}) )
                            )
                            .adopt(new Element("span", {"text": title}))
                            .adopt(new Element("input", {"type": "hidden", name: "'.$this->name.'", value: id}))
                        itemlist.adopt(item);
                        alert("Item added in the list.");
		            }else{
		                alert("The selected item is already in the list");
		            }

		';
		$script[] = '	}';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));


		// Setup variables for display.
		$html	= array();
		$link	= 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;function=jSelectArticle_'.$this->id;

        $title = JText::_('COM_CONTENT_SELECT_AN_ARTICLE');
		$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

		// The current user display field.
		$html[] = '<div class="fltlft">';
		$html[] = '  <input type="text" id="'.$this->id.'_name" value="'.$title.'" disabled="disabled" size="35" />';
		$html[] = '</div>';

		// The user select button.
		$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		$html[] = '	<a class="modal btn" title="'.JText::_('COM_CONTENT_CHANGE_ARTICLE').'"  href="'.$link.'&amp;'.JSession::getFormToken().'=1" rel="{handler: \'iframe\', size: {x: 800, y: 450}}">'.JText::_('COM_CONTENT_CHANGE_ARTICLE_BUTTON').'</a>';
		$html[] = '  </div>';
		$html[] = '</div>';
        $html[] = '<div class="clr"></div>';
        $html[] = '<ul id="items_'.$this->id.'" class="itemlist">'.$this->getItemlist().'</ul>';

		return implode("\n", $html);
	}

    public function getItemlist(){
        if(!$this->value) return '';
        $this->value = (array) $this->value;
        $db = JFactory::getDbo();
        $db->setQuery("SELECT id,title FROM #__content WHERE id IN(".implode(',', array_filter($this->value)).")");
        $items = $db->loadObjectList();

        ob_start();
        foreach($items as $item):?>
            <li id="item_<?php echo $item->id?>"><a href="javascript:void(0)" onclick="this.getParent().dispose()"><img alt="Remove entry from the list" src="<?php echo JURI::base(true) ?>/templates/bluestork/images/admin/publish_x.png" class="remove"></a> <span><?php echo $item->title?></span> <input type="hidden" name="<?php echo $this->name; ?>" value="<?php echo $item->id ?>"></li>
<?php
        endforeach;
       return ob_get_clean();
    }
}
