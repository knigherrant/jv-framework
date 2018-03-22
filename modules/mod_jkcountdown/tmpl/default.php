<?php
/*
# mod_jvdemo - JK CountDown
# @version		1.0.0
# ------------------------------------------------------------------------
# author    PHPKungfu Solutions Co
# copyright Copyright (C) 2014 phpkungfu.club. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
# Websites: http://www.phpkungfu.club
# Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
$document   = JFactory::getDocument();
$document->addStyleSheet('https://fonts.googleapis.com/css?family=Roboto:400,500,700,300');
$deadline = $params->get('date');
$dateTime = JFactory::getDate($deadline)->toUnix();
$showCountdown = false;
if($deadline && $dateTime > time()) $showCountdown = true;
?>
<?php if($showCountdown){ 
$dateWedding = explode(' ',$deadline);
?>
<script>
    jQuery(function(){
        // CountDown Js November 1 2018 11:59:00 GMT-0400
	var deadline = '<?php echo date('M d Y', $dateTime); ?> <?php echo $dateWedding[1]; ?> GMT<?php echo $params->get('gtm','+0700');?>';
        function time_remaining(endtime){
                var t = Date.parse(endtime) - Date.parse(new Date());
                var seconds = Math.floor( (t/1000) % 60 );
                var minutes = Math.floor( (t/1000/60) % 60 );
                var hours = Math.floor( (t/(1000*60*60)) % 24 );
                var days = Math.floor( t/(1000*60*60*24) );
                if(t < 0 || days < 0) t= days= seconds= minutes = hours = 0;
                return {'total':t, 'days':days, 'hours':hours, 'minutes':minutes, 'seconds':seconds};
        }
        function run_clock(id,endtime){
                var clock = document.getElementById(id);

                // get spans where our clock numbers are held
                var days_span = clock.querySelector('.days');
                var hours_span = clock.querySelector('.hours');
                var minutes_span = clock.querySelector('.minutes');
                var seconds_span = clock.querySelector('.seconds');

                function update_clock(){
                        var t = time_remaining(endtime);
                        // update the numbers in each part of the clock
                        days_span.innerHTML = t.days;
                        hours_span.innerHTML = ('0' + t.hours).slice(-2);
                        minutes_span.innerHTML = ('0' + t.minutes).slice(-2);
                        seconds_span.innerHTML = ('0' + t.seconds).slice(-2);
                        if(t.total<=0){ clearInterval(timeinterval); }
                }
                update_clock();
                var timeinterval = setInterval(update_clock,1000);
        }
        run_clock('clockdiv',deadline);	  
    })
          
</script>
<?php } ?>
<div class="wd_timer_wrapper <?php echo $params->get('moduleclass_sfx'); ?>">
    <?php if($params->get('header')){ ?>
    <div class="wd_center_words"> <h4><?php echo $params->get('header'); ?></h4> </div>
    <?php } ?>
    <div id="clockdiv">
        <?php if($showCountdown){ ?>
            <div><span class="days"></span><div class="smalltext"><?php echo JText::_('Days');?></div></div>
            <div><span class="hours"></span><div class="smalltext"><?php echo JText::_('Hours');?></div></div>
            <div><span class="minutes"></span><div class="smalltext"><?php echo JText::_('Minutes');?></div></div>
            <div><span class="seconds"></span><div class="smalltext"><?php echo JText::_('Seconds');?></div></div>
     <?php }else echo JText::_('Time Up'); ?>
    </div>
    <?php if($params->get('footer')){ ?>
    <div class="wd_center_words">
            <h4><?php echo $params->get('footer'); ?></h4>
    </div>
    <?php } ?>
</div>