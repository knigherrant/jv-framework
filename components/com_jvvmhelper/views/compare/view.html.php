<?php
/**
 # com_jvvmhelper - JV VM Helper
 # @version		1.0.0
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2015 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Metikaccmgr.
 */
class JVVMHelperViewCompare extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;
    protected $params;

    /**
     * Display the view
     */
    public function display($tpl = null) {
	$app = JFactory::getApplication();
	$this->params = $app->getParams();	
        $productid = jvmLibs::getCompare();
        $this->items 		= array();
        $model = VmModel::getModel('product');
        if (!class_exists('VmImage')) require(VMPATH_ADMIN . DS . 'helpers' . DS . 'image.php');
        
        $doc = JFactory::getDocument();
        JHtml::_('Jquery.framework');
        $doc->addStyleSheet(JUri::root().'components/com_jvvmhelper/assets/css/jvcompare.css');
        $doc->addScript(JUri::root().'components/com_jvvmhelper/assets/js/jvvmhelper.js');
        foreach ($productid as $pid) {
            $ratingModel = VmModel::getModel('ratings');
            $this->showRating = $ratingModel->showRating();
            $model->withRating = $this->showRating;
            $product = $model->getProduct($pid,TRUE,TRUE,TRUE);
            $model->addImages($product);
            if (VmConfig::get('show_manufacturers', 1) && !empty($product->virtuemart_manufacturer_id)) {
                    $manModel = VmModel::getModel('manufacturer');
                    $mans = array();
                    // Gebe die Hersteller aus
                    foreach($product->virtuemart_manufacturer_id as $manufacturer_id) {
                            $mans[] = $manModel->getManufacturer( $manufacturer_id );
                    }
                    $product->manufacturers = $mans;
            }
            $this->items[$pid] = $product;
        }
        if($this->items){
            $currency = CurrencyDisplay::getInstance( );
            $this->assignRef('currency', $currency);
        }
        $this->_prepareDocument();
        parent::display($tpl);
    }

    /**
     * Prepares the document
     */
    protected function _prepareDocument() {
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $title = null;

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('COM_JVVMHELPER_TITLE'));
        }
        $title = $this->params->get('page_title', '');
        if (empty($title)) {
            $title = $app->getCfg('sitename');
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
        }
        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }

}