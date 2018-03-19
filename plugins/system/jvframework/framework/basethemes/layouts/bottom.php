
<!--Block bottom-->
<?php if( $this['block']->count('bottom') ):?>
	<section id="block-bottom">
    	<div class="container">
         	<jdoc:include type="block" name="bottom"  />
        </div>
    </section>
<?php endif;?>
<!--/Block bottom-->

<!--Block bottomb-->
<?php if( $this['block']->count('bottomb') ):?>
	<section id="block-bottomb">
    	<div class="container">
         	<jdoc:include type="block" name="bottomb" />
        </div>
    </section>
<?php endif;?>
<!--/Block bottomb-->

<!--Block Footer-->
<?php if( $this['position']->count('footer') ):?>
	<footer id="block-footer">
    	<div class="container">
	         		<jdoc:include type="position" name="footer"/>
        </div>
    </footer>
<?php endif;?>
<!--/Block Footer-->