jQuery(function($){
	var itemtype = $('#jform_params_fxmenu_item');
	var group = itemtype.parent().parent();
        $('.nav-tabs a[href="#options"]').click(function(){
            var parent = $('#jform_parent_id').find(':selected').val();
            if(parent==1){
                itemtype.eq(0).attr('selected', 'selected');
                itemtype.parent().hide();
                if(group.find('.controls').hasClass('.msg-text')) group.find('.msg-text').show();
                else group.append('<div class="controls msg-text">This for children menu</div>');
            }else{
                itemtype.parent().show();
                itemtype.parent().parent().find('.msg-text').hide();
            }
        })
        
	itemtype.change(function(){
		changeType(itemtype.val());
	});
	
	itemtype.trigger('change');
	
	function changeType(type){
		if($('#jform_params_fxmenu_item').parent('li').length){
			var title 		= $('#jform_params_fxmenu_title').parent();
			//var titleLink 	= $('#jform_params_fxmenu_titlelink').parent();
			var subtitle 	= $('#jform_params_fxmenu_description').parent();
			var width 	 	= $('#jform_params_fxmenu_width').parent();
			var column 	 	= $('#jform_params_fxmenu_column').parent();
			var subwidth 	= $('#jform_params_fxmenu_subwidth').parent();
			var positions 	= $('#jform_params_fxmenu_module_pos').parent();
			var modules   	= $('#jform_params_fxmenu_modules').parent();
			var modulestyle = $('#jform_params_fxmenu_module_style').parent();			
		}else{
			var title 		= $('#jform_params_fxmenu_title').parent().parent();
			//var titleLink 	= $('#jform_params_fxmenu_titlelink').parent().parent();
			var subtitle 	= $('#jform_params_fxmenu_description').parent().parent();
			var width 	 	= $('#jform_params_fxmenu_width').parent().parent();
			var column 	 	= $('#jform_params_fxmenu_column').parent().parent();
			var subwidth 	= $('#jform_params_fxmenu_subwidth').parent().parent();
			var positions 	= $('#jform_params_fxmenu_module_pos').parent().parent();
			var modules   	= $('#jform_params_fxmenu_modules').parent().parent();
			var modulestyle = $('#jform_params_fxmenu_module_style').parent().parent();
		}
		
		switch (type) {
		case 'group':
			title.show();
			//titleLink.show();
			subtitle.show();
			width.show();
			column.show();
			subwidth.show();
			positions.hide();
			modules.hide();
			modulestyle.hide();
			
			break;
			
		case 'module':
			subtitle.hide();
			width.show();
			column.hide();
			subwidth.hide();
			positions.hide();
			modules.show();
			modulestyle.show();
			title.hide();
			//titleLink.hide();
			
			break;
			
		case 'position':
			subtitle.hide();
			width.show();
			column.hide();
			subwidth.hide();
			positions.show();
			modules.hide();
			modulestyle.hide();
			title.hide();
			//titleLink.hide();
			
			break;

		default:
			subtitle.show(); 
			width.show();
			column.show();
			subwidth.show();
			positions.hide();
			modules.hide();
			modulestyle.hide();
			title.hide();
			//titleLink.hide();
			
			break;
		}
		
	}
});