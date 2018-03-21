
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
	<?php
	echo $this['template']->render('head');	

    include($this['path']->findPath('style.config.php'));
    ?>    
</head>
<body class="<?php echo $this['option']->get('template.body.class'); ?>">
	<div id="wrapper">
        <div id="mainsite">
            <span class="flexMenuToggle" ></span> 
            <?php  echo $this['template']->render('top'); ?>
            <section id="block-main">
                <div class="container">
                	<div class="row">
                        <?php echo $this['template']->render('content'); ?>		
                        <?php echo $this['template']->render('sidebar-a'); ?>             	            
                        <?php echo $this['template']->render('sidebar-b'); ?>
                     </div>   
                </div>
            </section>
            <?php echo $this['template']->render('bottom'); ?>
        </div> 
	</div>
	<?php echo $this['position']->render('analytic.none'); ?>  
</body>
</html>