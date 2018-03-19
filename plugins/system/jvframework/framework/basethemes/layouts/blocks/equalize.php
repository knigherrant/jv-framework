<div class="block blockequalize equal-column <?php echo $options['class']; ?> row">
<?php 
$count = count($html);
$grid = json_decode($options['grid']);
if(empty($grid) || $grid=='null') $grid='';
else  $grid = json_encode($grid->$count);
$this['block']->calcGrid($grid, $count);
if($count <= 6):
	foreach ($grid as $i => $grid):
		printf('<div class="col-md-'.$grid.' col-sm-'.$grid.'">%s</div>', $html[$i]);
	endforeach;
endif;
?>
</div>