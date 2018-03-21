<div class="block blockgrid  equal-column <?php echo $options['class']; ?> row">
<?php 
$count = count($html);
$grid = json_decode($options['grid'], true);
$grid = $grid[$count];

if($count)
	switch ($count) {
	
		case 1:
			printf('<div class="col-md-12 col-sm-12">%s</div>', $html[0]);
			break;
	
		case 2:
			
			printf('<div class="col-md-'.$grid[0].' col-sm-'.$grid[0].'">%s</div>', $html[0]);
			printf('<div class="col-md-'.$grid[1].' col-sm-'.$grid[1].'">%s</div>', $html[1]);
			break;
	
		case 3:
			printf('<div class="col-md-'.$grid[0].' col-sm-'.$grid[0].'">%s</div>', $html[0]);
			printf('<div class="col-md-'.$grid[1].' col-sm-'.$grid[1].'">%s</div>', $html[1]);
			printf('<div class="col-md-'.$grid[2].' col-sm-'.$grid[2].'">%s</div>', $html[2]);
			break;
	
		case 4:
			printf('<div class="col-md-'.$grid[0].' col-sm-'.$grid[0].'">%s</div>', $html[0]);
			printf('<div class="col-md-'.$grid[1].' col-sm-'.$grid[1].'">%s</div>', $html[1]);
			printf('<div class="col-md-'.$grid[2].' col-sm-'.$grid[2].'">%s</div>', $html[2]);
			printf('<div class="col-md-'.$grid[3].' col-sm-'.$grid[3].'">%s</div>', $html[3]);
			break;
	
		case 5:
			printf('<div class="col-md-'.$grid[0].' col-sm-'.$grid[0].'">%s</div>', $html[0]);
			printf('<div class="col-md-'.$grid[1].' col-sm-'.$grid[1].'">%s</div>', $html[1]);
			printf('<div class="col-md-'.$grid[2].' col-sm-'.$grid[2].'">%s</div>', $html[2]);
			printf('<div class="col-md-'.$grid[3].' col-sm-'.$grid[3].'">%s</div>', $html[3]);
			printf('<div class="col-md-'.$grid[4].' col-sm-'.$grid[4].'">%s</div>', $html[4]);
			break;
			
		case 6:
			printf('<div class="col-md-'.$grid[0].' col-sm-'.$grid[0].'">%s</div>', $html[0]);
			printf('<div class="col-md-'.$grid[1].' col-sm-'.$grid[1].'">%s</div>', $html[1]);
			printf('<div class="col-md-'.$grid[2].' col-sm-'.$grid[2].'">%s</div>', $html[2]);
			printf('<div class="col-md-'.$grid[3].' col-sm-'.$grid[3].'">%s</div>', $html[3]);
			printf('<div class="col-md-'.$grid[4].' col-sm-'.$grid[4].'">%s</div>', $html[4]);
			printf('<div class="col-md-'.$grid[5].' col-sm-'.$grid[5].'">%s</div>', $html[5]);
			break;
		
	}	
?>
</div>