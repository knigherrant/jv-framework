<?php
/**
# mod_jvtouchjcarouselr - JV Touch jcarouselr
# @version        3.0
# ------------------------------------------------------------------------
# author    PHPKungfu Solutions Co
# copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
# Websites: http://www.phpkungfu.club
# Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.form.formfield');

class JFormFieldJCarousel extends JFormField
{
    protected $type = 'jcarousel';
    
    protected function getLabel()
    {   
        return false;
    }

    protected function getInput(){
		$doc = JFactory::getDocument();
        $j30 = true;
        if(version_compare(JVERSION,'3.0')<0)  $j30 = false;
        $doc->addScript(JURI::root().'administrator/components/com_jvframework/assets/js/jcarousel.js', 'text/javascript');
        $doc->addScript(JURI::root().'administrator/components/com_jvframework/assets/js/json2.js', 'text/javascript');
        $doc->addStyleSheet(JURI::root().'administrator/components/com_jvframework/assets/css/jcarousel.css', 'text/css');
	$this->value = json_decode($this->value);
        if($this->value->list){
            $jcarousel = $this->value;
        }else{
           $jcarousel =new stdClass(); 
           $jcarousel->list = array();
           $jcarousel->list[0]->element = '.jvSlider';
           $jcarousel->list[0]->title = 'jvSlider-1';
           $jcarousel->list[0]->vertical = false;
           $jcarousel->list[0]->rtl = 0;
           $jcarousel->list[0]->start = 1;
           $jcarousel->list[0]->offset = 1;
           $jcarousel->list[0]->scroll = 3;
           $jcarousel->list[0]->auto = 0;
           $jcarousel->list[0]->wrap = 'circular';
           
        }
        ob_start();
	   ?>
	   <div id="JV_jCarousel" class="w100">
		   <div id="control-add" class="w30">
				<div class="jCarousel-control">
					<a class="btn btn-success" href="javascript:void(0)" onclick="jCarousel.addNewSet()">
						<span class="icon-plus"></span> &nbsp; <?php echo JText::_('JV_JCAROUSEL_ADD_FIELD');?>
					</a>
				</div>
		   </div>
			<div id="jCarousel-list" class="w70">
				<div id="jCarousel-container">
					<?php
					if($jcarousel->list){
						for($i=0;$i<count($jcarousel->list);$i++){
							$x = $jcarousel->list[$i];
							?>
							<div id="<?php echo 'jcarousel-'.($i+1);?>" class="jCarousel-item">
								<div class="jCarousel-title">
									<div onclick="jCarousel.toggle(this)"><?php if($x->title) echo $x->title; else echo 'Title slider - '.($i+1);?></div>
									<div class="jCarousel-title-control">
										<a class="ui-state-default ui-corner-all jCarousel-button" href="javascript:void(0)" onclick="jCarousel.removeItem(this)" title="Remove"><span class="ui-icon ui-icon-close"></span></a>
									</div>
								</div>
								<div style="display:none" class="data-input">
									<div class="jCarousel-input">
										<label>Title</label>
										<input type="text" class="jCarousel-title" value="<?php if($x->title) echo $x->title; else echo 'jcarousel-'.($i+1);?>"/>
									</div>
									<div class="clr"></div>
									
									<div class="jCarousel-input">
										<label>Element (.class || #id)</label>
										<input type="text" value="<?php echo $x->element;?>" class="jCarousel-element"/>
									</div>
									<div class="clr"></div>
									
									<div class="jCarousel-input">
										<label>Vertical</label>
										<select class="jCarousel-vertical">
											<option <?php if($x->vertical =='false') echo 'selected';?> value="false">False</option>
											<option <?php if($x->vertical =='true') echo 'selected';?> value="true">True</option>
										</select>
									</div>
									<div class="clr"></div>
									<div class="jCarousel-input">
										<label>Rtl</label>
									   <select class="jCarousel-rtl">
											<option <?php if($x->rtl =='0') echo 'selected';?> value="0">No</option>
											<option <?php if($x->rtl =='1') echo 'selected';?> value="1">Yes</option>
										</select>
									</div>
									<div class="clr"></div>
									<div class="jCarousel-input">
										<label>Start</label>
										<input  type="text"  value="<?php echo $x->start;?>" class="jCarousel-start"/>
									</div>
									<div class="clr"></div>
									<div class="jCarousel-input">
										<label>Offset</label>
										<input  type="text"  value="<?php echo $x->offset;?>" class="jCarousel-offset"/>
									</div>
									<div class="clr"></div>
									<div class="jCarousel-input">
										<label>Scroll</label>
										<input  type="text"  value="<?php echo $x->scroll;?>" class="jCarousel-scroll"/>
									</div>
                                                                        <div class="clr"></div>
									<div class="jCarousel-input">
										<label>Wrap</label>
										<input  type="text"  value="<?php echo $x->wrap;?>" class="jCarousel-wrap"/>
									</div>
                                                                        <!--
                                                                        <div class="clr"></div>
									<div class="jCarousel-input">
										<label>Fix Height</label>
										<input  type="text"  value="" class="jCarousel-height"/><span class="height">px</span>
									</div>
                                                                        -->
									
								   <div class="clr"></div>
									<div class="jCarousel-input">
										<label>Auto</label>
										<select class="jCarousel-auto">
											<option <?php if($x->auto <1) echo 'selected';?> value="0">No</option>
											<option <?php if($x->auto ==1) echo 'selected';?> value="1">Yes</option>
										</select>
									</div>
								</div>
							</div>
							<?php
						}
					}
					?>
					<div class="clr"></div>
				</div>
				<div class="clr"></div>
				
			</div>
		</div>
	   
	   <script type="text/javascript">

        jQuery(function($){
            jCarousel.init(<?php if(isset($slide->list)) echo count($slide->list); else echo '0';?>);
			
			var _submit = Joomla.submitbutton;
			Joomla.submitbutton = function(task){
				//if(arguments[0].indexOf('cancel') > 0 ){
					if(task=='style.apply' || task=='style.save' ) jCarousel.jCarouselSetValue();
					_submit.apply(Joomla,arguments);
				//}
			} 
        })
    </script>
	   
	   
	   <?php 
	   
	   $html = ob_get_clean().'<input style="display:none" name="'.$this->name.'" id="'.$this->id.'"/>';
	   return $html;
    }

}
