<!--Block top-->
<?php if( $this['block']->count('panel') ):?>
	<section id="block-panel">
    	<div class="container">
    		<jdoc:include type="block" name="panel" />
        </div>
    </section>
<?php endif;?>
<!--/Block top-->

<!--Block Header -->
<header id="block-header">
    	<div class="container">

                <a class="flexMenuToggle" href="JavaScript:void(0);" ><span></span><span></span><span></span></a>
                <jdoc:include type="position" name="logo" />
                <jdoc:include type="position" name="top" style="none" />
            	<jdoc:include type="position" name="search" style="none"  />

        </div>
</header>
<!--/Block Header-->

<!--Block Mainnav-->
<?php if( $this['position']->count('menu') ):?>
	<section id="block-mainnav">
    	<div class="container">
			<jdoc:include type="position" name="menu" style="none" />
		</div>
	</section >
<?php endif;?>




<!--/Block Mainnav-->
<!--Block Slide-->
<?php if( $this['position']->count('slideshow') ):?>
	<section id="block-slide">
    	<div class="container">
		    <jdoc:include type="position" name="slideshow"  style="none"  />
		</div>
	</section>
<?php endif;?>
<!--/Block Slide-->

<!--Block Breadcrumb-->
<?php if( $this['position']->count('breadcrumb') ):?>
	<section id="block-breadcrumb">
    	<div class="container">
			<jdoc:include type="position" name="breadcrumb" style="none" />
		</div>
	</section>
<?php endif;?>
<!--/Block Breadcrumb-->
<!--Block top-->
<?php if( $this['block']->count('top') ):?>
	<section id="block-top">
    	<div class="container">
    		<jdoc:include type="block" name="top"  />
        </div>
    </section>
<?php endif;?>
<!--/Block top-->

<!--Block topb-->
<?php if( $this['block']->count('topb') ):?>
	<section id="block-topb">
    	<div class="container">
    		<jdoc:include type="block" name="topb" style="raw" />
        </div>
    </section>
<?php endif;?>
<!--/Block topb-->
