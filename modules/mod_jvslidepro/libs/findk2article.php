<?php 
 /**
# mod_jvslidepro - JV Slide Pro
# @versions: 1.5.x,1.6.x,1.7.x,2.5.x
# ------------------------------------------------------------------------
# author    Open Source Code Solutions Co
# copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
# Websites: http://www.joomlavi.com
# Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');
is_dir(JPATH_SITE.'/components/com_k2') or die(json_encode(array(array('text' => 'Please install K2 Article'))));
$keySearch = trim(JRequest::getVar('term'));
$keySearch = str_replace("'","\'",$keySearch);
$filterID = "";
if(is_numeric($keySearch)) $filterID = "or id LIKE '$keySearch%'";
$sql = "SELECT id,title as text FROM #__k2_items where title LIKE '%$keySearch%' ".$filterID." LIMIT 0,10";
$db = JFactory::getDbo();
$db->setQuery($sql);
$list = $db->loadObjectList();
die(json_encode($list));
?>
