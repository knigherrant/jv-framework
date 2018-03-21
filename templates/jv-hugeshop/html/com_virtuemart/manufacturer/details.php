<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage Manufacturer
* @author Kohl Patrick, Eugen Stranz
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 2701 2011-02-11 15:16:49Z impleri $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>

<div class="manufacturer-details">
	<div class="row">
		<div class="col-xs-4">
		<?php // Manufacturer Image
		if (!empty($this->manufacturerImage)) { ?>
			<div class="thumbnail">
			<?php echo $this->manufacturerImage; ?>
			</div>
			<div class="bottom-border"></div>
		<?php } ?>
		</div>
		<div class="col-xs-8">
			<h4 class="text-semi-bold text-uppercase"><?php echo $this->manufacturer->mf_name ?></h4>
			<?php // Manufacturer Email
			if(!empty($this->manufacturer->mf_email)) { ?>
				<div class="manufacturer-email">
					<span class="manufacturer-label text-semi-bold"><?php echo vmText::_('COM_VIRTUEMART_EMAIL') ?>: </span>
					<span>
						<?php // TO DO Make The Email Visible Within The Lightbox
						echo JHtml::_('email.cloak', $this->manufacturer->mf_email,true, $this->manufacturer->mf_email,false) ?>
					</span>
				</div>
			<?php } ?>

			<?php // Manufacturer URL
			if(!empty($this->manufacturer->mf_url)) { ?>
				<div class="manufacturer-url">
					<span class="manufacturer-label text-semi-bold"><?php echo vmText::_('COM_VIRTUEMART_MANUFACTURER_PAGE') ?>: </span>
					<a target="_blank" href="<?php echo $this->manufacturer->mf_url ?>"><?php echo $this->manufacturer->mf_url ?></a>
				</div>
			<?php } ?>

			<?php // Manufacturer Description
			if(!empty($this->manufacturer->mf_desc)) { ?>
				<div class="manufacturer-description pt-30">
					<?php echo $this->manufacturer->mf_desc ?>
				</div>
			<?php } ?>

			<?php // Manufacturer Product Link
			$manufacturerProductsURL = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_manufacturer_id=' . $this->manufacturer->virtuemart_manufacturer_id, FALSE);

			if(!empty($this->manufacturer->virtuemart_manufacturer_id)) { ?>
					<a target="_top" href="<?php echo $manufacturerProductsURL; ?>" class="btn btn-dark btn-outline btn-radius btn-md"><?php echo vmText::sprintf('COM_VIRTUEMART_PRODUCT_FROM_MF',$this->manufacturer->mf_name); ?></a>
			<?php } ?>
		</div>
	</div>
</div>