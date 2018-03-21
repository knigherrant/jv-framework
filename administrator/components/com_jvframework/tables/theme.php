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
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');

class TableTheme extends JTable{
    var $id = null;
	var $theme = null;
    var $published = null;
    	
	function __construct(&$db)
	{
		parent::__construct( '#__extensions', 'extension_id', $db );
	}
	
	function check(){
		if($this->params != '') $this->params = json_encode($this->params);
		
		return true;
	}
}
