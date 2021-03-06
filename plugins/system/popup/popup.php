<?php
defined( '_JEXEC' ) or die;
jimport ('joomla.application.component.controller');
jimport ('joomla.installer.installer');
/**
 *
 * @package     Joomla.Plugin
 * @subpackage  System.Popup
 * @since       3x
 * @author		NBT
 */
class PlgSystemPopup extends JPlugin 
{
	/**
	 * Class Constructor
	 * @param object $subject
	 * @param array $config
	 */
	public function __construct( & $subject, $config ) 
	{
		parent::__construct( $subject, $config );
		$this->loadLanguage();
		$jlang =JFactory::getLanguage();
		$jlang->load('com_virtuemart', JPATH_SITE, $jlang->getDefault(), true);
		$jlang->load('tpl_jv-hugeshop', JPATH_SITE, $jlang->getDefault(), true);
		$jlang->load('com_virtuemart', JPATH_SITE, null, true);	
	}
	// Before Render App
	function onBeforeRender() {
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		if (!($app->isAdmin())){
			$doc->addScript(JURI::root(true).'/plugins/system/popup/assets/popup.js');
		}
	}
	// After Initialise
	function onAfterInitialise(){ 
		if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

		$input = JFactory::getApplication()->input;
		if($input->getCmd('action') !== 'getproduct'){
			return;
		}
		$region = $input->getInt('product_id', 0);
		if ($region) {
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

			$product_model = VmModel::getModel('product');
			$prods = array($_GET['product_id']);

			$product = $product_model->getProduct($prods, true, true, 1);

			$product_model->addImages($product);
			$ratingModel = VmModel::getModel('ratings');
				$customfieldsModel = VmModel::getModel ('Customfields');
				$product->customfields = $customfieldsModel->getCustomEmbeddedProductCustomFields ($product->allIds);
				if ($product->customfields){
			
					if (!class_exists ('vmCustomPlugin')) {
						require(JPATH_VM_PLUGINS . DS . 'vmcustomplugin.php');
					}
					$customfieldsModel -> displayProductCustomfieldFE ($product, $product->customfields);
				}


			$mainframe = Jfactory::getApplication();
			$pathway = $mainframe->getPathway();
			$task = JRequest::getCmd('task');
			$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );
			$currency = CurrencyDisplay::getInstance( );
				$product->event = new stdClass();
				$product->event->afterDisplayTitle = '';
				$product->event->beforeDisplayContent = '';
				$product->event->afterDisplayContent = '';
				if (VmConfig::get('enable_content_plugin', 0)) {
					shopFunctionsF::triggerContentPlugin($product, 'productdetails','product_desc');
				}
			?>

			<?php
			$discont = $product->prices['discountAmount'];
			$discont = abs($discont);
			$show_price = $currency->createPriceDiv('salesPrice','',$product->prices);
			?>
			<div class="productdetails-view productdetails popupProduct">
					<div class="row">
						<div class="col-md-5 imagesProduct mb-sm-60">	
							<?php
							$app = JFactory::getApplication();
							$templateDir = JURI::base() . 'templates/' . $app->getTemplate();
							$database = JFactory::getDBO();
							$mediaModel = VmModel::getModel ('media');

							$slideNumber =rand (0,1000);

							$q = 'SELECT m.* FROM #__virtuemart_product_medias as m  WHERE m.virtuemart_product_id = '.$product->virtuemart_product_id;
							$database->setQuery($q);
							$product_media = $database->loadObjectList();
							$images = $product->images;
							$main_image_url = JURI::root().''.$images[0]->file_url;
							$main_image_url2 = JURI::root().''.$images[0]->file_url_thumb;
							if ($images[0]->published !==0){
								$main_image_url = JURI::root(true).'/'.$images[0]->file_url;
							}else {
								$main_image_url = JURI::root(true).'/components/com_virtuemart/assets/images/vmgeneral/noimage.gif';
							}

							$main_image_title = $images[0]->file_title;
							$main_image_description = $images[0]->file_description;
							$main_image_alt = $images[0]->file_meta;
							?>
							<img style="display:none!important;"  src="<?php echo $main_image_url ?>"  class="big_img" id="Img_to_Js_<?php echo $product->virtuemart_product_id; ?>"/>
							<div class="vmFullImage" data-product="<?php echo $slideNumber?>">
							<?php
								if(!empty($product->images) && $images[0]->published !== 0) {
									$start_image = VmConfig::get('add_img_main', 1) ? 0 : 1;
									for ($i = 0; $i < count($product->images); $i++) {
										$image = $product->images[$i];
										?>
										<div class="vm-product-media-container-a popupImgProduct">
											<?php
												echo '<img src="'.JURI::root().$image->file_url .'" alt="'. $image->file_title .'" >';
											?>
										</div>
									<?php
									}		
							    } else {
							    	?>
							    	<span class="vm-product-media-container-a">
							    		<img src="<?php echo $main_image_url ?>"  alt="'. $image->file_title .'" />
							    	</span>
							    	<?php
							    }
							?>
							</div>
							<?php
							if (count($product->images) > 1) { ?>
								<div class="additional-images-wrapper clearfix">
									<?php
									$start_image = VmConfig::get('add_img_main', 1) ? 0 : 1;
									for ($i = 0; $i < count($product->images); $i++) {
										$image = $product->images[$i];
										?>
										<div class="additionalItem">
											<?php
												echo $image->displayMediaThumb('', false);
											?>
										</div>
									<?php
									}
									?>
								</div>
							<?php } ?>
						</div>
						<div class="col-md-7">
							<div class="summaryProduct">
								<div class="summaryProduct-content">
									<?php $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .	$product->virtuemart_category_id); ?>
									<a class="details-title h2 block" title="<?php echo $product->product_name ?>" href="<?php echo $url; ?>"><?php echo $product->product_name ?></a>
								</div>
								<!-- end content -->
								<div class="review-price clearfix">
									<ul class="list-review list-unstyled">
										<?php
										$showRating = $ratingModel->showRating($product->virtuemart_product_id);
										if ($showRating=='true'){
											echo "<li>";
											$rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
											if( !empty($rating)) {
											  $r = $rating->rating;
											} else {
											  $r = 0;
											}
											$maxrating = VmConfig::get('vm_maximum_rating_scale',5);
											$ratingwidth = ( $r * 100 ) / $maxrating; ?>
											<?php  if( !empty($rating)) {  ?>                        
											      <div title=" <?php echo (vmText::_("COM_VIRTUEMART_RATING_TITLE") . round($rating->rating) . '/' . $maxrating) ?>" class="ratingbox" >
													  <div class="stars-orange" style="width:<?php echo $ratingwidth.'%'; ?>"></div>
													</div>
											 <?php } else { ?>
											    <div class="ratingbox dummy" title="<?php echo vmText::_('COM_VIRTUEMART_UNRATED'); ?>" ></div>
											<?php } 
											echo "</li>";
										 } ?>
										 <li class="ml-40">
											<?php
												$ratingsModel = VmModel::getModel ('ratings');
												$rating_reviews = $ratingsModel->getReviewsByProduct($product->virtuemart_product_id);
												$reviews = count($rating_reviews);
											?>
											<?php echo $reviews.' '; echo ($reviews > 0)?JText::_('COM_VIRTUEMART_REVIEWS'):JText::_('COM_VIRTUEMART_REVIEW')?>

