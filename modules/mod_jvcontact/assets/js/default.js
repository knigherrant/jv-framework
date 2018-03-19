/*
 # mod_jvcontact - JV Contact
 # @version		3.0.1
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/
function formsubmit(formid){
	var 
		form = $(formid),
		reg,
		flag = true,
		msg = ''
	;
	
	//form.submit();
	form.getElements('.email').each(function(el){
		console.log(el);
		reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(reg.test(el.value) == false){
			flag = false;
			msg = 'Invalid Email!';
			el.addClass('invalid');
		}else{
			el.removeClass('invalid');
		}
	});
	
	
	form.getElements('.require').each(function(el){
		
		if(el.value==''){
			flag = false;
			msg = 'Please input valid data in red fields!';
			el.addClass('invalid');
		}else{
			el.removeClass('invalid');
		}
	});
	
	if($('recaptcha_response_field')){
		if($('recaptcha_response_field').value==''){
			flag=false;
			msg = '<div class="alert alert-error alert-block">Please input valid data in captcha fields!</div>';
			$('recaptcha_response_field').addClass('invalid');
		}else{
			$('recaptcha_response_field').removeClass('invalid');
		}
	}
	

	if(flag){
		form.submit();
	}else{
		if($('msg'+formid)){
			$('msg'+formid).innerHTML = msg;
		}
	}

	return;
}