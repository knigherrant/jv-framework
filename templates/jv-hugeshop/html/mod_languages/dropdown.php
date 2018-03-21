<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_languages
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="mod-languages<?php echo $moduleclass_sfx ?> langdropdown">
<?php if ($headerText) : ?>
	<div class="pretext"><p><?php echo $headerText; ?></p></div>
<?php endif; ?>

<?php if ($params->get('dropdown', 1)) : ?>
	<div class="dropdown">
		<button type="button" class="btn btn-languages btn-outline-thin btn-dark dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-globe"></i>
			<span class="lang-label"><?php echo JText::_('TPL_LANGUAGES'); ?></span> 
			<?php foreach ($list as $language) : ?>
				<?php if ($language->active):?>
					<?php if ($params->get('image', 1)):?>
						<?php echo JHtml::_('image', 'mod_languages/' . $language->image . '.gif', $language->title_native, array('title' => $language->title_native), true);?>
					<?php endif; ?>
					<span class="lang-name <?php echo $params->get('full_name', 1) ? 'full-name' : 'short-name';?>">
						<?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef);?>
					</span>
				<?php endif;?>
			<?php endforeach;?>
			<i class="fa fa-angle-down"></i>
		</button>	
		<ul class="dropdown-menu <?php echo $params->get('inline', 1) ? 'lang-inline' : 'lang-block';?>">
		<?php foreach ($list as $language) : ?>
			<?php if ($params->get('show_active', 0) || !$language->active):?>
				<li class="<?php echo $language->active ? 'lang-active' : '';?>" dir="<?php echo JLanguage::getInstance($language->lang_code)->isRTL() ? 'rtl' : 'ltr' ?>">
				<a href="<?php echo $language->link;?>">
				<?php if ($params->get('image', 1)):?>
					<?php echo JHtml::_('image', 'mod_languages/' . $language->image . '.gif', $language->title_native, array('title' => $language->title_native), true);?>
				<?php endif; ?>
				<span class="lang-name <?php echo $params->get('full_name', 1) ? 'full-name' : 'short-name';?>">
					<?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef);?>
				</span>
				</a>
				</li>
			<?php endif;?>
		<?php endforeach;?>
		</ul>
	</div>
<?php else : ?>
	Use the dropdown in administrator
<?php endif; ?>

<?php if ($footerText) : ?>
	<div class="posttext"><p><?php echo $footerText; ?></p></div>
<?php endif; ?>
</div>
