<?php
	$content_left = ($this['block'] -> count('left') || $this['block'] -> count('left-1') || $this['block'] -> count('left-2'));
	$content_right = ($this['block'] -> count('right') || $this['block'] -> count('right-1') || $this['block'] -> count('right-2'));
?>
	<div id="main-content"  class="<?php echo $this['option']->get('template.content.class'); echo ($content_left)?' content-left':''; echo ($content_right)?' content-right':''; ?> main-content">
		
        <jdoc:include type="position" name="content-top" style="xhtml" />        
        <div id="content">
	        <jdoc:include type="message" />
            <jdoc:include type="component" />
	    </div>
        <jdoc:include type="position" name="content-bottom"  />  
    </div>
