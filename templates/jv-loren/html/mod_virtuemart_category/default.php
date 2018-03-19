<?php // no direct access
defined('_JEXEC') or die('Restricted access');
//JHTML::stylesheet ( 'menucss.css', 'modules/mod_virtuemart_category/css/', false );

/* ID for jQuery dropdown */
$ID = str_replace('.', '_', substr(microtime(true), -8, 8));
$id_module = rand(1000,9999);
$js="
//<![CDATA[
jQuery(document).ready(function() {
	jQuery('.VMmenu[data-id=\"".$id_module."\"] .VmArrowdown').click(
		function() {
			if (jQuery(this).parent('div').next('ul').is(':hidden')) {
				jQuery(this).parents('.VMmenu').find('ul:visible').slideUp(120,'linear').parents('li').addClass('VmClose').removeClass('VmOpen');
				jQuery(this).parent().next('ul').slideDown(120,'linear');
				jQuery(this).parents('li').addClass('VmOpen').removeClass('VmClose');
			} else{
				jQuery(this).parents('.VmOpen').addClass('VmClose').removeClass('VmOpen');
				jQuery(this).parent('div').next('ul').slideUp(120,'linear');
			}
		});
	});
//]]>
" ;

		$document = JFactory::getDocument();
		$document->addScriptDeclaration($js);
		
		?>

<ul class="VMmenu <?php echo $class_sfx ?>" data-id="<?php echo $id_module;?>">
<?php foreach ($categories as $category) {
		 $active_menu = 'class="VmClose"';
		$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
		$cattext = $category->category_name;
		//if ($active_category_id == $category->virtuemart_category_id) $active_menu = 'class="active"';
		if (in_array( $category->virtuemart_category_id, $parentCategories)) $active_menu = 'class="VmOpen"';

		?>

<li <?php echo $active_menu ?>>
	<div>
		<?php echo JHTML::link($caturl, $cattext);
		if ($category->childs) {
			?>
			<span class="VmArrowdown"> </span>
			<?php
		}
		?>
	</div>
<?php if ($category->childs) { ?>
<ul class="menu<?php echo $class_sfx; ?>">
<?php
		foreach ($category->childs as $child) {

		$active_child_menu = 'class="VmClose"';
		$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$child->virtuemart_category_id);
		$cattext = vmText::_($child->category_name);
		if ($child->virtuemart_category_id == $active_category_id) $active_child_menu = 'class="VmOpen"';
		?>
		<li <?php echo $active_child_menu ?>>
<li>
	<div ><?php echo JHTML::link($caturl, $cattext); ?></div>
</li>
<?php		} ?>
</ul>
<?php 	} ?>
</li>
<?php
	} ?>
</ul>
