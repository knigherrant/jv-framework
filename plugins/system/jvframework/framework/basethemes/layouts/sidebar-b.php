<?php if($this['block'] -> count('right')):?>
<aside id="sidebar-b" class="sidebar <?php echo $this['option']->get('template.sidebar-b.class'); ?>">
	<div class="sidebar-inner">
		<jdoc:include type="position" name="right-1"/>
		<jdoc:include type="position" name="right"/>
		<jdoc:include type="position" name="right-2"/>   
    </div>
</aside>
<?php endif;?>		