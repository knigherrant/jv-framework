<?php
/**
 # MOD_JVLATEST_NEWS - JV Latest News
 # @version		3.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2013 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------
*/

// No direct access to this file 
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'modules/mod_jvlatest_news/tmpl/'.$template.'/css/jvlatestnews.css');

JHTML::addIncludePath(JPATH_SITE.'/components/com_content/helpers');
JHTML::_('behavior.framework', true);

if(count($items)){
    if(!JRequest::getVar('jvlatestnews-ajax')){ ?>
    <div id="jvlatestnews<?php echo $module->id ?>" class="jvlatestnews <?php echo $template ;?>">
    
    	<?php if ( $params->get('description') != '' ) { ?>
    	<div class="description"><?php echo $params->get('description'); ?></div>
    <?php } ?>
        
        
        <?php if(intval($params->get('date_filter')) === 1){ ?>
            <div class="LatestNewsPagination">
            <ul class="nav nav-tabs jvlatestnews-pagination">
                <?php
                    $idow = 1;
                    foreach ($dayOfWeek as $kdow => $vdow) 
                    {
                        if($idow === 1)
                            echo '<li class="active"><a class="jvlatestnews-link" href="?mid='.$module->id.'&limit-start=0&date-filter='.$kdow.'">'.$vdow.'</a></li>';
                        else
                            echo '<li ><a class="jvlatestnews-link" href="?mid='.$module->id.'&limit-start=0&date-filter='.$kdow.'">'.$vdow.'</a></li>';
                        $idow++;
                    }
                ?>
            </ul>   
            </div> 
        <?php } ?> 

        <div class="jvlatestnews-container<?php echo $template != '' ?  ' '.$template : ''; ?><?php echo $moduleclass_sfx != '' ?  ' '.$moduleclass_sfx : ''; ?>">    

            <div class="jvlatestnews-content">
            <?php } ?>
            <?php 
                if($params->get('group_cat')) {
                    foreach ($items as $catTitle=>$list){
                        require JModuleHelper::getLayoutPath('mod_jvlatest_news', $template.'/article_lists');
                    }
                }else{
                    $list = $items;
                    require JModuleHelper::getLayoutPath('mod_jvlatest_news', $template.'/article_lists');
                }
            ?>
            <?php if(!JRequest::getVar('jvlatestnews-ajax')){  ?>     
            </div>
            <?php } ?>
        <?php if(intval($params->get('date_filter')) === 1){ 
            for($i = 1; $i < count($dayOfWeek); $i++){
                if(!JRequest::getVar('jvlatestnews-ajax')){  ?>     
                <div class="jvlatestnews-content"></div> 
                <?php } 
            } 
        }else if($pagination->get('pages.total') && $params->get('show_paging', 0)){
            for($i = 1; $i < $pagination->get('pages.total'); $i++){
                if(!JRequest::getVar('jvlatestnews-ajax')){  ?>     
                <div class="jvlatestnews-content"></div> 
                <?php } 
            } 
        } ?>

        <?php if(!JRequest::getVar('jvlatestnews-ajax')){  ?>     
        </div>
        <?php } ?>
    <?php if(JRequest::getVar('jvlatestnews-ajax') && JRequest::getVar('mid') == $module->id){ die;}  ?> 
    <?php if($params->get('show_paging', 0) && count($pagination)){
        require JModuleHelper::getLayoutPath('mod_jvlatest_news', $template.'/article_pagination');        
    } ?> 
    <?php if(!JRequest::getVar('jvlatestnews-ajax')){  ?>     
    </div>
    <?php } ?>

<?php } else {exit('0');} ?>