<?php

/**
 * @version     1.0.0
 * @package     com_jvportfolio
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Jvportfolio.
 */
class JvportfolioViewItems extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;
    protected $params;
    protected $cate;
	/**
     * Overwrite contructor
     */
    public function __construct($config = array()){
        $app                = JFactory::getApplication();
        $layout = $app->getMenu()->getActive()->params->get('layout', 'default');
        parent::__construct(array('layout'=>$layout));    
    }
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{   
        $app                = JFactory::getApplication();
        JRequest::setVar('limit', $app->getMenu()->getActive()->params->get('limit', 20));
        JRequest::setVar('limitstart', 0);
                
        $this->state		= $this->get('State');
		$data 				= $this->get('Items');
        $this->items		= $data['items'];
		$this->tags			= $data['tags'];
		
		if(isset($data['cate'])){
		    $this->cate		= $data['cate'];
		}
        $this->pagination	= $this->get('Pagination');
        $this->params       = $app->getParams('com_jvportfolio');
        
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {;
            throw new Exception(implode("\n", $errors));
        }
        
        $this->assets = JUri::root().'components/com_jvportfolio/assets'; 
		JHtml::stylesheet("{$this->assets}/css/fresco.css");		
        
        $this->_prepareDocument();
        parent::display($tpl);
	}


	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$title	= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if($menu)
		{
            $this->mparams = $menu->params;
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
            
            if($this->items) {
                $this->prefixPfo = "frm-portfolio";
                // Include JS
                JHtml::_('behavior.framework');
                JHtml::_('jquery.framework');
                JHtml::_('bootstrap.framework'); 
                $pageTotal = $this->pagination->pagesTotal;
                $limit = $this->pagination->limit; 
                $q = http_build_query(array(
                    'option'=>'com_jvportfolio',
                    'task'=>'items.buildJs',
                    'pageTotal'=>$pageTotal,
                    'limit'=>$limit,
                    'mid'=>$menu->id,
					'pfoid'=>$this->prefixPfo
                ), null, '&amp;');
                JHtml::script(JUri::root()."index.php?{$q}"); 
                
                // Include CSS
                $qcss = http_build_query(array(
                    'option'=>'com_jvportfolio',
                    'task'=>'items.buildCss',
                    'skinextend'=>$this->mparams->get('exeffect', 0)
                ), null, '&amp;');
                JHtml::stylesheet(JUri::root()."index.php?{$qcss}");
            } 
		} else {
			$this->params->def('page_heading', JText::_('COM_JVPORTFOLIO_DEFAULT_PAGE_TITLE'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}    
	}    
    	
}
