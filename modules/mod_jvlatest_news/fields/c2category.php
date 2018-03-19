<?php
/**
 * @version		1.0
 * @package		GroupSearch (Modules)
 * @author      JoomlaDoo - http://degrandpre.6degres.ca
 * @copyright	Copyright (c) 2012 - 2012 JoomlaDoo Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');
class JFormFieldC2category extends JFormField {

	protected $type = 'customfield';

	public function getInput() {
		return $this->_getHTML();
	}
	
	private function _getHTML(){
		$html = '';
		$customfields = $this->_getField();
		$html .= '
		<div id="jvCustomContainer">'.$customfields.'</div>
		<br style="clear:both"/>
		';
		
		return $html;
	}
	
	private function _getField(){
		$i = 0;
		$html ='';
		$customfields = $this->form->getValue('customfield','params');
                $customfields = $customfields['joomla'];
                jimport ( 'joomla.application.component.model' );
                if(version_compare(JVERSION,'3.0')<0){
                    JModel::addIncludePath ( JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_categories' . DS . 'models','categories' );
                    $model = JModel::getInstance('Categories', 'CategoriesModel', array('ignore_request' => true));
                }else{
                    JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_categories/models', 'categories');
                    $model = JModelLegacy::getInstance('Categories', 'CategoriesModel', array('ignore_request' => true));
                }
                $model->setState('list.limit','200');
                $model->setState('filter.extension','com_content');
                $mitems = $model->getItems();
                $children = array();
                if ($mitems){
                    foreach ($mitems as $v){
                        $v->parent_id = @$v->parentid;
                        $pt = @$v->parentid;
                        $list = @$children[$pt] ? $children[$pt] : array();
                        array_push($list, $v);
                        $children[$pt] = $list;
                    }
                }
               
                $mitems = array();
                foreach ($list as $item)
                {
                    $item->treename = str_repeat('- ', $item->level-1) .$item->title ;
                    $mitems[] = JHTML::_('select.option', $item->id, '   '.$item->treename);
                }
                $output= JHTML::_('select.genericlist',  $mitems, $this->name, 'class="inputbox" multiple="multiple" size="15"', 'value', 'text', $this->value, $this->id );
                return $output;	
	}
}


