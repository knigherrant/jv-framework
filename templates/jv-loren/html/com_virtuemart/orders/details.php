<?php
/**
*
* Order detail view
*
* @package	VirtueMart
* @subpackage Orders
* @author Oscar van Eijk, Valerie Isaksen
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: details.php 7601 2014-01-24 14:03:36Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHtml::stylesheet('vmpanels.css', JURI::root().'components/com_virtuemart/assets/css/');
if($this->print){
	?>

		<body onLoad="javascript:print();">
			<br>
			<div class="row">
				<div class="col-sm-2">
					<div class="thumbnail"><img src="<?php  echo JURI::root() . $this-> vendor->images[0]->file_url ?>" style="width: 100px;"></div>		
				</div>
				<div class="col-sm-10">
					<h2 class="mt-0"><?php  echo $this->vendor->vendor_store_name; ?></h2>
					<?php  echo $this->vendor->vendor_name .' - '.$this->vendor->vendor_phone ?>
					
				</div>
			</div>
			<br>
			<h1><?php echo vmText::_('COM_VIRTUEMART_ACC_ORDER_INFO'); ?></h1>
			<div class="orderDetail">
				<div class='spaceStyle'>
				<?php
				echo $this->loadTemplate('order');
				?>
				</div>

				<div class='spaceStyle'>
				<?php
				echo $this->loadTemplate('items');
				?>
				</div>
				<?php	echo $this->vendor->vendor_letter_footer_html; ?>
			</div>
		</body>
		<?php
} else {?>
	<div class="orderDetail">
		<div class="orderPrint pull-right">
			<?php
			/* Print view URL */
			$details_link = "<a class='btn btn-default btn-outline' href=\"javascript:void window.open('$this->details_url', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\" title=\"".vmText::_('COM_VIRTUEMART_PRINT')."\" data-icon=\"&#xe021;\"><i class=\"fa fa-print\"></i></a>";
			echo $details_link; ?>
		</div>
		<?php if($this->order_list_link){ ?>
				<a class="btn btn-default" href="<?php echo $this->order_list_link ?>" rel="nofollow"><?php echo vmText::_('COM_VIRTUEMART_ORDERS_VIEW_DEFAULT_TITLE'); ?></a>
		<?php }?>
		<div class='mt-40'>
			<?php
			echo $this->loadTemplate('order');
			?>
		</div>
		<div class="mt-40">
			<?php
			$tabarray = array();
			$tabarray['items'] = 'COM_VIRTUEMART_ORDER_ITEM';
			$tabarray['history'] = 'COM_VIRTUEMART_ORDER_HISTORY';
			shopFunctionsF::buildTabs ( $this, $tabarray); ?>
		</div>
	</div>
	<?php
}?>






