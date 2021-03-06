<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_images.php 7784 2014-03-25 00:18:44Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
<div class="additional-1 additional-images-wrapper clearfix <?php echo (count($this->product->images) > 4)?'largerItem':''; ?>">
		<?php
		$start_image = VmConfig::get('add_img_main', 1) ? 0 : 1;
		for ($i = 0; $i < count($this->product->images); $i++) {
			$image = $this->product->images[$i];
			?>
			<div class="additionalItem" data-index="<?php echo $i; ?>">
				<?php
					echo $image->displayMediaThumb('', false);
				?>
			</div>
		<?php
		}
		?>
</div>
<div id="foo2_prev" class="additional-images-nav"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></div>
<div id="foo2_next" class="additional-images-nav pull-right"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></div>

