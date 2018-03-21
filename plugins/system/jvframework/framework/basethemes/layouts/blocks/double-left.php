<div class="block blockleft  equal-column <?php echo $options['class']; ?> row">
<?php 
$count = count($html);
if($count)
	switch ($count) {
	
		case 1:
			printf('<div class="col-md-12 col-sm-12">%s</div>', $html[0]);
			break;
	
		case 2:
			
			printf('<div class="col-md-4 col-sm-4">%s</div>', $html[0]);
			printf('<div class="col-md-8 col-sm-8">%s</div>', $html[1]);
			break;
	
		case 3:
			printf('<div class="col-md-3 col-sm-3">%s</div>', $html[0]);
			printf('<div class="col-md-3 col-sm-3">%s</div>', $html[1]);
			printf('<div class="col-md-6 col-sm-6">%s</div>', $html[2]);
			break;
	
		case 4:
			printf('<div class="col-md-3 col-sm-3">%s</div>', $html[0]);
			printf('<div class="col-md-3 col-sm-3">%s</div>', $html[1]);
			printf('<div class="col-md-3 col-sm-3">%s</div>', $html[2]);
			printf('<div class="col-md-3 col-sm-3">%s</div>', $html[3]);
			break;
	
		case 5:
			printf('<div class="col-md-2 col-sm-2">%s</div>', $html[0]);
			printf('<div class="col-md-2 col-sm-2">%s</div>', $html[1]);
			printf('<div class="col-md-2 col-sm-2">%s</div>', $html[2]);
			printf('<div class="col-md-2 col-sm-2">%s</div>', $html[3]);
			printf('<div class="col-md-4 col-sm-4">%s</div>', $html[4]);
			break;
			
		case 6:
			printf('<div class="col-md-2 col-sm-2">%s</div>', $html[0]);
			printf('<div class="col-md-2 col-sm-2">%s</div>', $html[1]);
			printf('<div class="col-md-2 col-sm-2">%s</div>', $html[2]);
			printf('<div class="col-md-2 col-sm-2">%s</div>', $html[3]);
			printf('<div class="col-md-2 col-sm-2">%s</div>', $html[4]);
			printf('<div class="col-md-2 col-sm-2">%s</div>', $html[5]);
			break;
		
	}	
?>
</div>