<?php
/**
 * @version     1.0.0
 * @package     com_portfolio
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Portfolio.
 */
class JvportfolioViewItems extends JViewLegacy
{
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
        
        $this->state		= $this->get('State');
        $data 				= $this->get('Items');
        $this->items		= $data['items'];
		$this->tags			= $data['tags'];
        if(isset($data['cate'])){
            $this->cate     = $data['cate'];
        }
        $this->pagination	= $this->get('Pagination');
        $this->params       = $app->getParams('com_jvportfolio');
        
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {;
            throw new Exception(implode("\n", $errors));
        }
        $this->assets = JUri::root().'components/com_jvportfolio/assets';
        $this->_prepareDocument();
        parent::display($tpl);
	}
          
    /**
     * Prepares the document
     */
    protected function _prepareDocument()
    {
        $app    = JFactory::getApplication();
        $menus    = $app->getMenu();

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();
        if($menu)
        {
            $this->mparams = $menu->params;
        }
    }    
    	
}
