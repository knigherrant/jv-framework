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

defined('_JVNSEXEC') or require (dirname(__FILE__). "/../../services/_services.php"); 

$doc = JFactory::getDocument();
$doc->addStyleDeclaration('
    .panelform ul{
        display: inline-block;
    }
    .panelform ul li{
        display: inline-block;
    }
');  
  
if ($extra = JRequest::getVar('extra'))
{
    while(ob_get_length()>0||ob_get_clean())
    {
        ob_end_clean();
    }   
        
    if (JRequest::getVar('fn')=='modal'){
        $lists = JRequest::getVar('jlists');
        $modal = array();
        $modal[] = '<html>';
        $modal[] = '<head>
                    <link rel="stylesheet" type="text/css" href="'.JUri::root().'modules/mod_jvnewsletter/css/bootstrap.min.css">
                    <link rel="stylesheet" type="text/css" href="'.JUri::root().'modules/mod_jvnewsletter/css/bootstrap-responsive.min.css">
                    <script type="text/javascript" src="'.JUri::root().'modules/mod_jvnewsletter/js/jquery-1.9.1.min.js"></script>
                    <script type="text/javascript" src="'.JUri::root().'modules/mod_jvnewsletter/js/bootstrap.min.js"></script> 
                    <script type="text/javascript" src="'.JUri::root().'modules/mod_jvnewsletter/js/jvnewsletter.js"></script>
                    <script type="text/javascript">
                        $(function(){
                            var lists = '. ($lists? $lists : '[]') .',
                                id = '. JRequest::getVar('id') .';
                                jvnewsletter.init({
                                    modid: id,
                                    lists: lists,
                                    modal: "#jvnewslater-import-modal"
                                });
                        })
                    </script>
                    </head>';
        $modal[] = '<body>';
        $modal[] = '<div id="jvnewslater-import-modal">
                      <div class="modal-header">
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                        <h3>Import email to service</h3>
                      </div>
                      <div class="modal-body">
                        <table class="table table-hover table table-bordered">
                        <tr>
                            <th>
                                <input type="checkbox" class="jvnewslater-import-modal-checkall">
                            </th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>';
        $users = getJvNewsletterUsers();
        foreach($users as $u)
        {
            $modal[] = '<tr>';
            $modal[] = '<td><input type="checkbox" value="'.$u->email.'"></td>';
            $modal[] = '<td class="td-name">'.$u->name.'</td>';
            $modal[] = '<td>'.$u->email.'</td>';
            $modal[] = '</tr>';
        }
        $modal[] = '</table>
                      </div>
                      <div class="modal-footer">
                        <a href="#" id="jvnewslater-import-modal-btn-import" class="btn btn-primary">Import</a>
                      </div>
                    </div>';
        $modal[] = '</body>';
        $modal[] = '</html>';
        die( implode($modal));
    }
    $atc = ($atc = JRequest::getVar('atc'))? $atc : 'lists';
    if (isset($_POST['jvnewsletter_submit']))
    {
        $email = isset($_POST['email'])? $_POST['email']: '';
        $fname = isset($_POST['fname'])? $_POST['fname']: '';
        $lname = isset($_POST['lname'])? $_POST['lname']: '';
        $lists = isset($_POST['lists'])? $_POST['lists']: '';
        if ($atc == 'subscribe')
        {
            $rs = subcribeJvNewsletter($email, $fname, $lname, $lists);
            die (json_encode($rs));
        }
        else if($atc == 'lists')
        {
            die (json_encode(getJvNewsletterUsers()));
        }
    }
    die;
}
  
class JFormFieldAPIKey extends JFormField
{
    protected $type = 'APIKey';
    
    protected function getInput()
    {
        $params = getParams(JRequest::getInt('id'));
        $value = empty($this->value)?(object)array('list'=> array(),'key' => '' , 'fields' => ''):(object)$this->value;
                        
        $key = $value->key;
        $true_key = false;
        $nameclass = ($name = $params->get('chose'))? $name : "mailchimp";
        $ftory = new $nameclass( $key );
        
        if ($key && $params->get('alway_check'))
        {                 
             $true_key = $ftory->checkAPI();             
        }
        else if(!$params->get('alway_check') && $key)
        {
            $true_key = true;
        }
        
        $html = array();
        $html[] = '<span class="api-key-input">';
        if (!$true_key){
            $html[] = '<span class="error">Please input api key your service.</span><br />';
        }
        $html[] = '<span>';
        $html[] = '<input class="input api-input'.($true_key? '':' error').'" type="text" name="'.$this->name.'[key]" id="'.$this->id.'key" value="'.$value->key.'"/>';
        if ($true_key){
            $html[] = ' <a href="index.php?option=com_modules&view=module&layout=edit&id='.JRequest::getVar('id').'&extra=1&atc=subscribe&fn=modal" class="btn jvnewslater-import">Import</a>';
        }
        $html[] = '</span>';
        $html[] = '</span>';
        if((empty($value->fields) || $params->get('alway_check')) && $true_key){
            $data = $ftory->getLists();
            $value->fields = json_encode($data);
        }
        $html[] = '<textarea style="visibility:hidden;" name="'.$this->name.'[fields]">'.$value->fields.'</textarea>';
         
        if ($true_key && !empty($value->fields))
        {
            
            $lists = json_decode($value->fields);
            if ($lists)
            {
                $html[] = '<span class="list-api">';
                $html[] = '<h4>Chose list to activated subscibe.<h4>';
                foreach($lists as $val)
                {
                    $html[] = '<label for="'.$val->id.'">';   
                    $html[] = '<input type="checkbox" id="'.$val->id.'" name="'.$this->name.'[list]['.$val->id.']" value="'.$val->name.'" '.(empty($value->list[$val->id])?'':'checked').' /> ';
                    $html[] = $val->name.'</label>';
                }
            }
            $html[] = "</span>";
        }
        if ($true_key){
            $doc = JFactory::getDocument();
            $doc->addScript(JUri::root().'modules/mod_jvnewsletter/js/jvnewsletter.js');
            $doc->addScriptDeclaration("
            var jvHandler = {
                uriEncode : function(json){
                    return encodeURIComponent(JSON.stringify(json));
                },
                hasJQ : function(){
                    try{
                        var rs = jQuery;
                        return true;
                    }
                    catch(e){
                        return false;
                    }
                },
                getListsJQ: function(selector){
                    var lists = jQuery(selector),
                        dlists = [];
                    jQuery.each(lists, function(){
                        dlists.push(jQuery(this).attr('id'));
                    });
                    return dlists;
                },
                getListsMT: function(selector){
                    var lists = $$(selector),
                        dlists = [];
                    Array.each(lists, function(item){
                        dlists.push(item.get('id'));
                    });
                    return dlists;
                }
            };
            if (jvHandler.hasJQ())
            {
                jQuery.noConflict();
                (function($){
                    $(function(){
                        $('a.jvnewslater-import').click(function(){                            
                            var     modalbox = $('#jvnewslater-import-modal'),
                                    id = '".JRequest::getVar('id')."',
                                    lists = jvHandler.getListsJQ('span.list-api input[type=checkbox]:checked'),
                                    dlists = [];
                            if (lists.length <= 0)
                            {
                                alert('Please check anyone list to Import!');
                                return false;
                            }                            
                            $(modalbox).modal();
                            jvnewsletter.init({
                                modid: id,
                                modal: modalbox,
                                lists: lists
                            });
                            
                            return false;
                        });
                    })
                })(jQuery);
            }
            else
            {
                window.addEvent('domready', function(){
                    var btn = $$('a.jvnewslater-import');
                    btn.addEvent('click', function(){
                        var lists = jvHandler.getListsMT('span.list-api input[type=checkbox]:checked');
                        if (lists.length <= 0)
                        {
                            alert('Please check anyone list to Import!');
                            return false;
                        }
                        var slist = jvHandler.uriEncode(lists);
                        var href = btn.get('href') + '&jlists=' + slist;
                        SqueezeBox.initialize({
                            size: {x: 800, y: 450}
                        });
                        SqueezeBox.open(href, {handler: 'iframe'});
                        return false;
                    });
                });
            }    
            ");
            $modal = array();
            $modal[] = '<div id="jvnewslater-import-modal" class="modal hide fade">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3>Import email to service</h3>
                          </div>
                          <div class="modal-body">
                            <table class="table table-hover table table-bordered">
                            <tr>
                                <th>
                                    <input type="checkbox" class="jvnewslater-import-modal-checkall">
                                </th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>';
            $users = getJvNewsletterUsers();
            foreach($users as $u)
            {
                $modal[] = '<tr>';
                $modal[] = '<td><input type="checkbox" value="'.$u->email.'"></td>';
                $modal[] = '<td class="td-name">'.$u->name.'</td>';
                $modal[] = '<td>'.$u->email.'</td>';
                $modal[] = '</tr>';
            }
            $modal[] = '</table>
                          </div>
                          <div class="modal-footer">
                            <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
                            <a href="#" id="jvnewslater-import-modal-btn-import" class="btn btn-primary">Import</a>
                          </div>
                        </div>';
            $doc->addCustomTag(implode($modal));
        }
                
        return implode($html);
    }
}
?>