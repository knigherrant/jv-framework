<?php
/**
 * mod_jvnewsletter - JV NEWSLETTER
 * @version        1.0
 * ------------------------------------------------------------------------
 * author    PHPKungfu Solutions Co
 * copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 * Websites: http://www.phpkungfu.club
 * Technical Support:  http://www.phpkungfu.club/my-tickets.html
 *------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<a class="jvnewsletter-modal popup-modal btn" href="#jvnewsletter-<?php echo ($module->id);?>"><i class="fa fa-envelope-o"></i> <span><?php echo JText::_('TPL_NEWSLETTER');?></span></a>
<div id="jvnewsletter-<?php echo ($module->id);?>" class="mfp-hide jvnewsletter-box jvnewsletter-box-<?php echo ($module->id); ?>">
    <div class="custom<?php echo $moduleclass_sfx ?>">
        <?php
        if ($pretext = $params->get('pretext'))
        {
        ?>
        <div class="jvnewsletter_subscribe_pre_text">
            <span>
                <?php
                 echo $pretext;
                 ?>
             </span>
        </div>
        <?php
         }
         ?>
        <div class="jvnewsletter_subscribe_form">
    <form action="<?php echo JUri::getInstance()->toString();?>" method="post">
        <?php if(!$params->get('email_validate')){
            ?>
            <div class="control-group">
            <?php
                 if ($params->get('show_label'))
                 {
             ?>
            <label class="lbinput" for="email-<?php echo $module->id; ?>"><?php echo JText::_('TPL_EMAIL');?> *</label> 
            <?php
                 }
             ?>
            <input id="email-<?php echo $module->id; ?>" type="text" placeholder="<?php echo JText::_('TPL_EMAIL_ADDRESS');?>" name="email" class="form-control"/>
            </div>
        <?php
        }else
        {
            ?>
            <div class="control-group">
            <?php
                 if ($params->get('show_label'))
                 {
             ?>
            <label class="lbinput" for="email-<?php echo $module->id; ?>"><?php echo JText::_('TPL_EMAIL');?> *</label>
            <?php
                 }
             ?>
            <input id="email-<?php echo $module->id; ?>" type="email" placeholder="<?php echo JText::_('TPL_EMAIL_ADDRESS');?>" name="email" class="form-control"/>
            </div>
            <?php
        } ?>
        <?php if($params->get('lname')){
            ?>
            <div class="control-group">
            <?php
                 if ($params->get('show_label'))
                 {
             ?>
            <label class="lbinput" for="lname-<?php echo $module->id; ?>"><?php echo JText::_('TPL_LAST_NAME');?></label>
            <?php
                 }
             ?>
            <input id="lname-<?php echo $module->id; ?>" type="text" placeholder="<?php echo JText::_('TPL_LAST_NAME');?>" name="lname" class="form-control"/>
            </div>
        <?php
        } ?>
        <?php if($params->get('fname')){
            ?>
            <div class="control-group">
            <?php
                 if ($params->get('show_label'))
                 {
             ?>
            <label class="lbinput" for="fname-<?php echo $module->id; ?>"><?php echo JText::_('TPL_FIRST_NAME');?></label>
            <?php
                 }
             ?>
            <input id="fname-<?php echo $module->id; ?>" type="text" placeholder="<?php echo JText::_('TPL_FIRST_NAME');?>" name="fname" class="form-control"/>
            </div>
        <?php
        } ?>
        <?php if($params->get('chose_list')){            
            $listsr = (isset($params->get('api')->list)? (array)($params->get('api')->list) : array());
            foreach($listsr as $k=>$v){
            ?>
                <div class="control-group checkbox">
                    
                    <label class="control-label" for="list-<?php echo $k; ?>"><input type="checkbox" checked="checked" id="list-<?php echo $k; ?>" name="lists[]" value="<?php echo $k; ?>"/> <?php echo $v ?></label>
                </div>
        <?php
            }
        }
        if (!isset($params->get('api')->list) || empty($params->get('api')->list)){
            ?>
            <div class="control-group">
                <?php echo JText::_('TPL_CHECK_API_KEY');?>
            </div>
            <?php
        } ?>
        <?php
             if (!empty($message)){
         ?>
        <div class="control-group">
            <?php echo implode($message); ?>
        </div>
        <?php
             }
         ?>
        <input type="submit" class="btn button btn-primary btn-block" value="<?php echo JText::_('TPL_NEWSLETTER_SUBCRIBE');?>" name="subcribe-<?php echo $module->id; ?>">
    </form>
    </div>
    </div>
    <?php if ($params->get('show_dialog')/* && _JV_VERSION_EXEC*/) { ?>
    <div id="jvnewslatter_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="jvnewslatter_modal_label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h3 id="jvnewslatter_modal_label"><?php echo $params->get('title_dialog'); ?></h3>
                </div>
                <div class="modal-body">
                  <?php
                       echo (str_replace("[OUTPUT]", (empty($htmlrs) ? "" : implode($htmlrs)), $params->get('msg_dialog')));
                   ?>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>