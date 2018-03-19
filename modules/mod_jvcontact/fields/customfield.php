<?php
/**
 # Module		JV Contact
 # @version		3.0.1
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright © 2008-2012 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );




jimport('joomla.form.formfield');
class JFormFieldCustomfield extends JFormField {

	protected $type = 'customfield';

	public function getInput() {
		$doc = JFactory::getDocument();
		$doc->addScript(JURI::root().'modules/mod_jvcontact/assets/js/customfield.js');
		$doc->addStyleSheet(JURI::root().'modules/mod_jvcontact/assets/css/customfield.css');
		
		return $this->_getHTML();
		
	}
	
	private function _getHTML(){
		
		list($customfields,$i) = $this->_getField();
		$fields = array(
				'name'=>'Name',
				'email'=>'Email',
				'subjectfield'=>'Subject',
				'text'=>'Text',
				'radio'=>'Radio',
				'checkbox'=>'Check Box',
				'textarea'=>'Text Area',
				'select'=>'Select'
			);
		$list = array();
		foreach ($fields as $k=>$v) $list[] = JHTML::_('select.option',$k,$v);
		
		
		/* @todo advance input
		$list[] = JHTML::_('select.option','canlendar','Calendar');
		$list[] = JHTML::_('select.option','tab','Tab');
		*/
		
		$html = JHTML::_('select.genericlist',$list,'listtype','style="width:115px"');
		
		$html .= '
		<script type="text/javascript">var icustom='.$i.';</script>
		<a class="btn btn-small" id="btnaddfield" href="javascript:void(0);">Add Field</a>
		
		<a class="btn btn-small" onclick="restoreCustomField();" href="javascript:void(0);">Default</a>

		<br style="clear:both"/>
		<div id="container">'.$customfields.'</div>
		
		';
		
		return $html;
	}
	
	private function _getField(){
		$i = 0;
		$html ='';
		$customfields = $this->form->getValue('customfield','params');
		$validate[] = JHTML::_('select.option','none','None');
		$validate[] = JHTML::_('select.option','require','Require');
		$validate[] = JHTML::_('select.option','numberic','Number');
		$validate[] = JHTML::_('select.option','email','Email');
				
		if($customfields) foreach($customfields as $key=>$field){
			$i++;
			$rowoption = '';
			$classhidden = '';
			$listvalidate = JHTML::_('select.genericlist',$validate,'jform[params][customfield]['.$i.'][validate]','style="width:115px"','value','text',$field['validate']);
			$icondelete ='';
			
			switch($field['type']){
				case 'radio':
				case 'checkbox':
				case 'select':
					
					$rowoption = '<div class="control-group">
									<div class="control-label">
										<label for="jform[params][customfield]['.$i.'][option]">Option</label></div>
									<div class="controls">
										<textarea class="required" id="jform[params][customfield]['.$i.'][option]" name="jform[params][customfield]['.$i.'][option]">'.$field['option'].'</textarea></div>
								</div>';
					$icondelete = '<span class="icondelete"></span>';
					break;
				case 'subjectfield':
					$classhidden = 'hidden';
				case 'text':
				case 'textarea':
					$icondelete = '<span class="icondelete"></span>';
					break;
				case 'name':
				case 'email':
					$classhidden = 'hidden';
					break;
			}
			$field['name']=='' ? $title='New '.$field['type'] : $title=$field['name'];
			
			//parse HTML from params
			$html .= '<div class="jvrows subject '.$field['type'].'" style="padding-left:0">
			<h3 class="handler">
				<span class="icons">'.$title.'</span>'.$icondelete.'
			</h3>
			<div class="content hidden">
				
				<div class="row hidden">
					<label>Type</label>
					<input class="cftype" type="text" value="'.$field['type'].'" name="jform[params][customfield]['.$i.'][type]"/>
				</div>
							
				<div class="control-group '.$classhidden.'">
					<div class="control-label">
						<label for="jform[params][customfield]['.$i.'][name]">Name</label></div>
					<div class="controls">
						<input type="text" class="required" value="'.$field['name'].'" id="jform[params][customfield]['.$i.'][name]" name="jform[params][customfield]['.$i.'][name]"></div>
				</div>				
								
				<div class="control-group">
					<div class="control-label">
						<label for="jform[params][customfield]['.$i.'][title]">Title</label></div>
					<div class="controls">
						<input type="text" class="required" value="'.$field['title'].'" id="jform[params][customfield]['.$i.'][title]" name="jform[params][customfield]['.$i.'][title]"></div>
				</div>
				'.$rowoption.'
				
				<div class="control-group '.$classhidden.'">
					<div class="control-label"><label>Validate</label></div>
					<div class="controls">'.$listvalidate.'</div>
				</div>
				
			</div>
			</div>';
					
		}
		
		return array($html,$i);
	}
}