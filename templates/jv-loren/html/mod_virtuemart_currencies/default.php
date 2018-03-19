<?php // no direct access
defined('_JEXEC') or die('Restricted access');
vmJsApi::jQuery();
JHtml::_('formbehavior.chosen', 'select');
?>
<!-- Currency Selector Module -->
<?php echo $text_before ?>
<div class="mod_currency">
	<form action="<?php echo vmURI::getCleanUrl() ?>" method="post">
			<?php echo JHTML::_('select.genericlist', $currencies, 'virtuemart_currency_id', 'class="inputbox vm-chzn-select" onchange="this.form.submit()"', 'virtuemart_currency_id', 'currency_txt', $virtuemart_currency_id) ; ?>
	</form>
</div>