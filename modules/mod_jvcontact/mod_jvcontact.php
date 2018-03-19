<?php
/**
 # Module		JV Contact
 # @version		3.0.1
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright © 2008-2012 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$post = JRequest::get('post');

$moduleid = $module->id;

$helper = new modJVContactHelper($moduleid,$params);

$myparams = $helper->_params;

$fields = $helper->getFields();

$msgthankyou = $helper->sendMail($fields);
if($msgthankyou=='ok'){
	$app = JFactory::getApplication();
	$url = JFactory::getURI();
	$url->setVar("send","ok");
	$url = $url->toString();
	$app->redirect($url);
}

if(JRequest::getVar('send')=='ok'){
	$msgthankyou = $params->get('thankyou','Thank you!');
}

$divmsgid = 'msgjvcontact'.$moduleid;

require JModuleHelper::getLayoutPath('mod_jvcontact', $myparams['layout']);
