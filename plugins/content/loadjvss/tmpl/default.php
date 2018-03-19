<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_jvss
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$doc = JFactory::getDocument();
?>
<?php if($slider) :?>
<?php $config = $slider->sconfig?>
<?php $sid = JvssFrontendHelper::getPrefixSlider()?>
<?php $awid = "rev_slider_{$sid}_wrapper"?>
<?php $asid = "rev_slider{$sid}"?>
<?php $zstyle = array();?>
<div id="<?php echo $awid?>" 
class="<?php echo JvssFrontendHelper::getWrapperClass($slider->sconfig)?>"
style="<?php echo JvssFrontendHelper::getCssInlineWrapper($slider->sconfig)?>">
	<div id="<?php echo $asid?>" 
    class="<?php echo JvssFrontendHelper::getWrapperClass($slider->sconfig, 'slider')?>"
    style="<?php echo JvssFrontendHelper::getCssInlineWrapper($slider->sconfig, 'slider')?>">
		<ul>
		<?php $index = 0; foreach($slider->params as $k=>$slide):?>
            <?php if( isset( $slide[ 'state' ] ) && intval( $slide[ 'state' ] ) ):?>
			<li 
            <?php if( isset( $slide['id'] ) && $slide['id'] ):?>
            id="<?php echo $slide['id']?>" 
            <?php endif;?>
             <?php if( isset( $slide['zclass'] ) ):?>
			class="<?php echo $slide['zclass']?>" 
            <?php endif;?>
			<?php if( isset( $slide['attr'] ) ):?>
            <?php echo $slide['attr']?>
            <?php endif;?>
            <?php echo JvssFrontendHelper::getSlideTransition( $slide, $config, $index );?>
            <?php $index ++; ?>
			<?php if( isset( $slide['slotamount'] ) ): ?>
            data-slotamount="<?php echo $slide['slotamount']?>" 
            <?php endif;?>
            <?php if( isset( $slide['masterspeed'] ) ): ?>
			data-masterspeed="<?php echo $slide['masterspeed']?>" 
            <?php endif;?>
            <?php if( isset( $slide['title'] ) ):?>
            data-title="<?php echo $slide['title']?>" 
            <?php endif;?>             
			>
				<!-- MAIN IMAGE -->
				<?php if( $msrc = JvssFrontendHelper::getMainImage( $slide, $config ) ) : ?>
                <img 
                <?php echo $msrc; ?>  
				alt=""  
				<?php echo JvssFrontendHelper::getKenburn( $slide )?> 
				data-bgrepeat="<?php echo $slide['bgrepeat']?>">
                <?php endif;?>
                
                <?php if( isset($slide['items']) && is_array($slide['items']) && count($slide['items']) ):?>
                <?php foreach( $slide['items'] as $id => $layer ):?>
                    <?php $video_data = array( 
                        'hasVideo' => 0, 
                        'fullwidth' => 0,
                        'vkey' => '',
                        'vid' => ''
                    ); ?>
                    <div
                    <?php if( isset( $layer['zid'] ) && $layer['zid'] ): ?>id="<?php echo $layer['zid']?>"<?php endif;?> 
                    <?php if( $transitin = JvssFrontendHelper::getTransitCustom( $layer, 'in' ) ): ?>
                    <?php echo "data-customin='{$transitin}'\n";?>
                    <?php endif;?>
                    <?php if( $transitout = JvssFrontendHelper::getTransitCustom( $layer, 'out' ) ): ?>
                    <?php echo "data-customout='{$transitout}'\n"?>
                    <?php endif;?>
                    class="<?php echo JvssFrontendHelper::getLayerClass( $layer, $video_data, $config )?>"
                    <?php echo JvssFrontendHelper::getPosition( $layer, $video_data ) ?>
                    <?php if( $layer['easing'] ): ?>
                    <?php echo "data-easing='{$layer['easing']}'\n"?>
                    <?php endif;?>
                    <?php if( isset( $layer['splitin'] ) ): ?>
                    <?php echo "data-splitin='{$layer['splitin']}'\n"?>
                    <?php endif;?>
                    <?php if( isset( $layer['splitout'] ) ): ?>
                    <?php echo "data-splitout='{$layer['splitout']}'\n"?>
                    <?php endif;?>
                    <?php if( isset( $layer['easingout'] ) ): ?>
                    <?php echo "data-endeasing='{$layer['easingout']}'\n"?>
                    <?php endif;?>
                    <?php echo JvssFrontendHelper::getLayerTime( $layer, $config )?>
                    <?php echo JvssFrontendHelper::getSplitDelay( $layer )?>
                    <?php if( $video_data[ 'hasVideo' ] ) : ?>
                    <?php echo JvssFrontendHelper::getVideoData( $layer, $video_data )?>
                    <?php endif; ?>
                    style="<?php echo JvssFrontendHelper::getLayerStyle( $layer )?>"
                    >
                    <?php if( $loop = JvssFrontendHelper::getArr( $layer, 'loop', false ) ): ?>
                    <?php if( ( $loop_type = JvssFrontendHelper::getArr( $loop, 'loop_type', 'none' ) ) && in_array( $loop_type, array_keys( JvssFrontendMap::loop() ) ) ):?>
                    <div class="tp-layer-inner-rotation <?php echo "{$layer['zstyle']} {$loop_type}"?>"
                    <?php echo JvssFrontendHelper::getLoop( $loop, $loop_type ); ?>                    
                    >
                    <?php endif;?>
                    <?php endif;?>
                        
                        <?php if( !$video_data[ 'hasVideo' ] ) : ?>
                        <?php echo JvssFrontendFilter::theContent( $layer['content'] ); ?>
                        <?php endif; ?>
                    
                    <?php if( isset( $layer['loop'] ) ): ?>
                    <?php if( isset( $layer['loop'][ $loop_type ] ) ):?>
                    </div>
                    <?php endif;?>
                    <?php endif;?>
                    </div>
                    <?php if( $layer['zstyle'] ):?><?php array_push($zstyle, ".tp-caption.{$layer['zstyle']}" )?><?php endif;?>
                <?php endforeach;?>
                <?php endif;?>
			</li>
            <?php endif;?>
		<?php endforeach;?>
		</ul>
        <div class="tp-bannertimer <?php echo JvssFrontendHelper::getTimebarPosition( $config )?>"></div>
	</div>
