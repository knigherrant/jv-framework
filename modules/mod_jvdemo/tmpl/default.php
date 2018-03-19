<?php
/*
# mod_jvdemo - JV Demo Module
# @version		1.0.0
# ------------------------------------------------------------------------
# author    Open Source Code Solutions Co
# copyright Copyright (C) 2014 phpkungfu.club. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
# Websites: http://www.phpkungfu.club
# Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
$bgDefault = $jvoption->get('styles.background');
$sDefault = $jvoption->get('styles.themestyle');
defined('_JEXEC') or die('Restricted access');
$bgColor = $jvoption->get('styles.bgcolor');
JHtml::_('behavior.colorpicker');
JHtml::_('formbehavior.chosen', '#demo-fonts select');
$document   = JFactory::getDocument();
$document->addStyleSheet('http://fonts.googleapis.com/css?family=Droid+Serif');
$document->addStyleSheet('http://fonts.googleapis.com/css?family=Oswald:400,300');
$document->addStyleSheet('https://fonts.googleapis.com/css?family=Dosis:400,300,600,700');
?>
<script type="text/javascript">
(function($){
	$(document).ready(function(){
		$item1 = $('body');
		$('#demo-list-bg,#demo-list-box').each(function(){
			var $btns = $(this).find('a').click(function(){
				$item1
					.removeClass($btns.filter('.active').removeClass('active').data('value'))
					.addClass($(this).addClass('active').data('value'));
			});
		});		
		$('#demo-fonts').find('select').each(function(){
			var 
				select = $(this).change(function(){
					$item1.attr('demofont-' + name,select.val());
				}),
				name = select.data('assign')
			;
		});
		$switcher = $('#switcher')
		$('.show-switcher-icon').click(function(){
			if($switcher.hasClass('show-switcher')){
				$switcher.removeClass('show-switcher');
			}else{
				$switcher.addClass('show-switcher');
			}
		});			
		// change color
		var oCtrlColor = $('.themecolor-color').data('minicolorsSettings');
		!oCtrlColor || (function(ctrl, target){
			ctrl.change = function(c){
				target.css({backgroundColor: c});
			};
		})(oCtrlColor, $item1);	
	});	
})(jQuery);
</script>
<ul class="switcher">
    <li class="switcher-box ">
        <h5>Layout Style</h5>
        <ul class="demo-list-box" id="demo-list-box">
            <?php foreach ($jStyle as $jk=>$jv){ ?>
            <?php $jChecked = ''; if($sDefault == $jk) $jChecked = 'active '; ?>            
                <li><a  class="btn <?php echo $jChecked; ?> <?php echo $jk; ?>-style" data-value="<?php echo 'body-'.$jk; ?>" href="javascript:void(0)"><?php echo $jv; ?></a></li>
            <?php } ?>            
        </ul>      
    </li>
    <li class="switcher-box">
        <h5>Textures</h5>
		<p class="bgcolor">
		  <input type="text" class="minicolors themecolor-color" placeholder="Select color" value="<?php echo $bgColor;?>" />
		</p>
        <ul class="demo-list-bg clearfix" id="demo-list-bg">
            <?php foreach ($background as $f=>$text){ ?>
            <?php $jSelected = ''; if($bgDefault == $f) $jSelected = 'active '; ?>
                <li><a class="<?php echo $jSelected; ?> <?php echo modJVDemoHelper::getValue($f); ?>" data-value="<?php echo modJVDemoHelper::getValue($f); ?>" href="javascript:void(0)"></a></li>
            <?php } ?>
        </ul>
    </li>
    <li class="switcher-box" id="demo-fonts">
        <h5>Fonts</h5>
        <ul class="demo-list-fonts">
        	<li>
                <p>Body Font</p>
                <select data-assign="body">
                    <option value="f0">Select font</option>
                    <option value="f1">Open Sans</option>
                    <option value="f2">Roboto</option>
                    <option value="f3">Oswald</option>
                    <option value="f4">Dosis</option>
                    <option value="f6">Montserrat</option>
                    <option value="f7">Playfair Display</option>
                </select>    
            </li>
            <li>
                <p>Menu Font</p>
                <select data-assign="menu">
                    <option value="f0">Select font</option>
                    <option value="f1">Open Sans</option>
                    <option value="f2">Roboto</option>
                    <option value="f3">Oswald</option>
                    <option value="f4">Dosis</option>
                    <option value="f6">Montserrat</option>
                    <option value="f7">Playfair Display</option>
                </select>    
            </li>
            <li>
                <p>Title Font</p>
                <select data-assign="header">
                    <option value="f0">Select font</option>
                    <option value="f1">Open Sans</option>
                    <option value="f2">Roboto</option>
                    <option value="f3">Oswald</option>
                    <option value="f4">Dosis</option>
                    <option value="f6">Montserrat</option>
                    <option value="f7">Playfair Display</option>
                </select>    
            </li>    
        </ul>
    </li>
    <li class="switcher-box">
        <a href="http://themeforest.net/user/phpkungfu/portfolio" class="btn btn-primary btn-block" target="_blank">Purchase Loren now</a>
    </li>
</ul>