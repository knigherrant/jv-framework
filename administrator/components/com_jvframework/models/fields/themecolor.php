<?php
/**
# mod_jvtouchthemecolorr - JV Touch themecolorr
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

class JFormFieldThemecolor extends JFormField
{
    protected $type = 'themecolor';
    
    protected function getLabel()
    {   
        return false;
    }

    protected function getInput(){
	    $html = '';

            $this->value = json_decode($this->value);
            $doc = JFactory::getDocument();
            $doc->addScript(JURI::root().'administrator/components/com_jvframework/assets/js/themecolor.js', 'text/javascript');
            if(!empty($this->value->list)){
                $themecolor = $this->value;
            }else{
               $themecolor =new stdClass(); 
               $themecolor->list = array();
               $themecolor->list[0] = new stdClass(); 
               $themecolor->list[0]->css = 'a';
               $themecolor->list[0]->color = '';
               $themecolor->list[0]->selector = 'color';
            }
            
            $options = array();
            $options[] = JHTML::_('select.option','background-color', JText::_('Background'));
            $options[] = JHTML::_('select.option', 'border-color', JText::_('Border'));
            $options[] = JHTML::_('select.option', 'color', JText::_('Color'));
            JHtml::_('behavior.colorpicker');
            ob_start()
            ?>


            <div id="jv_themecolor" class="w100">
                <div id="control-add" class="w30">
                     <div class="themecolor-control">
                         <a class="btn btn-success" href="javascript:void(0)" onclick="JVColor.addNew()">
                             <span class="icon-plus"></span> &nbsp; <?php echo JText::_('Add new Custom Color');?>
                         </a>
                     </div>
                </div>
                 <div id="themecolor-list" class="w70">
                    <div id="themecolor-container">
                        <?php
                        if($themecolor->list){
                            for($i=0;$i<count($themecolor->list);$i++){
                                $x = $themecolor->list[$i];
                                $selector = JHTML::_('select.genericlist', $options, '', 'class="inputbox selector" ', 'value', 'text', @$x->selector);
                                ?>
                                <div id="<?php echo 'themecolor-'.($i+1);?>" class="themecolor-item">
                                    <div class="themecolor-close">
                                            <a class="ui-state-default ui-corner-all themecolor-button" href="javascript:void(0)" onclick="JVColor.removeItem(this)" title="Remove">X</a>
                                    </div>
                                    <div class="themecolor-data-inputs">
                                        
                                        <div class="themecolor-input-color">
                                            <label>Custom Color</label>
                                            <input type="text" class="minicolors themecolor-color" placeholder="<?php echo @$x->color;?>" value="<?php echo @$x->color;?>" />
                                        </div>
                                        <div class="themecolor-input-selector">
                                            <label>Selector</label>
                                            <?php echo $selector; ?>
                                        </div>
                                        <div class="themecolor-input">
                                            <label>Custom Css</label>
                                            <textarea class="themecolor-css" ><?php echo @$x->css;?></textarea>
                                        </div>
                                    
                                        
                                        <div class="clr"></div>
                                    
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
                    JVColor.init(<?php if(isset($themecolor->list)) echo count($themecolor->list); else echo '0';?>);
                    var _submit = Joomla.submitbutton;
                    Joomla.submitbutton = function(task){
                        if(task=='style.apply' || task=='style.save' ) JVColor.setValues();
                        _submit.apply(Joomla,arguments);
                    } 
                })
            </script>


            <?php
            $html = ob_get_clean().'<input type="hidden" name="'.$this->name.'" id="'.$this->id.'"/>';
            return $html;
    }

}
