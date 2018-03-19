<?php
/**
 # MOD_JVLATEST_NEWS - JV Latest News
 # @version		3.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2013 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$pagination->set('modid', $module->id); 
if($pagination->get('pages.total')) :
    $transition = $params->get('transition', 'linear');
    $ease    = $params->get('ease', 'easeIn');
    $duration= $params->get('duration', '500');
    $fx      = $params->get('fx', 'showHide');
    $width   = $params->get('width','100%');
    $width   = $width;
    $height  = $params->get('height','auto');
    $height  = is_numeric($height) ? $height . 'px' : $height;
    $autorun = $params->get('auto','0');
    $timer   = $params->get('timer','5000');
    $forcewaiting = $params->get('wait','0');

    
    $document->addScript(JURI::base().'modules/mod_jvlatest_news/tmpl/'.$template.'/js/pagination.js'); 
    $document->addScriptDeclaration("
    window.addEvent('domready', function(){
    	new jvlatestnews($('jvlatestnews{$module->id}'), {
    		'transition': Fx.Transitions.$transition" . ($transition != 'linear' ? '.' . $ease : '') . ",
    		'duration': $duration,
    		'fx': '$fx',
    		'ajax': 1,	
    		'autoRun': $autorun,
    		'newsTimer': $timer,
    		'forceWaiting': $forcewaiting,
    		'width': '$width',
    		'height': '$height'
    	});
    });");
endif;

echo '<div class="LatestNewsPagination">';
echo $pagination->getPagesLinks($template); 
echo '</div>';