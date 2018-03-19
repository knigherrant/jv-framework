<?php

/**
 * @version     1.0.0
 * @package     com_jvss
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PHPKungfu <info@phpkungfu.club> - http://www.joomalvi.com
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class JvssViewItem extends JViewLegacy {

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
        
        $tpl = JRequest::getVar( 'tmpl', false );
        
        if( !$tpl ) { return false; }
        
        parent::display($tpl);
    }
}
