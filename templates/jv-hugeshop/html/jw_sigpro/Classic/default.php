<?php
/**
 * @version		$Id: default.php 2827 2013-04-12 12:57:36Z joomlaworks $
 * @package		Simple Image Gallery Pro
 * @author		JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		http://www.joomlaworks.net/license
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$db = JFactory::getDBO();
$query = "SELECT template FROM #__template_styles WHERE client_id = 0 AND home = 1";
$db->setQuery($query);
$defaultemplate = $db->loadResult();
?>

<div id="sigProId<?php echo $gal_id; ?>" class="carouselOwl sigProContainer pgl-img-slide sigProClassic<?php echo $singleThumbClass.$extraWrapperClass; ?>" data-items="1" data-pagination="true" data-navigation="true" data-singleItem="true">
	<?php 
	foreach($gallery as $count=>$photo):
		$singlethumbmode = false;
		if($gal_singlethumbmode && $count>0) $singlethumbmode=true; 
		if(!$singlethumbmode): 
	?>

		<div class="sigProThumb item">
			<a href="<?php echo $photo->sourceImageFilePath; ?>" title="<?php echo '<p><b>'.$photo->captionTitle.'</b></p>'.$photo->downloadLink.$modulePosition; ?>" target="_blank"<?php echo $customLinkAttributes; ?>>
				<?php if(($gal_singlethumbmode && $count==0) || !$gal_singlethumbmode): ?>
				<img class="sigProImg" src="<?php echo JURI::root( true ).'/templates/'. $defaultemplate; ?>/images/transparent2x1.png" alt="<?php echo JText::_('JW_SIGP_LABELS_08').' '.$photo->filename; ?>" style="background-image:url(<?php echo $photo->sourceImageFilePath; ?>);" />
				<?php endif; ?>
				<?php if($gal_captions && !empty($photo->captionTitle)): ?>
					<span class="item-caption" title="<?php echo $photo->captionTitle; ?>"><?php echo $photo->captionTitle; ?></span>
				<?php endif; ?>
			</a>
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>

<?php if(isset($flickrSetUrl)): ?>
<a class="sigProFlickrSetLink" title="<?php echo $flickrSetTitle; ?>" target="_blank" href="<?php echo $flickrSetUrl; ?>"><?php echo JText::_('JW_SIGP_PLG_FLICKRSET'); ?></a>
<?php endif; ?>

<?php if($itemPrintURL): ?>
<div class="sigProPrintMessage">
	<?php echo JText::_('JW_SIGP_PLG_PRINT_MESSAGE'); ?>:
	<br />
	<a title="<?php echo $row->title; ?>" href="<?php echo $itemPrintURL; ?>"><?php echo $itemPrintURL; ?></a>
</div>
<?php endif; ?>