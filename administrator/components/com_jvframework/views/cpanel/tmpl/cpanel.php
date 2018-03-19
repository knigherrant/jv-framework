<?php
/**
  # com_jvframwork - JV Framework
  # @version		1.5.x
  # ------------------------------------------------------------------------
  # author    PHPKungfu Solutions Co
  # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
  # Websites: http://www.phpkungfu.club
  # Technical Support:  http://www.phpkungfu.club/my-tickets.html
  ------------------------------------------------------------------------- 
  */
// no direct access
defined ( '_JEXEC' ) or die ( 'Retricted Access' );
JHtml::_('behavior.tooltip');

?>

<div id="controlpanel">
	<form action="<?php echo JRoute::_('index.php?option=com_jvframework'); ?>" method="post" name="adminForm">
	<div class="width-70 fltlft">
		<div class="cpanel-icon">
			<div class="wrapper">
				<div class="icon">
					<a href="index.php?option=com_templates&view=styles" class="hasTip" title="<?php echo JText::_('COM_JVFRAMEWORK_MANAGER_STYLES'); ?>::The “Style” manager allows you to create, delete and edit styles – instances of the theme with their own setting, which you can apply to the entire site or a single page.">
						<img alt="" src="components/com_jvframework/assets/images/cpanel/style.png">
						<span><?php echo JText::_('COM_JVFRAMEWORK_MANAGER_STYLES'); ?></span>
					</a>
				</div>
			</div>	
			<div class="wrapper">
				<div class="icon">
					<a href="index.php?option=com_jvframework&view=typographies" class="hasTip" title="<?php echo JText::_('COM_JVFRAMEWORK_MANAGER_TYPOGRAPHIES'); ?>::The “Typography” manager allows you to set up, edit and delete the typographies that will be used on your site.">
						<img alt="" src="components/com_jvframework/assets/images/cpanel/typographies.png">
						<span><?php echo JText::_('COM_JVFRAMEWORK_MANAGER_TYPOGRAPHIES'); ?></span>
					</a>
				</div>
			</div>
			<div class="wrapper">
				<div class="icon">
					<a href="index.php?option=com_jvframework&view=extensions" class="hasTip" title="<?php echo JText::_('COM_JVFRAMEWORK_MANAGER_EXTENSIONS'); ?>::This manager list all the JV Framework extensions that were installed on your site.">
						<img alt="" src="components/com_jvframework/assets/images/cpanel/extension.png">
						<span><?php echo JText::_('COM_JVFRAMEWORK_MANAGER_EXTENSIONS'); ?></span>
					</a>
				</div>
			</div>
			<div class="wrapper">
				<div class="icon">
				<a href="index.php?option=com_installer" class="hasTip" title="<?php echo JText::_('COM_JVFRAMEWORK_MANAGER_INSTALL'); ?>::Use Joomla's Installer to install JV-Framework's Extension.">
					<img alt="" src="components/com_jvframework/assets/images/cpanel/install.png">
					<span><?php echo JText::_('COM_JVFRAMEWORK_MANAGER_INSTALL'); ?></span>
				</a>				
				</div>
			</div>
		</div>
	</div>
	<div class="width-30 fltrt about">
    	<div class="about-inner">
		<div class="cpanel-inner">
			<h3>//// JV Framework</h3>
			<ul>
				<li><em>Version: 4.2.5</em></li>
				<li><em>Release date: April 2016</em></li>
                <li><em>Contact us: <a href="mailto:info@phpkungfu.club">info@phpkungfu.club</a></em></li>
			</ul>
			<p>Flexible, customizable, high performance and developer-friendly.
JV Framework 4.2.5 is a steep improvemence over our old Framework. While dropping some functions like drag and drop, it had gained several new ones, more up-to-date functions like a Grid layout control, a Responsive Design and a modular nature, allowing developers to improve or create new features with ease.
<br/>Try it out and experience the improvemence.</p>
		</div>
        <div class="cpanel-logo"><a target="_blank" href="http://phpkungfu.club"><img src="components/com_jvframework/assets/images/logo2.png" alt="Logo" /></a></div>
        </div>
	</div>	
	<div>
    	<input type="hidden" name="task" value="" />	
        <input type="hidden" name="view" value="styles" />
		<?php echo JHtml::_('form.token'); ?>
    </div>
	</form>	
</div>
<div class="company-info">
	<a target="_blank" href="http://phpkungfu.club"><img src="components/com_jvframework/assets/images/phpkungfu.png" alt="PHPKungfu" /></a>
</div>


   