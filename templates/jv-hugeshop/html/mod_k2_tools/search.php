<?php
/**
 * @version		$Id: search.php 1899 2013-02-08 18:57:03Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

/*
Important note:
If you wish to use the live search option, it's important that you maintain the same class names for wrapping elements, e.g. the wrapping div and form.
*/

?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2SearchBlock k2SearchBlock<?php if($params->get('moduleclass_sfx')) echo $params->get('moduleclass_sfx'); if($params->get('liveSearch')) echo ' k2LiveSearchBlock'; ?>">
	<form action="<?php echo $action; ?>" method="get" autocomplete="off" class="k2SearchBlockForm">

		
		

		<?php if($button): ?>
			<?php if($imagebutton): ?>
				<input type="text" value="<?php echo $text; ?>" name="searchword" maxlength="<?php echo $maxlength; ?>" size="<?php echo $width; ?>" class="form-control" onblur="if(this.value=='') this.value='<?php echo $text; ?>';" onfocus="if(this.value=='<?php echo $text; ?>') this.value='';" />
				<button type="submit" class="button" onclick="this.form.searchword.focus();"><span class="fa fa-search"></span></button>
			<?php else: ?>
				<div class="input-group">
			      <input type="text" value="<?php echo $text; ?>" name="searchword" maxlength="<?php echo $maxlength; ?>" size="<?php echo $width; ?>" class="form-control" onblur="if(this.value=='') this.value='<?php echo $text; ?>';" onfocus="if(this.value=='<?php echo $text; ?>') this.value='';" />
			      <div class="input-group-btn">
			        <button type="submit" class="btn btn-primary" onclick="this.form.searchword.focus();"><span><?php echo $button_text; ?></span></button>
			      </div><!-- /btn-group -->
			    </div><!-- /input-group -->
			<?php endif; ?>
		<?php endif; ?>

		<input type="hidden" name="categories" value="<?php echo $categoryFilter; ?>" />
		<?php if(!$app->getCfg('sef')): ?>
		<input type="hidden" name="option" value="com_k2" />
		<input type="hidden" name="view" value="itemlist" />
		<input type="hidden" name="task" value="search" />
		<?php endif; ?>
		<?php if($params->get('liveSearch')): ?>
		<input type="hidden" name="format" value="html" />
		<input type="hidden" name="t" value="" />
		<input type="hidden" name="tpl" value="search" />
		<?php endif; ?>
	</form>

	<?php if($params->get('liveSearch')): ?>
	<div class="k2LiveSearchResults"></div>
	<?php endif; ?>
</div>
