<?php
/**
 *
 * Show the product images
 *
 * @package    VirtueMart
 * @subpackage
 * @author Truong Nguyen
 * @link http://www.phpkungfu.net
 * @copyright Copyright (c) 2004 - 2014 PHPKungfu Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_showprices.php 8024 2014-06-12 15:08:59Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
$product = $viewData['product'];
$app = JFactory::getApplication();
$templateDir = JURI::base() . 'templates/' . $app->getTemplate();
$database = JFactory::getDBO();
$mediaModel = VmModel::getModel ('media');
$q = 'SELECT m.* FROM #__virtuemart_product_medias as m  WHERE m.virtuemart_product_id = '.$product->virtuemart_product_id;
$database->setQuery($q);
$product_media = $database->loadObjectList();
?>

<?php
	if($product_media) {
		$i=1;
		foreach ( $product_media as $key => $media){
			if ($i <= 2) {
				$image = $mediaModel->createMediaByIds($media->virtuemart_media_id); ?>
				<?php echo $image[0]->displayMediaThumb('', false); ?>
				<?php
				if (count($product_media) == 1) { ?>
					<?php echo $image[0]->displayMediaThumb('', false); ?>
				<?php }
				?>
			<?php }
			$i++;
		}			
    } else {
    	?>
    		<img src="<?php echo $templateDir.'/images/shop/noimage.png'?>" alt="<?php echo $product->product_name ?>" >
			<img src="<?php echo $templateDir.'/images/shop/noimage.png'?>" alt="<?php echo $product->product_name ?>" >    	<?php
    }
?>