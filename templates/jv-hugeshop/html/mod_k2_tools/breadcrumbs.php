<?php
/**
 * @version		$Id: breadcrumbs.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2BreadcrumbsBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">
	<?php
	$output = '';
	if ($params->get('home')) {
		$output .= '<span class="fa fa-map-marker"></span>';
		$output .= '<a href="'.JURI::root().'">'.$params->get('home',JText::_('K2_HOME')).'</a>';
		if (count($path)) {
			foreach ($path as $link) {
				$output .= ' <i class="fa fa-angle-right"></i> '.$link;
			}
		}
		if($title){
			$output .= ' <i class="fa fa-angle-right"></i> '.$title;
		}
	} else {
		if($title){
			$output .= '<span class="fa fa-map-marker"></span> <i class="fa fa-angle-right"></i>';
		}
		if (count($path)) {
			foreach ($path as $link) {
				$output .= $link.' <i class="fa fa-angle-right"></i> ';
			}
		}
		$output .= $title;
	}

	echo $output;
	?>
</div>
