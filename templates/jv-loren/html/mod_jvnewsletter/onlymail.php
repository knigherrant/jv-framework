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
<div class="jvnewsletter-box jvnewsletter-box-<?php echo ($module->id); ?>">
    <div class="custom<?php echo $moduleclass_sfx ?>">
        <?php
        if ($pretext = $params->get('pretext'))
        {
        ?>
        <div class="jvnewsletter_subscribe_pre_text" data-title="<?php echo $module->title; ?>">
              <?php
               echo $pretext;
               ?>
        </div>
        <?php
         }
         ?>
        <div class="jvnewsletter_subscribe_form">
      <form action="<?php echo JUri::getInstance()->toString();?>" method="post">        
        <div class="input-group">
          <?php if(!$params->get('email_validate')){
            ?>
                <input id="email-<?php echo $module->id; ?>" type="text" placeholder="<?php echo JText::_('TPL_EMAIL_ADDRESS');?>" name="email" class="form-control input-sm"/>
            <?php
            }else
            {
                ?>
                <input id="email-<?php echo $module->id; ?>" type="email" placeholder="<?php echo JText::_('TPL_EMAIL_ADDRESS');?>" name="email" class="form-control input-sm"/>
                <?php
            } ?>
              <span class="input-group-btn">
                <input type="submit" class="btn button btn-primary btn-sm" value="<?php echo JText::_('TPL_NEWSLETTER_SUBSCRIBE');?>" name="subcribe-<?php echo $module->id; ?>">
              </span>
        </div><!-- /input-group -->
        <?php if (!isset($params->get('api')->list) || empty($params->get('api')->list)){
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
        
    </form>
    </div>
    </div>
    <?php
if ($params->get('show_dialog')/* && _JV_VERSION_EXEC*/)
{              
?>
    <div id="jvnewslatter_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="jvnewslatter_modal_label" aria-hidden="true" style="display: none;">
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
<?php
}
 ?>
</div>