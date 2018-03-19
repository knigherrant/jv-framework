<?php
/*
 # Module       JV Contact
 # @version     3.0.1
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright © 2008-2012 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
    <div class="contact-page <?php echo $myparams['moduleclass_sfx'] ?>">
        <?php if ($params->get('showmap')) {?>
            <div>
                <?php echo $myparams['map'];?>
            </div>
        <?php }?>
        <?php echo @$myparams['captcha'][1];?>
        <?php if($myparams['textheader'] || $myparams['moreinfo']){?>
        <div class="text-center mt-40 mb-50">
            <?php if($myparams['textheader']){?>
            <h2 class="text-white"><?php echo $myparams['textheader'];?></h2>
             <?php }?>

            <?php if($myparams['moreinfo']){?>
                <p><?php echo $myparams['moreinfo'];?></p>
            <?php }?>
        </div>
        <?php }?>
        <?php if($params->get('showsocial') != 0 || $params->get('showform') != 0 ){ ?>
        <div class="contact-form ">
            <?php if($params->get('showsocial') != 0){
                echo '<div class="mb-50">'.$myparams['social'].'</div>';
            }?>
            <?php if($params->get('showform') != 0){ ?>
             <form id="jvcontact<?php echo $moduleid;?>" action="<?php echo JUri::getInstance()->toString();?>" method="post" class="form-type form-11">
                <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-30">
                                <?php $i = 1; ?>
                                <?php if($fields) foreach($fields as $key => $field){ ?>
                                    <?php if ( $i < 3) { ?>
                                    <?php echo $field['input'];?>
                            </div>
                            <?php if ($i < count($fields) ) { ?>
                            <div class="form-group mb-30">       
                            <?php  } ?> 
                                    <?php  }  $i++ ; ?>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group mb-30">
                                <?php $i = 1; ?>
                                <?php if($fields) foreach($fields as $key => $field){ ?>
                                    <?php if ( $i > 2 && $i < 5) { ?>
                                    <?php echo $field['input'];?>
                                    </div>
                                        <?php if ($i < count($fields) ) { ?>
                                        <div class="form-group mb-30">       
                                        <?php  } ?>
                                    <?php  }  $i++ ; ?>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group mb-30">
                                <?php $i = 1; ?>
                                <?php if($fields) foreach($fields as $key => $field){ ?>
                                    <?php if ( $i > 4) { ?>
                                    <?php echo $field['input'];?>
                                        <?php if ($i < count($fields) ) { ?>
                                        </div>
                                        <div class="form-group mb-30">       
                                        <?php  } ?>
                                    <?php  }  $i++ ; ?>
                                <?php } ?>
                            </div>
                            <?php if($myparams['captcha']){?>
                                <div class="form-group mb-30">
                                    <?php echo $myparams['captcha'][0];?>
                                </div>
                            <?php }?>
                            
                            <?php if($myparams['mailcopy']){?>
                            <div class="mailcopy form-group mb-30">
                                <span style="float:left;width:100%">
                                    <input name="cbcopymail" type="checkbox" value=1 />
                                    <label for="cbcopymail"><?php echo $myparams['mailcopy'];?></label>
                                </span>
                            </div>
                            <?php }?>
                        </div>
                </div>
                <div class="form-group mb-0">
                    <a href="javascript:void(0);" class="btn btn-sm btn-darker pl-40 pr-40" onclick="formsubmit('jvcontact<?php echo $moduleid;?>');"><span class="text-normal"><?php echo $myparams['textsubmit'];?></span></a>
                </div>
                <?php }?>
                <div class="msgsendmailok" id="<?php echo $divmsgid?>">
                    <?php
                    if($msgthankyou && @$post['jvcontact'][$moduleid]){
                        echo '<div class="msgthankyou">'.$msgthankyou.'</div>';
                    }
                    ?>
                </div>
                <div class="msgfooter"><?php echo $myparams['textfooter'];?></div>
                <?php echo JHTML::_('form.token');?>
            </form>
        </div>
        <?php }?>
        <!-- end contact-form -->
    </div>
<!-- design -->