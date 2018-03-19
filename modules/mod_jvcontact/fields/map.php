<?php
/**
 # Module		JV Contact
 # @version		2.5.9
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright � 2008-2012 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.form.formfield');
class JFormFieldMap extends JFormField {

	protected $type = 'Map';

	public function getInput() {
		
 		$html = $this->_getMap();
		
// 		$maps = $this->form->getValue('maps','params');
		
		return $html;
		
	}
	
	private function _getMap(){
	
		$html  = '';
		$html  .='<input type="button" class="btn" id="showmap" value="Show map" onclick="javascript:void(0);" /> ';
		$form = $this->form;
		
		$mapapi = $form->getValue('map_apikey','params');
		$mainlat = $form->getValue('map_lat','params');
		$mainlong = $form->getValue('map_long','params');
		$infotext = $form->getValue('map_infotext','params');
		$moduleid = JRequest::getInt("id");
		
		$mapid = 'jvmap';
		
		if(!$mapapi) return;
		
		$markers = $this->form->getValue('map_marker','params');
		$zoom = $this->form->getvalue('map_zoom','params');
		
		$doc = JFactory::getDocument();
		$doc->addScript('http://maps.googleapis.com/maps/api/js?key='.$mapapi.'&sensor=false');
		$doc->addScript(JURI::root().'modules/mod_jvcontact/assets/js/jvmap.js');
		$js = 'window.addEvent(\'domready\',function(){';
		//onclick show map
		$js .= '$("showmap").addEvent("click",function(){';
		
		$js .= 'var injectel = $("jform_params_map-lbl").getParent().getNext();
				var divmap = new Element("div#'.$mapid.'",{
								style:"width:100%;height:500px"
							}).inject(injectel);
				';
		
		$js .= 'var mymap = new jvmap({
					hosturl : "'.JURI::root().'",
					moduleid: '.$moduleid.',
					jvmapid	: "'.$mapid.'",
					lat		: "'.$mainlat.'",
					lng		: "'.$mainlong.'",
					zoom	: '.$zoom.',
					addevent: 1,
					infotext: "'.$infotext.'"
				});';
		if($markers) foreach($markers as $marker){
			$arr = explode('|',$marker);
			$arr[2] = str_replace("'", "\'", $arr[2]);
			$arr[2] = str_replace('"', '\"', $arr[2]);
			$html .= '<input class="mapmarker" type="hidden" name="jform[params][map_marker][]" alt="'.$arr[0].'|'.$arr[1].'" value="'.$marker.'">';
			$js .= 'mymap.placeMarker('.$arr[0].','.$arr[1].',"'.$arr[2].'");';
			
		}
		
		$js .= 		'});
				});';
		
		$doc->addScriptDeclaration($js);
	
		$doc->addStyleDeclaration('#jvmap img{max-width:none !important}');
		
		return $html;
	}
	
	private function _getSubMarker($moduleid){
		$db = JFactory::getdbo();
		$query = "select params from #__modules where id = $moduleid";
		$db->setquery($query);
		$params = $db->loadResult();
		$params = JArrayHelper::fromObject(json_decode($params),true);		
		$submarkers = $params['submarker'];
		
		return $submarkers;
	}
	
}