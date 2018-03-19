<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$classCol= ' col-sm-'.floor ( 12 / $manufacturers_per_row );
$col= 1 ;
?>
<div class="vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?> blk-thmbs-pro">

<?php if ($headerText) : ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php endif;
if ($display_style =="div") { ?>
	<div class="row">
		<div class="multi-slides multi-slides-right vmmanufacturer<?php echo $params->get('moduleclass_sfx'); ?> carouselOwl" 
					data-items="<?php echo $manufacturers_per_row ?>" 
					data-itemsdesktop="<?php echo $manufacturers_per_row ?>" 
					data-itemsdesktopsmall="<?php echo (($manufacturers_per_row - 1)>0)?($manufacturers_per_row - 1):4 ?>" 
					data-itemstablet="4" 
					data-itemstabletsmall = "3"
					data-itemsmobile = "2" 
					data-pagination="false" 
					data-navigation="true"
				>
		<?php
		foreach ($manufacturers as $manufacturer) {
			$link = JROUTE::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);
			?>
			<div class="vmManufacturerItem col-sm-12">
				<a href="<?php echo $link; ?>">
					<?php
					if ($manufacturer->images && ($show == 'image' or $show == 'all' )) { ?>
						<?php echo $manufacturer->images[0]->displayMediaThumb('',false);?>
					<?php
					}
					if ($show == 'text' or $show == 'all' ) { ?>
					 <span class="vmMTitle h6 text-semi-bold text-uppercase mt-20 mb-20"><?php echo $manufacturer->mf_name; ?></span>
					<?php
					}
					?>
				</a>
			</div>
			<?php
		} ?>
		</div>
	</div>
<?php
} else {
?>
	<div class="vmmanufacturer<?php echo $params->get('moduleclass_sfx'); ?> grid-pro">
		<div class="row">
		<?php foreach ($manufacturers as $manufacturer) {
			$link = JROUTE::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);

			?>
			<div class="<?php echo $classCol;?>">
				<?php
				if ($manufacturer->images && ($show == 'image' or $show == 'all' )) { ?>
					<a href="<?php echo $link; ?>">
					<?php echo $manufacturer->images[0]->displayMediaThumb('',false);?>
					</a>
				<?php
				}
				if ($show == 'all' ) { ?>
				 <h6 class="vmMTitle text-semi-bold text-uppercase mt-20 mb-20"><?php echo $manufacturer->mf_name; ?></h6>
				<?php } ?>	
				<?php if ($show == 'text') { ?>
				 <div class="title"><a href="<?php echo $link; ?>"><?php echo $manufacturer->mf_name; ?></a></div>
				<?php } ?>				
			</div>
			<?php
			if ($col == $manufacturers_per_row) {
				echo "</div><div class='row'>";
				$col= 1 ;
			} else {
				$col++;
			}
		} ?>
		</div>
	</div>
	<?php }
	if ($footerText) : ?>
	<div class="vmfooter<?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
	<?php endif; ?>
</div>

