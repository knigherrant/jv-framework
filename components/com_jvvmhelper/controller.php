<?php
/**
 * com_jvvmhelper - JV VM Helper
 * @version		1.0.0
 * ------------------------------------------------------------------------
 * author    Open Source Code Solutions Co
 * copyright Copyright (C) 2015 phpkungfu.club. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 * Websites: http://www.phpkungfu.club
 * Technical Support:  http://www.phpkungfu.club/my-tickets.html
 *------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class JVVMHelperController extends JControllerLegacy
{
    public function addCompare(){
        $input = JFactory::getApplication()->input;
        $pid = $input->getInt('product_id');
        $model = VmModel::getModel('product');
        $product = $model->getProduct($pid,TRUE,TRUE,TRUE);
        if($product->virtuemart_product_id) $message = jvmLibs::addCompare($pid);
        $catid = $input->getInt('catid', $product->virtuemart_category_id);
        $shop = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$catid.'&Itemid='.$input->getInt('Itemid'), false); 
        ob_start();
        ?>
            <div class="jvPopup">         
                <div class="jvPopup_message bg-primary">
                        <h3><?php echo $product->product_name; ?></h3>
                        <div><?php echo jvmLibs::msgCompare((int)$message); ?></div> 
                </div> 
                <span class="jvPopup_continueshop"><a href="<?php echo $shop; ?>" class="btn btn-primary"><?php echo JText::_('PLG_SYSTEM_JVVM_CONTINUE_SHOP'); ?></a></span>
                <span class="jvPopup_viewcompare"><a href="<?php echo jvmLibs::buildRoute('compare'); ?>" class="btn btn-primary"><?php echo JText::_('PLG_SYSTEM_JVVM_CONTINUE_VIEWCOMPARE'); ?></a></span>
            </div>
        <?php
        $html = ob_get_clean();
        $return = array(
            'ok' => $message,
            'msg' => $html,
        );
        echo json_encode($return);
        exit;
    }
    
    public function addWishlist(){
        $user = JFactory::getUser();
        if($user->id){
            $input = JFactory::getApplication()->input;
            $pid = $input->getInt('product_id');
            $model = VmModel::getModel('product');
            $product = $model->getProduct($pid,TRUE,TRUE,TRUE);
            if($product->virtuemart_product_id) $message = jvmLibs::addWishlist($pid);
            $catid = $input->getInt('catid', $product->virtuemart_category_id);
            $shop = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$catid.'&Itemid='.$input->getInt('Itemid'), false);
        }
        ob_start();
        ?>
            <div class="jvPopup">
                <?php if($user->id) {?>
                    <div class="jvPopup_message bg-primary">
                            <h3><?php echo $product->product_name; ?></h3>
                            <div><?php echo jvmLibs::msgWishlist((int)$message); ?></div> 
                    </div> 
                    <span class="jvPopup_continueshop"><a href="<?php echo $shop; ?>" class="btn btn-primary"><?php echo JText::_('PLG_SYSTEM_JVVM_CONTINUE_SHOP'); ?></a></span>
                    <span class="jvPopup_viewWishlist"><a href="<?php echo jvmLibs::buildRoute('wishlist'); ?>" class="btn btn-primary"><?php echo JText::_('PLG_SYSTEM_JVVM_CONTINUE_VIEWWISHLIST'); ?></a></span>
                <?php }else{ ?>
                    <div class="jvPopup_message bg-primary">
                            <div><?php echo jvmLibs::msgWishlist($message = 3); ?></div> 
                    </div> 
                <?php } ?>
            </div>
        <?php
        $html = ob_get_clean();
        $return = array(
            'ok' => $message,
            'msg' => $html,
        );
        echo json_encode($return);
        exit;
    }
    
    
    public function removeCompare(){
        $input = JFactory::getApplication()->input;
        $pid = $input->getInt('product_id');
        $model = VmModel::getModel('product');
        $product = $model->getProduct($pid,TRUE,TRUE,TRUE);
        $return = array('ok'=>false);
        if($product->virtuemart_product_id){
            $return['ok'] = jvmLibs::removeCompare($pid);
        }
        echo json_encode($return);
        exit;
    }
    
    public function removeWishlist(){
        $input = JFactory::getApplication()->input;
        $pid = $input->getInt('product_id');
        $model = VmModel::getModel('product');
        $product = $model->getProduct($pid,TRUE,TRUE,TRUE);
        $return = array('ok'=>false);
        if($product->virtuemart_product_id){
            $return['ok'] = jvmLibs::removeWishlist($pid);
        }
        echo json_encode($return);
        exit;
    }
    
    
}

