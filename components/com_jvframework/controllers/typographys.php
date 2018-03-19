<?php
/**
 # com_jvframework - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controlleradmin');

class JControllerTypographys extends ControllerAdmin{
    
    function __construct($config = array()) {
        parent::__construct($config);
    }
        
    function getModel($name = 'Typography', $prefix = 'JModel', $config = array()) {
        return parent::getModel($name, $prefix, $config);
    }
    
    
}