<?php
/**
 * @version		$Id: modules.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the sliders style, you would use the following include:
 * <jdoc:include type="module" name="test" style="slider" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * two arguments.
 */

/**
 * Module chrome for rendering the module in a slider
 */
function modChrome_slider($module, &$params, &$attribs)
{
	jimport('joomla.html.pane');
	// Initialize variables
	$sliders = & JPane::getInstance('sliders');
	$sliders->startPanel( JText::_( $module->title ), 'module' . $module->id );
	echo $module->content;
	$sliders->endPanel();
}

function modChrome_raw($module, &$params, &$attribs){
	echo $module->content;
}

function modChrome_nav($module, &$params, &$attribs){ ?>
    <div class="navbar">
    <div class="navbar-inner">
        <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>     
        <div class="nav-collapse"> <div class="nav"> <?php  echo $module->content; ?> </div> </div><!--/.nav-collapse -->
        </div>
    </div>
    </div>
<?php } 

function modChrome_popup($module, &$params, &$attribs){ ?>
    <a class="popup-button <?php echo $module->module;?>" data-toggle="modal" href="#btmodal-<?php echo $module->id; ?>" >
            <span><?php echo $module->title; ?></span>
    </a>
    <div id="btmodal-<?php echo $module->id; ?>" class="btmodal <?php echo $module->module;?> hide fade module<?php if($params->get('moduleclass_sfx')) echo " mod".$params->get('moduleclass_sfx'); ?>">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <?php if($module->showtitle): ?>
                    <h3 class="title">
                            <?php if(isset($options['icon'])): ?>
                            <i class="icon-<?php echo $options['icon']; ?>"></i>
                            <?php endif; ?>
                            <span><?php echo $module->title; ?></span>
                    </h3>
                    <?php endif; ?>
            </div>
            <div class="contentmod modal-body">
                    <?php echo $module->content; ?>
            </div>
    </div>
<?php } 

function modChrome_jvxhtml($module, &$params, &$attribs){
	if (!empty ($module->content)) : ?>
	<<?php echo $params->get('module_tag'); ?> class="jv-module">
		<?php 
		if ($module->showtitle != 0) : 
			$title = explode('||',$module->title);
		?>
			<<?php echo $params->get('header_tag'); ?> class="title-module <?php echo $params->get('header_class'); ?>">
		   		<span><?php echo trim($title[0]); ?></span>
                <?php if (!empty($title[1])) echo '<small>'.trim($title[1]).'</small>'; ?>
            </<?php echo $params->get('header_tag'); ?>>
		<?php endif; ?>        
        <div class="contentmod clearfix">
			<?php echo $module->content; ?>
         </div>   
	</<?php echo $params->get('module_tag'); ?>>
	<?php endif;
}

function modChrome_jvxhtmls($module, &$params, &$attribs){ ?>
    <<?php echo $params->get('module_tag'); ?> class="jv-module <?php echo $module->module; ?>">
            <?php if($module->showtitle): ?>
            <<?php echo $params->get('header_tag'); ?> class="title-module <?php echo $params->get('header_class'); ?>">
                    <?php if(isset($options['icon'])): ?>
                            <i class="icon-<?php echo $options['icon']; ?>"></i>
                    <?php endif; ?>
                    <span><?php echo $module->title; ?></span>
            </<?php echo $params->get('header_tag'); ?>>
            <?php endif; ?>
            <div class="contentmod clearfix">
                    <?php echo $module->content; ?>
            </div>
    </<?php echo $params->get('module_tag'); ?>>
<?php } ?>