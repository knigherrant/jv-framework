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
-------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
if($params->get('css_bootstrap', 1)) { 
	$document->addStyleSheet(JURI::base().'modules/mod_jvlatest_news/classes/bootstrap.min.css');
}


require_once dirname(__FILE__).'/helpers/jvlatestnews.php';  

// Set option for pagination
$params->def('modid', $module->id);
$params->def('show_icons', 1);

//
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$columns         = (int)$params->get('columns', '1');
$template        = explode(':', $params->get('template', 'default'));
$template = end($template);
//
$jvlatestnews  = new JVLatestNews($params);
$items      = $jvlatestnews->getItems();
$pagination = $jvlatestnews->getPagination();

require JModuleHelper::getLayoutPath('mod_jvlatest_news', $template.'/default');

