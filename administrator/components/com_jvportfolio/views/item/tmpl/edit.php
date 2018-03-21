<?php
   /**
    * @version     1.0.0
    * @package     com_jvportfolio
    * @copyright   Copyright (C) 2014. All rights reserved.
    * @license     GNU General Public License version 2 or later; see LICENSE.txt
    * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
    */
   // no direct access
   defined('_JEXEC') or die;
   ?>    
<form action="<?php echo JRoute::_('index.php?option=com_jvportfolio&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="item-form" class="form-validate">
   <div class="form-horizontal">
      <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
      <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_JVPORTFOLIO_TITLE_ITEM', true)); ?>
      <div class="row-fluid">
         <div class="span7 form-horizontal">
            <fieldset class="adminform">
               <div class="control-group">
                  <div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
                  <div class="controls"><?php echo $this->form->getInput('id'); ?></div>
               </div>
               <div class="control-group">
                  <div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
                  <div class="controls"><?php echo $this->form->getInput('name'); ?></div>
               </div> 
               
               <div class="control-group">
                  <div class="control-label"><?php echo $this->form->getLabel('cate'); ?></div>
                  <div class="controls"><?php echo $this->form->getInput('cate'); ?></div>
               </div> 
               
               <div class="control-group">
                  <div class="control-label"><?php echo $this->form->getLabel('desc'); ?></div>
                  <div class="controls"><?php echo $this->form->getInput('desc'); ?></div>
               </div>
               <div class="control-group">
                  <div class="control-label"><?php echo $this->form->getLabel('link'); ?></div>
                  <div class="controls"><?php echo $this->form->getInput('link'); ?></div>
               </div>
               <div class="control-group">
                  <div class="control-label"><?php echo $this->form->getLabel('tag'); ?></div>
                  <div class="controls"><?php echo $this->form->getInput('tag'); ?></div>
               </div>
			   <div class="control-group">
                  <div class="control-label"><?php echo $this->form->getLabel('pfo_v'); ?></div>
                  <div class="controls"><?php echo $this->form->getInput('pfo_v'); ?></div>
               </div> 
			   <div class="control-group">
                  <div class="control-label"><?php echo $this->form->getLabel('pfo_t'); ?></div>
                  <div class="controls"><?php echo $this->form->getInput('pfo_t'); ?></div>
               </div> 
               <input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
               <?php if(empty($this->item->created_by)){ ?>
               <input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
               <?php } 
                  else{ ?>
               <input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
               <?php } ?>            
               <div class="control-group">
                  <div class="control-label"><?php echo $this->form->getLabel('date_created'); ?></div>
                  <div class="controls"><?php echo $this->form->getInput('date_created'); ?></div>
               </div>
            </fieldset>
         </div><!-- end div.span -->
         
         <div class="span5 pull-right">
          <div class="f-images">
             <table class="table table-bordered">
                <thead>
                   <tr>
                      <th>
                         <div class="">
                            <div class="control-label"><label class="span2">Image: </label></div>
                            <div class="">
                               <select class="span10 pull-right" data-iaction="">
                                  <option value="">Action</option>
                                  <option value="add-iaction">Add</option>
                                  <option value="checkall-iaction">Check all</option> 
                                  <option value="uncheck-iaction">Unchecked</option>
                                  <option value="remove-iaction">Remove checked</option>  
                               </select>
                            </div>
                         </div>
                      </th>
                   </tr>
                </thead>
                <tbody>
                   <tr>
                      <td>
                         <ul class="manager thumbnails items">
                         <?php if($this->item->image):?>     
                         <?php $this->item->image = explode(',', $this->item->image)?>
                         <?php foreach($this->item->image as $path):?>
                         <li class="imgOutline thumbnail height-80 width-80 center">
                              <div class="height-50"><img alt="" src="<?php echo JUri::root().$path?>" width="60" height="40"></div>
                              <input type="checkbox" name="jform_image[]" value="<?php echo $path?>">
                          </li>
                          <?php endforeach;?>
                         <?php endif;?>
                         </ul>
                      </td>
                   </tr>
                </tbody>
             </table>
            
            </div>

            <div class="w-extrafields">
              <?php echo $this->form->getInput( 'extrafields' ); ?>
              
            </div>
        </div>
        <!-- end div.span -->
      </div>
      <?php echo JHtml::_('bootstrap.endTab'); ?>
      <?php echo JHtml::_('bootstrap.endTabSet'); ?>
      <input type="hidden" name="task" value="" />
      <?php echo $this->form->getInput('image'); ?>   
      <?php echo JHtml::_('form.token'); ?>
   </div>
</form>
<script type="text/html" data-tmpl="himage">
<li class="imgOutline thumbnail height-80 width-80 center">
    <div class="height-50"><img alt="" src="{src}" width="60" height="40"></div>
    <input type="checkbox" name="jform_image[]" value="{path}">
</li>
</script>