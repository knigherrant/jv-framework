
	<div id="main-content"  class="<?php echo $this['option']->get('template.content.class'); ?>">
        <jdoc:include type="position" name="content-top"  />
	    <?php if($this['block']->count('contenttop')):?>
        <div class="contenttop">        
        	<jdoc:include type="block" name="contenttop" grid-mode="fluid" />
        </div>
        <?php endif;?>
        
        <div id="content">

	        <jdoc:include type="message" />
			<jdoc:include type="component" />
	    </div>
        <jdoc:include type="position" name="content-bottom"  />        
        <?php if($this['block']->count('contentbottom')):?>
        <div class="contentbottom">
        	<jdoc:include type="block" name="contentbottom" grid-mode="fluid" />
        </div>
        <?php endif;?>
    </div>
