<?php
/*
 # mod_jvtwitter - JV Twitter
 # @version		3.0
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
if(version_compare(JVERSION,'3.0')<0  && $params->get('jquery','1')){
    $document->addScript(JURI::root().'modules/mod_jvtwitter/assets/js/jquery.min.js');
}else{
    JHtml::_('Jquery.framework');
}

$document->addScript(JURI::base(true).'/modules/mod_jvtwitter/assets/js/jquery.noconflict.js');
$document->addScript(JURI::base(true).'/modules/mod_jvtwitter/assets/js/knockout-2.2.1.js');
$document->addScript(JURI::base(true).'/modules/mod_jvtwitter/assets/js/moment.js');
$document->addScript(JURI::base(true).'/modules/mod_jvtwitter/assets/js/twitter.ajax.js');
$document->addStyleSheet(JURI::base(true).'/modules/mod_jvtwitter/assets/css/bootstrap-twitter.css');
$document->addStyleSheet(JURI::base(true).'/modules/mod_jvtwitter/assets/css/jvtwitter.css');
//Build style
$css = array();
$css[] = modJVTwitterHelper::buildCss(
    "#jvTwitter{$module->id} .jvTwitterProfile,
    #jvTwitter{$module->id} .jvTwitterTweets,
    #jvTwitter{$module->id} .jvTwitterLoading,
    #jvTwitter{$module->id} .jvTwitterMessage",
    array(
        'color' => $params->get('fontcolor'),
        'background-color' => $params->get('bgcolor'),
        'border-color' => $params->get('bordercolor')
    )
);
$css[] = modJVTwitterHelper::buildCss(
    "#jvTwitter{$module->id} .jvTwitterTweets .media",
    array(
        'color' => $params->get('tweet_fontcolor'),
        'background-color' => $params->get('tweet_bgcolor'),
        'border-color' => $params->get('tweet_bordercolor')
    )
);
$css[] = modJVTwitterHelper::buildCss(
    "#jvTwitter{$module->id} .jvTwitterTweets .media:hover",
    array(
        'background-color' => $params->get('tweet_hover_bgcolor'),
        'border-color' => $params->get('tweet_hover_shadowcolor')
    )
);
$css[] = modJVTwitterHelper::buildCss("#jvTwitter{$module->id} .jvTwitterTweetContainer", array('max-height' => $params->get('tweet_height').'px'));
$document->addStyleDeclaration(implode($css));
?>

<div class="jvTwitter<?php echo $params->get('moduleclass_sfx'); ?>" id="jvTwitter<?php echo $module->id;?>">
    <div class="jvTwitterProfile thumbnail well well-small" data-bind="visible: showProfile" style="display: none">
        <div class="media">
            <a class="pull-left" target="_blank" data-bind="visible: params().profile_avatar == 1, attr:{href: profile().url}">
                <img class="media-object" src="#" data-bind="attr:{src: profile().avatar}" alt=""/>
            </a>
            <div class="media-body" data-bind="visible: params().profile_name == 1 || params().profile_username == 1">
                <div data-bind="visible: params().profile_name == 1">
                    <a target="_blank" data-bind="text: profile().name, attr:{href: profile().url}"></a>
                </div>
                <div data-bind="text: profile().screen_name, visible: params().profile_username == 1"></div>
            </div>
        </div>

        <div class="caption" data-bind="visible: showProfileInfo">
            <p data-bind="visible: showProfileLocation">
                <span class="jvTwitterLabel"><?php echo JText::_('MOD_JVTWITTER_LOCATION');?></span>
                <span data-bind="html: profile().location"></span>
            </p>
            <p data-bind="visible: showProfileBio">
                <span class="jvTwitterLabel"><?php echo JText::_('MOD_JVTWITTER_BIO');?></span>
                <span data-bind="html: profile().bio"></span>
            </p>
            <p data-bind="visible: showProfileWeb">
                <span class="jvTwitterLabel"><?php echo JText::_('MOD_JVTWITTER_WEB');?></span>
                <span data-bind="html: profile().web"></span>
            </p>
            <p class="jvTwitterProfileMore" data-bind="visible: showProfileMore">
                <span class="jvTwitter50" data-bind="visible: params().profile_tweets == 1">
                    <span class="jvTwitterLabel"><?php echo JText::_('MOD_JVTWITTER_TWEETS');?></span>
                    <span data-bind="text: profile().tweets"></span>
                </span>
                <span class="jvTwitter50" data-bind="visible: params().profile_following == 1">
                    <span class="jvTwitterLabel"><?php echo JText::_('MOD_JVTWITTER_FOLLOWING');?></span>
                    <span data-bind="text: profile().following"></span>
                </span>
                <span class="jvTwitter50" data-bind="visible: params().profile_followers == 1">
                    <span class="jvTwitterLabel"><?php echo JText::_('MOD_JVTWITTER_FOLLOWERS');?></span>
                    <span data-bind="text: profile().followers"></span>
                </span>
                <span class="jvTwitter50" data-bind="visible: params().profile_listed == 1">
                    <span class="jvTwitterLabel"><?php echo JText::_('MOD_JVTWITTER_LISTED');?></span>
                    <span data-bind="text: profile().listed"></span>
                </span>
            </p>
            <p class="jvTwitterProfileFollow" data-bind="visible: showProfileShareButton">
                <a href="https://twitter.com/share" class="twitter-share-button" data-via="<?php echo $screen_name;?>"><?php echo JText::_('MOD_JVTWITTER_TWEET')?></a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </p>
            <p class="jvTwitterProfileFollow" data-bind="visible: showProfileFollowButton">
                <a href="https://twitter.com/<?php echo $screen_name;?>" class="twitter-follow-button" data-show-count="true"><?php echo JText::_('MOD_JVTWITTER_FOLLOW').' '.$screen_name;?></a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </p>
            <p class="jvTwitterProfileFollow" data-bind="visible: showProfileHashtagButton">
                <a href="https://twitter.com/intent/tweet?button_hashtag=<?php echo $screen_name;?>" class="twitter-hashtag-button" data-related="<?php echo $screen_name;?>"><?php echo JText::_('MOD_JVTWITTER_TWEET')?> #<?php echo $screen_name;?></a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </p>
            <p class="jvTwitterProfileFollow" data-bind="visible: showProfileMentionButton">
                <a href="https://twitter.com/intent/tweet?screen_name=<?php echo $screen_name;?>" class="twitter-mention-button" data-related="<?php echo $screen_name;?>"><?php echo JText::_('MOD_JVTWITTER_TWEET_TO')?> @<?php echo $screen_name;?></a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </p>
        </div>
    </div>
    <div class="jvTwitterTweets latest-tweets" data-bind="visible: showTweet" style="display: none">
        <div class="jvTwitterTweetContainer " data-bind="foreach: tweets">
            <div class="jvTwitterTweetItem">
                
                <div class="media-body">
                    <a class="jvTweetAvatar" target="_blank" data-bind="visible: $root.params().tweet_avatar == 1, attr:{href: url}">
                        <img class="media-object" src="#" data-bind="attr:{src: avatar}" alt=""/>
                    </a>
                    <div class="jvTweetDetail">
                        <h4 class="media-heading" >
                            <span class="jvTwitterRetweeted" data-bind="if: retweeted, visible: retweeted"><?php echo JText::_('MOD_JVTWITTER_TWEET_RETWEETED')?></span><span data-bind="if: retweeted, visible: retweeted">&nbsp;</span>
                            <a target="_blank" data-bind="text: name, visible: $root.params().tweet_name == 1, attr:{href: url}"></a>
                            <span data-bind="text: screen_name, visible: $root.params().tweet_username == 1"></span>
                        </h4>
                        <div class="jvTweetText" data-bind="html: text, visible: $root.params().tweet_text == 1"></div>
                        <div class="jvTweetCreated" data-bind="visible: $root.params().tweet_created == 1 || $root.params().tweet_via == 1">
                            <span class="jvTweetCreatedTime" data-bind="html: created, visible: $root.params().tweet_created == 1"></span>
                            <span class="jvTweetCreatedAt" data-bind="visible: $root.params().tweet_via == 1">
                                <span><?php echo JText::_('MOD_JVTWITTER_VIA');?></span>
                                <span data-bind="html: via"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="jvTwitterLoading" data-bind="visible: showLoading" style="display: none">
        <img src="<?php echo JURI::base(true).'/modules/mod_jvtwitter/assets/images/loading.png';?>" width="35" height="35" alt=""/>
    </div>
    <div class="jvTwitterMessage" data-bind="visible: showMessage, text: message" style="display: none"></div>
</div>

<script type="text/javascript">
    (function($){
        $(function(){
            $('#jvTwitter<?php echo $module->id;?>').JVTwitter({
                autoRefresh: <?php echo (int)$params->get('refresh'); ?>,
                refreshTime: <?php echo (int)$params->get('refresh_time')*1000; ?>,
                requestURL: '<?php echo JURI::base(true).'/modules/mod_jvtwitter/jvtwitter.php?id='.$module->id;?>',
                slideTweet: <?php echo (int)$params->get('tweet_slide'); ?>
            });
        });
    })($JVTwitter)
</script>


