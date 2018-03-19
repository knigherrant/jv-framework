<?php
defined('_JEXEC') or  die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/*
* Module Helper
*
* @package VirtueMart
* @copyright (C) 2010 - Patrick Kohl
* @ Email: cyber__fr|at|hotmail.com
*
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if (!class_exists ('VmConfig')) {
	require(JPATH_ADMINISTRATOR  .'/components/com_virtuemart/helpers/config.php');
}

$config= VmConfig::loadConfig();
VmConfig::loadJLang('mod_virtuemart_deals', true);

class mod_virtuemart_countdown {

	static function addtocart ($product) {

		echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));
	}

} ?>
