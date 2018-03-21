<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_jvportfolio
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';
$cate = $params->get('cate', 0);
$tag = $params->get('tags', 0);  
$limitstart = JRequest::getInt('limitstart', 0);
$limit= $params->get('limit', 20);
$rs = ModJvPortfolioHelper::getItems($cate, $tag, $limitstart, $limit, $params->get('isize', '0x0'));
if(is_null($rs)) return false;
$items = $rs->items;
$total = $rs->total;
$pagination = new JPagination($rs->total, $limitstart, $limit);
$column = $params->get('column', 3);
$com_assets = JUri::root().'components/com_jvportfolio/assets'; 
$document = JFactory::getDocument();
JFactory::getLanguage()->load('com_jvportfolio');

$prefixPfo = "mod-frm-portfolio-{$module->id}";

// Include CSS
JHtml::stylesheet("{$com_assets}/css/fresco.css");
$qcss = http_build_query(array(
'option'=>'com_jvportfolio',
'task'=>'items.buildCss',
'skinextend'=>$params->get('exeffect', 0)
), null, '&amp;');
JHtml::stylesheet(JUri::root()."index.php?{$qcss}");

// Include JS
JHtml::_('behavior.framework');
JHtml::_('jquery.framework');
JHtml::_('bootstrap.framework');   
$q = http_build_query(array(
	'option'=>'com_jvportfolio',
	'task'=>'items.buildJs',
	'pageTotal'=>$pagination->pagesTotal,
	'limit'=>$limit,
	'mid'=>JRequest::getInt('Itemid', 0),
	'pfoid'=>$prefixPfo
), null, '&amp;');
JHtml::script(JUri::root()."index.php?{$q}"); 
            
require JModuleHelper::getLayoutPath('mod_jvportfolio', $params->get('layout', 'default') );

if(JRequest::getInt('ajax', 0)) die();
