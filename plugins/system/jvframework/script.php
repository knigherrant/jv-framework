<?php
/**
 # JV Framework
 # @version		2.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */

defined('_JEXEC') or die('Restricted access');

if(!class_exists('plgSystemJVFrameworkInstallerScript')){
    class plgSystemJVFrameworkInstallerScript {
       function install($parent) {
            $db = JFactory::getDbo();
            $query = "update #__extensions set enabled = 1 where element = 'jvframework'";
            $db->setquery($query);
            if($db->query()){
                echo 'Plugin System - JV Framework is enabled!';
            }
       }
    }
}
?>
