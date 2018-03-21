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

jimport('joomla.form.formfield');

if( !class_exists( 'JvportfolioHelper' ) ) {

	require_once( JPATH_ADMINISTRATOR . '/components/com_jvportfolio/helpers/jvportfolio.php' );

}

class JFormFieldExtrafields extends JFormField {

	protected $type = "extrafields";

	public function getLabel() {

		return "";
	}

	public function getInput() {

		$data 	= JComponentHelper::getParams( 'com_jvportfolio' );
		$groups = $data->get( 'jvpfo_assets', false);
		
		if( !$groups ) { return JText::_( 'COM_JVPORTFOLIO_NO_GROUPS' ); }

		$groups 	= json_decode( $groups );
		$isGroups 	= $groups && is_array( $groups );

		if( !$isGroups ) { return JText::_( 'COM_JVPORTFOLIO_NO_GROUPS' ); }

		$gid 		= "";
		$controls	= "";
		
		if( $this->value && ( $controls = json_decode( $this->value, true ) ) ) {

			$gid 	= array_keys( $controls );
			$gid 	= array_shift( $gid );

		}

		$gControls 	= JvportfolioHelper::gControls( $groups );
		$groups 	= JvportfolioHelper::gExtras( $groups );

		ob_start();

		require_once( dirname( __FILE__ ) . '/extrafields_form.php' );

		return ob_get_clean();
	}
}