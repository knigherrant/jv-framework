<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if ($this->params->get('presentation_style') == 'sliders'):?>
<div class="panel panel-default">
	<div class="panel-heading">
		<a class="panel-title" data-toggle="collapse" data-parent="accordionContact" href="#display-links">
		<?php echo JText::_('COM_CONTACT_LINKS');?>
		</a>
	</div>
	<div id="display-links" class="panel-collapse collapse">
		<div class="panel-body">
<?php endif; ?>
<?php if  ($this->params->get('presentation_style') == 'plain'):?>
<?php echo '<h3>'. JText::_('JGLOBAL_ARTICLES').'</h3>'; ?>
<?php endif; ?>

			<div class="contact-links clearfix">
				<ul class="features-list list-unstyled">
					<?php
					foreach (range('a', 'e') as $char) :// letters 'a' to 'e'
						$link = $this->contact->params->get('link'.$char);
						$label = $this->contact->params->get('link'.$char.'_name');

						if (!$link) :
							continue;
						endif;

						// Add 'http://' if not present
						$link = (0 === strpos($link, 'http')) ? $link : 'http://'.$link;

						// If no label is present, take the link
						$label = ($label) ? $label : $link;
						?>
						<li>
							<a href="<?php echo $link; ?>">
								<i class="fa fa-angle-right"></i>
							    <?php echo $label; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

<?php if ($this->params->get('presentation_style') == 'sliders'):?>
		</div>
	</div>
</div>
<?php endif; ?>
<?php if  ($this->params->get('presentation_style') == 'plain'):?>
<?php echo '<br>'; ?>
<?php endif; ?>


