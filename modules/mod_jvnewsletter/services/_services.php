<?php
/**
 # mod_jvnewsletter - JV NEWSLETTER
 # @version        1.0
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 -------------------------------------------------------------------------*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require (dirname(__FILE__). "/MCAPI.php");

function getInstanceService($nameclass, $args = array())
{
    $ftory = new ReflectionClass($nameclass);
    return $ftory->newInstanceArgs($args);
}
function getParams($id)
{
    $db = JFactory::getDbo();
    $db->getQuery(true);
    $db->setQuery("SELECT params FROM #__modules WHERE id='".$id."'");
    $params = new JRegistry();
    $params->loadString($db->loadResult());
    return $params;
}
function getParamsList($name)
{
    $db = JFactory::getDbo();
    $db->getQuery(true);
    $db->setQuery("SELECT id, params, title, published FROM #__modules WHERE module='".$name."'");
    $rs = $db->loadObjectList();
    $rsk = array();
    foreach($rs as $m)
    {
        $rparams = $m->params;
        $m->params = new JRegistry();
        $m->params->loadString($rparams); 
        $rsk[$m->id] = $m;
    }   
    return $rsk;
}
function getMenuAssigned($id)
{
    $db = JFactory::getDbo();
    $db->setQuery(true)
        ->select('*')
        ->from('#__modules_menu')
        ->where('moduleid = '. $id);
    return $db->loadObjectList();
}
function setMenuAssign($id, $menu_id)
{
    $db = JFactory::getDbo();
    $query = "INSERT INTO #__modules_menu VALUES(`$id`,`$menu_id`)";
    $db->setQuery($query);
    return $db->query();
}
function getJvNewsletterUsers()
{
    $db = JFactory::getDBO();
    $query = "SELECT `name`, `email` FROM #__users" ;
    $db->setQuery($query);
    $rows = $db->loadObjectList();
    return $rows;
}
function subcribeJvNewsletter($email, $fname, $lname, $lists = array())
{
    $params = getParams(JRequest::getInt('id'));
    $service = ($service = $params->get('chose'))? $service : 'mailchimp';
    $apikey = $params->get('api')->key;
    $ftory = new $service($apikey);
    $rs = array();
    $count = 0;
    foreach($lists as $k)
    {
        $r = ($ftory->subscribe($k, $email, $fname, $lname));
        $c = ($r? 1 : 0);
        $count += $c;
        $rs[] = array(
            'id'=>$k,
            'state'=> $c
         ); 
    }
    return array("email"=> $email, "state"=> $count, "data" => $rs);
}

class mailchimp
{
    protected $api;
    protected $apikey;
    function __construct($api_key)
    {
        $this->apikey = $api_key;
        $this->api = new MCAPI($this->apikey);
    }        
    
    function checkAPI()
    {
        try{
            return $this->api->ping();
        }
        catch(Exception $ex)
        {
            return false;
        }
        
    }
    
    function getLists()
    {
        $rs = $this->api->lists();
        return $rs['data'];
    }
    function subscribe($id, $email_address, $fname, $lname)
    {
        $merge_vars = array('FNAME'=>$fname, 'LNAME'=>$lname);
        return $this->api->listSubscribe($id, $email_address, $merge_vars);
    }
    function unsubscribe($id, $email_address)
    {
        return $this->api->listUnsubscribe($id, $email_address);
    }
    function subscribeAll($email_address, $fname, $lname)
    {                                                         
        $lists = $this->getLists();
        foreach($lists as $list)
        {
            $this->subscribe($list['id'], $email_address, $fname, $lname);
        }
    }
    function unsubscribeAll($email_address)
    {
        $lists = $this->getLists();
        foreach($lists as $list)
        {
            $this->unsubscribe($list['id'], $email_address);
        }
    }
}


require (dirname(__FILE__). "/cmonitor.class.php");
//campaign monitor services
class cmonitor
{
    protected $auth;
    protected $apikey;
    protected $clients;
    protected $lists;
    function __construct($api_key)
    {
        $this->apikey = $api_key;
        $this->auth = array('api_key' => $api_key);
    }        
    
    function checkAPI()
    {   
        try{
            $rs = @$this->getClients();
            return $rs ? $rs : false;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }
    
    function getClients()
    {
        try{
            if (!$this->clients){
                $api = new CS_REST_General($this->auth);
                $this->clients = $api->get_clients();
            }
            if ($this->clients->was_successful())
                return $this->clients->response;
            else
                return null;
        }
        catch (Exception $ex)
        {
            return null;
        }
    }
    
    function getListsBy($client_id)
    {
        $wrap = new CS_REST_Clients($client_id, $this->auth);
        $rs = $wrap->get_lists();
        if($rs->was_successful())
            return $rs->response;
        else
            return null;
    }
    
    function getLists()
    {
        if (empty($this->lists)){
            $this->lists = array();        
            if ($clients = $this->getClients()){
                foreach($clients as $c)
                {
                    $wrap = $this->getListsBy($c->ClientID);
                    if ($wrap)
                    {
                        foreach($wrap as $l)
                        {
                            $this->lists[] = array(
                                "id" => $l->ListID,
                                "name" => $l->Name
                            );
                        }
                    }
                }
            }
        }
        return $this->lists;
    }
    function subscribe($id, $email_address, $fname, $lname)
    {
        $wrap = new CS_REST_Subscribers($id, $this->auth);
        $result = $wrap->add(array(
            'EmailAddress' => $email_address,
            'Name' => $fname. ' '. $lname,
            'Resubscribe' => true
        ));                              
        return $result->was_successful();
    }
    function unsubscribe($id, $email_address)
    {
        $wrap = new CS_REST_Subscribers($id, $this->auth);
        $result = $wrap->unsubscribe($email_address);
        return $result->was_successful();
    }
    function subscribeAll($email_address, $fname, $lname)
    {                                                         
        $lists = $this->getLists();
        foreach($lists as $list)
        {
            $this->subscribe($list['id'], $email_address, $fname, $lname);
        }
    }
    function unsubscribeAll($email_address)
    {
        $lists = $this->getLists();
        foreach($lists as $list)
        {
            $this->unsubscribe($list['id'], $email_address);
        }
    }
}
?>