<?php
defined('_JEXEC') or  die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
/*
* Cart Ajax Extend Module
*
* @version $Id: mod_virtuemart_carte.php 8324 2014-09-24 17:30:33Z PHPKungfu $
* @package VirtueMart
* @subpackage modules
*
* www.virtuemart.net
*/
                                                                                                            
if(!class_exists('ModVirtuemartCarteHelper')) {
    require(implode(DS, array(JPATH_SITE, 'modules', 'mod_virtuemart_carte', 'helper.php'))); 
}
if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();


$viewName = vRequest::getString('view',0);
$checkAutomaticPS = false;
if($viewName=='cart'){ $checkAutomaticPS = true; }


$data = ModVirtuemartCarteHelper::getData($checkAutomaticPS);

if (!class_exists('CurrencyDisplay')) require(VMPATH_ADMIN . DS. 'helpers' . DS . 'currencydisplay.php');
$currencyDisplay = CurrencyDisplay::getInstance( );


vmJsApi::jQuery();
vmJsApi::addJScript("/modules/" . ModVirtuemartCarteHelper::$_MOD_PREFIX . "/assets/js/update_cart.js",false,false);                   
vmJsApi::cssSite();

$moduleclass_sfx = $params->get('moduleclass_sfx', '');
$show_price = (bool)$params->get( 'show_price', 1 ); // Display the Product Price?
$show_product_list = (bool)$params->get( 'show_product_list', 1 ); // Display the Product Price?

require JModuleHelper::getLayoutPath(ModVirtuemartCarteHelper::$_MOD_PREFIX, $params->get('layout', 'default'));
echo vmJsApi::writeJS();

 ?>