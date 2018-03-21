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

class JFormFieldPfoAssets extends JFormField {

	protected $type = "pfoassets";

	public function getLabel() {

		
		JHtml::_( 'behavior.framework' );
		JHtml::_( 'jquery.framework' );

		$assest = JUri::base( true ) . '/components/com_jvportfolio/assets/';
		$doc = JFactory::getDocument();
		$doc->addScript( "{$assest}js/jquery.tmpl.min.js" );

		ob_start();
		
		require_once( dirname( __FILE__ ) . '/pfoassets_form.php' );

		return ob_get_clean();

	}

	public function getInput() {
		return "";
	}
}