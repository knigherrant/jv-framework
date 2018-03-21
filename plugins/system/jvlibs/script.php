<?php
   /**
# plugin system jvlibs - JV Libraries
# @versions: 1.6.x,1.7.x,2.5.x,3.x
# ------------------------------------------------------------------------
# author    PHPKungfu Solutions Co
# copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
# @license - http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL or later.
# Websites: http://www.phpkungfu.club
# Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');

class plgSystemJVLibsInstallerScript {
   function install($parent) {
        $db = JFactory::getDbo();
        $query = "update #__extensions set enabled = 1 , ordering = 0 where element = 'jvlibs'";
        $db->setquery($query);
        if($db->query()){
            echo 'JV Libraries is enabled!';
        }
   }
}
?>
