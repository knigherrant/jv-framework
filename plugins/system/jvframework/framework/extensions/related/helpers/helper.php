<?php
/**
 # mod_jvnews - JV News
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
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.html.pagination');

if(!class_exists('ThumbBase')){
    require_once dirname(__FILE__) . '/../classes/ThumbBase.inc.php';
}

if(!class_exists('GdThumb')){
    require_once dirname(__FILE__) . '/../classes/GdThumb.inc.php';
}

abstract class RelatedContent{
    protected $num_intro = 0;
    protected $nums_link = 0;
    protected $limitstart = 0;  
    protected $limit = 0;   
    
    function __construct($params) {
        $this->params = $params;
        $this->num_intro   = (int) $params->num_intro;
        $this->nums_link   = (int) $params->nums_link;
        $this->limit       = $this->num_intro + $this->nums_link;  
    }
    
    abstract function getItems($catids = null);  

   
    public static function createPath(){
        $path 		= JPATH_ROOT.'/cache/jvframework/related';
        if(!JFolder::exists($path)){
        	if(!JFolder::create($path)) return;
        	$index = "<html><body></body></html>";
        	if(!JFile::write($path.'/'.'index.html',$index)) return;
        }
        if(!is_writable($path)){
            self::setError('JVFramework related: '.$path.' is not writable.', 'warning');
            return array();
        }
        return $path;
    }
    public static function getThumbnails(&$text, $mode, $thumbnail_width, $thumbnail_height, $isOverride = false, $clearImage = false){
    	$path = self::createPath();
        $thumbnail  = '';
        $doc = phpQuery::newDocumentHTML($text);
        foreach (pq('img') as $image){
        	$image = pq($image);        	
        	$src = $image->attr('src');  
               
        	$thumbnail = self::createThumb($src, $path, $thumbnail_width, $thumbnail_height, $mode);
        	if($clearImage){
        		$image->remove();
        	}elseif ($isOverride){
        		$image->attr('src', $thumbnail);
        	}
        }
        $text = $doc->html();
        return $thumbnail;       
    }
    
    public static function createThumb($source, $dest, $width, $height, $mode){
    	$size = @getimagesize ($source);
    	if (!is_array($size)){
    		return $source;
    	}
    	$replace = JURI::base(true).'/';
    	if(strpos($source, $replace) === 0){
    		$source = substr($source, strlen($replace));
    	}
    	if(preg_match('#http(s?):\/\/#', $source) && $source){
    		if(stripos($size['mime'], 'image') === 0){
    			$extension = substr($size['mime'], 6);
    			if($extension == 'jpeg'){
    				$extension = 'jpg';
    			}
    			$info = array('extension' => $extension, 'filename' => substr(base64_encode(json_encode($size)), 0, 10));
    		}else{ return $source; }	
    	}else{
    		$source = JPATH_SITE.'/'.$source;
    		$info = pathinfo($source);
    	}

    	// Resize path
    	$path = $dest."/{$mode}_{$width}_{$info['filename']}.{$info['extension']}";
        
           
    	if(!is_dir(dirname($path))){
    		JFolder::create(dirname($path));
    		$index = "<html><body></body></html>";
    		if(!JFile::write($path.'/'.'index.html',$index)) return;
    	}
    
    	if(!is_file($path)){
    		// Resize
    		$thumb = new GdThumb($source, array('jpegQuality' => 80));
    		$thumb->resize($width, $height);
    		$thumb->save($path, $info['extension']);
    	}
    	return self::toURL($path);
    }
    
    public static function toURL($path) {
        
    	$path = str_replace(JPATH_ROOT.DIRECTORY_SEPARATOR, '', str_replace('/', DIRECTORY_SEPARATOR, $path));
    	$url = str_replace(DIRECTORY_SEPARATOR, '/', $path);
        return JURI::root(true) .'/'. $url;
    }
    
    public static function clearContentImage($text){
    	$regex = '/<img.*src=[\'\"]([^\'^\"]*)?[\'\"].*\/>/i';
	return preg_replace($regex, '', $text);
    }
}

if(!function_exists('cut_html_string')){
    function cut_html_string($str, $limit = 100, $end_char = '') {
    	if (trim($str) == '' || $limit == 0) return $str;
    	$str = preg_replace( array("/\r|\n/","/\t/","/\s\s+/u"), array(" "," "," "), strip_tags(trim($str)));
    	if(strlen($str)>$limit){
    		if(function_exists("mb_substr")) {
    			$str = mb_substr($str, 0, $limit, 'UTF-8');
    		} else {
    			$str = substr($str, 0, $limit);
    		}
    		
    		return rtrim($str).$end_char;
    	} else {
    		return $str;
    	}
    }
}
