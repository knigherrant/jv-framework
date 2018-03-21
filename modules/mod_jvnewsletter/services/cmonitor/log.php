<?php
/**
 # mod_jvnewsletter - JV NEWSLETTER
 # @version        1.0
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 -------------------------------------------------------------------------*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
define('CS_REST_LOG_VERBOSE', 1000);
define('CS_REST_LOG_WARNING', 500);
define('CS_REST_LOG_ERROR', 250);
define('CS_REST_LOG_NONE', 0);

class CS_REST_Log {
    var $_level;

    function CS_REST_Log($level) {
        $this->_level = $level;
    }

    function log_message($message, $module, $level) {
        if($this->_level >= $level) {
            echo date('G:i:s').' - '.$module.': '.$message."<br />\n";
        }
    }
}