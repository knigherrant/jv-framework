<?php
/**
 # com_jvframwork - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

if (class_exists ( 'JV' )) {
	$jv = JV::getInstance();
	$jv->initialise();	
	echo $jv->render('error');

} else {
	JError::raiseError ( 'JV Framework not found', 'Please install JV Framework to use this template.<br/>Go to <a href="http://phpkungfu.club">http://phpkungfu.club</a> or contact <a href="mailto:info@phpkungfu.club">info@phpkungfu.club</a> for infomation about JV Framework' );
}
