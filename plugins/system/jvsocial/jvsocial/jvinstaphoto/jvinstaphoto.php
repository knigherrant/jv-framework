<?php
class JVInstaphoto {
    public $params;
    public $userparams;
    function __construct($params, $userparams){
        $this->params = $params;
        $this->userparams = $userparams;
    }

    public function getHTML(){
        JPlugin::loadLanguage( 'plg_community_jvinstaphoto', JPATH_ADMINISTRATOR );
        $uri		= JURI::base();
        $document	= JFactory::getDocument();
        $document->addStyleSheet($uri.'plugins/community/jvinstaphoto/jvinstaphoto/style.css');
        $document->addScript($uri.'plugins/community/jvinstaphoto/assets/js/instafeed.min.js');
        switch($this->userparams->get('get', 'popular')){
            case 'tagged': $getParams = "tagName: '".$this->userparams->get('tagName', '')."', "; break;
            case 'location': $getParams = "locationId: '".$this->userparams->get('locationId', '')."', "; break;
            case 'user': $getParams = "userId: ".intval($this->userparams->get('userId', '')).", accessToken: '".$this->params->get('accesstoken', '')."', "; break;
            default: $getParams = '';break;
        }
        $script = "
                    joms.jQuery(function($){
                        var jvinstaphoto = new Instafeed({
                            target: 'jvinstaphoto',
                            get: '".$this->userparams->get('get', 'popular')."', ".$getParams."
                            clientId: '".$this->params->get('clientid')."',
                            template: '<a href=\"{{link}}\" target=\"_blank\"><img src=\"{{image}}\" /></a>',
                            sortBy: '".$this->userparams->get('sortBy', 'most-recent')."',
                            limit: ".intval($this->userparams->get('limit', '10')).",
                            resolution: '".$this->userparams->get('resolution', 'thumbnail')."',
                            after: function(e){
                                $('#jvinstaphoto_loading').hide();
                            },
                            error: function(e){
                                $('#jvinstaphoto_loading').hide();
                                $('#jvinstaphoto').text(e);
                            }
                        });
                        jvinstaphoto.run();
                    });
                ";
        $document->addScriptDeclaration($script);
        $document->addStyleDeclaration('#jvinstaphoto a{width: '.$this->userparams->get('thumbSize', '48%').'}');
        $content = '<div id="jvinstaphoto_loading"><img src="'.JUri::root().'plugins/community/jvinstaphoto/assets/images/loading_transparent.gif'.'" alt=""/></div><div id="jvinstaphoto"></div>';
        return $content;
    }
}