<?php
/**
 * @version     1.0.0
 * @package     com_jvss
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PHPKungfu <info@phpkungfu.club> - http://www.joomalvi.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.framework');   
JHtml::_('jquery.framework');      
JHtml::_('jquery.ui', array('core', 'sortable'));
JHtml::_('bootstrap.framework');
JHtml::_('behavior.colorpicker');
JHtml::_('behavior.formvalidation');                
JHtml::_('formbehavior.chosen', 'select:not(.chzn-custom-value)');
JHtml::_('formbehavior.chosen', '.chzn-custom-value', null, array('disable_search_threshold'=>1));

JText::script('JGLOBAL_VALIDATION_FORM_FAILED');
JText::script('JGLOBAL_KEEP_TYPING');
JText::script('JGLOBAL_LOOKING_FOR');

// Import CSS
$document = JFactory::getDocument();
$assets = "components/com_jvss/assets/";
$document->addStyleSheet("{$assets}css/jvss.css"); 

$document->addScript( "{$assets}js/bootstrap.v3.min.js" );

/* Import Editor tinymce */       
$document->addScript(JUri::base( true )."/components/com_jvss/assets/editors/tinymce/tinymce.min.js"); 

/* Import Editor codemirror */ 
$document->addStyleSheet(JUri::root()."media/editors/codemirror/lib/codemirror.css");
$document->addStyleSheet(JUri::root()."media/editors/codemirror/addon/hint/show-hint.css");
JHtml::script(JUri::root()."media/editors/codemirror/lib/codemirror.js");
JHtml::script(JUri::root()."media/editors/codemirror/addon/hint/show-hint.js");
JHtml::script(JUri::root()."media/editors/codemirror/addon/hint/css-hint.js");
JHtml::script(JUri::root()."media/editors/codemirror/mode/css/css.js");
JHtml::script( JUri::root()."media/editors/codemirror/addon/display/fullscreen.js"          );

JHtml::script( JUri::root() . 'media/jui/js/ajax-chosen.min.js' );

/* Import range slider */

$document->addStyleSheet("{$assets}css/ion.rangeSlider.css");
$document->addStyleSheet("{$assets}css/ion.rangeSlider.skinFlat.css");  
$document->addScript("{$assets}js/ion.rangeSlider.js");

/* Import function tmpl */
$document->addScript("{$assets}js/jquery.tmpl.min.js"); 
$document->addScript("{$assets}js/imagesloaded.pkgd.min.js"); 

/* Import function plugin drag */
$document->addScript( "{$assets}js/draggable.min.js" ); 

$document->addScript("{$assets}js/jquery.jsonf.js");

/* Import function plugin */
$document->addScript("{$assets}js/jquery.jvss.func.js");
$document->addScript("{$assets}js/jquery.jvss.func.js");
$document->addScript("{$assets}js/do.js");

?>

<div>
	
    <div class="form-horizontal">
        
        <form action="<?php echo JRoute::_('index.php?option=com_jvss&layout=edit&id=' . (int) $this->item->id); ?>" 
        method="post" enctype="multipart/form-data" name="adminForm" id="item-form" class="form-validate">
            <div class="exclude-custom-param">
                
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('name'); ?></div>
                </div>
                
                <input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
                <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
                <input type="hidden" name="task" value="" />
                <div class="hidden" data-field="token"><?php echo JHtml::_('form.token'); ?></div>
                
            </div>                                                  
            <div data-tag="wscss"></div>                                                                                    
            <textarea data-tmpl="cache" name="jform[params]" class="hidden"><?php echo json_encode( JvssHelper::theContent( $this->item->params ) )?></textarea>
            <textarea name="jform[sconfig]" id="jform_sconfig" class="hidden"><?php echo $this->item->sconfig; ?></textarea>
        </form>

		<div class="jsonf slides" data-tag="slides" name="layer"></div>
		
		<div class="jsonf" data-tag="wsconfig" name="sconfig"></div>
    </div>
</div>

<div id="render_layout" class="modal fade" data-backdrop="static">
  
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="progress progress-success progress-striped">
                    <div class="bar" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>  
    
</div>

<div data-tag="wsimport"></div>                                                                                 


<script type="text/html" data-tmpl="layer" class="hidden"></script>
<script>
	window.JV = jQuery.extend(window.JV, {
		ochosen: {
			normal: {
				"disable_search_threshold":10,
				"allow_single_deselect":true,
				"placeholder_text_multiple":"Select some options",
				"placeholder_text_single":"Select an option",
				"no_results_text":"No results match"
			},
			custom: {
				"disable_search_threshold":1,
				"allow_single_deselect":true,
				"placeholder_text_multiple":"Select some options",
				"placeholder_text_single":"Select an option",
				"no_results_text":"No results match"
			}
		},
		ominicolors: {
			control: 'hue',
			position: 'right',
			theme: 'bootstrap'
		},
		UYT: '<?php echo JUri::root().'administrator/index.php?option=com_jvss&task=item.syt&maxResults=6'?>',
		UVIMEO: 'https://api.vimeo.com/videos?access_token=c79cc073e3f705116fe6ffba180fd809&per_page=6',
		back_url:'<?php echo JUri::base( true ). "/index.php?option=com_jvss&view=items"; ?>',
		nurl:'<?php echo JUri::base( true ). "/index.php?option=com_jvss&view=item&layout=edit&id=0"; ?>',
        sexport_url: '<?php echo JUri::base( true ) . "/index.php?option=com_jvss&task=item.sexport&id={$this->item->id}"; ?>',
        base_url: '<?php echo rtrim( JUri::root(), '/' ); ?>'
	});
</script>