<?php
/**
 # jvnewsletter - JV NEWSLETTER
 # @version        1.1
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 -------------------------------------------------------------------------*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
  
  define('_JVNSEXEC', TRUE);
 require(JPATH_SITE . "/modules/mod_jvnewsletter/services/_services.php"); 
 
  class PlgSystemJvNewsletter extends JPlugin
  {      
      function __construct(&$subject, $config)
      {
        parent::__construct($subject, $config);
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeContact');
      }
      public function onUserAfterSave($user, $isnew, $success, $msg)
      {
          if ($isnew)
          {
              $this->JvNewsletterSubscribe($user['name'], $user['email']);
          }
		  return true;
      }
      public function onBeforeContact()
      {
          if (isset($_POST['task']) && $_POST['task'] == 'contact.submit'){
              $name = isset($_POST['jform']['contact_name'])? $_POST['jform']['contact_name'] : '';
              $email = isset($_POST['jform']['contact_email'])? $_POST['jform']['contact_email'] : '';
              $this->JvNewsletterSubscribe($name, $email);
          }
      }
      
      protected function JvNewsletterSubscribe($name, $email)
      {   
          $fname = '';
          $lname = '';
          $cont = !empty($email);
          if ($cont)
          {
              $fl = explode(' ', $name);
              if (!empty($fl)){
                  $fname = $fl[0];
                  $lname =  ($s = (sizeof($fl) - 1)) > 0 ? $fl[$s]: "";
              }
              $api = array();
              $rs = getParamsList('mod_jvnewsletter');
			
              if (!empty($rs))
              {
                  if ($this->params->get('all_mod'))
                  {
                      foreach($rs as $p){
                          if($p->params->get('api')->key) $api[$p->params->get('api')->key] = array(
                            "type" => $p->params->get('chose'),
                            "lists" => (array)$p->params->get('api')->list
                          );
                      }
                  }
                  else
                  {
                      $cmod = $this->params->get('cmod');
                      if (empty($cmod))
                      {
                          $keys = array_keys($rs);
                          $cmod = array($keys[0]);
                      }
                      foreach($cmod as $id){
                          $mod = $rs[$id];
                          if($mod->params->get('api')->key) $api[$mod->params->get('api')->key] = array(
                            "type" => $mod->params->get('chose'),
                             "lists" => (array)$mod->params->get('api')->list
                          );
                      }
                  }
				
                  if($api) foreach($api as $key=>$val){
                      $ftory = getInstanceService($val['type'], array($key));
                      if ($ftory->checkAPI())
                      {
                          foreach($val['lists'] as $k=>$v){
                              $ftory->subscribe($k, $email, $fname, $lname); $c++;
                          }
                      }
                  }                  
              }
              
          }
      }
  }
?>
