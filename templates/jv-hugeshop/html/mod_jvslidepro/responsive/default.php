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
        <?php  foreach($dataImages as $key => $item): $thumb = $item->get('thumb',false); ?>
        <li class="slide<?php echo $key+1; ?><?php echo $item->get('type','')?>" data-thumb="<?php echo $item->path;?>" data-type="<?php echo $item->get('type','')?>" data-params='<?php echo str_replace("'","\\'",$item->get('params',''))?>' style="background-image: url(<?php if($item->get('path')){ echo $item->path;} ?>);">
            <?php 
                if ($item->get('type') == "k2" || $item->get('type') == "article") {
                ?>
                <div class="backgorundSlide" style="background-image: url(<?php if($item->get('path')){ echo $item->path;} ?>);"></div>
                <?php
                }
            ?>
            <div class="container">
                <?php 
                     if($item->get('path') && ($item->get('type') == "k2" || $item->get('type') == "article")){ ?> <img src="<?php echo $item->path;?>" alt="<?php echo $item->title?>" /><?php }
                    if($item->get('title') && ($item->get('type') == "k2" || $item->get('type') == "article")){ ?> <div class="title h3"><?php echo $item->title?></div><?php } 
                    if($item->get('content')){ ?> <div class="content"><?php echo $item->content?></div> <?php } 
                    if($item->get('desc')){ ?> <div class="descriptions"><?php echo $item->desc?></div> <?php } 
                    if($item->get('link')){ ?> <div class="readmore"><a href="<?php echo $item->link?>" class="btn btn-primary btn-icon"><i class="fa fa-angle-right"></i><span><?php echo JText::_(($item->readmore)?$item->readmore:'TPL_READMORE')?></span></a></div> <?php }
                ?>
            </div>
		</li>
        <?php endforeach;
         ?>
    </ul>
    <a href="javascript:void('Prev')" class="prev hidden-xs hidden-sm"><span>Prev</span></a>
    <a href="javascript:void('Next')" class="next hidden-xs hidden-sm"><span>Next</span></a>
</div>