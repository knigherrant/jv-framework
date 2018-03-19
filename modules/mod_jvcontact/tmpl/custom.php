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



$html = $myparams['customlayout'];



$html = JString::str_ireplace('{headertext}', $myparams['textheader'], $html);
$html = JString::str_ireplace('{footertext}', $myparams['textfooter'], $html);


$html = JString::str_ireplace('{moreinfo}', $myparams['moreinfo'], $html);
$html = JString::str_ireplace('{coypmail}', '<input type="checkbox" value="1" name="cbcopymail">'.$myparams['mailcopy'], $html);

$catpcha = $myparams['captcha'];


$html = str_replace('{social}', $myparams['social'], $html);
$html = str_replace('{captcha}',$catpcha[0] , $html);
$html = str_replace('{map}', $myparams['map'], $html);
$html = str_replace('{message}', '<div id="'. $divmsgid .'">'.$msgthankyou.'</div>', $html);

if($msgthankyou && isset($post['jvcontact'][$moduleid])){
	$html = JString::str_ireplace('{thankyou}', $msgthankyou, $html);
}else{
	$html = JString::str_ireplace('{thankyou}', '', $html);
}

if($fields) foreach($fields as $field){
	$html = JString::str_ireplace('{lb'.$field['name'].'}', @$field['label'], $html);
	$html = JString::str_ireplace('{inp'.$field['name'].'}', @$field['input'], $html);
}

$submitbutton = '<input type="button" class="jvcontactbtnsm button" onclick="formsubmit(\'jvcontact'. $moduleid .'\');" value="'.$myparams['textsubmit'].'" />';
$html = JString::str_ireplace('{submitbutton}', $submitbutton, $html);


$form = '<form id="jvcontact'. $moduleid .'" action="" method="post">';
$form .= $html;
$form .= JHTML::_('form.token');
$form .= '</form>';

echo $form;
?>

