<?php
/**
 # MOD_JVLATEST_NEWS - JV Latest News
 # @version		3.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2013 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.html.pagination');

if(!class_exists('JVLNewPagination')){
    require_once JPATH_SITE.'/modules/mod_jvlatest_news/classes/pagination.php';
}
if(!class_exists('phpQuery')){
	require_once JPATH_SITE.'/modules/mod_jvlatest_news/classes/phpQuery.php';
}
if(!class_exists('ThumbBase')){
    require_once JPATH_SITE.'/modules/mod_jvlatest_news/classes/ThumbBase.inc.php';
}
if(!class_exists('GdThumb')){
    require_once JPATH_SITE.'/modules/mod_jvlatest_news/classes/GdThumb.inc.php';
}
abstract class modJVLatestNewsHelper{
    protected $num_leading = 0;
    protected $num_intro = 0;
    protected $nums_link = 0;
    protected $limitstart = 0;
    protected $limit = 0;   
    protected $source;	
    protected $options;
    protected $params;
    
    static function setError($msg, $type = 'message'){
    	$app = JFactory::getApplication();
    	$app->enqueueMessage($msg, $type);
    }
    
    public function __construct($params){
        $this->params = $params;
        $this->source      = $params->get('source', 'content');  
        $this->num_intro   = (int) $params->get('num_intro', 5);
        $this->nums_link   = (int) $params->get('nums_link', 3);
        $this->limit       = ($params->get('group_cat'))? 1000 : $this->num_intro + $this->nums_link;  
        $this->limitstart  = JRequest::getInt('limit-start') && JRequest::getInt('mid') == $params->get('modid', 0) ? JRequest::getInt('limit-start') : 0;       
    }    
    
    public function groupByCategory($items){
        $categories = $this->getCategories();
        $lists = array();
        if($categories) foreach ($categories as $cat){
            foreach ($items as $item) if($cat->id == $item->catid) $lists[$cat->title][] = $item;
        }
        return $lists;
    }


    public function __get($name) { return isset($this->$name) ? $this->$name : '';}
    public function __set($name, $value) {$this->$name = $value; }
    abstract function getItems($catids = null);  
    abstract function buildCondition();
    abstract function buildContentOrderBy();  
    protected function setOption($option){$this->options = $option;}
    function getSPItems(){ return $this->params->get('items',array());}
    function getSPId($field){
        $ids = array();
        /*for($i=0;$i <5; $i++){
            if($this->params->get('sp_'.$field.'_'.$i)) 
                $ids[] = $this->params->get('sp_'.$field.'_'.$i);
        }*/

        $temp = explode(",",$this->params->get('sp_'.$field.'_0'));
        if (!empty($temp))
        {
            foreach ($temp as $key => $value) {
                if ($value !== '' && $value > 0)
                {
                   $ids[] = $value; 
                }
            }
        }
        
        return $ids;
    }
    
    public static function createPath(){
        $path 		= JPATH_ROOT.'/cache/jvlatestnews';
        if(!JFolder::exists($path)){
        	if(!JFolder::create($path)) return;
        	$index = "<html><body></body></html>";
        	if(!JFile::write($path.'/'.'index.html',$index)) return;
        }
        if(!is_writable($path)){
            self::setError('JV Latest News: '.$path.' is not writable.', 'warning');
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
                break;
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
			if($mode=='original'){
				JFile::copy($source, $path);
				return self::toURL($path);
			}
    		$thumb = new GdThumb($source, array('jpegQuality' => 90));
    		if($mode=='resize') $thumb->resize($width, $height);
            if($mode=='crop') $thumb->cropFromCenter($width, $height);
			
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

