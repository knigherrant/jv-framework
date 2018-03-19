<?php
/**
# mod_jvslidepro - JV Slide Pro
# @versions: 1.5.x,1.6.x,1.7.x,2.5.x
# ------------------------------------------------------------------------
# author    Open Source Code Solutions Co
# copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
# Websites: http://www.joomlavi.com
# Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');
JVJSLib::add('jquery');
$doc = JFactory::getDocument();
$doc->addScript(JURI::root().'modules/mod_jvslidepro/assets/js/jquery.nivo.slider.js');
$doc->addStyleSheet(JURI::root().'modules/mod_jvslidepro/assets/css/nivo/nivo-slider.css');
if($dataConfigs->get('theme')) $doc->addStyleSheet(JURI::root()."modules/mod_jvslidepro/assets/css/nivo/themes/{$dataConfigs->theme}/{$dataConfigs->theme}.css");

$moduleid = "jvjsl-nivo-".$module->id;
$doc->addScriptDeclaration("
    jQuery(function(){ 
        jQuery('#{$moduleid}').nivoSlider(".$dataConfigs.");
    });
");
  
?>
<div class="slider-wrapper <?php echo $dataConfigs->theme? 'theme-'.$dataConfigs->theme:''?> <?php echo $dataConfigs->get('suffix')?>">
    <div class="ribbon"></div>
    <div id="<?php echo $moduleid?>" class="nivoSlider">
        <?php 
        $descs = '';
        foreach($dataImages as $item){
            $thumb = $item->get('thumb')? 'data-thumb="'.$item->thumb.'"':'data-thumb="'.$item->path.'"';
            
            if($item->get('title') || $item->get('content') || $item->get('desc') || $item->get('link')){
                $descid = $moduleid.'-'.md5($item->path);
                echo '<img src="'.$item->path.'" alt="" title="#'.$descid.'" '.$thumb.'/>';
                $descs .= '<div id="'.$descid.'" class="nivo-html-caption">';
                    if($item->get('title')){ $descs .= '<div class="title">'.$item->title.'</div>'; }
                    if($item->get('content')){ $descs .= '<div class="content">'. $item->content .'</div>';} 
                    if($item->get('desc')){ $descs .= '<div class="desc">'.$item->desc.'</div>'; } 
                    if($item->get('link')){ $descs .= '<div class="readmore"><a href="'.$item->link.'"><span>'.JText::_($item->readmore).'</span></a></div>'; }
                $descs .= '</div>';
            }else{
                echo '<img src="'.$item->path.'" '.$thumb.'/>';
            }
        }
        ?>
    </div>
    <?php echo $descs?>
</div>
