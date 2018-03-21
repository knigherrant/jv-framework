<?php
/**
 * @version     1.0.0
 * @package     com_jvportfolio
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldEffect extends JFormField
{
    /**
     * The form field type.
     *
     * @var        string
     * @since    1.6
     */
    protected $type = 'effect';

    /**
     * Method to get the field input markup.
     *
     * @return    string    The field input markup.
     * @since    1.6
     */
    protected function getInput()
    {
        $data = array(
            array('value'=>'', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_NONE')),    
            array('value'=>'bounce', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_BOUNCE')),    
            array('value'=>'flash', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_FLASH')),    
            array('value'=>'pulse', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_PULSE')),    
            array('value'=>'rubber-band', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_RUBBERBAND')),    
            array('value'=>'shake', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_SHAKE')),    
            array('value'=>'swing', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_SWING')),    
            array('value'=>'tada', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_TADA')),    
            array('value'=>'wobble', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_WOBBLE')),    
            array('value'=>'bounceIn', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_BOUNCEIN')),    
            array('value'=>'bounceInDown', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_BOUNCEINDOWN')),    
            array('value'=>'bounceInLeft', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_BOUNCEINLEFT')),    
            array('value'=>'bounceInRight', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_BOUNCEINRIGH')),    
            array('value'=>'bounceInUp', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_BOUNCEINUP')),    
            array('value'=>'fadeIn', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_FADEIN')),    
            array('value'=>'fadeInDown', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_FADEINDOWN')),    
            array('value'=>'fadeInLeft', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_FADEINLEFT')),    
            array('value'=>'fadeInRight', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_FADEINRIGHT')),    
            array('value'=>'fadeInUp', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_FADEINUP')),    
            array('value'=>'flip', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_FLIP')),    
            array('value'=>'flipInX', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_FLIPINX')),    
            array('value'=>'flipInY', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_FLIPINY')),    
            array('value'=>'lightSpeedIn', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_LIGHTSPEEDIN')),    
            array('value'=>'rollIn', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ROLLIN')),    
            array('value'=>'rotateIn', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ROTATEIN')),    
            array('value'=>'rotateInDownLeft', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ROTATEINDOWNLEFT')),    
            array('value'=>'rotateInDownRight', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ROTATEINDOWNRIGHT')),    
            array('value'=>'rotateInUpLeft', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ROTATEINUPLEFT')),    
            array('value'=>'rotateInUpRight', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ROTATEINUPRIGHT')),    
            array('value'=>'slide-in-down', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ROTATEINDOWN')),    
            array('value'=>'slide-in-left', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_SLIDEINLEFT')),    
            array('value'=>'slide-in-right', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_SLIDEINRIGHT')),    
            array('value'=>'slide-in-up', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_SLIDEINUP')),    
            array('value'=>'zoomIn', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ZOOMIN')),    
            array('value'=>'zoomInDown', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ZOOMINDOWN')),    
            array('value'=>'zoomInLeft', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ZOOMINLEFT')),    
            array('value'=>'zoomInRight', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ZOOMINRIGHT')),    
            array('value'=>'zoomInUp', 'text'=>JText::_('COM_JVPORTFOLIO_CONFIGURATION_MENU_ITEM_EFFECT_ZOOMINUP'))    
        );
        
        return JHtml::_('select.genericlist',$data, $this->name, "class='{$this->class}'", 'value', 'text', $this->value);
    }
}