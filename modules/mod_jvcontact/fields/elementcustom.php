<?php
/**
 # Module		JV Contact
 # @version		3.0.1
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright © 2008-2012 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.form.formfield');
class JFormFieldElementcustom extends JFormField {

	protected $type = 'elementcustom';

	public function getInput() {
		
		$customfields = $this->form->getValue('customfield','params');
		
		$html = '<div style="overflow:hidden;float:left;width:292px">
		<div>
			<table width="100%">
				<tr>
					<td>{headertext}</td>
					<td>{footertext}</td>
					<td>{thankyou}</td>
				</tr>
				<tr>
					<td>{submitbutton}</td>
					<td>{moreinfo}</td>
					<td>{coypmail}</td>
				</tr>
				<tr>
					<td>{social}</td>
					<td>{captcha}</td>
					<td>{map}</td>
				</tr>
				<tr>
					<td>{message}</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				
			</table>
			
		</div>
		<div style="margin-top:10px">
			<table width="100%">
		';
			if($customfields) foreach($customfields as $field){
				$html .= '<tr><td>{lb'.$field['name'].'}</td>';
				$html .= '<td>{inp'.$field['name'].'}</td></tr>';
			}
			
		$html .="</table></div></div>";
		
		return $html;
		
	}
	
}