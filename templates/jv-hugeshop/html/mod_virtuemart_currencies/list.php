<?php // no direct access
defined('_JEXEC') or die('Restricted access');
vmJsApi::jQuery();
?>
<!-- Currency Selector Module -->
<?php echo $text_before ?>
<div class="mod_currency">
	<form action="<?php echo vmURI::getCleanUrl() ?>" method="post">
		
		<?php
		foreach ($currencies as $currency) { ?>
			<?php $checked = ($virtuemart_currency_id ==$currency->virtuemart_currency_id)?'checked':'';
				$select = ($virtuemart_currency_id ==$currency->virtuemart_currency_id)?' result-selected':'';  ?>
			<?php echo '<label class="radio'.$select.'"><input type="radio" name="virtuemart_currency_id" class="changeSendForm" value="'.$currency->virtuemart_currency_id.'" '.$checked.'>'. $currency->currency_txt.'</label>'; ?>
		<?php } ?>
	</form>
</div>
<?php 
$j = 'jQuery(document).ready(function() {

jQuery(".changeSendForm")
	.off("change",Virtuemart.sendCurrForm)
    .on("change",Virtuemart.sendCurrForm);
})';

vmJsApi::addJScript('sendFormChange',$j);

echo vmJsApi::writeJS();