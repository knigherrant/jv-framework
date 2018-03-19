<?php
/**
* @version		$Id: mod_404.php 2011-06-04 14:10:00Cecil Gupta $
* @package		Joomla
* @copyright	Copyright (C) 2011 Cecil Gupta. All rights reserved
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
$jlang =JFactory::getLanguage();
$jlang->load('mod_breadcrumbs', JPATH_SITE, $jlang->getDefault(), true);
$error_image		= $params->get( 'error_image');
$error_title 		= $params->get( 'error_title');
$error_sub_title 	= $params->get( 'error_sub_title');
$error_contents		= $params->get( 'error_content');

$error_background 	= $params->get( 'error_background');

$modulesuffix 		= $params->get('moduleclass_sfx');
?>
<?php 
require JModuleHelper::getLayoutPath('mod_404','default');
?>