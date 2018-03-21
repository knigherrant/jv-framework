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
?>
<div class="portfolioSort ">
    <?php echo JvportfolioFrontendHelper::getCtrlSort($this->mparams->get('sort',array()))?> 
</div>