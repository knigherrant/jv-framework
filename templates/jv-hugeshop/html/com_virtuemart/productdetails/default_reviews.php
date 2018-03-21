<?php
/**
 *
 * Show the product details page
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_reviews.php 8508 2014-10-22 18:57:14Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die ('Restricted access');

// Customer Reviews
$review_editable = true;
if ($this->allowRating || $this->allowReview || $this->showRating || $this->showReview) {

	$maxrating = VmConfig::get( 'vm_maximum_rating_scale', 5 );
	$ratingsShow = VmConfig::get( 'vm_num_ratings_show', 3 ); // TODO add  vm_num_ratings_show in vmConfig
	$stars = array();
	$stars2 = array();
	$showall = vRequest::getBool( 'showall', FALSE );
	$ratingWidth = $maxrating*11;
	for( $num = 0; $num<=$maxrating; $num++ ) {
		$stars[] = '
				<div title="'.(vmText::_( "COM_VIRTUEMART_RATING_TITLE" ).$num.'/'.$maxrating).'" class="ratingbox" style="margin: 0; display:inline-block;width:'. 14*$maxrating.'px;">
					<div style="width:'.(14*$num).'px">
					</div>
				</div>';
		$stars2[] = '
				<div title="'.(vmText::_( "COM_VIRTUEMART_RATING_TITLE" ).$num.'/'.$maxrating).'" class="ratingbox" style="margin: 0; display:inline-block;width:'. 14*$maxrating.'px;">
					<div style="width:'.(14*$num).'px">
					</div>
				</div>';
	}

	  echo '<div class="prodetail-review customer-reviews">';

	if ($this->rating_reviews) {
		foreach( $this->rating_reviews as $review ) {
			/* Check if user already commented */
			// if ($review->virtuemart_userid == $this->user->id ) {
			if ($review->created_by == $this->user->id && !$review->review_editable) {
				$review_editable = false;
			}
		}
	}
}

// ------------------------------------------------ Reviews List -------------------------------------------------
if ($this->showReview) {
	$ratingsModel = VmModel::getModel ('ratings');
	$rating_reviews = $ratingsModel->getReviewsByProduct($this->product->virtuemart_product_id);
	$reviews = count($rating_reviews);
	?>
	<h6 class="mt-0 mb-30 text-uppercase text-semi-bold text-size-20"><?php echo $reviews. ' '  . JText::_("TPL_REVIEW_FOR") . ' "' . $this->product->product_name ?>"</h6>
	<div class="post-block post-comments clearfix">
		<ul class="comments">
			<?php
			$i = 0;
			//$review_editable = TRUE;
			$reviews_published = 0;
			if ($this->rating_reviews) {
				foreach ($this->rating_reviews as $review) {
					?>

					<?php // Loop through all reviews
					if (!empty($this->rating_reviews) && $review->published) {
						$reviews_published++;
						?>
						<li>
							<div class="comment">
								<?php 
									$email = $review->email;
									$default = "404";
									$size = 80;
									$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
								?>
								<div class="comment-avatar"> <img src="<?php echo $grav_url; ?>" alt="<?php echo $review->name;?>" width="80" onError="this.src='<?php echo JUri::base() ?>templates/jv-hugeshop/images/avatar/default.jpg';"  /> </div>
								<div class="comment-block">
									<div class="comment-by"><strong><?php echo $review->customer ?></strong> - <span class="date"><?php echo JHtml::date ($review->created_on, JText::_('TPL_DATE_FORMAT_03')); ?></span></div>
									<?php echo $stars[(int)$review->review_rating] ?>
									<p class="comment-content"><?php echo $review->comment; ?></p>
								</div>
							</div>
						</li>
						<?php
					}
					$i++;
					if ($i == $ratingsShow && !$showall) {
						/* Show all reviews ? */
						if ($reviews_published >= $ratingsShow) {
							$attribute = array('class'=> 'details', 'title'=> vmText::_ ('COM_VIRTUEMART_MORE_REVIEWS'));
							echo '<li class="more_reviews">'.JHtml::link ($this->more_reviews, vmText::_ ('COM_VIRTUEMART_MORE_REVIEWS'), $attribute).'</li>';
						}
						break;
					}
				}

			} else {
				// "There are no reviews for this product"
				?>
				<li style="padding-left: 0;">
					<span class="step"><?php echo vmText::_ ('COM_VIRTUEMART_NO_REVIEWS') ?></span>
				</li>
				<?php
			}  ?>
		</ul>
	</div>
 <?php
}
// ------------------------------------------------ End Reviews List----------------------------------------------


