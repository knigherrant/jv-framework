<?php
/**
 # com_jvframwork - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
 */
// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

if (class_exists ( 'JV' )) {
	$jv = JV::getInstance();
	$jv->initialise();	
	echo $jv->render('error');

} else {
	JError::raiseError ( 'JV Framework not found', 'Please install JV Framework to use this template.<br/>Go to <a href="http://joomlavi.com">http://joomlavi.com</a> or contact <a href="mailto:info@joomlavi.com">info@joomlavi.com</a> for infomation about JV Framework' );
}
