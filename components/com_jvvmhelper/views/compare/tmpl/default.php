<?php
/**
 # com_jvvmhelper - JV VM Helper
 # @version		1.0.0
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2015 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;


?>
<div id="jvmLibsList">    
<?php if( $this->items ) { 
    $config = jvmLibs::getConfig();
    $ItemidStr = '';
    $Itemid = shopFunctionsF::getLastVisitedItemId();
    if(!empty($Itemid)){
            $ItemidStr = '&Itemid='.$Itemid;
    }
    ?>

<div class="table-responsive">
<table class="table <?php echo $config->get('jstyle','table-condensed');?>">
  <thead>
    <tr>
      <th>#</th>
      <?php if(jvmLibs::isShow('name')){ ?><th><?php echo JText::_('COM_JVVMHELPER_PRODUCT_NAME'); ?></th><?php } ?>
      <?php if(jvmLibs::isShow('image')){ ?><th><?php echo JText::_('COM_JVVMHELPER_PRODUCT_IMAGE'); ?></th><?php } ?>
      <?php if(jvmLibs::isShow('rating')){ ?><th><?php echo JText::_('COM_JVVMHELPER_PRODUCT_RATING'); ?></th><?php } ?>
      <?php if(jvmLibs::isShow('price')){ ?><th><?php echo JText::_('COM_JVVMHELPER_PRODUCT_PRICE'); ?></th><?php } ?>
      <?php if(jvmLibs::isShow('desc')){ ?><th><?php echo JText::_('COM_JVVMHELPER_PRODUCT_DESC'); ?></th><?php } ?>
      <?php if(jvmLibs::isShow('manu')){ ?><th><?php echo JText::_('COM_JVVMHELPER_PRODUCT_MANUFACTURE'); ?></th><?php } ?>
      <?php if(jvmLibs::isShow('stock')){ ?><th><?php echo JText::_('COM_JVVMHELPER_PRODUCT_AVAILABLE'); ?></th><?php } ?>
      <?php if(jvmLibs::isShow('sku')){ ?><th><?php echo JText::_('COM_JVVMHELPER_PRODUCT_SKU'); ?></th><?php } ?>
      <?php if(jvmLibs::isShow('weight')){ ?><th><?php echo JText::_('COM_JVVMHELPER_PRODUCT_WEIGHT'); ?></th><?php } ?>
      <th><?php echo JText::_('COM_JVVMHELPER_PRODUCT_ACTION'); ?></th>
    </tr>
  </thead>

  <tbody>
     <?php 
        $count=0;
        foreach ($this->items as $product){ 
        if(!$product)            continue;
        $count++;
     ?>
    <tr class="jrow">
      <th scope="row"><?php echo $count;?></th>
      <?php if(jvmLibs::isShow('name')){ ?><td><a href="<?php echo $product->link.$ItemidStr; ?>"><?php echo $product->product_name; ?></a></td><?php } ?>
      <?php if(jvmLibs::isShow('image')){ ?>
        <td>  
            <?php if (!empty($product->images)) { ?>
               <a title="<?php echo $product->product_name ?>" href="<?php echo $product->link.$ItemidStr; ?>">
						<?php
						echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
						?>
					</a>
					<?php } ?>
          </td>
      <?php } ?>
      <?php if(jvmLibs::isShow('rating')){ ?><td><?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$this->showRating, 'product'=>$product)); ?></td><?php } ?>
      <?php if(jvmLibs::isShow('price')){ ?><td><?php echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$product,'currency'=>$this->currency)); ?></td><?php } ?>
      <?php if(jvmLibs::isShow('desc')){ ?>
        <td>
          <?php if (!empty($product->product_desc)) { ?>
              <div class="product-description">
              <?php /** @todo Test if content plugins modify the product description */ ?>
              <?php echo $product->product_desc; ?>
              </div>
          <?php } ?>
        </td>
      <?php } ?>
      <?php if(jvmLibs::isShow('manu')){ ?>
        <td>
          <?php
              $i = 1;
              $mans = array();
              // Gebe die Hersteller aus
              if(isset($product->manufacturers)) foreach($product->manufacturers as $manufacturers_details) {
                      //Link to products
                      $link = JRoute::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturers_details->virtuemart_manufacturer_id. '&tmpl=component', FALSE);
                      $name = $manufacturers_details->mf_name;
                      // Avoid JavaScript on PDF Output
                      //if (!$this->writeJs) {
                              //$mans[] = JHtml::_('link', $link, $name);
                      //} else {
                              //$mans[] = '<a class="manuModal" rel="{handler: \'iframe\', size: {x: 700, y: 850}}" href="'.$link .'">'.$name.'</a>';
                      //}
                      $mans[] = $name;
              }
              echo implode(', ',$mans);
              ?>
        </td>
      <?php } ?>
      <?php if(jvmLibs::isShow('stock')){ ?>
        <td><?php echo ($product->product_in_stock < 1)? JText::_('COM_JVVMHELPER_OUT_STOCK') : JText::_('COM_JVVMHELPER_IN_STOCK') . $product->product_in_stock . JText::_('COM_JVVMHELPER_ITEMS'); ?></td>
      <?php } ?>
      <?php if(jvmLibs::isShow('sku')){ ?>
        <td><?php echo $product->product_sku; ?></td>
      <?php } ?>
      <?php if(jvmLibs::isShow('weight')){ ?>
        <td><?php echo $product->product_weight; ?> <?php echo $product->product_weight_uom; ?></td>
      <?php } ?>
      <td><div class="jv-remove"> <a class="removeCompare" data-id="<?php echo $product->virtuemart_product_id; ?>" href="javascript:void(0)"><?php echo JText::_('COM_JVVMHELPER_REMOVE');?></a></div></td>  
    </tr>
    <?php } ?>

  </tbody>
</table>
</div>

    
<?php }else{ ?>
    <?php echo JText::_('COM_JVVMHELPER_LIST_EMPTY');?>
<?php } ?>

</div>