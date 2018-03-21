<?php
/*
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

class JFormFieldOwl extends JFormField
{
    protected $type = 'owl';
    
    protected function getLabel()
    {   
        return false;
    }

    protected function getInput(){
        $doc = JFactory::getDocument();
        $doc->addScript(JURI::root().'administrator/components/com_jvframework/assets/js/owl.js', 'text/javascript');
	$this->value = json_decode($this->value);
        if(isset($this->value->list)){
            $owl = $this->value;
        }else{
           $owl =new stdClass(); 
           $owl->list = array();
           $owl->list[0] = new stdClass(); 
           $owl->list[0]->enable = 1;
           $owl->list[0]->element = '.JV-Element';
           $owl->list[0]->title = 'JV-Title-1';
           $owl->list[0]->params = '';
           
        }
        ob_start();
	   ?>
	   <div id="JV_OWL" class="w100">
		   <div id="control-add" class="w30">
				<div class="OWL-control">
					<a class="btn btn-success" href="javascript:void(0)" onclick="OWL.addNewSet()">
						<span class="icon-plus"></span> &nbsp; <?php echo JText::_('Add OWL Carousel');?>
					</a>
				</div>
				<div class="option-owl">
					<a href="http://owlgraphic.com/owlcarousel/#customizing"  target='_blank'>Read Full Documentation</a>
				</div>
		   </div>
			<div id="OWL-list" class="w70">
				<div id="OWL-container">
					<?php
					if($owl->list){
						for($i=0;$i<count($owl->list);$i++){
							$x = $owl->list[$i];
							?>
							<div id="<?php echo 'jcarousel-'.($i+1);?>" class="OWL-item">
								<div class="OWL-title">
									<div onclick="OWL.toggle(this)"><?php if($x->title) echo $x->title; else echo 'Title slider - '.($i+1);?></div>
									<div class="OWL-title-control">
											<span>
													<input type="checkbox" id="OWL-enable" class="OWL-enable" name="OWL-enable" <?php echo ($x->enable==1) ? 'checked' : ''?> />
													<label for="OWL-enable"></label>
											</span>
											 <span class="ct-multi-btnDelete btn btn-mini">
                      	<a class="ui-state-default ui-corner-all OWL-button" href="javascript:void(0)" onclick="OWL.removeItem(this)" title="Remove">
													<span class="icon-remove"></span>
												</a>
											</span>
									</div>
								</div>
								<div style="display:none" class="data-input">
									<div class="OWL-input">
										<label for="OWL-title">Title</label>
										<input type="text" class="OWL-title" name="OWL-title" value="<?php if($x->title) echo $x->title; else echo 'jcarousel-'.($i+1);?>"/>
									</div>							
									<div class="OWL-input">
										<label for="OWL-element" data-toggle="tooltip" data-placement="bottom" title=".class || #id">Element</label>
										<input type="text" value="<?php echo $x->element;?>" class="OWL-element" name="OWL-element"/>
									</div>
									<div class="OWL-input">
										<label for="OWL-params">Params</label>
                     <textarea class="OWL-params" name="OWL-params"><?php echo $x->params; ?></textarea>
									</div>
								</div>
							</div>
							<?php
						}
					}
					?>				
				</div>
			</div>
		</div>
	   
	   <script type="text/javascript">

        jQuery(function($){
            OWL.init(<?php if(isset($slide->list)) echo count($slide->list); else echo '0';?>);
			
			var _submit = Joomla.submitbutton;
			Joomla.submitbutton = function(task){
				//if(arguments[0].indexOf('cancel') > 0 ){
					if(task=='style.apply' || task=='style.save' ) OWL.OWLSetValue();
					_submit.apply(Joomla,arguments);
				//}
			} 
        })
    </script>
	   <?php 
	   $img = JURI::base() . 'components/com_jvframework/assets/images/params.png';
	   $html = ob_get_clean().'<input style="display:none" name="'.$this->name.'" id="'.$this->id.'"/>';
          // $html .= "<div class='img-demo'><a class='modal' href='$img'><img alt='OWL params' src='$img' /></a></div>";
	   return $html;
    }

}
