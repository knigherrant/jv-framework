<?php
/**
 * @package     Joomla.Site
 * @subpackage  Template.system
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$app = JFactory::getApplication();
// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

require_once JPATH_ADMINISTRATOR . '/components/com_users/helpers/users.php';
$twofactormethods = UsersHelper::getTwoFactorMethods();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.5, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="handheldfriendly" content="true" />
	<?php
	// Favicon
	$this['template']->document->addFavicon($this['path']->url('theme::icon/favicon.ico'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/favicon-16x16.png'), 'icon', 'rel', array('sizes' => '16x16', 'type' => 'image/png'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/favicon-32x32.png'), 'icon', 'rel', array('sizes' => '32x32', 'type' => 'image/png'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/favicon-96x96.png'), 'icon', 'rel', array('sizes' => '96x96', 'type' => 'image/png'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/android-icon-192x192.png'), 'icon', 'rel', array('sizes' => '192x192', 'type' => 'image/png'));

	// Apple Icon
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-57x57.png'), 'apple-touch-icon-precomposed');
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-60x60.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '60x60'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-72x72.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '72x72'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-76x76.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '76x76'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-114x114.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '114x114'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-120x120.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '120x120'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-152x152.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '152x152'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-152x152.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '152x152'));
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/apple-icon-180x180.png'), 'apple-touch-icon-precomposed', 'rel', array('sizes' => '180x180'));

	//Microsoft Icon
	$this['template']->document->addHeadLink($this['path']->url('theme::icon/manifest.json'), 'manifest', 'rel');
	$this['template']->document->setMetaData ( 'msapplication-TileColor', '#ffffff' );
	$this['template']->document->setMetaData ( 'msapplication-TileImage', $this['path']->url('theme::icon/ms-icon-144x144.png') );
	$this['template']->document->setMetaData ( 'theme-color', '#ffffff' );

	?>
	<link rel="stylesheet" href="<?php echo JUri::root(true)?>/plugins/system/jvlibs/javascripts/jquery/bootstrap/css/bootstrap.min.css" type="text/css" />   
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $app->getTemplate(); ?>/css/template.css" type="text/css" />
	<?php if ($this->direction == 'rtl') : ?>
		<link rel="stylesheet" href="<?php echo JUri::root(true)?>/plugins/system/jvlibs/javascripts/jquery/bootstrap/css/bootstrap-rtl.min.css" type="text/css" />   
		<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $app->getTemplate(); ?>/css/template.style.rtl.css" type="text/css" />
	<?php endif; ?>
	<?php
	if($this->direction == 'rtl'){ ?>
	<link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/responsive-margin-rtl.css'); ?>" type="text/css" />
	<?php 
	} else { ?>
	<link rel="stylesheet" href="<?php echo $this['path']->url('theme::css/responsive-margin.css'); ?>" type="text/css" />
	<?php 
	}?>
	<style type="text/css">
		html{height: 100%}
	</style>
	<?php
	if($this['option']->get('global.retina')){
		$this['asset']->addScript($this['path']->url('theme::js/retina.min.js'));
	}
	$this['asset']->addScript($this['path']->url('theme::js/jv.js'));
	?>
</head>
<body class="offline-page pt-150 pt-md-120 pt-sm-80 pt-xs-50">
	<div id="frame" class="container">
		<?php if ($app->get('offline_image') && file_exists($app->get('offline_image'))) : ?>
			<div class="offline-image text-center">
			<img src="<?php echo $app->get('offline_image'); ?>" alt="<?php echo htmlspecialchars($app->get('sitename')); ?>"/>
			</div>
		<?php endif; ?>
		<div class="offline-container">
			<div class="offline-body">
				<?php if ($app->get('display_offline_message', 1) == 1 && str_replace(' ', '', $app->get('offline_message')) != '') : ?>
					<div class="offline-message">
						<?php echo $app->get('offline_message'); ?>
					</div>
				<?php elseif ($app->get('display_offline_message', 1) == 2 && str_replace(' ', '', JText::_('JOFFLINE_MESSAGE')) != '') : ?>
					<div class="offline-message">
						<?php echo JText::_('JOFFLINE_MESSAGE'); ?>
					</div>
				<?php endif; ?>
				<jdoc:include type="message" />
				<?php if( $this['block']->count('offline-countdown') ):?>
				    <div class="offline-countdown"><jdoc:include type="position" name="offline-countdown"  style="none" /></div>
				<?php endif;?>
				<form action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="form-login">
				<fieldset class="input">
					<div class="input-login clearfix">
						<p id="form-login-username" class="form-group">
							<input name="username" id="username" type="text" class="form-control" alt="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" size="18" placeholder="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" />
						</p>
						<p id="form-login-password" class="form-group">
							<input type="password" name="password" class="form-control" size="18" alt="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" id="passwd" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" />
						</p>
					</div>
					<?php if (count($twofactormethods) > 1) : ?>
					<div class="row">
						<div class="col-sm-12">
							<p id="form-login-secretkey" class="form-group">
								<input type="text" name="secretkey" class="form-control" size="18" alt="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>" id="secretkey" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>" />
							</p>
						</div>
					</div>
					<?php endif; ?>	
					<p id="submit-buton" class="form-group clearfix">
						<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
							<label for="remember" class="checkbox pull-right"><input type="checkbox" name="remember" class="" value="yes" alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME'); ?>" id="remember" /><?php echo JText::_('JGLOBAL_REMEMBER_ME'); ?></label>
						<?php endif; ?>
						<input type="submit" name="Submit" class="btn btn-primary login pull-left" value="<?php echo JText::_('JLOGIN'); ?>" />
					</p>
					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="user.login" />
					<input type="hidden" name="return" value="<?php echo base64_encode(JUri::base()); ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</fieldset>
				</form>
				<?php if( $this['block']->count('offline-social') ):?>
				    <div class="offline-social" data-label="<?php echo JText::_('TPL_OFFLINE_STAY_TUNED'); ?>"><jdoc:include type="position" name="offline-social" style="none"/></div>
				<?php endif;?>
			</div>
		</div>
	</div>
</body>
</html>