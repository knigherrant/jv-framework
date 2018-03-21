/*
 # mod_jvcontact - JV Contact
 # @version		3.0.1
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
function formsubmit(formid){
	var $ = jQuery;
		form = $('#'+formid),
		flag = true,
		msg = ''
	;
	console.log(formid);
	//form.submit();
	form.find('.email').each(function(el){
		var el = $(this);
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(reg.test(el.val()) == false){
			flag = false;
			msg = 'Invalid Email!';
			el.addClass('invalid');
		}else{
			el.removeClass('invalid');
		}
	});
	
	
	form.find('.require').each(function(el){
		var el = $(this);
		if(el.attr('type') =="checkbox"){
			if(el.is(':checked')== false){
				flag = false;
				msg = 'Please input valid data in red fields!';
				el.addClass('invalid');
			}else{
				el.removeClass('invalid');
			}
		}else{
			if(el.val()==''){
				flag = false;
				msg = 'Please input valid data in red fields!';
				el.addClass('invalid');
			}else{
				el.removeClass('invalid');
			}
		}
	});
	
	if($('#recaptcha_response_field')){
		if($('#recaptcha_response_field').val()==''){
			flag=false;
			msg = '<div class="alert alert-error alert-block">Please input valid data in captcha fields!</div>';
			$('#recaptcha_response_field').addClass('invalid');
		}else{
			$('#recaptcha_response_field').removeClass('invalid');
		}
	}
	

	if(flag){
		form.submit();
	}else{
		if($('#msg'+formid)){
			$('#msg'+formid).html(msg);
		}
	}

	return;
}