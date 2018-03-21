<div class="block blockstack  <?php echo $options['class']; ?> row">
<?php 
if(count($html))
	foreach ($html as $html)
	printf('<div class="col-md-12 col-sm-12">%s</div>', $html);
?>
</div>