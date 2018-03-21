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

class JFormFieldCustomlayout extends JFormField {

	protected $type = "customlayout";

	public function getLabel() {
		
		return "";

	}

	public function getInput() {
		
		JHtml::_( 'behavior.framework' );
		JHtml::_( 'jquery.framework' );
		
		$jsfrontend = JUri::root() . 'components/com_jvportfolio/assets/js/';
		JHtml::_( 'script', "{$jsfrontend}modernizr.custom.min.js");                                    
		JHtml::_( 'script', "{$jsfrontend}jquery.shuffle.js");
		
		$assets_backend = JUri::root() . 'administrator/components/com_jvportfolio/assets/';
		JHtml::_( 'script', "{$assets_backend}js/jquery.tmpl.min.js" );
		JHtml::_( 'script', "{$assets_backend}js/pfo.menu.js" );
		JHtml::stylesheet( "{$assets_backend}css/menu.css" );
		
		ob_start();
		
		require_once( __DIR__ . '/customlayout_form.php' );
		
		return ob_get_clean();

	}
}