</div>
<?php $css = ""; ?>

<?php if( $slider->customcss):?>
<?php $css = $slider->customcss?>
<?php endif;?>

<?php if( $styles = JvssFrontendHelper::getStyle( $zstyle ) ):?>
<?php $css .= $styles;?>
<?php endif;?>

<?php if( $config->slider_type === 'responsitive' ): ?>
<?php $css .= sprintf('#%s,#%s { width:%dpx; height:%dpx; }', $awid, $asid, $config->width, $config->height)?>
<?php foreach( JvssFrontendHelper::getResponsitiveValues( $config ) as $item):?>
<?php 
$strMaxWidth = "";                                            
if($item["maxWidth"] >= 0) {
    $strMaxWidth = "and (max-width: {$item["maxWidth"]}px)";
}
?>
<?php $css .= "@media only screen and (min-width: {$item["minWidth"]}px) {$strMaxWidth} {"; ?>
    <?php $css .= sprintf('#%s,#%s { width:%dpx; height:%dpx; }', $awid, $asid, $item["sliderWidth"], $item["sliderHeight"])?>
<?php $css .= "}" ?>
<?php endforeach;?>
<?php endif;?>

<?php $doc->addStyleDeclaration( $css ); ?>
<?php $doc->addScriptDeclaration( "
	jQuery(function($) {
        var revapi, c = (function(p){ 
            return p || {} ;
        })(" . JvssFrontendHelper::getConfig($config, count( $slider->params ) ) . ");
		revapi =  $('#rev_slider{$sid}').revolution(c);
        $(\".revapi-next\").click(function(){
            revapi.revnext();
        });
        $(\".revapi-prev\").click(function(){
            revapi.revprev();
        });
	});
" ); ?>
<?php endif;?>