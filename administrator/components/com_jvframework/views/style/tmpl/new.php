<?php
/**
 # com_jvframwork - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
//no direct access
defined( '_JEXEC' ) or die( 'Retricted Access' );
?>
<form action="<?php echo JRoute::_('index.php?option=com_jvframework&id='.$this->item->id);?>" method="post" name="adminForm" id="adminForm" class="adminform">
    <div class="width-100 fltlft">
		<fieldset class="adminform">   			
			<ul class="fields">					
				<?php echo $this->form->getLabel('title'); ?>
				<?php echo $this->form->getInput('title'); ?>
				<?php echo $this->form->getLabel('theme'); ?>
				<?php echo $this->form->getInput('theme'); ?>
			</ul>
			 <div style="float: right">
		    	<button type="button" onclick="submitbutton('style.save');">Save</button>
		    </div>					
		 </fieldset>
	 </div>
	<div>		
		<input type="hidden" name="task" value="" />	
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>