// ------------------------------------------------ Reviews Form----------------------------------------------
if ($this->allowRating or $this->allowReview) {
	if ($review_editable) {
		?>
		<div class="post-block post-leave-comment">
			<form method="post"
				  action="<?php echo JRoute::_( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$this->product->virtuemart_product_id.'&virtuemart_category_id='.$this->product->virtuemart_category_id, FALSE ); ?>"
				  name="reviewForm" id="reviewform">

				<?php if($this->allowRating and $review_editable) { ?>

					<h6 class="mt-0 mb-30 text-uppercase text-semi-bold text-size-20"><?php echo vmText::_( 'COM_VIRTUEMART_WRITE_REVIEW' );
						if(count( $this->rating_reviews ) == 0) {
							?>&nbsp;<small><?php echo vmText::_( 'COM_VIRTUEMART_WRITE_FIRST_REVIEW' ) ?></small><?php
						} ?>
					</h6>
					<span class="step"><?php echo vmText::_( 'COM_VIRTUEMART_RATING_FIRST_RATE' ) ?></span>
					<div class="rating">
						<label for="vote"><?php echo $stars2[$maxrating]; ?></label>
						<input type="hidden" id="vote" value="<?php echo $maxrating ?>" name="vote">
					</div>

					<?php

					$reviewJavascript = "
					jQuery(function($) {
						var steps = ".$maxrating.";
						var parentPos= $('.rating .ratingbox').position();
						var boxWidth = $('.rating .ratingbox').width();// nbr of total pixels
						var starSize = (boxWidth/steps);
						var ratingboxPos= $('.rating .ratingbox').offset();

						jQuery('.rating .ratingbox').mousemove( function(e){
							var span = jQuery(this).children();
							var dif = e.pageX-ratingboxPos.left; // nbr of pixels
							difRatio = Math.floor(dif/boxWidth* steps )+1; //step
							span.width(difRatio*starSize);
							$('#vote').val(difRatio);
							//console.log('note = ',parentPos, boxWidth, ratingboxPos);
						});
					});
					";
					vmJsApi::addJScript( 'rating_stars', $reviewJavascript );

				}

				// Writing A Review
				if ($this->allowReview and $review_editable) {
				?>

					<?php // Show Review Length While Your Are Writing
					$reviewJavascript = "
					function check_reviewform() {

					var form = document.getElementById('reviewform');
					var ausgewaehlt = false;

						if (form.comment.value.length < ".VmConfig::get( 'reviews_minimum_comment_length', 100 ).") {
							alert('".addslashes( vmText::sprintf( 'COM_VIRTUEMART_REVIEW_ERR_COMMENT1_JS', VmConfig::get( 'reviews_minimum_comment_length', 100 ) ) )."');
							return false;
						}
						else if (form.comment.value.length > ".VmConfig::get( 'reviews_maximum_comment_length', 2000 ).") {
							alert('".addslashes( vmText::sprintf( 'COM_VIRTUEMART_REVIEW_ERR_COMMENT2_JS', VmConfig::get( 'reviews_maximum_comment_length', 2000 ) ) )."');
							return false;
						}
						else {
							return true;
						}
					}

					function refresh_counter() {
						var form = document.getElementById('reviewform');
						form.counter.value= form.comment.value.length;
					}
					";
					vmJsApi::addJScript( 'check_reviewform', $reviewJavascript ); ?>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<label><?php echo vmText::sprintf( 'COM_VIRTUEMART_REVIEW_COMMENT', VmConfig::get( 'reviews_minimum_comment_length', 100 ), VmConfig::get( 'reviews_maximum_comment_length', 2000 ) ); ?></label>
								<textarea class="form-control" title="<?php echo vmText::_( 'COM_VIRTUEMART_WRITE_REVIEW' ) ?>"
									  class="inputbox" id="comment" onblur="refresh_counter();" onfocus="refresh_counter();"
									  onkeyup="refresh_counter();" name="comment" rows="5"
									  cols="60"><?php if(!empty($this->review->comment)) {
									echo $this->review->comment;
								} ?></textarea>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<label><?php echo vmText::_( 'COM_VIRTUEMART_REVIEW_COUNT' ) ?></label>
								<input class="form-control" type="text" value="0" size="4" name="counter" maxlength="4" readonly="readonly"/>
							</div>
						</div>
					</div>
					<?php
				}

				if($review_editable and $this->allowReview) { ?>
					<div class="row">
						<div class="col-md-12">
							<input class="btn btn-primary btn-radius" type="submit" onclick="return( check_reviewform());"
							   name="submit_review" title="<?php echo vmText::_( 'COM_VIRTUEMART_REVIEW_SUBMIT' ) ?>"
							   value="<?php echo vmText::_( 'COM_VIRTUEMART_REVIEW_SUBMIT' ) ?>"/>
						</div>
					</div>
					
				<?php } else if($review_editable and $this->allowRating) { ?>
					<div class="row">
						<div class="col-md-12">
							<input class="btn btn-primary btn-radius" type="submit" name="submit_review"
						   title="<?php echo vmText::_( 'COM_VIRTUEMART_REVIEW_SUBMIT' ) ?>"
						   value="<?php echo vmText::_( 'COM_VIRTUEMART_REVIEW_SUBMIT' ) ?>"/>
						</div>
					</div>					
				<?php
				}

				?>    
				<input type="hidden" name="virtuemart_product_id"
					   value="<?php echo $this->product->virtuemart_product_id; ?>"/>
				<input type="hidden" name="option" value="com_virtuemart"/>
				<input type="hidden" name="virtuemart_category_id"
					   value="<?php echo vRequest::getInt( 'virtuemart_category_id' ); ?>"/>
				<input type="hidden" name="virtuemart_rating_review_id" value="0"/>
				<input type="hidden" name="task" value="review"/>
			</form>
		</div>
	<?php
	} else if(!$review_editable) {
		echo '<div class="post-block post-leave-comment">';
		echo '<h6 class="mt-10 mb-30 text-uppercase text-semi-bold text-size-20">'.vmText::_( 'COM_VIRTUEMART_DEAR' ).$this->user->name.'</h6>';
		echo vmText::_( 'COM_VIRTUEMART_REVIEW_ALREADYDONE' );
		echo '</div>';
	}
}





if ($this->allowRating || $this->allowReview || $this->showRating || $this->showReview) {
	 echo '</div> ';
}
?>
