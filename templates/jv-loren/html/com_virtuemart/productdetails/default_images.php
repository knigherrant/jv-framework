<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_images.php 8508 2014-10-22 18:57:14Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
	$imageJS = '
	jQuery(document).ready(function() {
		Virtuemart.updateImageEventListeners();
	});
	Virtuemart.updateImageEventListeners = function() {
		function bImage(view){
			view.find(\'.vmFullImage\').each(function(){
				var el = jQuery(this), thumb = view.find(".additional-images-wrapper");
				el.owlCarousel({
					direction : jQuery("body").hasClass( "rtl" )?\'rtl\':\'ltr\',
				    singleItem:true,
				   	pagination:false,
				    autoHeight:true,
				    afterAction : syncPosition
			    });	
	      		thumb.owlCarousel({
	      			direction : jQuery("body").hasClass( "rtl" )?\'rtl\':\'ltr\',
				    items : 5,
				    itemsDesktop      : [1199,5],
				    itemsDesktopSmall : [979,5],
				    itemsTablet       : [768,5],
				    itemsMobile       : [479,4],
				    pagination:false,
				    responsiveRefreshRate : 100,
				    navigation: true,
				    navigationText: ["<i class=\"fa fa-angle-left\"></i>","<i class=\"fa fa-angle-right\"></i>"],	
				    afterInit : function(el){
				      el.find(".owl-item").eq(0).addClass("synced");
				    }
			  	});

			  	function syncPosition(el){
				    var current = this.currentItem;
				    thumb
				      .find(".owl-item")
				      .removeClass("synced")
				      .eq(current)
				      .addClass("synced")
				    if(thumb.data("owlCarousel") !== undefined){
				      center(current)
				    }
				  }
		 
			  thumb.on("click", ".owl-item", function(e){
			    e.preventDefault();
			    var number = jQuery(this).data("owlItem");
			    el.trigger("owl.goTo",number);
			  });
			 
			  function center(number){
			    var sync2visible = thumb.data("owlCarousel").owl.visibleItems;
			    var num = number;
			    var found = false;
			    for(var i in sync2visible){
			      if(num === sync2visible[i]){
			        var found = true;
			      }
			    }
			 
			    if(found===false){
			      if(num>sync2visible[sync2visible.length-1]){
			        thumb.trigger("owl.goTo", num - sync2visible.length+2)
			      }else{
			        if(num - 1 === -1){
			          num = 0;
			        }
			        thumb.trigger("owl.goTo", num);
			      }
			    } else if(num === sync2visible[sync2visible.length-1]){
			      thumb.trigger("owl.goTo", sync2visible[1])
			    } else if(num === sync2visible[0]){
			      thumb.trigger("owl.goTo", num-1)
			    }
			    
			  }

			});
			view.find(".popupImgProduct").each(function(){
				var el = jQuery(this);
				el.magnificPopup({
					type: \'image\',
					closeOnContentClick: true,
					closeBtnInside: false,
					fixedContentPos: true,
					mainClass: \'mfp-no-margins \',
					removalDelay: 160,
					image: {
						verticalFit: true
					},
					zoom: {
						enabled: true,
						duration: 300
					}
				});
			});
		}
		bImage(jQuery(\'.imagesProduct\'));

		jQuery(".link-modal").each(function(){
			var el = jQuery(this);
			el.magnificPopup({
				type: \'iframe\',
				mainClass: \'my-mfp-zoom-in\',
				removalDelay: 160
			});
		});
		jQuery(".related .relatedOwl").owlCarousel({
  			direction : jQuery("body").hasClass( "rtl" )?\'rtl\':\'ltr\',
		    items : 4,
		    itemsDesktop      : [1199,4],
		    itemsDesktopSmall : [979,4],
		    itemsTablet       : [768,3],
		    itemsMobile       : [479,2],
		    pagination:false,
		    navigation: true,
		    navigationText: ["<i class=\"fa fa-angle-left\"></i>","<i class=\"fa fa-angle-right\"></i>"]
	  	});
		
	}
	';
 if (!VmConfig::get('jchosen')) {
 	$imageJS .= '
	jQuery(document).ready(function (){
		jQuery(".addtocart-area select").chosen({"placeholder_text_multiple":"'.JText::_('JGLOBAL_SELECT_SOME_OPTIONS').'","placeholder_text_single":"'.JText::_('JGLOBAL_SELECT_AN_OPTION').'","no_results_text":"'.JText::_('JGLOBAL_SELECT_NO_RESULTS_MATCH').'"});
	});';
 }
 vmJsApi::addJScript('imagepopup',$imageJS);
?>


<div class="vmFullImage">
<?php
	if(!empty($this->product->images)) {
		$start_image = VmConfig::get('add_img_main', 1) ? 0 : 1;
		for ($i = 0; $i < count($this->product->images); $i++) {
			$image = $this->product->images[$i];
			?>
			<a class="vm-product-media-container-a popupImgProduct" href="<?php echo $image->file_url; ?>" title="<?php echo $image->file_title;?>">
				<?php
					echo '<img src="'.$image->file_url .'" alt="'. $image->file_title .'" >';
				?>
			</a>
		<?php
		}		
    } else {
    	?>
    	<span class="vm-product-media-container-a">
    		<img src="<?php echo $templateDir.'/images/noimage.gif'?>" alt="<?php echo $this->product->product_name ?>" >
    	</span>
    	<?php
    }
?>
</div>