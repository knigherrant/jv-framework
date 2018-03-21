<?php if( $this['block']->count('panel') ):?>
    <!--Block panel-->
    <section id="block-panel">
        <div class="container">
            <jdoc:include type="block" name="panel"/>
        </div>
    </section>
    <!--/Block panel-->
<?php endif;?>

<?php
    $header_class = "";    
    $header_2 = strpos($this['option']->get('template.body.class'), 'header-2 ');
    $header_3 = strpos($this['option']->get('template.body.class'), 'header-3');
    $header_4 = strpos($this['option']->get('template.body.class'), 'header-4');
    $header_5 = strpos($this['option']->get('template.body.class'), 'header-5');
    $header_6 = strpos($this['option']->get('template.body.class'), 'header-6');
    $header_7 = strpos($this['option']->get('template.body.class'), 'header-7');
    $header_8 = strpos($this['option']->get('template.body.class'), 'header-8');
    $header_9 = strpos($this['option']->get('template.body.class'), 'header-9');
    $header_10 = strpos($this['option']->get('template.body.class'), 'header-10');
    $header_11 = strpos($this['option']->get('template.body.class'), 'header-11');
    $header_12 = strpos($this['option']->get('template.body.class'), 'header-12');
    $header_13 = strpos($this['option']->get('template.body.class'), 'header-13');
    $header_14 = strpos($this['option']->get('template.body.class'), 'header-14');
    $header_15 = strpos($this['option']->get('template.body.class'), 'header-15');
    $header_16 = strpos($this['option']->get('template.body.class'), 'header-16');
    $header_17 = strpos($this['option']->get('template.body.class'), 'header-17');
    $header_18 = strpos($this['option']->get('template.body.class'), 'header-18');
    $header_19 = strpos($this['option']->get('template.body.class'), 'header-19');
    $header_20 = strpos($this['option']->get('template.body.class'), 'header-20');
    $header_21 = strpos($this['option']->get('template.body.class'), 'header-21');
    
    if ($header_2) { $header_class = '-2'; } 
    if ($header_3) { $header_class = '-3'; } 
    if ($header_4) { $header_class = '-4'; } 
    if ($header_5) { $header_class = '-5'; } 
    if ($header_6) { $header_class = '-2 header-content-6'; } 
    if ($header_7) { $header_class = '-2 header-content-7'; } 
    if ($header_8) { $header_class = '-5 header-content-8'; } 
    if ($header_9) { $header_class = '-9'; } 
    if ($header_10) { $header_class = '-10'; } 
    if ($header_11) { $header_class = '-11'; } 
    if ($header_12) { $header_class = '-12'; } 
    if ($header_13) { $header_class = '-13'; } 
    if ($header_14) { $header_class = '-14'; } 
    if ($header_15) { $header_class = '-15'; } 
    if ($header_16) { $header_class = '-16'; } 
    if ($header_17) { $header_class = '-17'; } 
    if ($header_18) { $header_class = '-18'; } 
    if ($header_19) { $header_class = '-19'; } 
    if ($header_20) { $header_class = '-20'; } 
    if ($header_21) { $header_class = '-2 header-content-21'; } 
?>

