<ul class="nav nav-tabs">
	<?php foreach ($modules as $index => $module): ?>
		 <li <?php echo $index == 0 ? ' class="active"' : '';?>>		 	
		 	<a data-toggle="tab" href="#mod<?php echo $module->id; ?>">
		 		<?php echo $module->title; ?>
		 	</a>
		</li>
	<?php endforeach;?>
</ul>

<div class="tab-content">
	<?php foreach ($modules as $index => $module): ?>
		 <div class="tab-pane fade in<?php echo $index == 0 ? ' active' : '';?>" id="mod<?php echo $module->id; ?>">
		 	<?php echo $module->content; ?>
		 </div>
	<?php endforeach;?>
</div>