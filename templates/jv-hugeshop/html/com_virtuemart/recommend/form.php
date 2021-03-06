<?php
/**
 *TODO Improve the CSS , ADD CATCHA ?
 * Show the form Ask a Question
 *
 * @package	VirtueMart
 * @subpackage
 * @author Kohl Patrick, Maik K�nnemann
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
* @version $Id: default.php 2810 2011-03-02 19:08:24Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );

$min = VmConfig::get('asks_minimum_comment_length', 50);
$max = VmConfig::get('asks_maximum_comment_length', 2000);
vmJsApi::JvalideForm();
vmJsApi::addJScript('askform','
	jQuery(function($){
			$("#askform").validationEngine("attach");
			var counterResult = $("#comment").val().length;
			$("#counter").val( counterResult );
			$("#comment").keyup( function () {
				var result = $(this).val();
					$("#counter").val( result.length );
			});
	});
'); 

$vendorModel = VmModel::getModel ('vendor');
$this->vendor = $vendorModel->getVendor ($this->product->virtuemart_vendor_id);

/* Let's see if we found the product */
if (empty ( $this->product )) {
	echo vmText::_ ( 'COM_VIRTUEMART_PRODUCT_NOT_FOUND' );
	echo '<br /><br />  ' . $this->continue_link_html;
} else {
	$session = JFactory::getSession();
	$mailRecommendData = $session->get('mailrecommend', 0, 'vm');
	if(!empty($this->login)){
		echo $this->login;
	}
	if(empty($this->login) or VmConfig::get('recommend_unauth',false)){
		?>

		<div class="vmquestionview">
			<h1><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_RECOMMEND')  ?></h1>
			<hr>
			<div class="product-summary row">
				<div class="col-xs-3">
					<div class="thumbnail">
						<?php // Product Image
						echo $this->product->images[0]->displayMediaThumb('class="product-image"',false); ?>
					</div>
					<div class="bottom-border"></div>
				</div>
				<div class="col-xs-9">
					<h4><?php echo $this->product->product_name ?></h4>
					<?php // Product Short Description
					if (!empty($this->product->product_s_desc)) { ?>
						<div class="short-description">
							<?php echo $this->product->product_s_desc ?>
						</div>
					<?php } // Product Short Description END ?>
				</div>				
			</div>
			<hr>
			<div class="form-field">

				<form method="post" class="form-validate form-" action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$this->product->virtuemart_product_id.'&virtuemart_category_id='.$this->product->virtuemart_category_id.'&tmpl=component', FALSE) ; ?>" name="askform" id="askform" >
					<div class="form-group">
						<label><?php echo vmText::_('COM_VIRTUEMART_RECOMMEND_NAME')  ?> : </label>
						<input type="text" value="" name="name" id="name" size="30" class="validate[required,minSize[3],maxSize[64]] form-control"/>
					</div>
					<div class="form-group">
						<label><?php echo vmText::_('COM_VIRTUEMART_RECOMMEND_EMAIL')  ?> : </label>
						<input class="form-control" type="text" value="<?php echo $mailRecommendData['email'] ?>" name="email" id="email" size="30" class="validate[required,custom[email]]"/>
					</div>
					<div  class="form-group">
						<label><?php echo vmText::sprintf('COM_VIRTUEMART_COMMENT', $min, $max); ?></label>
						<textarea title="" class="validate[required,minSize[<?php echo $min ?>],maxSize[<?php echo $max ?>]] field form-control" id="comment" name="comment" rows="8"><?php echo vmText::sprintf('COM_VIRTUEMART_RECOMMEND_COMMENT') ?></textarea><div class="bottom-border"></div></td>
					</div>
					<div class=" form-group">
						<label><?php echo vmText::_('COM_VIRTUEMART_ASK_COUNT')  ?></label>
						<input type="text" value="0" size="4" class="counter form-control" id="counter" name="counter" maxlength="4" readonly="readonly" />
					</div>
					<div class="form-group clearfix">
						<?php // captcha addition
						if(VmConfig::get ('ask_captcha')){
							JHTML::_('behavior.framework');
							JPluginHelper::importPlugin('captcha');
							$dispatcher = JDispatcher::getInstance(); $dispatcher->trigger('onInit','dynamic_recaptcha_1');
							?>
							<div id="dynamic_recaptcha_1" class="form-group"></div>
						<?php 
						}
						?>
					</div>
					<div class="form-group">
						<input class="btn btn-default" type="submit" name="submit_ask" title="<?php echo vmText::_('COM_VIRTUEMART_RECOMMEND_SUBMIT')  ?>" value="<?php echo vmText::_('COM_VIRTUEMART_RECOMMEND_SUBMIT')  ?>" />
					</div>

					<input type="hidden" name="virtuemart_product_id" value="<?php echo vRequest::getInt('virtuemart_product_id',0); ?>" />
					<input type="hidden" name="tmpl" value="component" />
					<input type="hidden" name="view" value="productdetails" />
					<input type="hidden" name="option" value="com_virtuemart" />
					<input type="hidden" name="virtuemart_category_id" value="<?php echo vRequest::getInt('virtuemart_category_id'); ?>" />
					<input type="hidden" name="task" value="mailRecommend" />
					<?php echo JHTML::_( 'form.token' ); ?>
				</form>

			</div>
		</div>

<?php }
}?>