<?php if( $this['position']->count('logo') || $this['position']->count('top-banner') || $this['position']->count('top-menu') || $this['position']->count('menu')):?>
    <?php if( ($header_6 !== false || $header_7 !== false) ) {?>
        <div class="left-menu">
            <div class="left-menu-inner">
                <?php if( $this['position']->count('logo') ):?>
                <div class="left-menu-logo">
                    <?php if ($this['option']->get('extension.logo.type', 'text') == 'text'):?> 
                            <a id="logo-small" href="<?php echo JURI::base(true); ?>" title="<?php echo $this['option']->get('sitename'); ?>">
                                <span class="text"><?php echo $this['option']->get('extension.logo.text', $this['option']->get('sitename')); ?></span>
                                <span class="slogan"><?php echo $this['option']->get('extension.logo.slogan'); ?></span>
                            </a>
                    <?php else : ?>
                            <a id="logo-small" class="logo-<?php if($this['option']->get('extension.logo.image')) { echo 'image';} else echo 'bg';?>"  href="<?php echo JURI::base(true); ?>" title="<?php echo $this['option']->get('sitename'); ?>">                
                            <?php if($this['option']->get('extension.logo.image')) :?>
                                <img src="<?php echo JRoute::_($this['option']->get('extension.logo.image')); ?>" alt="<?php echo $this['option']->get('sitename'); ?>"/>
                            <?php endif;?>
                            </a>
                    <?php endif; ?>
                </div>
                <?php endif;?>
                <?php if ($this['position']->count('left-tools')):?>
                    <jdoc:include type="position" name="left-tools" />
                <?php endif;?>
                <?php if ($this['position']->count('left-menu')):?>
                    <jdoc:include type="position" name="left-menu" />
                <?php endif;?>
            </div>
            <?php if ($this['position']->count('left-bottom')):?>
                <jdoc:include type="position" name="left-bottom" />
            <?php endif;?>
        </div>
    <?php } ?>
    <?php if($header_20){?>
        <header id="block-header" class="header-wrapper<?php echo ($header_class !="")?' header-content'.$header_class:'';?>">
            <div class="header-top">
                <div class="container">
                    <div class="header-top-inner clearfix">
                        <div class="row">
                            <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4">
                                <a class="flexMenuToggle pull-left header-menu" href="JavaScript:void(0);" title="<?php echo JText::_('TPL_HEADER_MENU'); ?>"><i class="fa fa-bars"></i><span><?php echo JText::_('TPL_HEADER_MENU'); ?></span></a>   
                                <?php if( $this['position']->count('top-menu') ):?>
                                <div class="header-topmenu pull-left">
                                    <button id="topmenu-dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-topmenu"><span><?php echo JText::_("TPL_SETTING"); ?></span></button>
                                    <div class="dropdown-menu" aria-labelledby="topmenu-dropdown">
                                        <jdoc:include type="position" name="top-menu" />
                                    </div>
                                    <!-- end dropdown menu -->
                                </div>
                                <!-- end menu top -->
                                <?php endif;?>
                                <?php if( $this['position']->count('top-banner') ):?>
                                <div class="header-banner pull-left">
                                    <jdoc:include type="position" name="top-banner" />
                                </div>
                                <!-- end banner top -->
                                <?php endif;?>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-xs-12">
                                <?php if( $this['position']->count('logo') ):?>
                                <div class="header-logo text-center">
                                    <jdoc:include type="position" name="logo" />
                                </div>
                                <!-- end logo -->
                                <?php endif;?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                                <?php if( $this['position']->count('header-right') ):?>
                                    <jdoc:include type="position" name="header-right" />
                                <!-- end banner top -->
                                <?php endif;?>
                            </div>
                            
                        </div>
                        <!-- end cols -->
                    </div>
                </div>
            </div>
            <div class="header-content headroom">
                <div class="container">
                    <div class="header-inner">
                        <?php if( $this['position']->count('menu')):?>
                            <div class="block-mainnav-wrapper">
                                <!--Block Mainnav-->
                                <div id="block-mainnav" class="block-mainnav" data-responsive="<?php echo $this->params->get('menu')->responsive; ?>">
                                    <jdoc:include type="position" name="menu" style="none"/>
                                </div>
                                <!--/Block Mainnav-->
                            </div>
                        <?php endif;?>
                    </div>
                </div>  
            </div>  
        </header>
    <?php } elseif($header_17){?>
        <header id="block-header" class="header-wrapper<?php echo ($header_class !="")?' header-content'.$header_class:'';?>">
            <div class="header-content headroom">
                <div class="container">
                    <?php if( $this['position']->count('logo') ):?>
                    <div class="header-logo pull-left">
                        <jdoc:include type="position" name="logo" />
                    </div>
                    <!-- end logo -->
                    <?php endif;?>
                    <div class="header-inner pull-right">
                        <a class="flexMenuToggle pull-right header-menu" href="JavaScript:void(0);" title="<?php echo JText::_('TPL_HEADER_MENU'); ?>"><i class="fa fa-bars"></i></a>   
                        <?php if( $this['position']->count('top-menu') ):?>
                        <div class="header-topmenu pull-right">
                            <button id="topmenu-dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-topmenu"><span></span></button>
                            <div class="dropdown-menu" aria-labelledby="topmenu-dropdown">
                                <jdoc:include type="position" name="top-menu" />
                            </div>
                            <!-- end dropdown menu -->
                        </div>
                        <!-- end top menu -->
                        <?php endif;?>
                        <?php if( $this['position']->count('menu')):?>
                            <div class="block-mainnav-wrapper pull-right">
                                <!--Block Mainnav-->
                                <div id="block-mainnav" class="block-mainnav" data-responsive="<?php echo $this->params->get('menu')->responsive; ?>">
                                    <jdoc:include type="position" name="menu" style="none"/>
                                </div>
                                <!--/Block Mainnav-->
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>    
            <div class="header-bottom">
                <?php if( $this['position']->count('top-banner') ):?>
                    <div class="container">
                        <div class="header-banner">
                            <div class="row">
                                <!-- <div class="col-sm-offset-0 col-md-9 col-md-offset-3"> -->
                                <div class="col-md-12">
                                  <jdoc:include type="position" name="top-banner" />  
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- end banner top -->
                <?php endif;?>
            </div>            
            <!-- end header-bottom -->
        </header>
        <!-- Header -->
    <?php } elseif($header_14){?>
        <header id="block-header" class="header-wrapper<?php echo ($header_class !="")?' header-content'.$header_class:'';?>">
            <div class="header-content headroom">
                <div class="container">
                    <?php if( $this['position']->count('logo') ):?>
                    <div class="header-logo">
                        <jdoc:include type="position" name="logo" />
                    </div>
                    <!-- end logo -->
                    <?php endif;?>
                    <div class="header-inner">
                        <?php if( $this['position']->count('menu')):?>
                            <div class="block-mainnav-wrapper">
                                <!--Block Mainnav-->
                                <div id="block-mainnav" class="block-mainnav" data-responsive="<?php echo $this->params->get('menu')->responsive; ?>">
                                    <jdoc:include type="position" name="menu" style="none"/>
                                </div>
                                <!--/Block Mainnav-->
                            </div>
                        <?php endif;?>
                        <?php if( $this['position']->count('top-banner') ):?>
                        <div class="header-banner">
                            <jdoc:include type="position" name="top-banner" />
                        </div>
                        <!-- end top menu -->
                        <?php endif;?>
                        <?php if( $this['position']->count('top-menu') ):?>
                        <div class="header-topmenu">
                            <button id="topmenu-dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-topmenu"><span></span></button>
                            <div class="dropdown-menu" aria-labelledby="topmenu-dropdown">
                                <jdoc:include type="position" name="top-menu" />
                            </div>
                            <!-- end dropdown menu -->
                        </div>
                        <!-- end banner menu -->
                        <?php endif;?>
                        <a class="flexMenuToggle header-menu" href="JavaScript:void(0);" title="<?php echo JText::_('TPL_HEADER_MENU'); ?>"><i class="huge-menu"></i></a>     
                    </div>
                </div>
            </div>                
        </header>
        <!-- Header -->
    <?php } elseif($header_10){?>
        <header id="block-header" class="header-wrapper<?php echo ($header_class !="")?' header-content'.$header_class:'';?>">
            <div class="header-top">
                <div class="container">
                    <div class="header-top-inner clearfix">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 hidden-xs">
                                <?php if( $this['position']->count('header-left') ):?>
                                    <jdoc:include type="position" name="header-left" />
                                <!-- end banner top -->
                                <?php endif;?>
                            </div>
                            <div class="col-sm-6 col-md-8">
                                <?php if( $this['position']->count('top-menu') ):?>
                                <div class="header-topmenu pull-right">
                                    <button id="topmenu-dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-topmenu"><span><?php echo JText::_("TPL_SETTING"); ?></span></button>
                                    <div class="dropdown-menu" aria-labelledby="topmenu-dropdown">
                                        <jdoc:include type="position" name="top-menu" />
                                    </div>
                                    <!-- end dropdown menu -->
                                </div>
                                <!-- end menu top -->
                                <?php endif;?>
                                <?php if( $this['position']->count('top-banner') ):?>
                                <div class="header-banner pull-right">
                                    <jdoc:include type="position" name="top-banner" />
                                </div>
                                <!-- end banner top -->
                                <?php endif;?>
                            </div>
                        </div>
                        <!-- end cols -->
                    </div>
                </div>
            </div>
            <div class="header-content headroom">
                <div class="container">
                    <div class="header-inner clearfix">
                        <?php if( $this['position']->count('logo') ):?>
                        <div class="header-logo pull-left">
                            <jdoc:include type="position" name="logo" />
                        </div>
                        <!-- end logo -->
                        <?php endif;?>
                        <a class="flexMenuToggle pull-right header-menu" href="JavaScript:void(0);" title="<?php echo JText::_('TPL_HEADER_MENU'); ?>"><i class="fa fa-bars"></i></a> 
                        <?php if( $this['position']->count('menu')):?>
                            <div class="block-mainnav-wrapper pull-right">
                                <!--Block Mainnav-->
                                <div id="block-mainnav" class="block-mainnav" data-responsive="<?php echo $this->params->get('menu')->responsive; ?>">
                                    <jdoc:include type="position" name="menu" style="none"/>
                                </div>
                                <!--/Block Mainnav-->
                            </div>
                        <?php endif;?>
                    </div>
                </div>  
            </div>  
        </header>
    <?php } elseif($header_9 || $header_15 || $header_16 || $header_18  || $header_19){?>
        <header id="block-header" class="header-wrapper<?php echo ($header_class !="")?' header-content'.$header_class:'';?>">
            <div class="header-top">
                <div class="container">
                    <div class="header-top-inner clearfix">
                        <div class="row">
                            <div class="col-md-4 col-sm-3 col-xs-4">
                                <?php if( $this['position']->count('logo') ):?>
                                <div class="header-logo">
                                    <jdoc:include type="position" name="logo" />
                                </div>
                                <!-- end logo -->
                                <?php endif;?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-5 hidden-xs">
                                <?php if( $this['position']->count('header-left') ):?>
                                    <jdoc:include type="position" name="header-left" />
                                <!-- end banner top -->
                                <?php endif;?>
                            </div>
                            <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4">
                                <a class="flexMenuToggle pull-right header-menu" href="JavaScript:void(0);" title="<?php echo JText::_('TPL_HEADER_MENU'); ?>"><i class="fa fa-bars"></i><span><?php echo JText::_('TPL_HEADER_MENU'); ?></span></a>   
                                <?php if( $this['position']->count('top-menu') ):?>
                                <div class="header-topmenu pull-right">
                                    <button id="topmenu-dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-topmenu"><span><?php echo JText::_("TPL_SETTING"); ?></span></button>
                                    <div class="dropdown-menu" aria-labelledby="topmenu-dropdown">
                                        <jdoc:include type="position" name="top-menu" />
                                    </div>
                                    <!-- end dropdown menu -->
                                </div>
                                <!-- end menu top -->
                                <?php endif;?>
                                <?php if( $this['position']->count('top-banner') ):?>
                                <div class="header-banner pull-right">
                                    <jdoc:include type="position" name="top-banner" />
                                </div>
                                <!-- end banner top -->
                                <?php endif;?>
                            </div>
                        </div>
                        <!-- end cols -->
                    </div>
                </div>
            </div>
            <div class="header-content headroom">
                <div class="container">
                    <div class="header-inner">
                        <?php if( $this['position']->count('menu')):?>
                            <div class="block-mainnav-wrapper">
                                <!--Block Mainnav-->
                                <div id="block-mainnav" class="block-mainnav" data-responsive="<?php echo $this->params->get('menu')->responsive; ?>">
                                    <jdoc:include type="position" name="menu" style="none"/>
                                </div>
                                <!--/Block Mainnav-->
                            </div>
                        <?php endif;?>
                    </div>
                </div>  
            </div>  
        </header>
    <?php } elseif($header_5 || $header_8){?>
        <header id="block-header" class="header-wrapper<?php echo ($header_class !="")?' header-content'.$header_class:'';?>">
            <div class="header-top">
                <div class="container">
                    <div class="header-top-inner clearfix">
                        <?php if( $this['position']->count('logo') ):?>
                        <div class="header-logo text-center">
                            <jdoc:include type="position" name="logo" />
                        </div>
                        <!-- end logo -->
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="header-content headroom">
                <div class="container">
                    <div class="header-inner">
                        <a class="flexMenuToggle pull-left header-menu" href="JavaScript:void(0);" title="<?php echo JText::_('TPL_HEADER_MENU'); ?>"><i class="huge-menu"></i></a>     
                        <?php if( $this['position']->count('top-menu') ):?>
                        <div class="header-topmenu pull-right">
                            <button id="topmenu-dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-topmenu"><span></span></button>
                            <div class="dropdown-menu" aria-labelledby="topmenu-dropdown">
                                <jdoc:include type="position" name="top-menu" />
                            </div>
                            <!-- end dropdown menu -->
                        </div>
                        <!-- end menu top -->
                        <?php endif;?>
                        <?php if( $this['position']->count('top-banner') ):?>
                        <div class="header-banner pull-right">
                            <jdoc:include type="position" name="top-banner" />
                        </div>
                        <!-- end banner top -->
                        <?php endif;?>
                        <?php if( $this['position']->count('menu')):?>
                            <div class="block-mainnav-wrapper">
                                <!--Block Mainnav-->
                                <div id="block-mainnav" class="block-mainnav" data-responsive="<?php echo $this->params->get('menu')->responsive; ?>">
                                    <jdoc:include type="position" name="menu" style="none"/>
                                </div>
                                <!--/Block Mainnav-->
                            </div>
                        <?php endif;?>
                    </div>
                </div>  
            </div>  
        </header>
    <?php } elseif($header_4){?>
        <header id="block-header" class="header-wrapper<?php echo ($header_class !="")?' header-content'.$header_class:'';?>">
            <div class="header-top">
                <div class="container">
                    <div class="header-top-inner clearfix">
                        <div class="header-left pull-left">
                            <?php if( $this['position']->count('top-menu') ):?>
                            <div class="header-topmenu pull-left">
                                <button id="topmenu-dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-topmenu"><span></span></button>
                                <div class="dropdown-menu" aria-labelledby="topmenu-dropdown">
                                    <jdoc:include type="position" name="top-menu" />
                                </div>
                                <!-- end dropdown menu -->
                            </div>
                            <!-- end banner top -->
                            <?php endif;?>
                            <?php if( $this['position']->count('header-left') ):?>
                            <div class="header-align-inner pull-left">
                                <jdoc:include type="position" name="header-left" />
                            </div>
                            <!-- end banner top -->
                            <?php endif;?>
                        </div>
                        <div class="header-right pull-right">
                            <?php if( $this['position']->count('header-right') ):?>
                            <div class="header-align-inner pull-right">
                                <jdoc:include type="position" name="header-right" />
                            </div>
                            <!-- end banner top -->
                            <?php endif;?>
                        </div>
                        <?php if( $this['position']->count('logo') ):?>
                        <div class="header-logo pull-left text-center">
                            <jdoc:include type="position" name="logo" />
                        </div>
                        <!-- end logo -->
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="header-content headroom">
                <div class="container">
                    <div class="header-inner">
                        <a class="flexMenuToggle pull-left header-menu" href="JavaScript:void(0);" title="<?php echo JText::_('TPL_HEADER_MENU'); ?>"><i class="huge-menu"></i></a>     
                        <?php if( $this['position']->count('top-banner') ):?>
                        <div class="header-banner pull-right">
                            <jdoc:include type="position" name="top-banner" />
                        </div>
                        <!-- end banner top -->
                        <?php endif;?>                        
                        <?php if( $this['position']->count('menu')):?>
                            <div class="block-mainnav-wrapper">
                                <!--Block Mainnav-->
                                <div id="block-mainnav" class="block-mainnav" data-responsive="<?php echo $this->params->get('menu')->responsive; ?>">
                                    <jdoc:include type="position" name="menu" style="none"/>
                                </div>
                                <!--/Block Mainnav-->
                            </div>
                        <?php endif;?>
                    </div>
                </div>  
            </div>  
        </header>
    <?php } else {?>
        <header id="block-header" class="header-wrapper<?php echo ($header_class !="")?' header-content'.$header_class:'';?>">
            <div class="header-content headroom">
                <div class="container">
                    <?php if( $this['position']->count('logo') ):?>
                    <div class="header-logo pull-left">
                        <jdoc:include type="position" name="logo" />
                    </div>
                    <!-- end logo -->
                    <?php endif;?>
                    <div class="header-inner pull-right">
                        <a class="flexMenuToggle pull-right header-menu" href="JavaScript:void(0);" title="<?php echo JText::_('TPL_HEADER_MENU'); ?>"><i class="huge-menu"></i></a>     
                        <?php if( $this['position']->count('top-menu') ):?>
                        <div class="header-topmenu pull-right">
                            <button id="topmenu-dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-topmenu"><span></span></button>
                            <div class="dropdown-menu" aria-labelledby="topmenu-dropdown">
                                <jdoc:include type="position" name="top-menu" />
                            </div>
                            <!-- end dropdown menu -->
                        </div>
                        <!-- end top menu -->
                        <?php endif;?>
                        <?php if( $this['position']->count('top-banner') ):?>
                        <div class="header-banner pull-right">
                            <jdoc:include type="position" name="top-banner" />
                        </div>
                        <!-- end banner top -->
                        <?php endif;?>
                        <?php if( $this['position']->count('menu')):?>
                            <div class="block-mainnav-wrapper pull-right">
                                <!--Block Mainnav-->
                                <div id="block-mainnav" class="block-mainnav" data-responsive="<?php echo $this->params->get('menu')->responsive; ?>">
                                    <jdoc:include type="position" name="menu" style="none"/>
                                </div>
                                <!--/Block Mainnav-->
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>                
        </header>
        <!-- Header -->
    <?php } ?>
