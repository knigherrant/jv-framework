<?php
/**
 *
 * Show the products in a category
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @author Max Milbers
 * @todo add pagination
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 8715 2015-02-17 08:45:23Z Milbo $
 */

defined ('_JEXEC') or die('Restricted access');
 JHtml::_('formbehavior.chosen', 'select');
?>

<div class="category-view pd-content"> 
	<?php
	$js = "
	jQuery(document).ready(function () {
		function setCookie(cname,cvalue,exdays){
			var d = new Date();
			d.setTime(d.getTime()+(exdays*24*60*60*1000));
			var expires = 'expires='+d.toGMTString();
			document.cookie = cname + '=' + cvalue + '; ' + expires + ';path=/';
		}
		function getCookie(cname){
			var name = cname + '=';
			var ca = document.cookie.split(';');
			for(var i=0; i<ca.length; i++) 
			  {
			  var c = ca[i].trim();
			  if (c.indexOf(name)==0) return c.substring(name.length,c.length);
			  }
			return '';
		}
		jQuery('.list-view a').each(function(){
			var el = jQuery(this),
				a = el.parent('li'),
				b = el.parents('.browse-view'),
				c  = el.data('display'),
				d = jQuery('.list-view li');

				el.click(function(){
					d.removeClass('active');
					a.addClass('active');
					if (c == 'gird') {
						b.removeClass('vmlist');
						setCookie('listing','',1);
					}
					if (c == 'list') {
						b.addClass('vmlist');
						setCookie('listing','list',1);
					}
				});
		});
		jQuery('.orderlistcontainer').hover(
			function() { jQuery(this).find('.orderlist').stop().show()},
			function() { jQuery(this).find('.orderlist').stop().hide()}
		);
	});
	";
	vmJsApi::addJScript('vm.hover',$js);
	$listing = "";
	if (isset ($_COOKIE['listing'])) {$listing = $_COOKIE['listing'];}
	// Show child categories
	if (VmConfig::get ('showCategory') and empty($this->keyword)) {
		if (!empty($this->category->haschildren)) {
			// Calculating Categories Per Row
			$categories_per_row = VmConfig::get ( 'categories_per_row', 3 );
			echo ShopFunctionsF::renderVmSubLayout('categories',array('categories'=>$this->category->children, 'categories_per_row' => $categories_per_row, 'class' => 'pb-60' ));

		}
	}

	if($this->showproducts){
	?>
	<div class="browse-view <?php echo ($listing)?"vm".$listing:'';?>">
		<?php
		if (!empty($this->keyword)) {
			//id taken in the view.html.php could be modified
			$category_id  = vRequest::getInt ('virtuemart_category_id', 0); ?>

			<form action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=category&virtuemart_category_id=0&limitstart=0', FALSE); ?>" method="get">
				<!--BEGIN Search Box -->
				<div class="virtuemart_search input-group">
					<?php echo $this->searchcustom ?>
					<?php echo $this->searchCustomValues ?>
					<input name="keyword" class="form-control" type="text" size="20" value="<?php echo $this->keyword ?>"/>
					<span class="input-group-btn">
						<input type="submit" value="<?php echo vmText::_ ('COM_VIRTUEMART_SEARCH') ?>" class="btn btn-primary" onclick="this.form.keyword.focus();"/>
					</span>
				</div>
				<input type="hidden" name="search" value="true"/>
				<input type="hidden" name="view" value="category"/>
				<input type="hidden" name="option" value="com_virtuemart"/>
				<input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>

			</form>
			<!-- End Search Box -->
		<?php  } ?>

		<?php if (empty($this->keyword) and !empty($this->category) and !empty($this->category->category_description)) {
		?>
		<div class="category_description"><?php echo $this->category->category_description; ?></div>
		<?php
		} ?>

		<div class="list-header clearfix">
			<div class="vm-results pull-left"><?php echo $this->vmPagination->getResultsCounter ();?></div>
			<ul class="list-view list-unstyled pull-right">
				<li class="<?php echo ($listing == 'list')?'active':'';?>"><a href="javascript:void(0);" data-display="list"><i class="fa fa-th-list"></i></a></li>
				<li class="<?php echo ($listing != 'list')?'active':'';?>"><a href="javascript:void(0);" data-display="gird"><i class="fa fa-th"></i></a></li>
				
			</ul>
			<ul class="list-sort pull-right  list-unstyled">
				<li>
					<?php echo $this->orderByList['orderby']; ?>
				</li>
				<li><?php echo $this->orderByList['manufacturer']; ?></li>
			</ul>
		</div>
		<!-- End list-header -->

		<?php
		if (!empty($this->products)) {
			$products = array();
			$products[0] = $this->products;
			echo shopFunctionsF::renderVmSubLayout($this->productsLayout,array('products'=>$products,'currency'=>$this->currency,'products_per_row'=>$this->perRow,'showRating'=>$this->showRating));
			?>
			<div class="pagination-wrap clearfix"><?php echo $this->vmPagination->getPagesLinks (); ?></div>
		<?php
		} elseif (!empty($this->keyword)) {
			echo vmText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
		}
		?>

		
	</div>
	<?php } ?>
</div>

<?php
$j = "Virtuemart.container = jQuery('.category-view');
Virtuemart.containerSelector = '.category-view';";
vmJsApi::addJScript('ajaxContent',$j);
?>
<!-- end browse-view -->