<?php
/**
 * @version     1.0.0
 * @package     plg_system_jvajax_search_virtuemart
 * @copyright   Copyright (C) 2014 PHPKungfu. All rights reserved.
 * @license     http://www.gnu.org/licenseses/gpl-2.0.html GNU/GPL or later
 * @author      info@phpkungfu.club <www.phpkungfu.club>
 */

defined('_JEXEC') or die('Restricted access');

if(!class_exists('plgSystemJVAjax_Shop_SearchInstallerScript')){
    class plgSystemJVAjax_Shop_SearchInstallerScript {
       function install($parent) {
            $db = JFactory::getDbo();
            $query = "update #__extensions set enabled = 1 where element = 'jvajax_shop_search' and folder = 'system'";
            $db->setquery($query);
            if($db->query()){
                echo 'System - JV Ajax Shop Search Plugin is enabled!';
            }
       }
	   
       function update($parent) {
            $db = JFactory::getDbo();
            $query = "update #__extensions set enabled = 1 where element = 'jvajax_shop_search' and folder = 'system'";
            $db->setquery($query);
            if($db->query()){
                echo 'System - JV Ajax Shop Search Plugin is enabled!';
            }
       }
	   
	   
    }
}
?>
