<?php
/**
 * @copyright	Copyright (C) 2015 Joomalvi, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die("Restricted access");
 
class plgSystemJv_shortcode_system extends JPlugin
{
	// for admin
	public function onBeforeRender()
	{
		require_once (dirname ( __FILE__ ) . '/shortcode/core/generator.php');
		
		# load language
		$lang = JFactory::getLanguage();
		$extension = 'plg_system_jv_shortcode_system';
		$base_dir = JPATH_ADMINISTRATOR;
		$language_tag = 'en-GB';
		$reload = true;
		$lang->load($extension, $base_dir, $language_tag, $reload);
		
		#generator list shortcodes
		if(JRequest::getVar('jvaction')=== "jv_shortcode_system" ){
			 global $shortcode_tags;
			 Jv_shortcodeHelper::init();
			if(JRequest::getVar('task')=== 'listview'){
			  	# Reading xml 
			    $xml = Jv_shortcodeHelper::loadXml();
			    
			    # generate html shortcode list
			    $shortcodeList = '';
			   
			    foreach($xml->children() as $shortcode){
			    	if((string)$shortcode->show === 'yes'){
						$shortcodeList .= 
						'<span data-group="'.$shortcode->group.'" data-desc="'.$shortcode->desc.'" title="'.JText::_($shortcode->desc).'" data-shortcode="'.$shortcode->tagcode.'" data-name="'.JText::_($shortcode->name).'" >'
								.'<i class="fa fa-'.$shortcode->icon.'"></i>'
								.JText::_($shortcode->name)
						.'</span>';
			    	}
			    }
			    
			   # featch head
			   echo '<!DOCTYPE html><html><head>' . Jv_shortcodeHelper::fetchHead() . '</head><body>';
			   
			   # generate html code
			   	echo 
			   	'<div id="jv-generator">'
			   		.'<input id="jv-generator-search" type="text" placeholder="'.JText::_('SEARCH_SHORTCODE').'" value="" name="jv-generator-search" />'
			   		.'<div id="jv-generator-filter">'
			   			.'<strong>'.JText::_('FILTER_BY_TYPE').' </strong>'
			   			.'<a data-filter="all" href="#" class="active">'.JText::_('ALL').'</a>'
			   			.'<a data-filter="content" href="#">'.JText::_('CONTENT').'</a>'
			   			.'<a data-filter="box" href="#">'.JText::_('BOX').'</a>'
			   			.'<a data-filter="media" href="#">'.JText::_('MEDIA').'</a>'
			   			.'<a data-filter="gallery" href="#">'.JText::_('GALLERY').'</a>'
			   			.'<a data-filter="data" href="#">'.JText::_('DATA').'</a>'
			   			.'<a data-filter="other" href="#">'.JText::_('OTHER').'</a>'
			   		.'</div>'
			   		.'<div id="jv-generator-choices" class="jv-generator-clearfix">'
			   			.$shortcodeList
			   		.'</div>'
			   		.'<div id="jv-generator-settings">'
			   		.'</div>'
			   		.'<input id="jv-generator-selected" type="hidden" value="" />'
			   		.'<input id="plg-url" type="hidden" value="'. JURI::base().'" />'
			   		.'<input type="hidden" name="jv-compatibility-mode-prefix" id="jv-compatibility-mode-prefix" value="'.jv_shortcodeHelper::getPrefix().'" />'
			   	.'</div>';
				echo '</body></html>';
			   	die();
		 	 }elseif(JRequest::getVar("task") === "settings"){
		 	 	# setting attribute of shortcode
		  		Jv_shortcodeHelper::settings();
		  	}elseif(JRequest::getVar("task") ==='preview'){
		  		# preview shortcode 
		  		Jv_shortcodeHelper::preview();
		  	}elseif(JRequest::getVar("task") ==='images'){
		  		$path = JRequest::getVar('folder');
		  		# get images
		  		Jv_shortcodeHelper::getImages($path);
		  	}elseif (JRequest::getVar("task")==="upload"){
		  		#upload images
		  		Jv_shortcodeHelper::uploadImages();
		  	}elseif(JRequest::getVar("task")==="imagescat"){
		  		# get images from cat
		  		Jv_shortcodeHelper::getCatImages(JRequest::getVar('cats'),JRequest::getVar('limit'),JRequest::getVar('prefix'));
		  	}elseif(JRequest::getVar("task")==="add_preset"){
		  		#get var
		  		$shortcode = JRequest::getVar("shortcode");
		  		$id = JRequest::getVar("id");
		  		$name = JRequest::getVar("name");
		  		$settings = JRequest::getVar("settings");
		  		# add preset
		  		Jv_shortcodeHelper::add_preset($shortcode, $id,$name,$settings);
		  	}elseif(JRequest::getVar("task")==="remove_preset"){
		  		$id = JRequest::getVar('id');
		  		$shortcode = JRequest::getVar('shortcode');
		  		# remove preset
		  		Jv_shortcodeHelper::remove_preset($shortcode, $id);
		  	}elseif(JRequest::getVar("task")==="load_preset"){
		  		$id = JRequest::getVar('id');
		  		$shortcode = JRequest::getVar('shortcode');
		  		#load preset
		  		Jv_shortcodeHelper::load_preset($shortcode, $id);
		  	}elseif(JRequest::getVar("task")==="icon"){
		  		Jv_shortcodeHelper::icons();
		  	}
		}
	}
}
