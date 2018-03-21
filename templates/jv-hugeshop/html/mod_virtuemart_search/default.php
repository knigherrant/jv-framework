<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<!--BEGIN Search Box -->
<form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0&virtuemart_category_id='.$category_id ); ?>" method="get">
<div class="search<?php echo $params->get('moduleclass_sfx'); ?> vmSearch">
<?php $output = '<input name="keyword" id="mod_virtuemart_search" maxlength="'.$maxlength.'" alt="'.$button_text.'" class="inputbox'.$moduleclass_sfx.' form-control" type="text" size="'.$width.'" value="'.$text.'"  onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';" />';

			if ($button) :
			    if ($imagebutton) :
			        $button = '<span class="input-group-btn"><button type="submit" title="'.$button_text.'" class="button'.$moduleclass_sfx.' btn btn-default btn-icon" onclick="this.form.keyword.focus();"><i class="fa fa-search"></i></button></span>';
			    else :
			        $button = '<span class="input-group-btn"> <input type="submit" value="'.$button_text.'" class="button'.$moduleclass_sfx.' btn btn-default " onclick="this.form.keyword.focus();"/></span>';
			    endif;
		

			switch ($button_pos) :
			    case 'top' :
				    $button = $button.'<br />';
				    $output = $button.$output;
				    break;

			    case 'bottom' :
				    $button = '<br />'.$button;
				    $output = $output.$button;
				    break;

			    case 'right' :
				    $output =   '<div class="input-group">'.$output.$button.'</div>';
				    break;

			    case 'left' :
			    default :
				    $output = 	'<div class="input-group">'.$button.$output.'</div>';
				    break;
			endswitch;
			endif;
			
			echo $output;
?>
</div>
		<input type="hidden" name="limitstart" value="0" />
		<input type="hidden" name="option" value="com_virtuemart" />
		<input type="hidden" name="view" value="category" />
<?php if(!empty($set_Itemid)){
	echo '<input type="hidden" name="Itemid" value="'.$set_Itemid.'" />';
} ?>

	  </form>

<!-- End Search Box -->
