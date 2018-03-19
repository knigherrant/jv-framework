<?php
class JVEmailconnect {
    public $userparams;
    function __construct($userparams){
        $this->userparams = $userparams;
    }

    public function getHTML(){
        JPlugin::loadLanguage( 'plg_community_jvemailconnect', JPATH_ADMINISTRATOR );

        $uri		= JURI::base();
        $document = JFactory::getDocument();
        $document->addStyleSheet($uri	.'plugins/community/jvemailconnect/jvemailconnect/style.css');

        if($this->userparams->get('username','') && $this->userparams->get('password','') && $this->userparams->get('host','')){
            //if(empty($_SESSION['user_id']) || $_SESSION['username'] != $this->userparams->get('username','')){
            $document->addScriptDeclaration('
                joms.jQuery(function($){
                    $.ajax({
                        url: "'.JUri::root().'plugins/community/jvemailconnect/roundcubemail/",
                        type: "post",
                        dataType: "json",
                        data:{
                            _user: "'.$this->userparams->get('username','').'",
                            _pass: "'.$this->userparams->get('password','').'",
                            _host: "'.$this->userparams->get('host','').'",
                            _task: "login",
                            _action: "login",
                            is_ajax_login: 1
                        },
                        success: function(data){
                            if(data.rs){
                                $("#jvemailconnect").html($("<iframe/>",{src: "'.JUri::root().'plugins/community/jvemailconnect/roundcubemail/", width: "100%", frameborder:"no", height: "'.$this->userparams->get('height','500').'"}));
                            }
                            else $("#jvemailconnect").text(data.msg);
                        }
                    });
                });
            ');
            $content = '<div id="jvemailconnect"><img src="'.JUri::root().'plugins/community/jvemailconnect/assets/images/loading_transparent.gif'.'" alt=""/></div>';
            /*}else{
                $content = '<div id="jvemailconnect"></div>';
            }*/
        }else{
            $content = 'Please complete your configs email connect!';
        }
        return $content;
    }
}