<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_jvportfolio
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_jvportfolio
 *
 * @package     Joomla.Site
 * @subpackage  mod_jvportfolio
 * @since       1.5
 */

require_once JPATH_SITE.'/components/com_jvportfolio/helpers/jvportfolio.php';
class ModJvPortfolioHelper
{
    public static function toggleVoteAjax() {
        $db = JFactory::getDbo();
        $u = JvportfolioFrontendHelper::getUid();
        $pfid = JRequest::getInt('pfid', 0);
        if(!$pfid) {
            return null;
        }
        $rs = $db
        ->setQuery("SELECT id FROM #__jvportfolio_liked WHERE u = '{$u}'")
        ->loadObject();
        if(is_null($rs)) {
            $db
            ->setQuery("INSERT INTO #__jvportfolio_liked(pfid, u) VALUES ({$pfid}, '{$u}')")
            ->execute();
        }
        else {
            $db
            ->setQuery("DELETE FROM #__jvportfolio_liked WHERE id = {$rs->id}")
            ->execute();
        }
        
        return $db
        ->setQuery("SELECT count(*) as c FROM #__jvportfolio_liked WHERE u = '{$u}'")
        ->loadObject()->c;
    }
    
    public static function getItems($cate, $tag, $offset, $limit, $isize='0x0'){
        $db = JFactory::getDbo();
        $uid = JvportfolioFrontendHelper::getUid();
        $where = "";
        if($tag || $cate) {
            $where = "WHERE ";
            if($tag) {
                $tag = implode(',', $tag);
                $where .= "a.tag in ({$tag})";
            }
            if($tag && $cate) {
                $where .= " AND ";
            }
            if($cate) {
                $cate = implode(',', $cate);
                $where .= "a.cate in ({$cate})";
            }
        }
        $q = 'SELECT DISTINCT a.*,'.
            "(select count(*) from #__jvportfolio_liked as l where l.pfid = a.id) as cliked,".
            "(select count(*) from #__jvportfolio_liked as l where l.u = '{$uid}') as lactive
            FROM `#__jvportfolio_item` AS a
            {$where}
            ORDER BY a.id DESC";
        $rs = $db->setQuery($q, $offset, $limit)->loadObjectList();
        if(is_null($rs)) return 0;
        
        foreach($rs as &$item) {
            JvportfolioFrontendHelper::build($item, $isize);    
        }
        
        $q = "SELECT DISTINCT count(*) as rows FROM `#__jvportfolio_item` AS a {$where}";
        return (object)array('items'=>$rs, 'total'=>$db->setQuery($q)->loadObject()->rows);
    }
    
    public static function loadTemplate($template){
        return JModuleHelper::getLayoutPath('mod_jvportfolio', $template);
    }
    
    public static function isIncludeJS(){
        foreach(JFactory::getDocument()->_scripts as $src=>$attr) {
            if(preg_match('/option=com_jvportfolio&amp;task=items.buildJs/', $src)) {
                return true;
            }    
        }
        return false;
    }
    
    public static function isIncludeCss(){
        foreach(JFactory::getDocument()->_styleSheets as $href=>$attrs) {
            if(preg_match('/option=com_jvportfolio&amp;task=items.buildCss/', $href)) {
                return true;
            }    
        }
        return false;
    }	
}
