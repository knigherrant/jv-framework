<jdoc:include type="head" />
<?php
JHtml::_('jquery.framework');
$this['asset']->Mootool(true);

$this['asset']->addLess('system');
$this['asset']->addLess('general');
$this['asset']->addLess('icomoon');
// basethemes 
Jhtml::_('bootstrap.framework');
$this['asset']->addScript($this['path']->url('theme::js/jv.js'));

if($this['option']->isRTL()){
	$this['asset']->addLess('bootstrap-rtl.min');
	$this['asset']->addLess('core-template-rtl');	
	$this ['asset']->addLess ( 'menu-touch.rtl');	

}
else
{
	$this['asset']->addLess('bootstrap.min');
	$this['asset']->addLess('core-template');
	$this ['asset']->addLess ( 'menu-touch');	
}

$this['asset']->addLess('css3');
$this['asset']->addLess('template');
$this['asset']->addLess('mobile');
$this['asset']->addLess('responsive');


if($this['option']->isRTL()){
	$this['asset']->addLess('template.style.rtl');
}

// Set different body class for home and other page
$menus = JFactory::getApplication()->getMenu();
$active = $menus->getActive();
$class  = $active == $menus->getDefault() ? 'home' : 'inner_page';
if($active) $page_class =  $active->params->get('pageclass_sfx');
if($page_class) $class .= ' '.$page_class;

if(isset($active->alias)){
	//$class .= ' '.$active->alias;
}
if($this['option']->get('global.k2css')) $this['asset']->addLess('k2');
if($this['option']->get('template.body.class'))
	$this['option']->set('template.body.class', $this['option']->get('template.body.class').' '.$class);
else
	$this['option']->set('template.body.class', $class);

// Handheld Friendly
if($this['option']->get('global.mobile.allmobile.enable') != 3){
    $this['template']->document->setMetaData ( 'viewport', 'width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.5, user-scalable='.$this['option']->get('mobile.allmobile.scalable_content', 'no') );
    $this['template']->document->setMetaData ( 'apple-mobile-web-app-capable', 'yes' );
}

// Favicon
$this['template']->document->addFavicon($this['path']->url('theme::favicon.ico'));

//  APPLE FAVICON 
$this['template']->document->addHeadLink($this['path']->url('theme::touch-icon-iphone.png'), 'apple-touch-icon-precomposed');
$this['template']->document->addHeadLink($this['path']->url('theme::touch-icon-ipad.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '72x72'));
$this['template']->document->addHeadLink($this['path']->url('theme::touch-icon-iphone4.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '114x114'));
?>

<?php
// Reorder Asset - To Support compression
$this ['event']->fireEvent ( 'onRenderHead' );

// Important method
$this ['asset']->reverse ();
?>

