<?php 
// Override path
$this['path']->addPath(dirname(__FILE__).'/layouts', 'layouts');
$this['path']->addPath(dirname(__FILE__).'/layouts/html', 'override');
$this['path']->addPath(dirname(__FILE__).'/extensions', 'extensions');
