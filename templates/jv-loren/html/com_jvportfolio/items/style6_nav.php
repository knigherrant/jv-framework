<?php  
/**
 * @version     1.0.0
 * @package     com_portfolio
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
 */
// no direct access
defined('_JEXEC') or die;    
$mfetch = $this->mparams->get('mfetch', 'scroll');
?>
    <div class="page-number text-center">
        <?php if(!strcmp($mfetch,'button')):?>
        <div class="page-button simple-pagination">
        	<a class="btn btn-primary load-more"><i class="fa fa-angle-down"></i></a>
        </div>		
        <?php endif;?>
        <?php if(!strcmp($mfetch,'nav')):?>
        <div data-nav="" class=""></div>
        <?php endif;?>
    </div> <!-- and page-number -->
<div class="navigation"><a href="index.php?page=2"></a></div>