<?php
/*
 # com_jvframwork - JV Framework
 # @version		3.3.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
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

	<title><?php  echo '404'; ?> - <?php echo $doc->title; ?></title>

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" type="text/css">
    <link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/template.css'); ?>" type="text/css" />
    <?php
    if($this['option']->isRTL()){ ?>
    	<link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/template.style.rtl.css'); ?>" type="text/css" />
    <?php 
    }?>
    <?php
    if($this['option']->isRTL()){ ?>
        <link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/responsive-margin-rtl.css'); ?>" type="text/css" />
    <?php 
    } else { ?>
        <link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/responsive-margin.css'); ?>" type="text/css" />
    <?php 
    }?>
	<link rel="stylesheet" href="<?php echo $this['path']->url('theme::colors/' . $dthemecolor . '/style.css'); ?>" type="text/css" /> 
    <script src="<?php echo JURI::base(true); ?>/media/jui/js/jquery.min.js"></script>
</head>
<body id="error404" class="error404">
    <?php if ($this->countModules('404')) { ?>
        <header id="block-header" class="header-content">
            <div class="clearfix header-top">
                <div class="container">
                    <div class="row">
                        <?php if( $this['position']->count('logo') ):?>
                        <div class="header-logo">
                            <a id="logo" class="logo-<?php if($this['option']->get('extension.logo.image')) { echo 'image';} else echo 'bg';?>"  href="<?php echo JURI::base(true); ?>" title="<?php echo $this['option']->get('sitename'); ?>">                
                            <?php if($this['option']->get('extension.logo.image')) :?>
                                <img src="<?php echo JURI::base(true).'/'.$this['option']->get('extension.logo.image'); ?>" alt="<?php echo $this['option']->get('sitename'); ?>"/>
                            <?php endif;?>
                            </a>
                        </div>
                        <!-- end logo -->
                        <?php endif;?>
                    </div>                        
                </div>
            </div>
            <div class="bg-primary pt-5"></div>
        </header>
        <!-- Header content -->
        <div class="error-style">
            <jdoc:include type="position" name="404" style="none"/>
        </div>
        <div class="footer">
            <?php if( $this['position']->count('footer') || $this['position']->count('footer-menu')):?>
                <!--Block Footer-->
                <footer id="block-footer" class="blk-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-<?php echo ($this['position']->count('footer-menu'))?'5':'12 text-center';?> col-copyright">
                                <jdoc:include type="position" name="footer"/>
                            </div>
                            <?php if( $this['position']->count('footer-menu')):?>
                            <div class="col-md-7 col-menu text-right">
                                <jdoc:include type="position" name="footer-menu" style="none"/>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                </footer>
                <!--/Block Footer-->
            <?php endif;?>
        </div>    
        <!-- end footer -->
    <?php } else { ?>
    <div id="error404-inner">
        <div class="container">            
                <div class="row error-default pt-150 pt-sm-100 pb-150 pb-sm-100">
                    <div class="col-md-4">
                        <div class="error-image"><img src="<?php echo $this['path']->url('theme::images/icon-404.png'); ?>" alt="Page Not Found"/></div>
                    </div>
                    <div class="col-md-6">
                        <div class="error-content">
                            <?php if( $this['position']->count('logo') ):?>
                            <div class="error-logo mb-60">
                                <a id="logo" class="logo-<?php if($this['option']->get('extension.logo.image')) { echo 'image';} else echo 'bg';?>"  href="<?php echo JURI::base(true); ?>" title="<?php echo $this['option']->get('sitename'); ?>">                
                                <?php if($this['option']->get('extension.logo.image')) :?>
                                    <img src="<?php echo JURI::base(true).'/'.$this['option']->get('extension.logo.image'); ?>" alt="<?php echo $this['option']->get('sitename'); ?>"/>
                                <?php endif;?>
                                </a>
                            </div>
                            <?php endif;?>   
                            <div class="error-message mb-50"><?php echo JText::_('TPL_404_MESSAGE')?></div>
                            <?php if ($doc->debug) :
                                echo '<div class="error-debug">'.$doc->renderBacktrace().'</div>';
                            endif; ?>
                            <div class="error-button"><a href="<?php echo JURI::base(true); ?>" class="btn btn-primary text-normal "><?php echo JText::_('TPL_404_BUTTON')?></a></div>
                        </div>
                    </div>
                </div>            
        </div>
    </div>
    <?php } ?>
</body>
</html>