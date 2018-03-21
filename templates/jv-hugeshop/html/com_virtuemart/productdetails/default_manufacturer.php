<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @version $Id: default_manufacturer.php 8702 2015-02-14 15:28:56Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
<span class="manufacturer">
	<?php
	$i = 1;

	$mans = array();
	// Gebe die Hersteller aus
	foreach($this->product->manufacturers as $manufacturers_details) {

		//Link to products
		$link = JRoute::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturers_details->virtuemart_manufacturer_id. '&tmpl=component', FALSE);
		$name = $manufacturers_details->mf_name;

		// Avoid JavaScript on PDF Output
		if (strtolower(vRequest::getCmd('output')) == "pdf") {
			$mans[] = JHtml::_('link', $link, $name);
		} else {
			$mans[] = '<a class="link-modal"  href="'.$link .'">'.$name.'</a>';
		}
	}
	echo implode(', ',$mans);
	?>
</span>