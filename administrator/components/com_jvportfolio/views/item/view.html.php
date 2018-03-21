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
 * View to edit
 */
class JvportfolioViewItem extends JViewLegacy {

    protected $state;
    protected $item;
    protected $form;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->addToolbar();
        $this->preDocument();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar() {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $user = JFactory::getUser();
        $isNew = ($this->item->id == 0);
        if (isset($this->item->checked_out)) {
            $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        } else {
            $checkedOut = false;
        }
        $canDo = JvportfolioHelper::getActions();

        JToolBarHelper::title(JText::_('COM_JVPORTFOLIO_TITLE_ITEM'), 'new');

        // If not checked out, can save the item.
        if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create')))) {

            JToolBarHelper::apply('item.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::save('item.save', 'JTOOLBAR_SAVE');
        }
        if (!$checkedOut && ($canDo->get('core.create'))) {
            JToolBarHelper::custom('item.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
        }
        // If an existing item, can save to a copy.
        if (!$isNew && $canDo->get('core.create')) {
            JToolBarHelper::custom('item.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
        }
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('item.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('item.cancel', 'JTOOLBAR_CLOSE');
        }
    }
    
    public function preDocument(){
        
        $document = JFactory::getDocument();
        $this->assets = JUri::base().'components/com_jvportfolio/assets';
       
       
        JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
        JHtml::_('behavior.tooltip');
        JHtml::_('behavior.modal');
        JHtml::_('behavior.formvalidation');
        JHtml::_('formbehavior.chosen', 'select');
        JHtml::_('behavior.keepalive');
        JHtml::_('jquery.ui', array('core', 'sortable'));
        
        // Import JS
        JText::script('JGLOBAL_VALIDATION_FORM_FAILED');
        $document->addScript("{$this->assets}/js/com_jvportfolio.edit.js");
        $document->addScript("{$this->assets}/js/jquery.tmpl.min.js");
        $document->addScript(JUri::base()."index.php?option=com_jvportfolio&task=item.buildJS");
        
        
        // Import CSS                                                    
        $document->addStyleSheet("{$this->assets}/css/jvportfolio.css");
        
        
    }

}
