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
<div class="col-md-12">
                            
    <div class="page-number">
        <?php if(!strcmp($mfetch,'button')):?>
            <div class="text-center"><a class="btn btn-default btn-sm load-more" title="<?php echo JText::_('COM_JVPORTFOLIO_VIEW_MORE')?>"><i class="fa fa-refresh"></i> <?php echo JText::_('COM_JVPORTFOLIO_VIEW_MORE')?></a></li></div>
        <?php endif;?>
        <?php if(!strcmp($mfetch,'nav')):?>
        <div data-nav="" class=""></div>
        <?php endif;?>
    </div> <!-- and page-number -->

</div>
<div class="navigation"><a href="index.php?page=2"></a></div>
<?php } ?>