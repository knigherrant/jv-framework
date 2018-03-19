<?php
/**
*
* Layout for the login
*
* @package	VirtueMart
* @subpackage User
* @author Max Milbers, George Kostopoulos
*
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: cart.php 4431 2011-10-17 grtrustme $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

  //set variables, usually set by shopfunctionsf::getLoginForm in case this layout is differently used
  if (!isset( $this->show )) $this->show = TRUE;
  if (!isset( $this->from_cart )) $this->from_cart = FALSE;
  if (!isset( $this->order )) $this->order = FALSE ;


  if (empty($this->url)){
  	$url = vmURI::getCleanUrl();
  } else{
  	$url = $this->url;
  }

  $user = JFactory::getUser();

  if ($this->show and $user->id == 0  ) {
  JHtml::_('behavior.formvalidation');
  JHtml::_ ( 'behavior.modal' );


	//$uri = JFactory::getURI();
	//$url = $uri->toString(array('path', 'query', 'fragment'));
		//Extra login stuff, systems like openId and plugins HERE
		if (JPluginHelper::isEnabled('authentication', 'openid')) {
      $lang = JFactory::getLanguage();
      $lang->load('plg_authentication_openid', JPATH_ADMINISTRATOR);
      $langScript = '
      //<![CDATA[
        '.'var JLanguage = {};' .
        ' JLanguage.WHAT_IS_OPENID = \'' . vmText::_('WHAT_IS_OPENID') . '\';' .
        ' JLanguage.LOGIN_WITH_OPENID = \'' . vmText::_('LOGIN_WITH_OPENID') . '\';' .
        ' JLanguage.NORMAL_LOGIN = \'' . vmText::_('NORMAL_LOGIN') . '\';' .
        ' var comlogin = 1;
      //]]>
      ';
      vmJsApi::addJScript('login_openid',$langScript);
      JHtml::_('script', 'openid.js');
		}

		$html = '';
		JPluginHelper::importPlugin('vmpayment');
		$dispatcher = JDispatcher::getInstance();
		$returnValues = $dispatcher->trigger('plgVmDisplayLogin', array($this, &$html, $this->from_cart));

		if (is_array($html)) {
			foreach ($html as $login) {
				echo $login.'<br />';
			}
		}
		else {
			echo $html;
		}

		//end plugins section

	?>
    <div class="row vmLogin <?php echo ($this->order)?'loginOder':'';?>">
		<?php
            //anonymous order section
        if ($this->order  ) {	?>
        	<div class="col-sm-6">
              <div class="featured-box featured-box-secondary featured-box-cart ">
                <div class="box-content">
                  <h4><?php echo vmText::_('COM_VIRTUEMART_ORDER_ANONYMOUS') ?></h4>
                  <form action="<?php echo JRoute::_( 'index.php', 1, $this->useSSL); ?>" method="post" name="com-login" class="form-horizontal" >
                    
                    <div class="form-group" id="com-form-order-number">
                        <label for="order_number" class="col-sm-4 control-label"><?php echo vmText::_('COM_VIRTUEMART_ORDER_NUMBER') ?></label>
                        <div class="col-sm-8">
                          <input type="text" id="order_number" name="order_number" class="form-control" size="18"/>
                        </div>                        
                    </div>
                    <div class="form-group" id="com-form-order-pass">
                        <label for="order_pass" class="col-sm-4 control-label"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PASS') ?></label>
                        <div class="col-sm-8">
                          <input type="text" id="order_pass" name="order_pass" class="form-control" size="18" value="p_"/>
                        </div>                         
                    </div>
                    <div  id="com-form-order-submit" class="form-group">
                        <div class="col-sm-8 col-sm-offset-4">
                          <input type="submit" name="Submitbuton" class="btn btn-sm btn-default" value="<?php echo vmText::_('COM_VIRTUEMART_ORDER_BUTTON_VIEW') ?>" />
                        </div>
                    </div>
                    <input type="hidden" name="option" value="com_virtuemart" />
                    <input type="hidden" name="view" value="orders" />
                    <input type="hidden" name="layout" value="details" />
                    <input type="hidden" name="return" value="" />
                  </form>
                </div>
              </div>
          </div>
        <?php   
        }

        // XXX style CSS id com-form-login ?>
            
        <div class="col-sm-<?php if ($this->order  ) echo '6'; else echo '12'; ?>">
          <div class="featured-box featured-box-secondary featured-box-cart ">
            <div class="box-content">
              <h4><?php echo vmText::_('COM_VIRTUEMART_LOGIN') ?></h4>
              <form action="<?php echo JRoute::_('index.php', $this->useXHTML, $this->useSSL); ?>" method="post" name="com-login" class="form-horizontal">
                
                <div class="userdata">
                  <div class="form-group" id="com-form-login-username">
                    <label for="vmusername" class="col-sm-4 col-md-2 control-label"><?php echo vmText::_('COM_VIRTUEMART_USERNAME'); ?></label>
                    <div class="col-sm-8 col-md-10">
                      <input type="text" name="username" id="vmusername" class="form-control" size="18" placeholder="<?php echo vmText::_('COM_VIRTUEMART_USERNAME'); ?>"  />
                    </div>
                  </div>
                  <div class="form-group" id="com-form-login-password">
                    <label for="modlgn-passwd" class="col-sm-4 col-md-2  control-label"><?php echo vmText::_('COM_VIRTUEMART_PASSWORD'); ?></label>
                    <div class="col-sm-8 col-md-10">
                      <input id="modlgn-passwd" type="password" name="password" class="form-control" size="18" placeholder="<?php echo vmText::_('COM_VIRTUEMART_PASSWORD'); ?>"  />
                    </div>
                  </div>
                  
                  <div class="form-group" id="form-login-submit">
                    <div class="col-sm-8 col-md-10 col-sm-offset-4 col-md-offset-2">
                    <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                      <div class="checkbox pull-right">
                        <label for="remember"><input type="checkbox" id="remember" name="remember" class="inputbox" value="yes" /> <?php echo $remember_me = vmText::_('JGLOBAL_REMEMBER_ME') ?></label>
                      </div>                    
                    <?php endif; ?>
                      <input type="submit" name="Submit" class="btn  btn-sm btn-default" value="<?php echo vmText::_('COM_VIRTUEMART_LOGIN') ?>" />
                    </div>
                  </div>
                </div>
                <div class="form-group" >
                  <ul class="list-unstyled col-sm-8 col-md-10 col-sm-offset-4 col-md-offset-2">
                    <li><a title=" <?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_USERNAME'); ?>" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"><?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_USERNAME'); ?></a></li>
                    <li><a title=" <?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_PASSWORD'); ?>" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"><?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_PASSWORD'); ?></a> </li>
                  </ul>
                </div>
                <input type="hidden" name="task" value="user.login" />
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" />
                <?php echo JHtml::_('form.token'); ?>
              </form>
            </div>
          </div>         
        </div>
    </div>  
<?php  
} else if ( $user->id ) { ?>
    <form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="login" id="form-login" class="mb-50">
      <h4 class="mt-0 mb-0"><?php echo vmText::sprintf('COM_VIRTUEMART_WELCOME_USER', $user->name); ?>
        <input type="submit" name="Submit" class="btn btn-xs btn-gray btn-outline" value="<?php echo vmText::_( 'COM_VIRTUEMART_BUTTON_LOGOUT'); ?>" style="margin-top: -5px;">
      </h4>
      <input type="hidden" name="option" value="com_users" />
      <input type="hidden" name="task" value="user.logout" />
      <?php echo JHtml::_('form.token'); ?>
      <input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" />
    </form> 
<?php 
}

?>
