<?php 
	// Theme configuration
	include($this['path']->findPath('style.config.php'));
?>
<!DOCTYPE html>
<html lang="<?php echo $this['template']->document->language; ?>" dir="<?php echo $this['template']->document->direction; ?>" >
<head>
	<?php echo $this['template']->render('head');?>	
</head>
<body class="<?php echo $this['option']->get('template.body.class'); ?>">
	<div class="wrapper">
		<div id="block-main">
		    <div class="container">

		        	<?php if($this['position']->count('message')) echo $this['position']->render('message');?>
					<jdoc:include type="component" />

		    </div>
		</div>
	</div>
	<?php echo $this['position']->render('analytic.none'); ?> 
</body>
</html>