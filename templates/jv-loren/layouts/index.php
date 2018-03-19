<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
    <head>
    	<?php
    	echo $this['template']->render('head');	
        include($this['path']->findPath('style.config.php'));
        ?>    
    </head>
    <?php
        $view   = (JRequest::getCmd('view') !='')?' view-'.JRequest::getCmd('view'):'';
        $option = (JRequest::getCmd('option') !='')?' option-'.JRequest::getCmd('option'):'';
        $layout = (JRequest::getCmd('layout') !='')?' layout-'.JRequest::getCmd('layout'):'';
        $task   = (JRequest::getCmd('task') !='')?' task-'.JRequest::getCmd('task'):'';
    ?>
    <body class="<?php echo $this['option']->get('template.body.class'); echo $view; echo $option; echo $layout; echo $task;?>">
    	<?php if(class_exists('plgSystemLoader')){?>
            <div class="loader-overlay"></div>
            <div class="loader-content" id="landing-progress"></div>
        <?php } ?>
        <?php // Main Wrapper?>
        <div id="wrapper">
            <div id="mainsite">
                <span class="flexMenuToggle" ></span> 
                <?php echo $this['template']->render('top'); ?>
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
        <?php // Switcher Demo Style?>
        <?php if( $this['position']->count('demo') ):?>    
        <div id="switcher">
            <a href="javascript:void(0)" class="show-switcher-icon" id="button-switch"></a>
            <jdoc:include type="position" name="color" style="none" />
            <jdoc:include type="position" name="demo" style="none" />
        </div> 
        <?php endif;?> 
        <?php // Demo Menu Module ?>
        <?php if( $this['position']->count('demo-menu') ):?>
        <div id="demo-menu" class="demo-menu">
            <jdoc:include type="position" name="demo-menu" style="none" />
        </div>
        <?php endif;?>
    	<?php echo $this['position']->render('analytic.none'); ?> 
    </body>
</html>