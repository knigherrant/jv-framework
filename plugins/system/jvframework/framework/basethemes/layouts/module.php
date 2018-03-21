<?php 
//echo JModuleHelper::renderModule( $module, $options );

echo $this->render("modules/{$style}", compact('module', 'params', 'options'));
defined('_JEXEC') or die;


