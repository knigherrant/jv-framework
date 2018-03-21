<?php if($this['block'] -> count('left') || $this['block'] -> count('left-1') || $this['block'] -> count('left-2')):?>
<aside id="sidebar-a" class="sidebar  <?php echo $this['option']->get('template.sidebar-a.class'); ?> sidebar-left">
	<div class="sidebar-inner">
		<jdoc:include type="position" name="left-1"/>
		<jdoc:include type="position" name="left"/>
		<jdoc:include type="position" name="left-2"/>                
    </div>
</aside>
<?php   endif;?>