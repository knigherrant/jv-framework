<?php
/**
 # MOD_JVLATEST_NEWS - JV Latest News
 # @version		3.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2013 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class JVLatestNews{
	protected $params = null;
	protected $source = 'content';
	protected $contentHelper = null;
	protected $pagination    = null;
	function __construct($params = array()){
		$this->params = $params;		
		$source = $params->get('source', 'content'); 
		if($source=='k2content'){
                    require_once dirname(__FILE__).'/k2.php';    
                    $this->contentHelper = new modJVLNewsK2Content($params);
		}else {
                    require_once dirname(__FILE__).'/content.php';    
                    $this->contentHelper = new modJVLNewsContent($params);
		}
	}
	function getContentHelper(){return $this->contentHelper;}
	function getItems(){
            $items = array();
            $items             = $this->contentHelper->getItems();  
            $this->pagination  = $this->contentHelper->getPagination(); 
            return $items ;
	}
	function getSpecialArticle(){return $this->contentHelper->getArticleById();}
	function getPagination() {return $this->pagination;}
	

}