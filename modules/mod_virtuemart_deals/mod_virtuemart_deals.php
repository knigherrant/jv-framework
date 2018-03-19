<?php
/**
* @version		$Id: mod_virtuemart_deals.php 2011-06-04 14:10:00Cecil Gupta $
* @package		Joomla
* @copyright	Copyright (C) 2011 Cecil Gupta. All rights reserved
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

	$document = JFactory::getDocument();
	JHTML::script(JURI::base().'modules/mod_virtuemart_deals/assets/countdown.js');
	JHTML::stylesheet(JURI::base().'modules/mod_virtuemart_deals/assets/countdown.css');
	
	$opt_content = $app->input->getCmd('view', '');
	$timer_format = $params->get( 'time_format', "hours" );
	$modulesuffix = $params->get('moduleclass_sfx');
	$product_id = $params->get( 'product_id', 22 );
	$show_price = (bool)$params->get( 'show_price', 1 );
	$show_addtocart = (bool)$params->get( 'show_addtocart', 1 );
	$debug_mode = (bool)$params->get( 'debug_mode', 0 );

	$lDays = $params->get( 'days', JText::_('DR_DAYS') );
	$lHours = $params->get( 'hours', JText::_('DR_HOURS') );
	$lMinutes = $params->get( 'minutes', JText::_('DR_MINUTES') );
	$lSeconds = $params->get( 'seconds', JText::_('DR_SECONDS') );

	$component_suffix="";

	$productArray = preg_split("/[\s,]+/", $product_id);
	defined('DS') or define('DS', DIRECTORY_SEPARATOR);
	if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
	VmConfig::loadConfig();
	vmRam('Start');
	vmSetStartTime('Start');
	VmConfig::loadJLang('com_virtuemart', true);
	if (!class_exists( 'calculationHelper' )) require(JPATH_ADMINISTRATOR.  '/components/com_virtuemart/helpers/calculationh.php');
	if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR. '/components/com_virtuemart/helpers/currencydisplay.php');
	if (!class_exists( 'VirtueMartModelVendor' )) require(JPATH_ADMINISTRATOR. '/components/com_virtuemart/models/vendor.php');
	if (!class_exists( 'VmImage' )) require(JPATH_ADMINISTRATOR. '/components/com_virtuemart/helpers/image.php');
	if (!class_exists( 'shopFunctionsF' )) require(JPATH_SITE.'/components/com_virtuemart/helpers/shopfunctionsf.php');
	if (!class_exists( 'calculationHelper' )) require(JPATH_COMPONENT_SITE.'/helpers/cart.php');
	if (!class_exists('vmCustomPlugin')) require(JPATH_VM_PLUGINS .'/vmcustomplugin.php');
	if (!class_exists( 'VirtueMartModelProduct' )){
	   JLoader::import( 'product', JPATH_ADMINISTRATOR . '/components/com_virtuemart/models' );
	}
	if (!class_exists( 'VirtueMartModelRatings' )){
		JLoader::import( 'ratings', JPATH_ADMINISTRATOR .'/components/com_virtuemart/models' );
	}
	$productModel = VmModel::getModel('Product');
?>

<div class="vmDeals <?php echo $params->get( 'moduleclass_sfx' ) ?>" id="vmDeals-<?php echo $module->id;?>">
	<?php if (count($productArray) > 1) { ?>
	<div class="list-unstyled carouselOwl" 
		data-items="1" 
		data-singleitem="true" 
		data-pagination="false" 
		data-navigation="true"
	>
	<?php } ?>
	<?php 
	foreach($productArray as $key => $product_ids){
		$mainframe = Jfactory::getApplication();
		$product = $productModel->getProduct($product_ids);
		$productModel->addImages($product);
		$currency = CurrencyDisplay::getInstance();
		vmJsApi::jQuery();
		if ($show_addtocart) {
			vmJsApi::jPrice();
			vmJsApi::cssSite();
		}
		/* load the template */
		$product_in_stock = $product->product_in_stock;
		if(!empty($product)) {
			if($product_in_stock){
					if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){
						require JModuleHelper::getLayoutPath('mod_virtuemart_deals', $params->get('layout', 'default'));
					}else {
						echo JText::_('DR_DEALS_EXPIRES');
					}
			} 
		}
	}
	?>
	<?php if (count($productArray) > 1) { ?>
	</div>
	<?php } ?>
</div>
<?php //} ?>