<?php
/**
 # MOD_JVLATEST_NEWS - JV Latest News
 # @version		3.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2013 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JFormFieldK2Categories extends JFormField{
    protected $type = 'k2categories';
    protected function getInput(){
        if(!file_exists(JPATH_SITE.'/components/com_k2/helpers/utilities.php')){
            $output .= JHTML::_('select.genericlist',  array(),$this->name, 'class="inputbox" style="display:none" multiple="multiple" size="10"', 'value', 'text', $this->value, $this->id );
            $output .= JText::_('<p>Please install com_k2</p>');
            return $output;
        }
        $db = JFactory::getDBO();
        $query = 'SELECT m.* FROM #__k2_categories m WHERE trash = 0 ORDER BY parent, ordering';
        $db->setQuery($query);
        $mitems = $db->loadObjectList();
        $children = array();
        if ($mitems){
            foreach ($mitems as $v){
                $v->title = $v->name;
                $v->parent_id = $v->parent;
                $pt = $v->parent;
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
        }
        $list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0);
        $mitems = array();
        foreach ($list as $item)
        {
            $item->treename = JString::str_ireplace('&#160;', '- ', $item->treename);
            $mitems[] = JHTML::_('select.option', $item->id, '   '.$item->treename);
        }
        $output= JHTML::_('select.genericlist',  $mitems, $this->name, 'class="inputbox" multiple="multiple" size="10"', 'value', 'text', $this->value, $this->id );
        return $output;	
    }
}
