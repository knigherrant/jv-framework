<?php
$user = JFactory::getUser();
$icon = JUri::root() . '/plugins/system/jvsocial/assets/images/';

if(!$user->id){ ?>
    <script type="text/javascript">
            jQuery(function($){
                    var currentUrl = '<?php echo JURI::getInstance()->toString(); ?>';
                    $('.jvLoginFacebook, .jvLoginTwitter, .jvLoginGoogle').click(function(){
                        var  $auth_window = window.open($(this).attr('data'), "ServiceAssociate", 'width=900,height=700'),
                            auth_poll = null;
                            auth_poll = setInterval(function() {
                            if ($auth_window.closed) {
                                clearInterval(auth_poll);
                                window.location.href= currentUrl;
                            }
                        }, 100);
                    })
            });
    </script> 
    <?php if(isset($jvLink['fb'])){ ?>
        <a class="jvLoginFacebook" href="javascript:void(0)" data="<?php echo $jvLink['fb']; ?>" >
            <img alt="" src="<?php echo $icon . 'sign-facebook.png'; ?>" />
        </a>
    <?php } ?>
    <?php if(isset($jvLink['tw'])){ ?>
        <a class="jvLoginTwitter" href="javascript:void(0)" data="<?php echo $jvLink['tw']; ?>" >
            <img alt="" src="<?php echo $icon . 'sign-twitter.png'; ?>" />
        </a>
    <?php } ?>
    <?php if(isset($jvLink['google'])){ ?>
        <a class="jvLoginGoogle" href="javascript:void(0)" data="<?php echo $jvLink['google']; ?>" >
            <img alt="" src="<?php echo $icon . 'sign-google.png'; ?>" />
        </a>
    <?php } ?>
<?php } ?>    