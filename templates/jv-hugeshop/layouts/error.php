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

	<title><?php echo $doc->title; ?></title>

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" type="text/css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700,100italic,300italic,400italic,700italic&amp;subset=latin,latin-ext" type="text/css">
    <link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/template.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/custom.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo JURI::base(true); ?>/plugins/system/jvframework/framework/extensions/jscustom/assets/css/owl.carousel_2.0.0.css" type="text/css" /> 
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
    <script src="<?php echo $this['path']->url('theme::js/libs.js'); ?>"></script>
    <script src="<?php echo $this['path']->url('theme::js/script.js'); ?>"></script>
    <script type="text/javascript">
        jQuery(function($){
            function getHeight(){
                var h = $(window).height();
                    $('.error-default').each(function(i){
                        $(this).css({'height': h});
                    });
            }
            
            function OsParallax() {
                $(window).stellar({
                    scrollProperty: 'scroll',
                    positionProperty: 'transform',
                    horizontalScrolling: false,
                    verticalScrolling:true,
                    responsive: true,
                    parallaxBackgrounds: true
                });
            }
            $(window).on("load resize", function () {
                // getHeight();
                // OsParallax();
            });
        });
    </script>

</head>
<body id="error404" class="error404">
    <div id="error404-inner" class="error404-inner">
        <div class="container">
            <?php if ($this->countModules('404')) { ?>
                <div class="error-style">
                    <jdoc:include type="position" name="404" style="none"/>
                </div>
            <?php } else { ?>
                <?php if( $this['position']->count('logo') ):?>
                <div class="error-logo">
                    <a id="logo" class="logo-<?php if($this['option']->get('extension.logo.image')) { echo 'image';} else echo 'bg';?>"  href="<?php echo JURI::base(true); ?>" title="<?php echo $this['option']->get('sitename'); ?>">                
                    <?php if($this['option']->get('extension.logo.image')) :?>
                        <img src="<?php echo JURI::base(true).'/'.$this['option']->get('extension.logo.image'); ?>" alt="<?php echo $this['option']->get('sitename'); ?>"/>
                    <?php endif;?>
                    </a>
                </div>
                <?php endif;?> 
                <div class="error-default text-center" >
                    <div class="divtable">
                        <div class="divtablecell">
                            <div class="error-message mb-50">
                                <p class="error-404text"><?php echo JText::_('TPL_404')?></p>
                                <h1 class="error-title"><?php echo JText::_('TPL_404_MESSAGE')?></h1>
                            </div>
                            <?php if ($doc->debug) :
                                echo '<div class="error-debug">'.$doc->renderBacktrace().'</div>';
                            endif; ?>
                            <div class="error-button"><a href="<?php echo (JURI::base(true))?JURI::base(true):'/'; ?>" class="btn btn-primary btn-radius"><?php echo JText::_('TPL_404_BUTTON')?></a></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php if( $this['block']->count('bottom-e') ):?>
        <section id="block-bottom-e">
            <div class="container">
                <jdoc:include type="block" name="bottom-e"/>
            </div>
        </section>
        <!--/Block bottom-e -->
    <?php endif;?>
    <?php if( $this['block']->count('bottom-f') ):?>
        <section id="block-bottom-f">
            <div class="container">
                <jdoc:include type="block" name="bottom-f"/>
            </div>
        </section>
        <!--/Block bottom-f -->
    <?php endif;?>


    <?php if( $this['block']->count('footer-top')):?>
        <!--Block bottomb-top-->
        <section id="block-bottomb-top" class="blk-footer-top">
            <div class="container">
                <jdoc:include type="position" name="footer-top"/>
            </div>
        </section>
        <!--/Block bottomb-top-->
    <?php endif;?>

    <?php if( $this['block']->count('bottomb') ):?>
        <!--Block bottomb-->
        <section id="block-bottomb" class="blk-buttomb">
            <div class="container">
                <div class="blk-buttomb-inner">
                    <jdoc:include type="block" name="bottomb"/>
                </div>
            </div>
        </section>
        <!--/Block bottomb-->
    <?php endif;?>

    <?php if( $this['position']->count('footer') || $this['position']->count('footer-menu')):?>
        <!--Block Footer-->
        <footer id="block-footer" class="blk-footer ">
            <div class="container">
                <div class="row">
                    <?php 
                        $cols_footer = 'col-md-12 text-center';
                        if( $this['position']->count('footer-menu') && $this['position']->count('footer') ) $cols_footer = 'col-md-6';
                    ?>
                    <div class="<?php echo $cols_footer; ?> col-copyright">
                        <jdoc:include type="position" name="footer"/>
                    </div>
                    <?php if( $this['position']->count('footer-menu')):?>
                    <div class="<?php echo $cols_footer; ?> col-menu">
                        <jdoc:include type="position" name="footer-menu" style="none"/>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </footer>
        <!--/Block Footer-->
    <?php endif;?>
    <!-- end footer -->
</body>
</html>