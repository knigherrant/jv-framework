<?php if($this['block'] -> count('left')):?>
<aside id="sidebar-a" class="sidebar  <?php echo $this['option']->get('template.sidebar-a.class'); ?>">
	<div class="sidebar-inner">
		<jdoc:include type="position" name="left-1"/>
		<jdoc:include type="position" name="left"/>
		<jdoc:include type="position" name="left-2"/>                
    </div>
</aside>
<?php   endif;?>