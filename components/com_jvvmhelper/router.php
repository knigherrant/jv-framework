<?php
/**
 # com_jvvmhelper - JV VM Helper
 # @version		1.0.0
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2015 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;
/**
 * @param	array	A named array
 * @return	array
 */
function JVVMHelperBuildRoute(&$query)
{
    $segments = array();
    if(isset($query['view'])){
        $segments[] = $query['view'];
        unset( $query['view'] );
    }
    return $segments;
}

/**
 * @param	array	A named array
 * @param	array
 *
 * Formats:
 *
 */
function JVVMHelperParseRoute($segments)
{
	$vars = array();
        $vars['view'] = $segments[0];   
	return $vars;
}
