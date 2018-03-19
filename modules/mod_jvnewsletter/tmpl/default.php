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
<style type="text/css">
.jvnewsletter-box{
    
}
</style>
<div class="jvnewsletter-box jvnewsletter-box-<?php echo ($module->id); ?>">
    <div class="jvnewsletter_subscribe custom<?php echo $moduleclass_sfx ?>">
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
            <label class="lbinput" for="email-<?php echo $module->id; ?>">Email *</label>
            <?php
                 }
             ?>
            <input id="email-<?php echo $module->id; ?>" type="text" placeholder="Email" name="email"/>
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
            <label class="lbinput" for="email-<?php echo $module->id; ?>">Email *</label>
            <?php
                 }
             ?>
            <input id="email-<?php echo $module->id; ?>" type="email" placeholder="Email" name="email"/>
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
            <label class="lbinput" for="lname-<?php echo $module->id; ?>">Last Name</label>
            <?php
                 }
             ?>
            <input id="lname-<?php echo $module->id; ?>" type="text" placeholder="Last Name" name="lname"/>
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
            <label class="lbinput" for="fname-<?php echo $module->id; ?>">First Name</label>
            <?php
                 }
             ?>
            <input id="fname-<?php echo $module->id; ?>" type="text" placeholder="First Name" name="fname"/>
            </div>
        <?php
        } ?>
        <?php if($params->get('chose_list')){            
            $listsr = (isset($params->get('api')->list)? (array)($params->get('api')->list) : array());
            foreach($listsr as $k=>$v){
            ?>
                <div class="control-group checkbox">
                    <input type="checkbox" checked="checked" id="list-<?php echo $k; ?>" name="lists[]" value="<?php echo $k; ?>"/>
                    <label class="control-label" for="list-<?php echo $k; ?>"><?php echo $v ?></label>
                </div>
        <?php
            }
        }
        if (!isset($params->get('api')->list) || empty($params->get('api')->list)){
            ?>
            <div class="control-group">
                <?php echo "Please check your API key or chose list to subcribe from admin manager!"; ?>
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
        <input type="submit" class="btn button" value="Subscibe" name="subcribe-<?php echo $module->id; ?>">
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