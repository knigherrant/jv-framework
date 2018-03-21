<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;
$flagQuote = false;
?>
<?php if($this->item->params->get('itemExtraFields') && count($this->item->extra_fields)): ?>
	<!-- Item extra fields -->
	<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
	<?php if($extraField->value != ''): ?>
		<?php if($extraField->name == 'Quote'):	$flagQuote = true; endif; ?>
	<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>

<?php if(JRequest::getInt('print')==1): ?>
	<div class="clearfix">
	<!-- Print button at the top of the print page only -->
	<a class="itemPrintThisPage pull-right btn btn-primary" rel="nofollow" href="#" onclick="window.print();return false;">
	 <span class="fa fa-print"></span>	<span><?php echo JText::_('K2_PRINT_THIS_PAGE'); ?></span>
	</a>
	</div>
<?php endif; ?>

<!-- Start K2 Item Layout -->
<span id="startOfPageId<?php echo JRequest::getInt('id'); ?>"></span>
<div id="k2Container" class="k2SingleDefault blog-wide<?php echo ($this->item->featured) ? ' itemIsFeatured' : ''; ?><?php if($this->item->params->get('pageclass_sfx')) echo ' '.$this->item->params->get('pageclass_sfx'); ?>">
	<div class="post-body">
		<?php if (!$flagQuote) { ?>
			<?php if($this->item->params->get('itemImageGallery') && !empty($this->item->gallery)){ ?>
				<!-- Item image gallery -->
				<div class="post-image">
					<?php if($this->item->params->get('itemDateCreated')): ?>
					<span class="post-created">
						<span class="post-created-day"><?php echo JHTML::_('date', $this->item->created , 'd'); ?></span> 
						<span class="post-created-month"><?php echo JHTML::_('date', $this->item->created , 'M'); ?></span> 
					</span>
					<?php endif; ?>
					<!-- End Date -->	
					<?php echo $this->item->gallery; ?>
				</div>
			<?php } else{ ?>
				<?php if($this->item->params->get('itemVideo') && !empty($this->item->video)){ ?>
				<!-- Item video -->
				<div class="post-image" style="background-image: url(<?php echo $this->item->image; ?>)">
					<?php if($this->item->videoType=='embedded'): ?>
					<div class="itemVideoEmbedded">
						<?php echo $this->item->video; ?>
					</div>
					<?php else: ?>
					<?php echo $this->item->video; ?>
					<?php endif; ?>
				</div>
				<?php } else{ ?>
					<?php if($this->item->params->get('itemImage') && !empty($this->item->image)): ?>
					<!-- Item Image -->
					<div class="post-image">
						<?php if($this->item->params->get('itemDateCreated')): ?>
						<span class="post-created">
							<span class="post-created-day"><?php echo JHTML::_('date', $this->item->created , 'd'); ?></span> 
							<span class="post-created-month"><?php echo JHTML::_('date', $this->item->created , 'M'); ?></span> 
						</span>
						<?php endif; ?>
						<!-- End Date -->	
					    <img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px; height:auto;" />
					</div>
					<?php endif; ?>
				<?php } ?>
			<?php } ?>
		<?php } else {?>
			<div class="post-content post-large">
				<blockquote>
					<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
						<?php if($extraField->name == 'Quote'): ?>
						<p>“ <?php echo $extraField->value; ?> ”</p>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
						<?php if($extraField->name == 'Author'): ?>
						<footer><?php echo JText::_('TPL_BLOG_BY');?> <cite title="<?php echo $extraField->value; ?>"><?php echo $extraField->value; ?></cite></footer>
						<?php endif; ?>
					<?php endforeach; ?>
				</blockquote>
			</div>
		<?php } ?>
		<div class="post-content">
			<!-- Plugins: BeforeDisplayContent -->
			<?php echo $this->item->event->BeforeDisplayContent; ?>

			<!-- K2 Plugins: K2BeforeDisplayContent -->
			<?php echo $this->item->event->K2BeforeDisplayContent; ?>
			<?php if(
				$this->item->params->get('itemRating') ||
				$this->item->params->get('itemFontResizer') ||
				$this->item->params->get('itemPrintButton') ||
				$this->item->params->get('itemEmailButton') ||
				$this->item->params->get('itemCommentsAnchor')
			): ?>
			<!-- Item Rating -->
			<div class="itemRatingBlock clearfix pull-right">
				<?php if( $this->item->params->get('itemRating') ): ?>
				<div class="itemRatingForm">
					<ul class="itemRatingList">
						<li class="itemCurrentRating" id="itemCurrentRating<?php echo $this->item->id; ?>" style="width:<?php echo $this->item->votingPercentage; ?>%;"></li>
						<li><a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_1_STAR_OUT_OF_5'); ?>" class="one-star">1</a></li>
						<li><a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_2_STARS_OUT_OF_5'); ?>" class="two-stars">2</a></li>
						<li><a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_3_STARS_OUT_OF_5'); ?>" class="three-stars">3</a></li>
						<li><a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_4_STARS_OUT_OF_5'); ?>" class="four-stars">4</a></li>
						<li><a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_5_STARS_OUT_OF_5'); ?>" class="five-stars">5</a></li>
					</ul>
					<div id="itemRatingLog<?php echo $this->item->id; ?>" class="itemRatingLog"><?php echo $this->item->numOfvotes; ?></div>
				</div>
				<?php endif; ?>

				<?php if(
				$this->item->params->get('itemFontResizer') ||
				$this->item->params->get('itemPrintButton') ||
				$this->item->params->get('itemEmailButton')
				): ?>
				<div class="dropdown pull-right">
					<span class="fa fa-cog dropdown-toggle" id="itemToolbarDropdown<?php echo $this->item->id;?>" data-toggle="dropdown"></span>
					<ul class="dropdown-menu" role="menu" aria-labelledby="itemToolbarDropdown<?php echo $this->item->id;?>">
						<?php if($this->item->params->get('itemFontResizer')): ?>
							<!-- Font Resizer -->
							<li>
								<a href="#" id="fontIncrease">
									<i class="fa fa-plus-circle"></i> <span class="fontSize"><?php echo JText::_('K2_INCREASE_FONT_SIZE'); ?></span>
								</a>
							</li>
							<li>
								<a href="#" id="fontDecrease">
									<i class="fa fa-minus-circle"></i> <span class="fontSize"><?php echo JText::_('K2_DECREASE_FONT_SIZE'); ?></span>
								</a>
							</li>
							
							<li role="presentation" class="divider"></li>
						<?php endif; ?>

						<?php if($this->item->params->get('itemPrintButton') && !JRequest::getInt('print')): ?>
						<!-- Print Button -->
						<li>
							<a class="itemPrintLink" rel="nofollow" href="<?php echo $this->item->printLink; ?>" onclick="window.open(this.href,'printWindow','width=900,height=600,location=no,menubar=no,resizable=yes,scrollbars=yes'); return false;">
								<span><i class="fa fa-print"></i> <?php echo JText::_('K2_PRINT'); ?></span>
							</a>
						</li>
						<?php endif; ?>

						<?php if($this->item->params->get('itemEmailButton') && !JRequest::getInt('print')): ?>
						<!-- Email Button -->
						<li>
							<a class="itemEmailLink link-modal" rel="nofollow" href="<?php echo $this->item->emailLink; ?>">
								<span><i class="fa fa-envelope"></i> <?php echo JText::_('K2_EMAIL'); ?></span>
							</a>
						</li>
						<?php endif; ?>
					</ul>
				</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<div class="post-meta">
				<?php if($this->item->params->get('itemCategory')): ?>
				<span>
					<a class="meta-value" href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
				</span>
				<?php endif; ?>
				<!-- End Category -->	
				<?php if($this->item->params->get('itemAuthor')): ?>
				<span>
					<span class="meta-label"><?php echo JText::_('TPL_BLOG_BY');?> </span>
					<?php if(isset($this->item->author->link) && $this->item->author->link): ?>
					<a class="meta-value" rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
					<?php else: ?>
						<span class="meta-value"><?php echo $this->item->author->name; ?></span>
					<?php endif; ?>
				</span>
				<?php endif; ?>
				<!-- End Author -->
				<?php if($this->item->params->get('itemHits')): ?>
				<span>
					<span class="meta-label"><?php echo JText::_('K2_READ'); ?>: </span>
					<span class="meta-value"><?php echo $this->item->hits; ?> <?php echo JText::_('K2_TIMES'); ?></span>
				</span>
				<?php endif; ?>
				<!-- End hits -->
				<?php if($this->item->params->get('itemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
				<span class="post-info-comment">
					<span class="meta-label"><?php echo JText::_('K2_COMMENT'); ?>: </span>
					
						<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
							<!-- K2 Plugins: K2CommentsCounter -->
							<span class="meta-value"><?php echo $this->item->event->K2CommentsCounter; ?></span>
						<?php else: ?>
							<?php if($this->item->numOfComments > 0): ?>
								<a class="itemCommentsLink k2Anchor meta-value" href="<?php echo $this->item->link; ?>#itemCommentsAnchor"><?php echo $this->item->numOfComments; ?></a>
							<?php else: ?>
								<a class="itemCommentsLink k2Anchor meta-value" href="<?php echo $this->item->link; ?>#itemCommentsAnchor">0</a>
							<?php endif; ?>
						<?php endif; ?>					
				</span>
				<?php endif; ?>
				<!-- End Comments -->
				<?php if($this->item->params->get('itemDateModified') && intval($this->item->modified)!=0): ?>
				<!-- Item date modified -->
				<span>
					<span class="meta-label"><?php echo JText::_('K2_LAST_MODIFIED_ON'); ?>: </span> 
					<span class="meta-value"><?php echo JHTML::_('date', $this->item->modified, JText::_('TPL_DATE_FORMAT_03')); ?></span>
				</span>
				<?php endif; ?>
				<?php if($this->item->params->get('itemVideo') && !empty($this->item->video)){ ?>
				<?php if($this->item->params->get('itemDateCreated')): ?>
				<span class="post-date">
					<span class="meta-label"><?php echo JText::_('TPL_POSTED');?> </span> 
					<span class="meta-value"><?php echo JHTML::_('date', $this->item->created , JText::_('TPL_DATE_FORMAT_03')); ?></span>
				</span>
				<?php endif; ?>
				<!-- End Date -->
				<?php } ?>
			</div>

			<?php if($this->item->params->get('itemTitle') && !$flagQuote): ?>
				<!-- Item title -->
				<h4 class="post-title clearfix">
					<?php echo $this->item->title; ?>

					<?php if($this->item->params->get('itemFeaturedNotice') && $this->item->featured): ?>
						<!-- Featured flag -->
						<sup>
							<small class="text-warning"><i class="fa fa-star"></i> <?php echo JText::_('K2_FEATURED'); ?></small>
						</sup>				
					<?php endif; ?>
					<?php if(isset($this->item->editLink)): ?>
					<!-- Item edit link -->
					<sup class="itemEditLink">
						<a class="edit-modal" href="<?php echo $this->item->editLink; ?>">
							<small class="text-primary"><i class="fa fa-edit"></i> <?php echo JText::_('K2_EDIT_ITEM'); ?></small>
						</a>
					</sup>
					<?php endif; ?>
				</h4>
			<?php endif; ?>

			<div class="itemFullText mt-30">
				<?php if(!empty($this->item->fulltext)): ?>
				<?php if($this->item->params->get('itemIntroText')): ?>
				<!-- Item introtext -->
				<div>
					<?php echo $this->item->introtext; ?>
				</div>
				<?php endif; ?>
				<?php if($this->item->params->get('itemFullText')): ?>
				<!-- Item fulltext -->
				<div>
					<?php echo $this->item->fulltext; ?>
				</div>
				<?php endif; ?>
				<?php else: ?>
				<!-- Item text -->
				<div>
				  	<?php echo $this->item->introtext; ?>
				</div>
				<?php endif; ?>
		  	</div>
			<!-- Plugins: AfterDisplayContent -->
			<?php echo $this->item->event->AfterDisplayContent; ?>

			<!-- K2 Plugins: K2AfterDisplayContent -->
			<?php echo $this->item->event->K2AfterDisplayContent; ?>

			<?php if($this->item->params->get('itemExtraFields') && count($this->item->extra_fields) && !$flagQuote): ?>
			<!-- Item extra fields -->
			<div class="itemExtraFields">
				<strong class="upp"><?php echo JText::_('K2_ADDITIONAL_INFO'); ?>: </strong>
				<ul>
				<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
				<?php if($extraField->value != ''): ?>
				<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
					<?php if($extraField->type == 'header'): ?>
					<h4 class="itemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
					<?php else: ?>
					<span class="itemExtraFieldsLabel"><?php echo $extraField->name; ?>:</span>
					<span class="itemExtraFieldsValue"><?php echo $extraField->value; ?></span>
					<?php endif; ?>
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php if($this->item->params->get('itemAttachments') && count($this->item->attachments)): ?>
			<div class="post-tags post-attachment">
				<strong><?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?></strong><br>
				<?php foreach ($this->item->attachments as $attachment): ?>
					<a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?> - <?php echo $attachment->hits; ?> <?php echo ($attachment->hits==1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>" href="<?php echo $attachment->link; ?>">
						<?php echo $attachment->title; ?>
						<?php if($this->item->params->get('itemAttachmentsCounter')): ?>
						<sup> (<?php echo $attachment->hits; ?>)</sup>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<!-- End Attachment -->

			<?php if($this->item->params->get('itemTags') && count($this->item->tags)): ?>
			<!-- Item tags -->
			<div class="tags clearfix">
				<?php foreach ($this->item->tags as $tag): ?>
				<a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<!-- End post tags -->
		</div>
		<?php // End Post content ?>

		<?php if(
		$this->item->params->get('itemSocialButton') ||
		$this->item->params->get('itemTwitterButton',1) || 
		$this->item->params->get('itemFacebookButton',1) || 
		$this->item->params->get('itemGooglePlusOneButton',1)
		): ?>
		<div class="post-social clearfix">
			<div class="social-label pull-left mr-20"><?php echo JText::_("TPL_SHARE_THIS_POST"); ?>: </div>
			<?php if($this->item->params->get('itemTwitterButton',1) || $this->item->params->get('itemFacebookButton',1) || $this->item->params->get('itemGooglePlusOneButton',1)): ?>
			<!-- Social sharing -->
			<div class="itemSocialSharingFooter pull-left mr-20">
					<?php if($this->item->params->get('itemFacebookButton',1)): ?>
					<!-- Facebook Button -->
					<div class="itemFacebookButton pull-left">
						<div id="fb-root"></div>
						<script type="text/javascript">
							(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));
						</script>
						<div class="fb-like" data-send="false" data-width="200" data-show-faces="true"></div>
					</div>
					<?php endif; ?>

					<?php if($this->item->params->get('itemGooglePlusOneButton',1)): ?>
					<!-- Google +1 Button -->
					<div class="itemGooglePlusOneButton pull-left">
						<div class="g-plusone"></div>
						<script type="text/javascript">
						  (function() {
						  	window.___gcfg = {lang: 'en'}; // Define button default language here
						    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
						    po.src = 'https://apis.google.com/js/plusone.js';
						    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
						  })();
						</script>
					</div>
					<?php endif; ?>
					<?php if($this->item->params->get('itemTwitterButton',1)): ?>
					<!-- Twitter Button -->
					<div class="itemTwitterButton pull-left">
						<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal"<?php if($this->item->params->get('twitterUsername')): ?> data-via="<?php echo $this->item->params->get('twitterUsername'); ?>"<?php endif; ?>>
							<?php echo JText::_('K2_TWEET'); ?>
						</a>
						<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
					</div>
					<?php endif; ?>
			</div>
			<?php endif; ?>
			<?php if($this->item->params->get('itemSocialButton') && !is_null($this->item->params->get('socialButtonCode', NULL))): ?>
			<!-- Item Social Button -->
			<div class="socialButtonCode pull-left">
				<?php echo $this->item->params->get('socialButtonCode'); ?>
			</div>
			<?php endif; ?>
		</div>
		<!-- End post social -->
		<?php endif; ?>

		

		<?php if($this->item->params->get('itemNavigation') && !JRequest::getCmd('print') && (isset($this->item->nextLink) || isset($this->item->previousLink))): ?>
		<div class="post-nav clearfix">
			<div class="row">
				<div class="col-xs-6">
					<?php if(isset($this->item->previousLink)): ?>
						<a class="btn btn-outline-thin btn-block btn-sm btn-dark btn-radius" href="<?php echo $this->item->previousLink; ?>" title="<?php echo $this->item->previousTitle; ?>"><i class="fa fa-long-arrow-left"></i><span><?php echo $this->item->previousTitle; ?></span></a>
					<?php endif; ?>
				</div>
				<div class="col-xs-6">
					<?php if(isset($this->item->nextLink)): ?>
						<a class="btn btn-outline-thin btn-block btn-sm btn-dark btn-radius" href="<?php echo $this->item->nextLink; ?>" title="<?php echo $this->item->nextTitle; ?>"><span><?php echo $this->item->nextTitle; ?></span><i class="fa fa-long-arrow-right"></i></a>
					<?php endif; ?>	
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if($this->item->params->get('itemAuthorBlock') && empty($this->item->created_by_alias)): ?>
		<!-- Author Block -->
		<div class="itemAuthorBlock clearfix">
			<div class="itemAuthorLeft">
				<?php if($this->item->params->get('itemAuthorImage') && !empty($this->item->author->avatar)): ?>
				<img class="itemAuthorAvatar" src="<?php echo $this->item->author->avatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($this->item->author->name); ?>"  onError="this.src='<?php echo JUri::base() ?>templates/jv-hugeshop/images/avatar/default.jpg';" />
				<?php endif; ?>
			</div>		

			<div class="itemAuthorDetails">
				<h4 class="itemAuthorTitle"><?php echo JText::_("TPL_ABOUT_AUTHOR"); ?></h4>
				<a class="itemAuthorName mb-20 block text-uppercase" rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
				<?php if( ($this->item->params->get('itemAuthorURL') && !empty($this->item->author->profile->url)) || ($this->item->params->get('itemAuthorEmail')) ): ?>
				<div class="itemAuthorLink">
					<?php if($this->item->params->get('itemAuthorURL') && !empty($this->item->author->profile->url)): ?>
					<span><?php echo JText::_('K2_WEBSITE'); ?> </span><a rel="me" href="<?php echo $this->item->author->profile->url; ?>" target="_blank" title="<?php echo JText::_('K2_WEBSITE'); ?>"><?php echo $this->item->author->profile->url; ?></a>
					<?php endif; ?>

					<?php if($this->item->params->get('itemAuthorEmail')): ?>
						<span><?php echo JText::_('K2_EMAIL'); ?>: </span><a rel="nofollow" href="mailto:<?php echo $this->item->author->email; ?>" target="_blank" title="<?php echo JText::_('K2_EMAIL'); ?>"><?php echo $this->item->author->email; ?></a>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<?php if($this->item->params->get('itemAuthorDescription') && !empty($this->item->author->profile->description)): ?>
				<?php echo $this->item->author->profile->description; ?>
				<?php endif; ?>
				<!-- K2 Plugins: K2UserDisplay -->
				<?php echo $this->item->event->K2UserDisplay; ?>
				<?php if($this->item->params->get('itemAuthorLatest') && empty($this->item->created_by_alias) && isset($this->authorLatestItems)): ?>
				<!-- Latest items from author -->
				<div class="itemAuthorLatest">
					<h6><?php echo JText::_('K2_LATEST_FROM'); ?> <?php echo $this->item->author->name; ?></h6>
					<ul class="list-unstyled">
						<?php foreach($this->authorLatestItems as $key=>$item): ?>
						<li>
							<a href="<?php echo $item->link ?>"><i class="fa fa-angle-right"></i> <?php echo $item->title; ?></a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>

			</div>
		</div>
		<?php endif; ?>

		<?php if($this->item->params->get('itemRelated') && isset($this->relatedItems)): ?>
		<!-- Related items by tag -->
		<div class="related-posts">
			<h4 class="text-uppercase title-icon"><?php echo JText::_("K2_RELATED_ITEMS_BY_TAG"); ?></h4>
			<div class="row pt-30">
				<div class="carouselOwl" 
						data-items="3" 
						data-itemsdesktop="3" 
						data-itemsdesktopsmall="3" 
						data-itemstablet="2" 
						data-itemstabletsmall="2" 
						data-itemsmobile="1"
					>
					<?php foreach($this->relatedItems as $key=>$item): ?>
					<div class="col-xs-12">
						<article class="related-item">
							<?php if (!empty($item->image)) { ?>							
							<div class="related-image post-image" style="background-image: url(<?php echo $item->image; ?>);">
								<div class="post-created">
									<div class="post-created-day"><?php echo JHTML::_('date', $this->item->created , 'd'); ?></div> 
									<div class="post-created-month"><?php echo JHTML::_('date', $this->item->created , 'M'); ?></div> 
								</div>
								<?php if($this->item->params->get('itemRelatedImageGallery') && !empty($item->gallery)){ ?>
									<?php echo $item->gallery; ?>
								<?php } elseif($this->item->params->get('itemRelatedMedia') && !empty($item->video)){?>
									<?php if($item->videoType=='embedded'): ?>
										<?php echo $item->video; ?>
									<?php else: ?>
										<?php echo $item->video; ?>
									<?php endif; ?>
								<?php } elseif( $this->item->params->get('itemRelatedImageSize') && !empty($item->image)){ ?>
									<span><img class="hidden" src="<?php echo $item->image; ?>" alt="<?php K2HelperUtilities::cleanHtml($item->title); ?>" /></span>
								<?php } ?>
							</div>
							<?php } ?>
							<div class="related-content text-center">
								<?php if($this->item->params->get('itemRelatedCategory') || $this->item->params->get('itemRelatedAuthor') ): ?>
									<div class="post-meta mb-10">
										<?php if($this->item->params->get('itemRelatedCategory')): ?>
											<span class="itemInfoItem">
												<a  class="meta-value" href="<?php echo $item->category->link ?>"><?php echo $item->category->name; ?></a>
											</span>
										<?php endif; ?>

										<?php if($this->item->params->get('itemRelatedAuthor')): ?>
											<span class="itemInfoItem">
												<a class="meta-value" rel="author" href="<?php echo $item->author->link; ?>"><?php echo $item->author->name; ?></a>
											</span>
										<?php endif; ?>
									</div>
									<div class="clearfix"></div>
								<?php endif; ?>
								<?php if($this->item->params->get('itemRelatedTitle', 1)): ?>
									<h6 class="mb-0"><a class="related-title" href="<?php echo $item->link ?>"><?php echo $item->title; ?></a></h6>
								<?php endif; ?>
								<?php if($this->item->params->get('itemRelatedIntrotext')): ?>
								<div class="itemRelIntrotext"><?php echo strip_tags(substr($item->introtext, 0,125)."..."); ?></div>
								<?php endif; ?>

								<?php if($this->item->params->get('itemRelatedFulltext')): ?>
								<div class="itemRelFulltext"><?php echo $item->fulltext; ?></div>
								<?php endif; ?>
								<a class="btn btn-outline-thin btn-sm btn-dark btn-radius mt-20" href="<?php echo $item->link; ?>">
									<?php echo JText::_('TPL_READ_MORE'); ?>
								</a>	
							</div>
							
						</article>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>


		<?php if($this->item->params->get('itemComments') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1'))): ?>
			<!-- K2 Plugins: K2CommentsBlock -->
			<?php echo $this->item->event->K2CommentsBlock; ?>
		<?php endif; ?>

		<?php if($this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2')) && empty($this->item->event->K2CommentsBlock)): ?>
		<!-- Item comments -->
		<div class="post-block post-comments clearfix" id="itemCommentsAnchor">

			<?php if($this->item->params->get('commentsFormPosition')=='above' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))): ?>
			<!-- Item comments form -->
				<?php echo $this->loadTemplate('comments_form'); ?>
			<?php endif; ?>


			<?php if($this->item->numOfComments>0 && $this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2'))): ?>
				<!-- Item user comments -->
				<h4 class="text-uppercase title-icon mb-40">
					<span><?php echo $this->item->numOfComments; ?></span> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
				</h4>

				<ul class="comments list-unstyled">
					<?php foreach ($this->item->comments as $key=>$comment): ?>
						<li class="clearfix comment">
							<div class="comment-inner clearfix">
								<?php if($comment->userImage): ?>
								<div class="comment-avatar">
									<img src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" width="<?php echo $this->item->params->get('commenterImgWidth'); ?>" onerror="this.onerror=null;this.src='<?php echo JURI::base(true); ?>/templates/jv-hugeshop/images/avatar/default.jpg';" />
								</div>
								<?php endif; ?>
								<div class="comment-content">
									<div class="comment-name">
										<?php if(!empty($comment->userLink)): ?>
											<a href="<?php echo JFilterOutput::cleanText($comment->userLink); ?>" title="<?php echo JFilterOutput::cleanText($comment->userName); ?>" target="_blank" rel="nofollow">
											<?php echo $comment->userName; ?>
											</a>
											<?php else: ?>
											<?php echo $comment->userName; ?>
										<?php endif; ?>
									</div>
									<div class="comment-tool">
										<span class="comment-date"><?php echo JHTML::_('date', $comment->commentDate, JText::_('TPL_DATE_FORMAT_05')); ?></span>
										<a href="<?php echo $this->item->link; ?>#comment<?php echo $comment->id; ?>" id="comment<?php echo $comment->id; ?>" title="<?php echo JText::_('K2_COMMENT_LINK'); ?>"><small><?php echo JText::_('K2_COMMENT_LINK'); ?></small></a>
										<?php if($this->inlineCommentsModeration): ?>
											<?php if(!$comment->published): ?>
											<a class="commentApproveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=publish&commentID='.$comment->id.'&format=raw')?>"><small><?php echo JText::_('K2_APPROVE')?></small></a>
											<?php endif; ?>

											<a class="commentRemoveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=remove&commentID='.$comment->id.'&format=raw')?>"><small><?php echo JText::_('K2_REMOVE')?></small></a>
										<?php endif; ?>

										<?php if($comment->published && ($this->params->get('commentsReporting')=='1' || ($this->params->get('commentsReporting')=='2' && !$this->user->guest))): ?>
										<a class="link-modal" rel="{handler:'iframe',size:{x:560,y:480}}" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=report&commentID='.$comment->id)?>"><small><?php echo JText::_('K2_REPORT')?></small></a>
										<?php endif; ?>

										<?php if($comment->reportUserLink): ?>
										<a class="k2ReportUserButton" href="<?php echo $comment->reportUserLink; ?>"><small><?php echo JText::_('K2_FLAG_AS_SPAMMER'); ?></small></a>
										<?php endif; ?>
									</div>
									<div class="comment-text"><?php echo $comment->commentText; ?></div>									
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
				<div class="comments-pagination">
					<div class="pagination-wrap">
					<?php echo $this->pagination->getPagesLinks(); ?>
					</div>
				</div>
				
			<?php endif; ?>


			<?php if($this->item->params->get('commentsFormPosition')=='below' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))): ?>
				<!-- Item comments form -->
				<?php  echo $this->loadTemplate('comments_form'); ?>
			<?php endif; ?>

			<?php $user = JFactory::getUser(); if ($this->item->params->get('comments') == '2' && $user->guest): ?>
					<div><?php echo JText::_('K2_LOGIN_TO_POST_COMMENTS'); ?></div>
			<?php endif; ?>

	  	</div>
	  	<?php endif; ?>
	</div>
</div>
<!-- End K2 Item Layout -->
