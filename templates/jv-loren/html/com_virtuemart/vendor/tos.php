<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage vendor
* @author Patrick Kohl, Max Milbers
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 2701 2011-02-11 15:16:49Z impleri $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
<div class="vendor-details-view row">
    <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="thumbnail vendor-image">
                        <?php if (!empty($this->vendor->images[0])) { ?>
                        <?php echo $this->vendor->images[0]->displayMediaThumb('',false); ?>
                        <?php
                        } ?>
                        </div>
                        <div class="bottom-border"></div>
                    </div>
                    <div class="col-sm-9 featured-box">
                        <h4 class="text-uppercase mt-0 mb-30"><?php echo vmText::_('COM_VIRTUEMART_VENDOR_TOS').$this->vendor->vendor_store_name;?></h4>
                        <?php // vendor Description
                        if(!empty($this->vendor->vendor_terms_of_service)) { ?>
                            <div class="vendor-description">
                                <?php echo $this->vendor->vendor_terms_of_service;   ?>
                            </div>
                        <?php } ?>
                        <div class="clearfix vendor-details-view-link">
                            <span class="btn btn-default"><?php echo $this->linkdetails; ?></span> &nbsp;   
                            <span class="btn btn-default"><?php echo $this->linkcontact; ?></span>
                        </div>
                    </div>
                </div>
                
    </div>
</div>