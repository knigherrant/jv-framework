<?php
/**
 * mod_jvnewsletter - JV NEWSLETTER
 * @version        1.0
 * ------------------------------------------------------------------------
 * author    Open Source Code Solutions Co
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
        <?php if ($pretext = $params->get('pretext')) { ?>
        <div class="jvnewsletter_subscribe_pre_text">
            <span>
                <?php echo $pretext; ?>
             </span>
        </div>
        <?php }?>
        <div class="jvnewsletter_subscribe_form">
          <form action="<?php echo JUri::getInstance()->toString();?>" method="post" id="form<?php echo ($module->id); ?>">
              <div class="input-group" data-text="<?php echo JText::_('TPL_NEWSLETTER');?>:">
                <?php if(!$params->get('email_validate')){ ?>
                      <input id="email-<?php echo $module->id; ?>" type="text" placeholder="<?php echo JText::_('TPL_EMAIL_ADDRESS');?>" name="email" class="form-control"/>
                  <?php } else {?>
                      <input id="email-<?php echo $module->id; ?>" type="email" placeholder="<?php echo JText::_('TPL_EMAIL_ADDRESS');?>" name="email" class="form-control"/>
                  <?php } ?>
                    <span class="input-group-btn">
                      <button type="submit" name="subcribe-<?php echo $module->id; ?>" form="form<?php echo ($module->id); ?>" value="<?php echo JText::_('TPL_NEWSLETTER_DONE');?>" data-text="<?php echo JText::_('TPL_NEWSLETTER_SUBCRIBE');?>" class="btn btn-primary"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
                    </span>
              </div><!-- /input-group -->
              <?php if (!isset($params->get('api')->list) || empty($params->get('api')->list)){ ?>
                  <div class="mt-5">
                      <?php echo JText::_('TPL_CHECK_API_KEY');?>
                  </div>
              <?php } ?>
              <?php if (!empty($message)){ ?>
              <div class="mt-5">
                  <?php echo implode($message); ?>
              </div>
              <?php } ?>              
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