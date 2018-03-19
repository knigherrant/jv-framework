<?php
JVJSLib::$libs['jquery.plugins.jvresponsiveslider'] = array(
    'require' => 'jquery.plugins.touchswipe,jquery.plugins.mousewheel,jquery.ui.effects,jquery.plugins.transform,jquery.plugins.imagesloaded,jquery.plugins.hotkey',
    'js' => JUri::root(true).'/modules/mod_jvslidepro/assets/js/jquery.jvresponsiveslider.js',
    'css' => JUri::root(true).'/modules/mod_jvslidepro/assets/css/jvresponsiveslider.css'
);
JVJSLib::add('jquery.plugins.jvresponsiveslider');
$moduleid = "resslide_".$module->id;
$doc->addStyleDeclaration("#{$moduleid} > ul.items > li{ width: {$dataConfigs->itemWidth} }");
$doc->addScriptDeclaration("
    jQuery(function($){
        new JVResponsiveSlide('#{$moduleid}',{$dataConfigs});
    })
");
    ?>
<div id="<?php echo $moduleid?>" class="jvresslide <?php echo $dataConfigs->state('selected').'-'.$dataConfigs->type;?> <?php echo $dataConfigs->get('suffix')?>">
    <div class="resbon"></div>
    <ul class="items">
        <?php  foreach($dataImages as $item): $thumb = $item->get('thumb',false); ?>
        <li class="<?php echo $item->get('type','')?>" <?php echo $thumb?'data-thumb="'.$thumb.'"':''?> data-type="<?php echo $item->get('type','')?>" data-params='<?php echo str_replace("'","\\'",$item->get('params',''))?>'>
        <?php 
            if($item->get('path')){ ?> <img src="<?php echo $item->path;?>" /><?php }
            if($item->get('title')){ ?> <div class="title"><?php echo $item->title?></div><?php } 
            if($item->get('content')){ ?> <div class="content"><?php echo $item->content?></div> <?php } 
            if($item->get('desc')){ ?> <div class="desc"><?php echo $item->desc?></div> <?php } 
            if($item->get('link')){ ?> <div class="readmore"><a href="<?php echo $item->link?>"><span><?php echo JText::_($item->readmore)?></span></a></div> <?php }
        ?>
		</li>
        <?php endforeach;
         ?>
    </ul>
    <a href="javascript:void('Prev')" class="prev"><span>Prev</span></a>
    <a href="javascript:void('Next')" class="next"><span>Next</span></a>
</div>