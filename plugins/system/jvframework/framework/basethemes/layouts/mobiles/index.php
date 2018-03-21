<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<?php
	echo $this['template']->render('head');	

    include($this['path']->findPath('style.config.php'));
    ?>
</head>
<body id="mobile" class="<?php echo $this['option']->get('template.body.class'); ?>">
<div id="wrapper">
  <div id="block-mainnav-mobile">
    <jdoc:include type="position" name="menu" style="raw" />
  </div>
  <div id="mainsite"> <span class="flexMenuToggle" ></span>
    <section  id="block-header">
      <div class="container"> 
      	<a class="flexMenuToggle" href="JavaScript:void(0);" ><span></span><span></span><span></span></a>
        <jdoc:include type="position" name="logo" />
      </div>
    </section>
    <section  id="block-main">
      <div class="container">
        <jdoc:include type="message" />
        <jdoc:include type="component" />
        <jdoc:include type="position" name="content-top"  />
        <jdoc:include type="position" name="content-bottom"  />
      </div>
    </section>
    <footer id="block-footer">
      <div class="container">
        <jdoc:include type="position" name="footer"  />
      </div>
    </footer>
  </div>
</div>
</body>
</html>