<div class="accordion position position-<?php echo $position; echo isset($options['class']) ? ' '.$options['class'] : ''; ?>"  id="tbaccordion-<?php echo $position; ?>">
<?php 
	$count = count($modules);
	foreach($modules as $index => $module): 
		$id   = 'tbaccordion-'.$position.'-'.$index;?>		
		<div class="accordion-group">
	      <div class="accordion-heading">
	      	<h3 class="title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#tbaccordion-<?php echo $position; ?>" href="<?php echo '#'.$id; ?>">
		         <span><?php echo $module->title; ?></span>
		        </a>
			</h3>	        
	      </div>
	      <div id="<?php echo $id; ?>" class="accordion-body collapse<?php if($index == 0) echo ' in'; ?>">
	        <div class="accordion-inner">
	          <?php echo $module->content; ?>
	        </div>
	      </div>
	    </div>	    
	<?php endforeach; ?>
</div>