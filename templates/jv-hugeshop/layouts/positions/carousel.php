<?php 
$id = "tbcarousel{$position}";
$this['asset']->addInlineScript("
	jQuery(function($){
		var carousel = $('#{$id}'),
			buttons  = carousel.find('.carousel-button');
		
		if(buttons){
			buttons.eq(0).addClass('btnactive');
			carousel.bind('slid', function(){
				var active = $(this).find('.active');
				
				buttons.removeClass('btnactive');
				buttons.eq(active.data('index')).addClass('btnactive');
			});
			
			buttons.each(function(){
				$(this).click(function(){					
					carousel.carousel($(this).data('index'));
				});
			});
		}
	});	
");
?>
</script>
<div id="<?php echo $id; ?>" class="carousel slide position position-<?php echo $position; echo isset($options['class']) ? ' '.$options['class'] : ''; ?>">
	<!-- Carousel items -->
	<div class="carousel-inner">
		<?php foreach($modules as $index => $module): ?>
			<figure data-index="<?php echo $index; ?>" id="tbitem<?php echo $module->id; ?>" class="item<?php echo $index == 0 ? ' active' : ''; ?>">
				<?php echo $module->content; ?>
				<?php if(isset($options['showCaption']) && $options['showCaption']):?>
				<figcaption class="carousel-caption">
	                  <h4><?php echo $module->title; ?></h4>
	            </figcaption >
	            <?php endif;?>
            </figure>
		<?php endforeach; ?>
	</div>
	<ul class="carousel-buttons">
	<?php foreach($modules as $index => $module): ?>
	<li>
		<a data-index="<?php echo $index; ?>" class="carousel-button" href="javascript:void(0);"><?php echo $index+1; ?></a>
	</li>
	<?php endforeach; ?>
	</ul>
	<!-- Carousel nav -->
	<a class="carousel-control left" href="#<?php echo $id; ?>" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#<?php echo $id; ?>" data-slide="next">&rsaquo;</a>
</div>