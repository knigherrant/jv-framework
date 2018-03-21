<?php
$count = count($html);
$grid = '';
$this['block']->calcGrid($grid, $count);

if($count <= 6):	
	echo "<div class='position position-{$position}'>";
		echo "<div class='row-fluid'>";
			foreach ($grid as $i => $grid):
				printf('<div class="span'.$grid.'">%s</div>', $html[$i]);
			endforeach;
		echo "</div>";
	echo "</div>";
endif;