										</li>
									</ul>
								</div>
								<?php if (!empty($product->product_sku)) {?>
							    	<div class="summary-sku"><span><?php echo vmText::_('TPL_PRODUCT_CODE')?> </span> <span><?php echo $product->product_sku;?></span></div>	
							    <?php  }?>
								<?php echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$product,'currency'=>$currency)); ?>
								
								<?php
							    // Product Short Description
							    if (!empty($product->product_s_desc)) {
								?>
							        <div class="summary-description"><?php echo nl2br($product->product_s_desc); ?></div>
								<?php
							    } // Product Short Description END?>								    
								<div class="summaryDetail">
									<?php // Product category ?>
									<div class="product-info">
										<span><?php echo vmText::_('COM_VIRTUEMART_CATEGORY')?>:</span>
										<?php
										$cats = array();
										foreach($product->categoryItem as $category) {
											//Link to products
											$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category['virtuemart_category_id'], FALSE);
											$categoryName = $category['category_name'];
											$cats[] = '<a href='.$catURL.' title="'.$categoryName.'">'.$categoryName.'</a>';
										}
										echo implode(', ',$cats);
										?>
									</div>
									<div class="product-info">
										<?php 
										if (VmConfig::get('show_manufacturers', 1)) {
											echo '<span>'.JText::_('COM_VIRTUEMART_PRODUCT_DETAILS_MANUFACTURER_LBL').'</span>';
										    ?>
										   	<?php echo $product->mf_name ?>
										<?php }
										?>
									</div>
								</div>
								<?php // Product tool ?>
								<?php echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));?>
							</div>
						</div>
					</div>
					<!-- End row -->
			</div>
			<?php die(); ?>
		<?php 
		} 
	}
} 
class PlgSystemPopupInstallerScript{
    public function postflight($type, $parent)
    { 
        $db = JFactory::getDBO();        
        $query = "UPDATE #__extensions SET enabled=1 WHERE type='plugin' AND element=".$db->Quote('popup')." AND folder=".$db->Quote('system');
        $db->setQuery($query);
        $db->query(); 
    }    
}        
?>