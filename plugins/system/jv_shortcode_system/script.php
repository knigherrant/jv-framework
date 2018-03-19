<?php
/**
 * @package 	JV Shortcode
 * @version		1.0.0
 * @created		June 2015
 * @author		PHPKungfu
 * @email		support@phpkungfu.club
 * @website		http://phpkungfu.club
 * @support		Forum - http://phpkungfu.club/forum/
 * @copyright	Copyright (C) 2015 PHPKungfu. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;
jimport('joomla.installer.installer');
class plgSystemJv_shortcode_systemInstallerScript
{

    public function postflight($type, $parent)
    {
        $db = JFactory::getDBO();        
        $query = "UPDATE #__extensions SET enabled=1 WHERE type='plugin' AND element=".$db->Quote('jv_shortcode_system')." AND folder=".$db->Quote('system');
        $db->setQuery($query);
        $db->query();       
    }

    
}        