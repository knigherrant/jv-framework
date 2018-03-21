<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage vendor
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

<div class="vendor-details-view">

    <div class="row">
        <div class="col-sm-3">
                <div class="thumbnail vendor-image">
                <?php if (!empty($this->vendor->images[0])) { ?>
                <?php echo $this->vendor->images[0]->displayMediaThumb('',false); ?>
                <?php
                } ?>
                </div>
            </div>
        <div class="col-sm-9 featured-box">
        	<h4 class="text-uppercase mt-0 mb-30"><?php echo $this->vendor->vendor_store_name; ?></h4>
            <?php echo shopFunctionsF::renderVendorAddress($this->vendor->virtuemart_vendor_id); ?>
            <br>   
            <div class="clearfix vendor-details-view-link">
                <span class="btn btn-dark btn-outline btn-radius"><?php echo $this->linktos ?></span>
                <span class="btn btn-dark btn-outline btn-radius"><?php echo $this->linkdetails ?></span>
            </div>
        </div>
    </div>
    <!-- End row -->
    <div class="form-field">
    	<p><?php echo vmText::_('COM_VIRTUEMART_VENDOR_ASK_QUESTION')  ?></p>
    	<br>	
		<?php
			/*	foreach($this->userFields as $userfields){

				foreach($userfields['fields'] as $item){
					if(!empty($item['value'])){
						if($item['name']==='agreed'){
							$item['value'] =  ($item['value']===0) ? vmText::_('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_NO'):vmText::_('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_YES');
						}
					?><!-- span class="titles"><?php echo $item['title'] ?></span -->
								<span class="values vm2<?php echo '-'.$item['name'] ?>" ><?php echo $this->escape($item['value']) ?></span>
							<?php if ($item['name'] != 'title' and $item['name'] != 'first_name' and $item['name'] != 'middle_name' and $item['name'] != 'zip') { ?>
								<br class="clear" />
							<?php
						}
					}
				}
			} */
			$min = VmConfig::get('asks_minimum_comment_length', 50);
			$max = VmConfig::get('asks_maximum_comment_length', 2000) ;
			vmJsApi::JvalideForm();
			vmJsApi::addJScript('askform', '
				jQuery(function($){
						$("#askform").validationEngine("attach");
						$("#comment").keyup( function () {
							var result = $(this).val();
								$("#counter").val( result.length );
						});
				});
			');
		?>
		<form method="post" class="form-validate" action="<?php echo JRoute::_('index.php') ; ?>" name="askform" id="askform">

			<div class="form-group">
				<label for="name"><?php echo vmText::_('COM_VIRTUEMART_USER_FORM_NAME')  ?> :</label><input type="text" class="validate[required,minSize[4],maxSize[64]] form-control" value="<?php echo $this->user->name ?>" name="name" id="name" size="30"  validation="required name"/>
				<div class="bottom-border"></div>
			</div>

			<div class="form-group">
				<label for="email"> <?php echo vmText::_('COM_VIRTUEMART_USER_FORM_EMAIL')  ?> :</label> <input type="text" class="validate[required,custom[email]] form-control" value="<?php echo $this->user->email ?>" name="email" id="email" size="30"  validation="required email"/>
				<div class="bottom-border"></div>
			</div>
			<div class="form-group">
				<label for="comment"> <?php
				$ask_comment = vmText::sprintf('COM_VIRTUEMART_ASK_COMMENT', $min, $max);
				echo $ask_comment;
				?>
				</label>
				<textarea title="<?php echo $ask_comment ?>" class="form-control validate[required,minSize[<?php echo $min ?>],maxSize[<?php echo $max ?>]] field" id="comment" name="comment" cols="30" rows="10"></textarea>
				<div class="bottom-border"></div>
			</div>
			<p class="form-inline">
				<?php echo vmText::_('COM_VIRTUEMART_ASK_COUNT')  ?>
				<input type="text" value="0" size="4" class="counter form-control" id="counter" name="counter" maxlength="4" readonly="readonly" />
			</p>
			<p class="submit">
				<input class="btn btn-primary btn-radius" type="submit" name="submit_ask" title="<?php echo vmText::_('COM_VIRTUEMART_ASK_SUBMIT')  ?>" value="<?php echo vmText::_('COM_VIRTUEMART_ASK_SUBMIT')  ?>" />
			</p>

			<input type="hidden" name="view" value="vendor" />
			<input type="hidden" name="virtuemart_vendor_id" value="<?php echo $this->vendor->virtuemart_vendor_id ?>" />
			<input type="hidden" name="option" value="com_virtuemart" />
			<input type="hidden" name="task" value="mailAskquestion" />
			<?php echo JHtml::_( 'form.token' ); ?>
		</form>
	</div>

</div>