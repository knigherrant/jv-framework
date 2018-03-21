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

/**
 * Jvportfolio helper.
 */
class JvportfolioHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        JHtmlSidebar::addEntry(
			JText::_('COM_JVPORTFOLIO_TITLE_ITEMS'),
			'index.php?option=com_jvportfolio&view=items',
			$vName == 'items'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_jvportfolio';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

    public static function gExtras( $data = array() ) {

        $d = array( '' => '' );

        foreach( $data as $item ) {

            $d[ $item->index ] = $item->name;

        }
        return $d;
    }
    public static function gControls( $data = array() ) {

        $d = array();

        foreach( $data as $item ) {

            $d[ $item->index ] = $item->controls;

        }
        return $d;
    }
}
