<?php

/**
 * @version     1.0.0
 * @package     com_jvportfolio
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
 */
defined('_JEXEC') or die;
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );

class JvportfolioFrontendHelper {
    public static function getTags($ids = ''){
        if(is_array($ids)) $ids = implode(',',$ids);
		if(empty($ids)) return null;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("title, alias");
        $query->from('`#__tags`');
        $query->where( "id in ({$ids})");

        return $db->setQuery($query)->loadObjectList();
    }
    public static function getCateTags($idsCate = '', $idsTag = ''){
        if(is_array($idsCate)) $idsCate = implode(',',$idsCate);
        if(is_array($idsTag)) $idsTag = implode(',',$idsTag);
        $rs     = array();
        $sIdTag = '';
        if ($idsTag) {
            $sIdTag = " AND tag in (".$idsTag.")";
        }
        $tags   = JFactory::getDbo()->setQuery(" SELECT tag FROM #__jvportfolio_item WHERE cate in (".$idsCate.")".$sIdTag)->loadObjectList(); 
        if( $tags )
        {
            foreach( $tags as $item )
            {
                $rs[ $item->tag ] = self::getTags( $item->tag );
            }
            
            $xrs = array();
            foreach( array_values( $rs ) as $items )
            {
                foreach( $items as $item )
                {
                    $xrs[ $item->alias ] = $item;
                }
            }
            $rs = array_values( $xrs );
        }
        
        return array_values( $rs );   
    }
    
    public static function getAllTag(){
		$rs 	= array();
        $tags 	= JFactory::getDbo()->setQuery(" SELECT tag FROM #__jvportfolio_item ")->loadObjectList();    
		
		if( $tags )
		{
			foreach( $tags as $item )
			{
				$rs[ $item->tag ] = self::getTags( $item->tag );
			}
			
			$xrs = array();
			foreach( array_values( $rs ) as $items )
			{
				foreach( $items as $item )
				{
					$xrs[ $item->alias ] = $item;
				}
			}
			$rs = array_values( $xrs );
		}
		
		return array_values( $rs );
    } 
    
    public static function build(&$item, $isize = '0x0'){
        // field image 
        $item->gallery = explode(',', $item->image);
        self::prefixGallery($item->gallery, $isize);
        if(isset($item->gallery['feature'])) {
            $item->image = $item->gallery['feature'];
            unset($item->gallery['feature']);
        }
        
        if (!isset($item->tag)) return;
            // Cleaning and initalization of named tags array
            $namedTags = array(); 
            $aliasTags = array();

            // Get the tag names of each tag id
            $item->tags_id = $item->tag;
            $row = self::getTags($item->tag);

            // Read the row and get the tag name (title)
            if (!is_null($row)) {
                foreach ($row as $value) {
                    if ($value && isset($value->title) ) {
                        $namedTags[] = trim($value->title);
                    }
                    if ($value && isset($value->alias) ) {
                        $aliasTags[] = '"'.trim($value->alias).'"';
                    }
                }
            }                              

            // Finally replace the data object with proper information
            $item->tag = !empty($namedTags) ? implode(', ',$namedTags) : $item->tag;
            $item->aliasTags = !empty($aliasTags) ? implode(',',$aliasTags) : '';    
    }
    
    /* get liked */
    public static function getLiked($pid = 0){
        return JFactory::getDbo()->setQuery("
        SELECT COUNT(*) as rs 
        FROM #__jvportfolio_liked l
        WHERE l.pfid={$pid}")->loadObject()->rs;
    }
    
    /* Build category from string ids */
    public static function buildCates(&$item){
        $taghelper = new JHelperTags;
        if($item->cate && ($cates = explode(',', $item->cate)) && count($cates)) {
            $item->cates = $taghelper->getTagNames($cates);
            $item->cate = implode(', ', $item->cates);
        }
    }
    
    private static function prefixGallery(&$gallery, $isize = '0x0'){
        if(!$gallery)   return false;
        
        if(!class_exists('imageLib')) {
            require_once(implode(DIRECTORY_SEPARATOR, array(JPATH_SITE, 'components', 'com_jvportfolio', 'helpers', 'lib', 'php_image_magician.php')));
        }
        
        $prefix = $isize;
        $feature = $gallery[0];
    
        $savePath = implode(DIRECTORY_SEPARATOR, array(JPATH_CACHE, 'rportfolio', $prefix));
        if(!JFolder::exists($savePath)) {
            JFolder::create($savePath);    
        }
        
        $pathFile   = implode(DIRECTORY_SEPARATOR, array(JPATH_SITE, $feature));
        $fn         = JFile::getName($pathFile);
        $savePath   = implode(DIRECTORY_SEPARATOR, array($savePath, $fn));
        $isize      = self::dumpSize($isize);
        
        if(!JFile::exists($savePath) && count($isize) == 2 && intval($isize[0]) && intval($isize[1])) {
            
            $w = intval($isize[0]);
            $h = intval($isize[1]);
            
            $resizer = new imageLib($pathFile);
            
            $resizer->resizeImage($w, $h, 1);
            $resizer->saveImage($savePath);   
        }                                    
        
        if(JFile::exists($savePath)) {
            $feature = implode('/', array(rtrim(JUri::root(), '/'), 'cache', 'rportfolio', $prefix, $fn)); 
        }
        
        
        foreach($gallery as $i=>$item) {
             $gallery[$i] = JUri::root().$item;    
        }
        
        // set feature
        $gallery['feature'] = $feature;
    }
    
    public static function dumpSize($str = '0x0') {
        
        if(!preg_match('/^\d+x\d+$/', $str)) {return array();};
        
        return explode('x', $str);
    }
    
    public static function getPrefixCol($col){
        $cols = array(
            1=>'portfolio one',
            2=>'portfolio two',
            3=>'portfolio three',
            4=>'portfolio4 four',
            5=>'portfolio six',
            '_imasonry'=>'portfolio3 portfolio-masonry'
        );
        return isset($cols[$col]) ? $cols[$col] : $col;
    }
    public static function getActionQView($normal='', $active=''){
         $qview = array(
            'view'=>'#pfo-item-id',
            'c'=>array(
                array(
                    'removeClass'=>$normal,
                    'addClass'=>$active
                ),
                array(
                    'removeClass'=>$active,
                    'addClass'=>$normal
                )
            )
       );
       return json_encode($qview);
    }
    
    public static function getCtrlSort($data = array()){
        foreach($data as $i=>$item){
            $data[$i] = array(
                'value'=>$item, 
                'text'=>JText::_("COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_SORT_".strtoupper($item))
            );    
        }
        
        return JHtml::_('select.genericlist', $data, 'csort', null, 'value', 'text', 'date');
    }
    
    public static function getUid(){
        $u = JFactory::getUser();
        if($u->guest) {
            return $_SERVER["REMOTE_ADDR"];
        }
        return $u->id;
    } 
	
	public static function getModule($id){
		$module = JFactory::getDbo()->setQuery("SELECT params FROM #__modules WHERE id={$id} AND published=1")->loadObject();
		if(!$module) {return false;}
		return new JRegistry($module->params);
	}

    public static function getExtraField( $item = object ) {

        if( !property_exists( $item, 'extrafields') ) { return false; }

        $extrafields = json_decode( $item->extrafields, true );

        if( $extrafields && is_array( $extrafields ) && count( $extrafields ) ) {

            return $extrafields;
        }

        return  false;
    }
}
