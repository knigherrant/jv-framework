<?php if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){?>
<div  class="bzSaleTimer item<?php echo $product_id;?>M format<?php echo ucfirst($timer_format); ?>">
	<?php
	$data = $product->prices['product_price_publish_down'];
	$data = explode(' ', $data);
	$time = explode(':', $data[1]);
	$data = explode('-', $data[0]);
	//var_dump($data);
	$year = $data[0];
	$month = $data[1];
	$data = $data[2];
	//var_dump($time);
	?>
	<div class="count_holder">
		<div id="CountSmall<?php echo $module->id.'-'.$product->virtuemart_product_id ?>" class="countdown countdown-big">
		 <script type="text/javascript">
		jQuery(function () {    
			jQuery('#CountSmall<?php echo $module->id."-".$product->virtuemart_product_id ?>').countdown({
			until: new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $data; ?>),
			labels: ['Years', 'Months', 'Weeks', '<?php echo $lDays; ?>', '<?php echo $lHours; ?>', '<?php echo $lMinutes;?>', '<?php echo $lSeconds; ?>'],
			labels1:['Years','Months','Weeks', '<?php echo $lDays; ?>', '<?php echo $lHours; ?>', '<?php echo $lMinutes;?>', '<?php echo $lSeconds; ?>'],
			compact: false});
		});
		 </script>
		 </div>
	 </div>
</div>   
<?php } ?>
