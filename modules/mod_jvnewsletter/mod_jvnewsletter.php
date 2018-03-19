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

//defined jv newsletter
defined('_JV_VERSION_EXEC') or define('_JV_VERSION_EXEC', (($pos = strstr(JVERSION, '.', true)) >= 3));
// set access module
$document = JFactory::getDocument();
$sucess = false;
$message = array();

$document->addStyleDeclaration('
.jvnewsletter_subscribe_pre_text{
    margin-bottom: 9px;
    color: #555;
}
.jvnewsletter_subscribe label.label.lbinput 
{
    margin-right: 10px;
    width: 8.4em;
    display: block;
    float: left;
}
.jvnewsletter-box label{
    cursor: pointer;
}
.jvnewsletter_subscribe input[type=text], .jvnewsletter_subscribe input[type=email]
{
    height: 25px;
    width: 100% !important;
    -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
    -moz-box-sizing: border-box;    /* Firefox, other Gecko */
    box-sizing: border-box;
    padding: 4px 6px;
    margin-bottom: 9px;
    font-size: 13px;
    line-height: 18px;
    color: #555;
    border-radius: 3px;
    border: 1px solid #dfdfdf;
}
.jvnewsletter-box-'.$module->id.'{
    max-width: '. (($mwidth = $params->get('maxwidth')) == 'auto' ? $mwidth: $mwidth.'px') .';
}
.jvnewsletter_subscribe input[type=text]:focus, .jvnewsletter_subscribe input[type=email]:focus{
    outline-color: #afafaf;
}
');

if($params->get('addscript')){
    $document->addStyleSheet(JURI::base(). 'modules/mod_jvnewsletter/css/bootstrap.jvnewsletter.min.css');
    $document->addScript(JURI::base(). 'modules/mod_jvnewsletter/js/jquery-1.9.1.min.js');
    $document->addScript(JURI::base(). 'modules/mod_jvnewsletter/js/bootstrap.min.js');
	$document->addScriptDeclaration('
		$.noConflict();
	');
}
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$app  = JFactory::getApplication();

if (isset($_POST['subcribe-'.$module->id]))
{
    $fname = isset($_POST['fname'])? $_POST['fname'] : '';
    $lname = isset($_POST['lname'])? $_POST['lname'] : '';
    $email = isset($_POST['email'])? $_POST['email'] : '';
    if (!empty($email)){
        defined('_JVNSEXEC')or require (dirname(__FILE__). "/services/_services.php");
        $nameclass = $params->get('chose');        
        $ftory = new $nameclass( $params->get('api')->key );
        $lists = array();
        if (!$params->get('chose_list'))
        {
            $lists = isset($params->get('api')->list)? (array)($params->get('api')->list) : array();
        }
        else
        {
            $tlists = isset($_POST['lists'])? $_POST['lists']:'';
            foreach($tlists as $i)
            {
                $lists[$i] = 'on';
            }
        }
        $rs = array();    
        foreach($lists as $k=>$v)
        {
            $rs[$k] = $ftory->subscribe($k, $email, $fname, $lname);
        }
        $htmlrs = array();
        if(!empty($rs))
        {
            $htmlrs[] = '<div>';
            foreach($rs as $k=>$v)
            {
                $htmlrs[] = '<div class="control-group">';
                if ($v){
                    $htmlrs[] = '<span class="text-success">'.$params->get('api')->list->{$k}.'</span> <i class="icon-ok"></i>';
                }
                else
                {
                    $htmlrs[] = '<span class="text-error">'.$params->get('api')->list->{$k}.'</span> <i class="icon-remove"></i>';
                }
                $htmlrs[] = '</div>';
            }
            $htmlrs[] = '</div>';
            $message[] = '<span class="success">Subscribe successful!</span>';
            $sucess = true;
        }        
    }
    else
    {
        $message[] = '<span class="error">Please input your email!</span>';
    }
}

require JModuleHelper::getLayoutPath('mod_jvnewsletter', $params->get('layout', 'default'));
?>
<?php
if(isset($_POST['subcribe-'.$module->id])&& $sucess && $params->get('show_dialog')/*&& _JV_VERSION_EXEC*/)
{
    $document->addScriptDeclaration("
    try{    
        jQuery.noConflict();
        (function($){
            $(function(){
                $('#jvnewslatter_modal').modal();
            });
        })(jQuery);
    }
    catch(e)
    {
        
    }
    ");
}
$sucess = false;
 ?>