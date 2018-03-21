<?php
/**
 * @version     1.0.0
 * @package     mod_jvajax_shop_search
 * @copyright   Copyright (C) 2014 JoomlaVi. All rights reserved.
 * @license     http://www.gnu.org/licenseses/gpl-2.0.html GNU/GPL or later
 * @author      info@phpkungfu.club <www.phpkungfu.club>
 */

defined('_JEXEC') or die('Restricted access');
?><?php

$source = $params->get('source', 'virtuemart');
$image_width = intval($params->get('image_width', ''));
if($image_width) $image_width = 'width="'.$image_width.'"'; else $image_width='';
$image_height = intval($params->get('image_height', ''));
if($image_height) $image_height = 'height="'.$image_height.'"'; else $image_height='';
$Itemid = $params->get('itemid', 0);
$max_cols = $params->get('max_cols', 1);
$max_rows = intval($params->get('max_rows', 6));
$show_style = $params->get('show_style', 'module');
if($show_style == 'popup') $popup_width = 'width:'.intval($params->get('popup_width','800')).'px'; else $popup_width = '';
$show_image = intval($params->get('show_image', 1));
$image_pos = intval($params->get('image_pos', 0));
$image_align = $params->get('image_align', '');
$show_title = intval($params->get('show_title', 1));
$show_price = intval($params->get('show_price', 1));
$show_desc = intval($params->get('show_desc', 1));
$desc_limit_char = intval($params->get('desc_limit_char', 80));
$show_addtocart = intval($params->get('show_addtocart', 1));
$name_filter = $params->get('name_filter', 1);
$price_filter = $params->get('price_filter', 1);
$price_style = $params->get('price_style', 'slider');
$price_slider_min = intval($params->get('price_slider_min', 1));
$price_slider_max = intval($params->get('price_slider_max', 1000));
$pagination_position = $params->get('pagination_position', 'top');
$auto_cat = intval($params->get('auto_cat', 1));
$cid = 0;
$currency = 0;
$input = JFactory::getApplication()->input;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
if($source == 'virtuemart'){
    if (!is_file(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php')){
        echo 'This module can not work without the VirtueMart Component';
        return;
    }
    if (!class_exists( 'VmConfig' )) require_once(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
    VmConfig::loadConfig();

    if ($show_addtocart) {
        vmJsApi::jPrice();
        vmJsApi::cssSite();
    }

    if($auto_cat && $input->get('option') == 'com_virtuemart' && $input->getInt('virtuemart_category_id')) $cid = $input->getInt('virtuemart_category_id', 0);
}else{
    if(!is_file(rtrim(JPATH_ADMINISTRATOR,DS).DS.'components'.DS.'com_hikashop'.DS.'helpers'.DS.'helper.php')){
        echo 'This module can not work without the Hikashop Component';
        return;
    };
    require_once(rtrim(JPATH_ADMINISTRATOR,DS).DS.'components'.DS.'com_hikashop'.DS.'helpers'.DS.'helper.php');

    $currencyHelper = hikashop_get('class.currency');
    $mainCurr = $currencyHelper->mainCurrency();
    $currency = JFactory::getApplication()->getUserState( HIKASHOP_COMPONENT.'.currency_id', $mainCurr);

    if($auto_cat && $input->get('option') == 'com_hikashop' && $input->get('ctrl') == 'category' && $input->get('task') == 'listing') $cid = $input->getInt('cid', 0);
}

//Add assets
$document = JFactory::getDocument();
if(version_compare(JVERSION, '3.0', '<')){
    $document->addScript(JUri::root().'modules/mod_jvajax_shop_search/assets/js/jquery.min.js');
}else{
    JHtml::_('Jquery.framework');
}
$document->addScript(JUri::root().'modules/mod_jvajax_shop_search/assets/js/jquery.noconflict.js');
$document->addScript(JUri::root().'modules/mod_jvajax_shop_search/assets/js/knockout.js');
$document->addScript(JUri::root().'modules/mod_jvajax_shop_search/assets/js/knockout.simpleGrid.1.3.js');
$document->addScript(JUri::root().'modules/mod_jvajax_shop_search/assets/bootstrap-slider/bootstrap-slider.min.js');
$document->addStyleSheet(JUri::root().'modules/mod_jvajax_shop_search/assets/bootstrap-slider/bootstrap-slider.min.css');
$document->addScript(JUri::root().'modules/mod_jvajax_shop_search/assets/js/jvajax_shop_search.js');
if($params->get('css_bootstrap', 0)) $document->addStyleSheet(JUri::root().'modules/mod_jvajax_shop_search/assets/css/bootstrap.min.css');
$document->addStyleSheet(JUri::root().'modules/mod_jvajax_shop_search/assets/css/jvajax_shop_search.css');

//Get layout
require(JModuleHelper::getLayoutPath('mod_jvajax_shop_search', $params->get('layout', 'default')));