<?php endif;?>    

<?php if( $this['position']->count('slideshow') ):?>
    <!--Block Slide-->
    <section id="block-slideshow">
        <div class="container">
            <jdoc:include type="position" name="slideshow" grid-mode="fluid"/>
        </div>
    </section>
    <!--/Block Slide-->
<?php endif;?>


<?php if( $this['position']->count('breadcrumb') ):?>
<!--Block Breadcrumb-->
    <section id="block-breadcrumb">
        <jdoc:include type="position" name="breadcrumb" style="none" />
    </section>
<!--/Block Breadcrumb-->
<?php endif;?>


<?php if( $this['block']->count('top') ):?>
    <!--Block top-->
	<section id="block-top">
    	<div class="container">
    		<jdoc:include type="block" name="top"/>
        </div>
    </section>
    <!--/Block top-->
<?php endif;?>


<?php if( $this['block']->count('topt') ):?>
    <!--Block top-->
    <section id="block-topt">
        <div class="container">
            <jdoc:include type="block" name="topt"/>
        </div>
    </section>
    <!--/Block topt-->
<?php endif;?>
<?php if( $this['block']->count('top-a') ):?>
    <!--Block top-->
    <section id="block-top-a">
        <div class="container">
            <jdoc:include type="block" name="top-a"/>
        </div>
    </section>
