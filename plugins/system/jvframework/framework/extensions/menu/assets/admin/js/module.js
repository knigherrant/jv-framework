jQuery(function($){
    
    $('#jform_params_flexconfig').parent().parent().parent().hide();
    
    var type = $('#jform_params_jvmenutyle'),
        fix = $('#jform_params_flexmenu_style').parent().parent();
    
    type.change(function(){
        var val = $(this).children(':selected').val();
        if(!val || val==''){
            fix.show();
            fix.next().show();
            $('#jform_params_flexconfig').parent().parent().parent().hide();
        }else{
            fix.hide();
            fix.next().hide();
        }
    })
    
    /*
    
	var type  = $('#jform_params_jvmenutyle'),
		style = $('#jform_params_flexmenu_style'),		
		customfield = $('.jvcustomfieldpanel'),
		spacer = $('.collapse');

    $(type).parents('li, div.control-group').parent().addClass('adminformlist flexmenu');

	spacer.each(function(){
		var parent = $(this).parent().parent('li');
		if(!parent.length){
			parent = $(this).parent().parent().parent()
		}		
		parent.addClass($(this).attr('class'));
	});		
	
	controls   = $('.collapse').parent().children('*');	
	type.change(function(){
		//controls.hide();
		//controls[0].show();
		//if($(this).val()){
		//	var control = $('.'+$(this).val());
		//	control.show();
		//	showNext(control);
		//}		
	});
	
	var showNext = function(el){
		var next = $(el).next();	
		if(next.length){
			if($(next).hasClass('collapse')){
				return;	
			}			
			next.show();
			showNext(next);
		}
	};
	
	style.change(function(){
		if($(this).val() == 'accordion'){
			//customfield.hide();
		}else{
			customfield.show();
		}
	});
	
	type.trigger('change');
	style.trigger('change');
        */
});