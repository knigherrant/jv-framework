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
-------------------------------------------------------------------------
*/
//no direct access
defined( '_JEXEC' ) or die( 'Retricted Access' );
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
            Joomla.submitform(task, document.getElementById('adminForms'));	
	}
</script>

<form class="typography" action="<?php echo JRoute::_('index.php?option=com_jvframework&id='.$this->item->id);?>" method="post" name="adminForm" id="adminForms">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend>Typography</legend>
			<ul class="adminformlist">		
			<?php 
			$fields = $this->form->getFieldset();
			
			foreach ($fields as $field){?>
				<li>
				<?php 
					echo $field->label;
					echo $field->input;
				?>
				</li>
			<?php }	?>
			</ul>
		</fieldset>
	</div>
	<div>
            <input type="hidden" name="option" value="com_jvframework" />
		<input type="hidden" name="task" value="" />	
		<?php echo JHtml::_('form.token'); ?>
	</div>
	
</form>