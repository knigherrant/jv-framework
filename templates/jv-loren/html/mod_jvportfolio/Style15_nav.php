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
$mfetch = $params->get('mfetch', 'scroll');
if (strcmp($mfetch,'none')) {
?>
    <div class="page-number text-center">
        <?php if(!strcmp($mfetch,'button')):?>
        <a class="btn btn-outline btn-md btn-dark load-more"><?php echo JText::_('TPL_LOAD_MORE')?></a>
        
        <?php endif;?>
        <?php if(!strcmp($mfetch,'nav')):?>
        <div data-nav="" class=""></div>
        <?php endif;?>
    </div> <!-- and page-number -->
<div class="navigation"><a href="index.php?page=2"></a></div>
<?php } ?>