<?php endif;?>
<?php if( $this['block']->count('top-b') ):?>
    <section id="block-top-b">
        <div class="container">
            <jdoc:include type="block" name="top-b"/>
        </div>
    </section>
<?php endif;?>
<?php if( $this['block']->count('top-c') ):?>
    <section id="block-top-c">
        <div class="container">
            <jdoc:include type="block" name="top-c"/>
        </div>
    </section>
<?php endif;?>
<?php if( $this['block']->count('top-cfull') ):?>
    <section id="block-top-cfull">
            <jdoc:include type="block" name="top-cfull"/>
    </section>
<?php endif;?>
<?php if( $this['block']->count('top-d') ):?>
    <!--Block top-->
    <section id="block-top-d">
        <div class="container">
            <jdoc:include type="block" name="top-d"  />
        </div>
    </section>
    <!--/Block top d-->
<?php endif;?>
<?php if( $this['block']->count('top-dfull') ):?>
    <!--Block top-->
    <section id="block-top-dfull">
        <jdoc:include type="block" name="top-dfull"  />
    </section>
    <!--/Block top d-->
<?php endif;?>
<?php if( $this['block']->count('top-e') ):?>
    <!--Block top e-->
    <section id="block-top-e">
        <div class="container">
            <jdoc:include type="block" name="top-e"  />
        </div>
    </section>
    <!--/Block top e-->
<?php endif;?>
<?php if( $this['block']->count('top-efull') ):?>
    <!--Block top e-->
    <section id="block-top-efull">
        <jdoc:include type="block" name="top-efull"  />
    </section>
    <!--/Block top e-->
<?php endif;?>
<?php if( $this['block']->count('top-f') ):?>
    <!--Block top e-->
    <section id="block-top-f">
        <div class="container">
            <jdoc:include type="block" name="top-f"  />
        </div>
    </section>
    <!--/Block top f-->
<?php endif;?>
<?php if( $this['block']->count('topb') ):?>
    <!--Block topb-->
	<section id="block-topb">
    	<div class="container">
    		<jdoc:include type="block" name="topb"/>
        </div>
    </section>
    <!--/Block topb-->
<?php endif;?>
<?php if($this['block']->count('contenttop')):?>
    <!--Block contenttop-->
    <section id="contenttop" class="contenttop">
        <div class="container">
            <jdoc:include type="block" name="contenttop"/>
        </div>
    </section>
    <!--/Block contenttop-->
<?php endif;?>