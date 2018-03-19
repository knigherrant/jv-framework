<?php
/**
 # com_jvframwork - JV Framework
 # @version		3.3.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');
$dthemecolor = $this ['option']->get ( 'styles.themecolor' );
// Get document error 
$doc = JDocument::getInstance('error');?>
<!DOCTYPE html>
<html dir="<?php if($this['option']->isRTL()) echo 'rtl'; else echo 'ltr'; ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.5, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="handheldfriendly" content="true" />
    <title><?php echo $doc->error->getCode(); ?> - <?php echo $doc->title; ?></title>

    
<?php
if($this['option']->isRTL()){

		
?>
    <link rel="stylesheet" href="<?php echo JUri::root(true)?>/plugins/system/jvlibs/javascripts/jquery/bootstrap/css/bootstrap-rtl.min.css" type="text/css" />    
   
    <link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/core-template-rtl.css'); ?>" type="text/css" />   
<?php
}else { 

	
?>
    <link rel="stylesheet" href="<?php echo JUri::root(true)?>/plugins/system/jvlibs/javascripts/jquery/bootstrap/css/bootstrap.min.css" type="text/css" />     
    <link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/core-template.css'); ?>" type="text/css" />   	
<?php
}?>
    <link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/css3.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/menu.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/template.css'); ?>" type="text/css" />
<?php
if($this['option']->isRTL()){ ?>
	<link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/template.style.rtl.css'); ?>" type="text/css" />
<?php 
}?>
	<link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/colors/' . $dthemecolor . '/style.css'); ?>" type="text/css" />       
     
</head>
<body id="error404" class="<?php echo $this['option']->get('template.body.class'); ?>">
<div id="wrapper"><div id="mainsite">

<header id="block-header">
    	<div class="container">
        <jdoc:include type="position" name="logo" />
</div>    
</header>
<!--Block Mainnav-->
<?php if( $this['position']->count('menu') ):?>
	<section id="block-mainnav">
    	<div class="container">
			<jdoc:include type="position" name="menu" style="none" />
		</div>
	</section >
<?php endif;?>

<section id="block-main">
	<div class="container">
	<?php if ($this->countModules('404')) { ?>
    	<jdoc:include type="position" name="404" style="raw"/>
    <?php } else { ?>
        <a class="image404" href="<?php echo JURI::base(true); ?>" title="Back To Home Page"><img src="<?php echo $this['path']->url('theme::images/default/404.jpg'); ?>" alt="Page Not Found"/></a>
        <?php // echo $doc->error->getCode() ; ?>&nbsp;<?php //echo $doc->error->getMessage();?>
        <?php if ($doc->debug) :
            echo $doc->renderBacktrace();
        endif; ?>
    <?php } ?>
	</div>
</section>                        
</div></div>
</body>
</html>