<?php // no direct access
    error_reporting('E_ALL');
    defined('_JEXEC') or die('Restricted access');
    $title = ($error_title != "")?'<h1 class="error-title">'.$error_title.'</h1>':'';
    $sub_title = ($error_sub_title != "")?'<p class="error-sub-title">'.$error_sub_title.'</p>':'';
    $error_contents = ($error_contents != "")?('<div class="error-content">'.$error_contents.'</div>'):'';
?>
<div class="position position-breadcrumb">
    <div class="extended-breadcrumb" style="background-image: url(&quot;<?php echo JURI::base(true).'/'.$error_image ?>&quot;); background-size: cover; background-position: 50% -426px;" data-stellar-background-ratio="0.15" data-stellar-horizontal-offset="0" data-stellar-vertical-offset="3000">
    <div class="container">
    <h1 class="pageHeading"><?php echo JText::_("TPL_ERROR"); ?> 404</h1>
    <ul class="breadcrumb">
    <li><a href="<?php echo JURI::base(true); ?>" class="pathway"><?php echo JText::_("MOD_BREADCRUMBS_HOME"); ?></a></li><li class="active"><span><?php echo JText::_("TPL_ERROR"); ?> 404</span></li>       </ul>
    </div>
    <div class="extended-breadcrumb-overlay" style="background-color: #000000; opacity: 0.4;"></div>
    </div>
</div>  
<div class="error-mod " style="background-image: url('<?php echo JURI::base(true).'/'.$error_background;?>');">
    <?php 
        echo $title.$sub_title.$error_contents;
    ?>
    <div class="error-button"><a href="<?php echo JURI::base(true); ?>" class="btn btn-primary text-normal "><?php echo JText::_('TPL_404_BUTTON')?></a></div>
</div>
