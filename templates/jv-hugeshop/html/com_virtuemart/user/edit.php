<?php
/**
*
* Modify user form view
*
* @package	VirtueMart
* @subpackage User
* @author Oscar van Eijk
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: edit.php 8565 2014-11-12 18:26:14Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Implement Joomla's form validation
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', '.vm-chzn-select');
JHtml::stylesheet('vmpanels.css', JURI::root().'components/com_virtuemart/assets/css/'); // VM_THEMEURL
vmJsApi::addJScript('modals',"
//<![CDATA[
	jQuery(document).ready(function($) {
		$('.vm_thumb').addClass('modal').removeClass('vm_thumb');
		$('#divadmintable .modal').magnificPopup({
			type: 'image',
			mainClass: 'my-mfp-zoom-in',
			removalDelay: 160
		});
	});
//]]>
");
?>


<?php $this->vmValidator(); ?>

<div class="page-user-maxwidth vm-view-user-edit">

	<?php echo shopFunctionsF::getLoginForm(false); ?>

	<div class="panel panel-default ">
	    <div class="panel-heading">
	        <h3 class="panel-title"><?php if($this->userDetails->virtuemart_user_id==0) {	echo vmText::_('COM_VIRTUEMART_YOUR_ACCOUNT_REG'); } else echo vmText::_('COM_VIRTUEMART_YOUR_ACCOUNT_DETAILS');   ?></h3>
	    </div>
	    <div class="panel-body">
			<form method="post" id="adminForm" name="userForm" action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=user',$this->useXHTML,$this->useSSL) ?>" class="form-validate">
				<?php if($this->userDetails->user_is_vendor){ ?>
				    <div class="buttonBar-right">
					<button class="btn btn-primary btn-sm btn-outline" type="submit" onclick="javascript:return myValidator(userForm, true);" ><?php echo $this->button_lbl ?></button>
					&nbsp;
					<button class="btn btn-default btn-sm btn-outline" type="reset" onclick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=user&task=cancel', FALSE); ?>'" ><?php echo vmText::_('COM_VIRTUEMART_CANCEL'); ?></button>
					</div>
			    <?php } ?>

				<?php // Loading Templates in Tabs
				if($this->userDetails->virtuemart_user_id!=0) { 
				    $tabarray = array();

				    $tabarray['shopper'] = 'COM_VIRTUEMART_SHOPPER_FORM_LBL';

					if($this->userDetails->user_is_vendor){
						if(!empty($this->add_product_link)) {
							echo $this->manage_link;
							echo $this->add_product_link;
						}
						$tabarray['vendor'] = 'COM_VIRTUEMART_VENDOR';
					}

				    //$tabarray['user'] = 'COM_VIRTUEMART_USER_FORM_TAB_GENERALINFO';
				    if (!empty($this->shipto)) {
					    $tabarray['shipto'] = 'COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL';
				    }
				    if (($_ordcnt = count($this->orderlist)) > 0) {
					    $tabarray['orderlist'] = 'COM_VIRTUEMART_YOUR_ORDERS';
				    }
				    shopFunctionsF::buildTabs ( $this, $tabarray);

				 } else {
				    echo $this->loadTemplate ( 'shopper' );
				    echo $this->captcha;
				 }

				// captcha addition
				/*if(VmConfig::get ('reg_captcha')){
					JHTML::_('behavior.framework');
					JPluginHelper::importPlugin('captcha');
					$dispatcher = JDispatcher::getInstance(); $dispatcher->trigger('onInit','dynamic_recaptcha_1');
					?>
					<div id="dynamic_recaptcha_1"></div>
				<?php
				}*/
				// end of captcha addition
				?>
				<input type="hidden" name="option" value="com_virtuemart" />
				<input type="hidden" name="controller" value="user" />
				<?php echo JHtml::_( 'form.token' ); ?>
			</form>
	    </div>
	</div>
</div>

