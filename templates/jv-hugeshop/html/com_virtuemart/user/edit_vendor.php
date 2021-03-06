<?php
/**
*
* Modify user form view, User info
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
* @version $Id: edit_vendor.php 8539 2014-10-30 15:52:48Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access'); ?>
<!--div class="col50"-->

<div id="divadmintable">
<div class="row">
	<div class="col-sm-6">
    	<div class="wraptable">
			<h3 class="userfields_info "><?php echo vmText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL') ?></h3>
			<table class="admintable table table-striped table-hover table-bordered">
				<tr>
					<td class="key">
						<?php echo vmText::_('COM_VIRTUEMART_STORE_FORM_STORE_NAME'); ?>:
					</td>
					<td>
						<input class="form-control" type="text" name="vendor_store_name" id="vendor_store_name" size="50" value="<?php echo $this->vendor->vendor_store_name; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo vmText::_('COM_VIRTUEMART_STORE_FORM_COMPANY_NAME'); ?>:
					</td>
					<td>
						<input class="form-control" type="text" name="vendor_name" id="vendor_name" size="50" value="<?php echo $this->vendor->vendor_name; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo vmText::_('COM_VIRTUEMART_PRODUCT_FORM_URL'); ?>:
					</td>
					<td>
						<input class="form-control" type="text" name="vendor_url" id="vendor_url" size="50" value="<?php echo $this->vendor->vendor_url; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo vmText::_('COM_VIRTUEMART_STORE_FORM_MPOV'); ?>:
					</td>
					<td>
						<input class="form-control" type="text" name="vendor_min_pov" id="vendor_min_pov" size="10" value="<?php echo $this->vendor->vendor_min_pov; ?>" />
					</td>
				</tr>
			</table>
		</div>
    </div>
	<div class="col-sm-6">
    	<div class="wraptable">
			<h3 class="userfields_info "><?php echo vmText::_('COM_VIRTUEMART_STORE_CURRENCY_DISPLAY') ?></h3>
			<table class="admintable table table-striped table-hover table-bordered">
				<tr>
					<td class="key">
						<?php echo vmText::_('COM_VIRTUEMART_CURRENCY'); ?>:
					</td>
					<td>
						<?php echo JHtml::_('Select.genericlist', $this->currencies, 'vendor_currency', 'class="vm-chzn-select"', 'virtuemart_currency_id', 'currency_name', $this->vendor->vendor_currency); ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo vmText::_('COM_VIRTUEMART_STORE_FORM_ACCEPTED_CURRENCIES'); ?>:
					</td>
					<td>
						<?php echo JHtml::_('Select.genericlist', $this->currencies, 'vendor_accepted_currencies[]', 'size=10 multiple="multiple" class="vm-chzn-select"', 'virtuemart_currency_id', 'currency_name', $this->vendor->vendor_accepted_currencies); ?>
					</td>
				</tr>
			</table>
		</div>
    </div>
</div>


	

<div class="row">
	<div class="col-sm-6">
		<div class="wraptable">
			<h3 class="userfields_info "><?php echo vmText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL') ?></h3>
			<?php
				echo $this->vendor->images[0]->displayFilesHandler($this->vendor->virtuemart_media_id,'vendor');
			?>
		</div>
    </div>
	<div class="col-sm-6">
		<div class="wraptable">
			<h3 class="userfields_info "><?php echo vmText::_('COM_VIRTUEMART_STORE_FORM_DESCRIPTION') ?></h3>
			<?php echo $this->editor->display('vendor_store_desc', $this->vendor->vendor_store_desc, '100%', 450, 70, 15)?>
		</div>
    </div>    
</div>
    

<div class="row">
	<div class="col-sm-6">
    	<div class="wraptable">
			<h3 class="userfields_info "><?php echo vmText::_('COM_VIRTUEMART_STORE_FORM_TOS') ?></h3>
			<?php echo $this->editor->display('vendor_terms_of_service', $this->vendor->vendor_terms_of_service, '100%', 450, 70, 15)?>
		</div>
    </div>
	<div class="col-sm-6">
    	<div class="wraptable">
			<h3 class="userfields_info "><?php echo vmText::_('COM_VIRTUEMART_STORE_FORM_LEGAL') ?></h3>
			<?php echo $this->editor->display('vendor_legal_info', $this->vendor->vendor_legal_info, '100%', 400, 70, 15)?>
		</div>
    </div>    
</div>
    
    
<!--/div -->
<input type="hidden" name="user_is_vendor" value="1" />
<input type="hidden" name="virtuemart_vendor_id" value="<?php echo $this->vendor->virtuemart_vendor_id; ?>" />
<input type="hidden" name="last_task" value="<?php echo vRequest::getCmd('task'); ?>" />


</div>