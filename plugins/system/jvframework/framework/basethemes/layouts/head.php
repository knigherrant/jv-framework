<jdoc:include type="head" />
<?php
JHtml::_('jquery.framework');
$this['asset']->Mootool(true);
//jf($this['lessc']->compileAll());
$this['asset']->addLess('icomoon');
// basethemes
Jhtml::_('bootstrap.framework');
if($this['option']->get('global.retina')){
	$this['asset']->addScript($this['path']->url('theme::js/retina.min.js'));
}
$this['asset']->addScript($this['path']->url('theme::js/jv.js'));


if($this['option']->isRTL()){
    JHtmlBootstrap::loadCss(false,'rtl');
	$this['asset']->addLess('core-template-rtl');
	$this ['asset']->addLess ( "menu-touch.rtl", array('media' => 'screen and (max-width: '.$this['option']->get('menu.responsive').'px)'));	
}

else
{
    JHtmlBootstrap::loadCss(false);
	$this['asset']->addLess('core-template');
	$this ['asset']->addLess ( "menu-touch", array('media' => 'screen and (max-width: '.$this['option']->get('menu.responsive').'px)'));	
}

$this['asset']->addLess('css3');
$this['asset']->addLess('menu');
if($this['option']->get('global.k2css')) $this['asset']->addLess('k2');
$this['asset']->addLess('template');
$this['asset']->addLess('responsive');


if($this['option']->isRTL()){
	$this['asset']->addLess('template.style.rtl');
}
//add custom css
$this['asset']->addStyle($this['path']->url('theme::css/custom.css'));
// Set different body class for home and other page
$menus = JFactory::getApplication()->getMenu();
$active = $menus->getActive();
$class  = $active == $menus->getDefault() ? 'home' : 'inner_page';
if($active){
    $page_class =  $active->params->get('pageclass_sfx'); 
    if($page_class) $class .= ' '.$page_class; 
}

if(isset($active->alias)){
	//$class .= ' '.$active->alias;
}


if($this['option']->get('template.body.class'))
	$this['option']->set('template.body.class', $this['option']->get('template.body.class').' '.$class);
else
	$this['option']->set('template.body.class', $class);

// Handheld Friendly

if($this['option']->get('global.mobile.allmobile.enable') != 3){
    $this['template']->document->setMetaData ( 'viewport', 'width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.5, user-scalable='.$this['option']->get('mobile.allmobile.scalable_content', 'no') );
    $this['template']->document->setMetaData ( 'apple-mobile-web-app-capable', 'yes' );
}


//JHtml::_('bootstrap.tooltip');


$this['template']->document->setMetaData ( 'HandheldFriendly', 'true' );

// Favicon
$this['template']->document->addFavicon($this['path']->url('theme::favicon.ico'));

//  APPLE FAVICON 
$this['template']->document->addHeadLink($this['path']->url('theme::touch-icon-iphone.png'), 'apple-touch-icon-precomposed');
$this['template']->document->addHeadLink($this['path']->url('theme::touch-icon-ipad.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '72x72'));
$this['template']->document->addHeadLink($this['path']->url('theme::touch-icon-iphone4.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '114x114'));
?>

<!--[if lt IE 9]>
<script src="<?php echo $this['path']->url('theme::js/html5shiv.js') ?>" type="text/javascript"></script>
<script src="<?php echo $this['path']->url('theme::js/respond.src.js') ?>" type="text/javascript"></script>
<![endif]-->
<?php
// Reorder Asset - To Support compression
$this ['event']->fireEvent ( 'onRenderHead' );

// Important method
$this ['asset']->reverse ();
?>

