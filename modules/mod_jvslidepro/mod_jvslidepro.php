<?php
/**
# mod_jvslidepro - JV Slide Pro
# @versions: 1.5.x,1.6.x,1.7.x,2.5.x
# ------------------------------------------------------------------------
# author    Open Source Code Solutions Co
# copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
# Websites: http://www.joomlavi.com
# Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access'); 

if(class_exists('JVCustomParam')){
    require_once(dirname(__FILE__).'/libs/sources.php');
    JHtml::_('jquery.framework');
    $doc = JFactory::getDocument();
    $source = new JVJSlideProSource(new JVCustomParam($params->get('imagesource', array())));
    $dataImages = $source->data();
    $dataConfigs = new JVCustomParam($params->get('slideconfig',array()));
    $selectedSlide = $dataConfigs->state('selected');
    $layoutPrefix = (string)$dataConfigs->get('layout');// $params->get('layoutprefix','default');
    $file = JModuleHelper::getLayoutPath('mod_jvslidepro',$selectedSlide .'/'.$layoutPrefix);
    if(!is_file($file)) $file = JModuleHelper::getLayoutPath('mod_jvslidepro',$selectedSlide .'/default');
    include($file);
}else JError::raiseWarning(null,"Make sure you have installed and enabled, set Order first the newest version of jvlibs plug-in to use module JV Slide Pro");

?> 