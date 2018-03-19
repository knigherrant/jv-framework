<?php
/*------------------------------------------------------------------------
# plg_linked - linked for Joomla 2.5/3.x and Jomsocial 2.8/3.x
# ------------------------------------------------------------------------
# version 2.0.0
# author joomlavi
# copyright (C) 2013 www.joomlavi.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomlavi.com
# Technical Support: Forum - http://joomlavi.com
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class PlgSystemJVSocial extends JPlugin{
    
   public function __construct(&$subject, $config){
        parent::__construct($subject, $config);
        $this->input = JFactory::getApplication()->input;
    }
    
    public function onBeforeRender(){
        $plugin = $this->input->getString('plugin');
        if($plugin=='jvsocial'){
            $task = $this->input->getString('task');
            JVSocial::$task ();
        }
        if($this->input->getString('code') && $this->input->getString('state')) JVSocial::fbLogin();
    }
    
    public function onAfterRender() {
        $app = JFactory::getApplication();
        if ($app->getName() != 'site')
        {
                return true;
        }
        $buffer = $app->getBody();
        $regexfb     = '#\[fbLogin\]#m';
        if(preg_match($regexfb, $buffer)){
            $fbLogin = JVSocial::getButtonLogin(array('fb'));
            $buffer    = preg_replace($regexfb, $fbLogin, $buffer);
        }
        $regextw     = '#\[twLogin\]#m';
        if(preg_match($regexfb, $buffer)){
            $twLogin = JVSocial::getButtonLogin(array('tw'));
            $buffer    = preg_replace($regextw, $twLogin, $buffer);
        }
        $regexg     = '#\[googleLogin\]#m';
        if(preg_match($regexg, $buffer)){
            $googleLogin = JVSocial::getButtonLogin(array('google'));
            $buffer    = preg_replace($regexg, $googleLogin, $buffer);
        }
        $regex     = '#\[jvSocialLogin\]#m';
        if(preg_match($regex, $buffer)){
            $jvLogin = JVSocial::getButtonLogin();
            $buffer    = preg_replace($regex, $jvLogin, $buffer);
        }
        $app->setBody($buffer);
        return true;
    }
}

class JVSocial{
    
    static $config = null;
    static $facebook = null;
    static $twitter = null;
    static $youtube =array();
    static $import = array();
    static $google = array();
    static $amazone = array();
    static $ebay = array();
    static $jvinstaphoto = array();
    static $jvsoundcloud = array();
    static $jvemailconnect = array();
    static $return = array(
        'fb' => 'index.php?plugin=jvsocial&task=fbLogin',
        'tw' =>  'index.php?plugin=jvsocial&task=twLogin',
        'google' =>  'index.php?plugin=jvsocial&task=googleLogin',
        'youtube' =>  'index.php?plugin=jvsocial&task=youtubeLogin',
    );
     static $linkLogin = array();
    
    public static function getConfig(){
        if(!isset(self::$config)){
            $plugin = JPluginHelper::getPlugin('system', 'jvsocial');
            self::$config = new JRegistry($plugin->params);
        }
        return self::$config;
    }
    
    public static function import($key, $path = null){
        if(empty(self::$import[$key])){
            $loaded = false;
            $path = (!empty($path))? $path : dirname(__FILE__) . DIRECTORY_SEPARATOR ;
            $key = str_replace('.', DIRECTORY_SEPARATOR, $key);
            $file = $path . $key . '.php'; 
            if(is_file($file)) $loaded = (bool) require_once ($file);
            self::$import[$key] = $loaded;
        }
    }
    
    public static function input(){
        return JFactory::getApplication()->input;
    }
    
    public static function fbLogin(){
        $fb = self::fb();
        $helper = $fb->getRedirectLoginHelper(); 
        $helper = $fb->getRedirectLoginHelper();  
        try {  
            $accessToken = $helper->getAccessToken();  
        } catch(Facebook\Exceptions\FacebookResponseException $e) {  
            // When Graph returns an error  
            echo 'Graph returned an error: ' . $e->getMessage();  
            self::jExit();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {  
            // When validation fails or other local issues  
            echo 'Facebook SDK returned an error: ' . $e->getMessage();  
            self::jExit();
        }  
        if(!$accessToken) self::jExit ();
        $fields = array( 'id', 'name', 'first_name', 'last_name', 'link', 'website',  'gender', 'locale', 'about', 'email', 'hometown', 'location' );
        $response = $fb->get('/me?fields=' . implode(',', $fields), $accessToken->getValue());
        $fUser = $response->getGraphUser();
        $password = JUserHelper::genRandomPassword(6);
        $data = array(
            "name"=> $fUser->getName(),
            "username"=>$fUser->getEmail(),
            "password"=>$password,
            "password2"=>$password,
            "email"=>$fUser->getEmail(),
        );
        self::saveUser($data);
        self::jExit();
    }
    
    public static function twLogin(){
        $session = JFactory::getSession();
        $token = $session->get('oauth_token');
        $tokensec = $session->get('oauth_token_secret');
        $verifier = self::input()->get('oauth_verifier');
        $connection =self::twitter($token,$tokensec);
        $access_token = $connection->getAccessToken($verifier); //require
        $user = $connection->get('account/verify_credentials');
        $email = $user->name . '@gmail.com';
        $data = array();
        $password = JUserHelper::genRandomPassword(6);
        $data = array(
            "name"=> $user->screen_name,
            "username"=>$email,
            "password"=>$password,
            "password2"=>$password,
            "email"=>$email,
        );
        self::saveUser($data);
        self::jExit();
    }
    
    public static function youTubeLogin(){
        $youube = self::youTube();
        $youube['google']->authenticate(self::input()->getString('code'));
        $data = array();
        $data['userid'] = JFactory::getUser()->id;
        $data['ytid'] = JRequest::getVar('code');
        $data['yttoken'] = $youube['google']->getAccessToken();
    }
    
    
    
    public static function googleLogin(){
        $google = self::google();
        $google['google']->authenticate();
        $user = $google['plugs']->userinfo->get();
        $data = array();
        $password = JUserHelper::genRandomPassword(6);
        $data = array(
            "name"=> $user['name'],
            "username"=>$user['email'],
            "password"=>$password,
            "password2"=>$password,
            "email"=>$user['email'],
        );
        self::saveUser($data);
        self::jExit();
    }
    
    public static function saveUser($data){
        if(JFactory::getUser()->id) return false;
        $db = JFactory::getDbo();
        $user = $db->setQuery("SELECT * FROM #__users WHERE email='".$data['email']."' OR username='".$data['email']."'")->loadObject();
        $credentials = array();
        $password = $data['password'];
        if(isset($user->id)){
            $passwordupdate = md5($password);
            $db->setQuery("UPDATE #__users SET password = '$passwordupdate' WHERE email='$user->email' or username='$user->email'");
            if($db->query()){
                    $credentials['username'] = $user->username;
                    $credentials['password'] = $password;
            }
        }else{
            jimport('joomla.application.component.helper');
            $config	= JComponentHelper::getParams('com_users');
            $data['groups'] = array($config->get('new_usertype', 2));
            $user = new JUser();
            if(!$user->bind($data)) {
                    throw new Exception("Could not bind data. Error: " . $user->getError());
            }
            if (!$user->save()) {
                    throw new Exception("Could not save user. Error: " . $user->getError());
            }
            $credentials['username'] = $data['username'];
            $credentials['password'] = $password;
        }
        if($credentials) self::login($credentials);
    }

    public static function login($credentials){
        $app = JFactory::getApplication();
        $options = array();
        $options['remember']	= true;
        $options['silent']	= true;
        if($app->login($credentials,$options)){
            //$app->redirect(JRoute::_($url,false));
        }
    }
        
    
    
   
    public static function jExit(){
        ?><script>window.close()</script><?php
    }
    
    /********************************* GET LIBRARY ***************************************/
    
    public static function fb($token = null) {
        if (! self::$facebook) {
                self::import('jvsocial.Facebook.autoload');
                $config = self::getConfig();
                self::$facebook = new Facebook\Facebook([
                    'app_id' => $config->get('fbapi'),
                    'app_secret' => $config->get('fbsecret'),
                    'default_graph_version' => 'v2.4',
                  ]);
                if($token){
                    self::$facebook->setDefaultAccessToken ( $token );
                }else if (!empty($user->facebook_token)) {
                    self::$facebook->setDefaultAccessToken ( $user->facebook_token );
                }
        }
        return self::$facebook;
    }

    
    public static function google(){
        if (empty(self::$google)) {
            $config = self::getConfig();
            self::import('jvsocial.google.Google_Client');
            self::import('jvsocial.google.contrib.Google_Oauth2Service');
            self::import('jvsocial.google.contrib.Google_PlusService');
            self::$google['google'] = new Google_Client(array(
                'oauth2_client_id' => $config->get('clientId'), 
                'oauth2_client_secret' => $config->get('clientSecret'),
                'oauth2_redirect_uri' => JURI::root() . self::$return['google']
            ));
            self::$google['google']->setScopes(array(
                'https://www.googleapis.com/auth/userinfo.profile',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/plus.login',
                'https://www.googleapis.com/auth/plus.me'
            ));
            self::$google['google']->setRequestVisibleActions(array(
                'http://schemas.google.com/AddActivity',
                'http://schemas.google.com/ReviewActivity'
            ));
            self::$google['service'] = new Google_PlusService(self::$google['google']);
            self::$google['plugs'] = new Google_Oauth2Service(self::$google['google']);
            
        }
        return self::$google;
    }
    
    
    public static function youTube(){
        if (empty(self::$youtube)) {
            $config = self::getConfig();
            self::import('jvsocial.google.Google_Client');
            self::import('jvsocial.google.contrib.Google_YouTubeService');
            self::$youtube['google'] = new Google_Client(array(
                'oauth2_client_id' => $config->get('clientId'), 
                'oauth2_client_secret' => $config->get('clientSecret'),
                'oauth2_redirect_uri' => JUri::root() .  self::$return['youtube']
            ));
            self::$youtube['google']->setScopes(array(
                'https://www.googleapis.com/auth/youtube'
            ));
            self::$youtube['youtube'] = new Google_YouTubeService(self::$youtube['google']);
        }
        return self::$youtube;
    }
    
    
    
    static function twitter($oauth_token = null, $oauth_token_secret=null){
        if(!self::$twitter){
            $config = self::getConfig();
            self::import('jvsocial.twitter.twitteroauth');
            self::$twitter = new TwitterOAuth($config->get('twapi'), $config->get('twsecret'), $oauth_token, $oauth_token_secret);
        }
        return self::$twitter;
    }

    static function amazone($params){
        self::import('jvsocial.amazone.jvamazone');
        self::$amazone = new JVAmazone($params);
        return self::$amazone;
    }

    static function ebay($params){
        if(!self::$ebay){
            self::import('jvsocial.ebay.jvebay');
            self::$ebay = new JVEbay($params);
        }
        return self::$ebay;
    }

    static function jvinstaphoto($params, $userparams){
        self::import('jvsocial.jvinstaphoto.jvinstaphoto');
        self::$jvinstaphoto = new JVInstaphoto($params, $userparams);
        return self::$jvinstaphoto;
    }

    static function jvsoundcloud($userparams){
        self::import('jvsocial.jvsoundcloud.jvsoundcloud');
        self::$jvsoundcloud = new JVSoundclound($userparams);
        return self::$jvsoundcloud;
    }

    static function jvemailconnect($userparams){
        self::import('jvsocial.jvemailconnect.jvemailconnect');
        self::$jvemailconnect = new JVEmailconnect($userparams);
        return self::$jvemailconnect;
    }

    static function shareSocial($socialTypes, $type, $data){
        $jUser = JVSocial::loadUser();
        if(in_array('facebook', $socialTypes)){
            if($jUser->fbtoken){
                $facebook = JVSocial::fb($jUser->fbtoken);
                if($type == 'message' || $type == 'video'){
                    $facebook->send('/me/feed', $data);
                }elseif($type == 'photo'){
                    $facebook->send('/me/photos', $data);
                }
            }
        }
        if(in_array('google', $socialTypes)){
            if($jUser->gtoken){
                $google = JVSocial::google();
                $google['google']->setAccessToken($jUser->gtoken);
                if($type == 'message' || $type == 'video'){
                    $moment_body = new Google_Moment();
                    $moment_body->setType("http://schemas.google.com/AddActivity");
                    $item_scope = new Google_ItemScope();
                    $item_scope->setId("target-id-1");
                    $item_scope->setType("http://schemas.google.com/AddActivity");
                    $item_scope->setName("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
                    $item_scope->setDescription("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
                    //$item_scope->setImage("https://developers.google.com/+/plugins/snippet/examples/thing.png");
                    $moment_body->setTarget($item_scope);
                    $momentResult = $google['service']->moments->insert('me', 'vault', $moment_body);
                    print_r($momentResult);die;
                }elseif($type == 'photo'){

                }
            }
        }
    }
    
    
    public static function getLinkLogin($type){
        if(!isset(self::$linkLogin[$type])){
            if('fb' == $type){
                $helper = self::fb()->getRedirectLoginHelper();
                $scope = array('user_photos,user_videos,publish_actions,email,user_birthday,user_location,user_work_history,user_about_me,user_hometown');
                self::$linkLogin[$type] = $helper->getLoginUrl(JURI::root() . self::$return['fb'], $scope);
            }
            if('tw' == $type){
                $session  = JFactory::getSession();
                $request_token = self::twitter()->getRequestToken(JURI::root() . self::$return['tw']);
                /* Save temporary credentials to session. */
                $session->set('oauth_token', $request_token['oauth_token']);
                $session->set('oauth_token_secret', $request_token['oauth_token_secret']);
                switch (self::twitter()->http_code) {
                case 200:
                    /* Build authorize URL and redirect user to Twitter. */
                    self::$linkLogin[$type] = self::twitter()->getAuthorizeURL($request_token['oauth_token']);
                    break;
                default:
                    /* Show notification if something went wrong. */
                    echo 'Could not connect to Twitter. Refresh the page or try again later.';
                }
            }
            if('google' == $type){
                $google = self::google();
                self::$linkLogin[$type] = $google['google']->createAuthUrl();
            }
        }
        return self::$linkLogin[$type];
    } 
    
    
    public static function getButtonLogin($type = array('fb','tw','google')){
        $jvLink = array();
        foreach ($type as $t){
            $jvLink[$t] = self::getLinkLogin($t);
        }
        ob_start();
        include  JPATH_SITE . '/plugins/system/jvsocial/tmpl/default.php';   
        return ob_get_clean();
    }
    
}


