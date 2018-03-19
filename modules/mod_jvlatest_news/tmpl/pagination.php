<?php
/**
 * @version		$Id: pagination.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

function jvlastnew_pagination_list_footer($list)
{
	$html = "<div class=\"list-footer\">\n";

	$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
	$html .= $list['pageslinks'];
	$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";

	$html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div>";

	return $html;
}

function jvlastnew_pagination_list_render($list)
{
	// Initialize variables
	$html = "<ul class=\"jvlatestnews-pagination\">";
	$html .= $list['start']['data'];
	$html .= $list['previous']['data'];

	foreach( $list['pages'] as $page )
	{
		$html .= $page['data'];
	}

	$html .= $list['next']['data'];
	$html .= $list['end']['data'];
	$html .= "</ul>";
	return $html;
}

function jvlastnew_pagination_item_active(&$item) {
	return "<li><a class=\"jvlatestnews-link".(((int) $item->text == 0)? ' '.strtolower($item->text) : '')."\" href=\"".$item->link."\" title=\"".JText::_($item->text)."\">".JText::_($item->text)."</a></li>";
}

function jvlastnew_pagination_item_inactive(&$item) {
	$itemId = JRequest::getInt('Itemid');
    return "<li><a class=\"jvlatestnews-link ".($item->link == '' && (!in_array($item->text, array('Start', 'Next', 'Prev', 'End'))) ? 'jvlatestnews-pagination-selected' : '')."".(((int) $item->text == 0)? ' '.strtolower($item->text) : '')."\" href=\"".JRoute::_("&mid={$item->modid}&Itemid={$itemId}")."\" title=\"".JText::_($item->text)."\">".JText::_($item->text)."</a></li>";
}
?>