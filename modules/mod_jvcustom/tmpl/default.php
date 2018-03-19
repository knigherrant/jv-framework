<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$document 	= JFactory::getDocument();
if (!empty($video)) {
	$document->addStyleSheet( JUri::root(true).'/modules/mod_jvcustom/assets/css/YTPlayer.css');
	$document->addScript( JUri::root(true).'/modules/mod_jvcustom/assets/js/jquery.mb.YTPlayer.min.js');
	$document->addScriptDeclaration("
		(function(\$){
			\$(function(){
			   \$('.player').YTPlayer();
			});
		})(jQuery);
	");
	if (!empty($colorOverlay) && !empty($opacityOverlay)) {
		
		$document->addStyleDeclaration("
			.YTPOverlay {
				background-color: ".$colorOverlay.";
				opacity: ".$opacityOverlay.";
			}
		");
	}
}

if ($full) {
	$document->addScriptDeclaration("
		(function(\$){
			\$(function(){
			   function fullscreenBanner(){
				    var h = \$(window).height();
				    \$('#jvcustom-".$module->id."').each(function(i){
				    	$(this).height(h);
				    });
				}
				\$(window).resize(fullscreenBanner);
				fullscreenBanner();
			});
		})(jQuery);
	");
}
?>


<div 
	id="jvcustom-<?php echo $module->id;?>" 
	class="jvcustom<?php echo $moduleclass_sfx ?><?php echo (!empty($textalign))?' text-'.$textalign:''; ?> <?php echo ($color)?$color:''; ?> <?php echo ($background)?' background':''; ?> <?php echo (!empty($video))?' video':'';?>" 
	<?php echo ($parallax)?'data-stellar-background-ratio="'.$speed.'"':''; ?> 
	<?php echo ($parallax)?'data-stellar-horizontal-offset="'.$horizontalOffset.'"':''; ?> 
	<?php echo ($parallax)?'data-stellar-vertical-offset="'.$verticalOffset.'"':''; ?> 
	data-parent="<?php echo ($parent)?$parent:''; ?>"  
	<?php echo ($colorBgOverlay)?' data-coloroverlay="'.$colorBgOverlay.'" ':'';?>
	<?php echo ($opacityBgOverlay)?' data-opacityoverlay="'.$opacityBgOverlay.'"':'';?>
	style="<?php echo (!empty($background))?'background-image:url('.JUri::root(true).'/'.$background.');':''; ?> <?php echo (!empty($position))?'background-position: '.$position.';':''; ?> <?php echo (!empty($size))?'background-size: '.$size.';':''; ?> <?php echo (!empty($backgroundColor))?'background-color: '.$backgroundColor.';':''; ?> <?php echo (!empty($bgCss))?' '.$bgCss:''; ?>">
	<?php if (!empty($video)) {?>
	<div class="player"  
		data-property="{
			videoURL:'http://youtu.be/<?php echo $video;?>',
			containment:'#jvcustom-<?php echo $module->id;?>' 
			<?php 	echo (!empty($startAt))?', startAt:'.$startAt:''; 
					echo (!empty($stopAt))?', stopAt:'.$stopAt:''; 
					echo (!empty($mute))?', mute:'.$mute:'';  ?> ,
			autoPlay:true,
			loop:true, 
			showControls: true, 
			showYTLogo: false
		}" >
	</div>
	<?php } ?>
	<?php echo $contents; ?>
</div>
