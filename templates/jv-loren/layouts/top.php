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
    $header_2 = strpos($this['option']->get('template.body.class'), 'header-2');
    $header_3 = strpos($this['option']->get('template.body.class'), 'header-3');
    
    if ($header_2 !== false) {$header_class = '-2';} 
    if ($header_3 !== false) {$header_class = '-3';}
?>
    <?php if( $this['position']->count('logo') || $this['position']->count('top-banner') || $this['position']->count('menu')):?>
        <?php if( $header_2 !== false || $header_3 !== false){ ?>            
            <header id="block-header">
                <div class="header-content<?php echo $header_class;?>">
                    <div class="header-top">
                        <div class="header-top-content clearfix">
                            <div class="container">
                                <?php if( $this['position']->count('header-left') ):?>
                                <div class="header-left">
                                    <jdoc:include type="position" name="header-left" />
                                </div>
                                <!-- end header-left -->
                                <?php endif;?>
                                <?php if( $this['position']->count('header-right') ):?>
                                <div class="header-right">
                                    <jdoc:include type="position" name="header-right" />
                                </div>
                                <?php endif;?>
                            </div>                            
                        </div>
                    </div>
                    <div class="headroom-wrapper">
                        <div class="header-bottom headroom">
                            <div class="header-inner clearfix">
                                <div class="container">                            
                                    <?php if( $this['position']->count('logo') ):?>
                                    <div class="header-logo pull-left">
                                        <jdoc:include type="position" name="logo" />
                                    </div>
                                    <!-- end logo -->
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
                                        <a class="flexMenuToggle btn" href="JavaScript:void(0);" ><i class="fa fa-align-justify"></i></a>             
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </header>
            <!-- Header content -->
        <?php } else {?>
            <header id="block-header" class="header-content<?php echo $header_class;?>">
                <div class="clearfix header-top">
                    <div class="container">
                        <div class="row">
                            <?php 
                                $cols_class = "col-sm-12 text-center";
                                if ($this['position']->count('header-left') || $this['position']->count('header-right')) {
                                    if ($this['position']->count('header-left')) {
                                        $cols_class = "col-sm-8 text-right";
                                    }
                                    if ($this['position']->count('header-right')) {
                                        $cols_class = "col-sm-8 text-left";
                                    }
                                }
                                if ($this['position']->count('header-left') && $this['position']->count('header-right')) {
                                    $cols_class = "col-sm-4 text-center";
                                }
                            ?>
                            <?php if( $this['position']->count('header-left') ):?>
                            <div class="header-left col-sm-4 pull-left">
                                <jdoc:include type="position" name="header-left" />
                            </div>
                            <!-- end header-left -->
                            <?php endif;?>
                            <?php if( $this['position']->count('header-right') ):?>
                            <div class="header-right col-sm-4 pull-right">
                                <jdoc:include type="position" name="header-right" />
                            </div>
                            <!-- end header-right -->
                            <?php endif;?>

                            <?php if( $this['position']->count('logo') ):?>
                            <div class="header-logo <?php echo $cols_class ?>">
                                <jdoc:include type="position" name="logo" />
                            </div>
                            <!-- end logo -->
                            <?php endif;?>
                        </div>                        
                    </div>
                </div>
                <div class="clearfix header-bottom headroom">
                    <div class="container">
                        <?php if( $this['position']->count('menu') ):?>
                        <div class="block-mainnav-wrapper pull-left">
                            <!--Block Mainnav-->
                            <div id="block-mainnav" class="block-mainnav" data-responsive="<?php echo $this->params->get('menu')->responsive; ?>">
                                    <jdoc:include type="position" name="menu" style="none" />
                            </div>
                            <!--/Block Mainnav-->
                        </div> 
                        <a class="flexMenuToggle btn" href="JavaScript:void(0);" ><i class="fa fa-align-justify"></i></a>        
                        <?php endif;?>
                        <?php if( $this['position']->count('top-banner') ):?>
                        <div class="header-banner pull-right">
                            <jdoc:include type="position" name="top-banner" />
                        </div>
                        <!-- end banner top -->
                        <?php endif;?>                    
                    </div>
                </div> 
                <div class="offset"></div>                  
            </header>
            <!-- Header content -->
        <?php } ?>
    <!--/Block Header-->
    <?php endif;?>
    


<?php if( $this['position']->count('breadcrumb') ):?>
<!--Block Breadcrumb-->
    <jdoc:include type="position" name="breadcrumb" style="none" />
<!--/Block Breadcrumb-->
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


