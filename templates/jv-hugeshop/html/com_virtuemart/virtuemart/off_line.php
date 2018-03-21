<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage
* @author
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 2931 2011-04-02 00:57:47Z Electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
<div class="shopoffline">
	<div class="shopoffline-body text-center col-xs-10 col-sm-8 col-xs-offset-1 col-sm-offset-2">
		<h2 class="text-size-40 text-uppercase text-bold"><?php echo $this->vendor->vendor_store_name; ?></h2>
		<p class="text-size-20 font-playfair text-italic"><?php echo VmConfig::get('offline_message','shop offline mode'); ?> </p>
		<div class="error-button mt-50"><a href="<?php echo JURI::base(true); ?>" class="btn btn-primary text-normal "><?php echo JText::_('TPL_404_BUTTON')?></a></div>
	</div>
</div>
