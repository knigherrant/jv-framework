<?php if($this['block']->count('contentbottom')):?>
    <section id="contentbottom" class="contentbottom">
        <div class="container">
            <jdoc:include type="block" name="contentbottom"/>
        </div>
    </section>
    <!--/Block contentbottom-->
<?php endif;?>

<?php if( $this['block']->count('bottom') ):?>
	<section id="block-bottom">
    	<div class="container">
         	<jdoc:include type="block" name="bottom"/>
        </div>
    </section>
    <!--/Block bottom-->
<?php endif;?>

<?php if( $this['block']->count('bottomt') ):?>
    <section id="block-bottomt">
        <div class="container">
            <jdoc:include type="block" name="bottomt"/>
        </div>
    </section>
    <!--/Block bottom-->
<?php endif;?>

<?php if( $this['block']->count('bottom-a') ):?>
    <section id="block-bottom-a">
        <div class="container">
            <jdoc:include type="block" name="bottom-a"/>
        </div>
    </section>
    <!--/Block bottom-a-->
<?php endif;?>

<?php if( $this['block']->count('bottom-b') ):?>
    <section id="block-bottom-b">
        <div class="container">
            <jdoc:include type="block" name="bottom-b"/>
        </div>
    </section>
    <!--/Block bottom-b -->
<?php endif;?>

<?php if( $this['block']->count('bottom-c') ):?>
    <section id="block-bottom-c">
        <div class="container">
            <jdoc:include type="block" name="bottom-c"/>
        </div>
    </section>
    <!--/Block bottom-c -->
<?php endif;?>

<?php if( $this['block']->count('bottom-d') ):?>
    <section id="block-bottom-d">
        <div class="container">
            <jdoc:include type="block" name="bottom-d"/>
        </div>
    </section>
    <!--/Block bottom-d -->
<?php endif;?>
<?php if( $this['block']->count('bottom-dfull') ):?>
    <section id="block-bottom-dfull">
        <jdoc:include type="block" name="bottom-dfull" grid-mode="fluid"/>
    </section>
    <!--/Block bottom-d -->
<?php endif;?>

<?php if( $this['block']->count('bottom-e') ):?>
    <section id="block-bottom-e">
        <div class="container">
            <jdoc:include type="block" name="bottom-e"/>
        </div>
    </section>
    <!--/Block bottom-e -->
<?php endif;?>

<?php if( $this['block']->count('bottom-efull') ):?>
    <section id="block-bottom-efull">
        <jdoc:include type="block" name="bottom-efull" grid-mode="fluid"/>
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

<?php
    $footer_2 = strpos($this['option']->get('template.body.class'), 'footer-2');
    $footer_3 = strpos($this['option']->get('template.body.class'), 'footer-3');
    $footer_5 = strpos($this['option']->get('template.body.class'), 'footer-5');
    $footer_6 = strpos($this['option']->get('template.body.class'), 'footer-6');
    $footer_14 = strpos($this['option']->get('template.body.class'), 'footer-14');
?>

<div class="footer">
    <?php if( $this['block']->count('footer-top')):?>
        <!--Block bottomb-top-->
        <section id="block-bottomb-top" class="blk-footer-top">
            <div class="container">
                <?php if( $this['block']->count('footer-top')):?>  
                     <jdoc:include type="block" name="footer-top"/>
                <?php endif;?>
            </div>
        </section>
        <!--/Block bottomb-top-->
    <?php endif;?>

    <?php if( $this['block']->count('bottomb') ):?>
        <!--Block bottomb-->
        <section id="block-bottomb" class="blk-buttomb">
            <div class="container">
                <jdoc:include type="block" name="bottomb"/>
            </div>
        </section>
        <!--/Block bottomb-->
    <?php endif;?>

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