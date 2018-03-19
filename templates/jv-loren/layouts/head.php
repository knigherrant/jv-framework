<jdoc:include type="head" />
<?php
JHtml::_('jquery.framework');
$this['asset']->Mootool(true);

// basethemes
Jhtml::_('bootstrap.framework');
if($this['option']->get('global.retina')){
	$this['asset']->addScript($this['path']->url('theme::js/retina.min.js'));
}
$this['asset']->addScript($this['path']->url('theme::js/jv.js'));


if($this['option']->isRTL()){
	$this ['asset']->addLess('menu-touch.rtl', array('media' => 'screen and (max-width: '.$this['option']->get('menu.responsive').'px)'));	
}else{
	$this ['asset']->addLess('menu-touch', array('media' => 'screen and (max-width: '.$this['option']->get('menu.responsive').'px)'));	
}

$this['asset']->addLess('template');
if($this['option']->isRTL()){
	$this['asset']->addLess('template.style.rtl');
}
if($this['option']->isRTL()){
	$this['asset']->addLess('responsive-margin-rtl');
} else {
	$this['asset']->addLess('responsive-margin');
}
$this['asset']->addStyle($this['path']->url('theme::css/custom.css'));


// Set different body class for home and other page
$menus = JFactory::getApplication()->getMenu();
$active = $menus->getActive();
$class  = $active == $menus->getDefault() ? 'home_page' : 'inner_page';
if($active){
    $page_class =  $active->params->get('pageclass_sfx'); 
    if($page_class) $class .= ' '.$page_class; 
}

if(isset($active->alias)){
	$class .= ' '.$active->alias;
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

// Meta data
$this['template']->document->setMetaData ( 'HandheldFriendly', 'true' );

// Favicon
$this['template']->document->addFavicon($this['path']->url('theme::icon/favicon.ico'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/favicon-16x16.png'), 'icon', 'rel', array('sizes' => '16x16', 'type' => 'image/png'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/favicon-32x32.png'), 'icon', 'rel', array('sizes' => '32x32', 'type' => 'image/png'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/favicon-96x96.png'), 'icon', 'rel', array('sizes' => '96x96', 'type' => 'image/png'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/android-icon-192x192.png'), 'icon', 'rel', array('sizes' => '192x192', 'type' => 'image/png'));

// Apple Icon
$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-57x57.png'), 'apple-touch-icon-precomposed');
$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-60x60.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '60x60'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-72x72.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '72x72'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-76x76.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '76x76'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-114x114.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '114x114'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-120x120.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '120x120'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-152x152.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '152x152'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-152x152.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '152x152'));
$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-180x180.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '180x180'));

//Microsoft Icon
$this['template']->document->addHeadLink($this['path']->url('theme::icon/manifest.json'), 'manifest', 'rel');
$this['template']->document->setMetaData ( 'msapplication-TileColor', '#ffffff' );
$this['template']->document->setMetaData ( 'msapplication-TileImage', $this['path']->url('theme::icon/ms-icon-144x144.png') );
$this['template']->document->setMetaData ( 'theme-color', '#ffffff' );

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

