<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>

<button class="btn btn-search-modal btn-primary" data-toggle="modal" data-target="#search-modal-<?php echo $module->id; ?>" data-text="<?php echo $button_text;?>"><i class="fa fa-search"></i></button>
<div id="search-modal-<?php echo $module->id; ?>" class="modal fade search-wrapper" tabindex="-1" role="dialog" aria-hidden="false" >
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
	<div class="modal-dialog modal-lg">
		<div class="modal-content clearfix">
			<form action="<?php echo JRoute::_('index.php');?>" method="post">
			<?php
				$output = '';
				if ($params->get('label') !="") {
					$output .= '<label for="mod-search-searchword" class="element-invisible">' . $label . '</label><br />';
				}
				
				$input  = '<input name="searchword" id="mod-search-searchword" maxlength="' . $maxlength . '"  class="form-control search-query" type="search"';
				$input .= ' placeholder="' . $text . '" />';

				if ($button) :
					if ($imagebutton) :
						$btn_output = ' <button class="button btn btn-primary" onclick="this.form.searchword.focus();"><i class="fa fa-search"></i></button>';
					else :
						$btn_output = ' <button class="button btn btn-primary" onclick="this.form.searchword.focus();">' . $button_text . '</button>';
					endif;

					switch ($button_pos) :
						case 'top' :
							$output .= '<p>'.$btn_output . '</p>' . $input;
							break;

						case 'bottom' :
							$output .= '<p>'.$input . '</p>' . $btn_output;
							break;

						case 'right' :
							$output .= '<div class="input-group">'.$input.'<span class="input-group-btn">'.$btn_output.'</span></div>';
							break;

						case 'left' :
						default :
							$output = '<div class="input-group"><span class="input-group-btn">'.$btn_output.'</span>'.$input.'</div>';
							break;
					endswitch;

				endif;

				echo $output;
			?>
			<input type="hidden" name="task" value="search" />
			<input type="hidden" name="option" value="com_search" />
			<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
		</form>
		</div>
	</div>
</div>
