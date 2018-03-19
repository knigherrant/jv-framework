<?php
/**
 # com_jvframework - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$groups = $this->param->getGroups();  
         
foreach($groups as $group => $count){
    $attributes = $this->param->getGroupAttr($group);
    $title = isset($attributes['label']) ? JText::_($attributes['label']) : JText::_($attributes['group']);
?>
    
    <div class="jv-slider-sub">
		<span><span><span><?php echo $title ?></span></span></span>    
	</div>
	<div class="jv-slider-content-sub <?php echo strtolower(str_replace(' ', '_',$title)) ?>">
		<?php echo $this->param->render('jform[params]', $group); ?>
	</div>
    
    
<?php  } ?>