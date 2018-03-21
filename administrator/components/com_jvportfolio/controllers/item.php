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

jimport('joomla.application.component.controllerform');

/**
 * Item controller class.
 */
class JvportfolioControllerItem extends JControllerForm
{

    function __construct() {
        $this->view_list = 'items';
        parent::__construct();
    }
    
    function buildJS(){
        header('Content-Type: text/javascript');
        $cparams = JComponentHelper::getParams('com_jvportfolio');
        $mfolder = $cparams->get('mfolder', 'demo/portfolio');
        $uid = JFactory::getUser()->id;
        $media = JUri::base()."index.php?option=com_media&view=images&tmpl=component&asset=com_jvportfolio&author={$uid}&folder={$mfolder}&fieldid=jform_image";
        $bmedia = JUri::root();
        echo "
        window.JV = jQuery.extend(window.JV, {
            imedia: '{$media}',
            bmedia: '{$bmedia}'
        });
        ";
        
        JFactory::getApplication()->close();
    }

}