<?php
class JVSoundclound {
    public $userparams;
    function __construct($userparams){
        $this->userparams = $userparams;
    }

    public function getHTML(){
        JPlugin::loadLanguage( 'plg_community_jvsoundcloud', JPATH_ADMINISTRATOR );
        $document	= JFactory::getDocument();
        $document->addStyleSheet(JURI::base()	.'plugins/community/jvsoundcloud/jvsoundcloud/style.css');

        $content = '<iframe width="'.$this->userparams->get('soundclound_width',100).'%" height="'.$this->userparams->get('soundclound_height',170).'" scrolling="no" frameborder="no" src="http://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2F'.$this->userparams->get('soundclound_type','tracks').'%2F'.$this->userparams->get('soundclound_id','106881113').'&amp;auto_play='.$this->userparams->get('soundclound_autoplay',true).'&amp;show_artwork='.$this->userparams->get('soundclound_art',true).'&amp;color='.$this->userparams->get('soundclound_color','30b3db').'"></iframe>';
        return $content;
    }
}