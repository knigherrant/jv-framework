var JVColor = (function($){
    var func = {
        init: function(countset){
            this.countset = countset;
        },
        addNew: function(){
            var seft = this;
            this.countset = this.countset + 1;
            $('#themecolor-list #themecolor-container') .append( 
                    '<div id="themecolor-'+ this.countset+ '" class="themecolor-item">' +
                            '<div class="themecolor-close">' +
                                    '<a class="ui-state-default ui-corner-all themecolor-button" href="javascript:void(0)" onclick="JVColor.removeItem(this)" title="Remove">X</a>' +
                            '</div>' +
                            '<div>' +
                                '<div class="themecolor-inputs">' +

                                    '<div class="themecolor-input-color">' +
                                        '<label>Custom Color</label>' +
                                        '<input type="text" class="minicolors themecolor-color new-'+this.countset+'" placeholder="" />' +
                                    '</div>' +	
                                    '<div class="themecolor-input-selector">' +
                                            '<label>Selector</label>' +
                                            '<select class="inputbox selector snew-'+this.countset+'">' +
                                                seft.getOption() +
                                            '</select>' +
                                    '</div>' +
                                    '<div class="themecolor-input">' +
                                        '<label>Custom Css</label>' +
                                        '<textarea class="themecolor-css" >a</textarea>' +
                                    '</div>' +
		
                                    '<div class="clr"></div>' +
                                '</div>' +
                            '</div>' +
                        '</div>'
             );
            $('#themecolor-list #themecolor-container').find('.snew-'+ this.countset).chosen({
                        disable_search_threshold : 10,
                        allow_single_deselect : true
                });
            $('#themecolor-list #themecolor-container').find('.new-'+ this.countset).minicolors({
                    control: jQuery(this).attr('data-control') || 'hue',
                    position: jQuery(this).attr('data-position') || 'right',
                    theme: 'bootstrap'
                });
            
        },
        toggle: function(el){
            $(el).parent().next().slideToggle(200);
        },
        setValues: function(){
            var data = {};
            data['list'] = new Array();
            $.each($('#themecolor-list .themecolor-item'), function(i, item){
                data['list'][i] = {};
                data['list'][i].css = $(item).find('textarea.themecolor-css').val();
                data['list'][i].color = $(item).find('input.themecolor-color').val();
                data['list'][i].selector = $(item).find('select.selector').find('option:selected').val();
            });
            $('#jform_params_styles_cthemecolor').val(JSON.stringify(data));
            $('#params_styles_cthemecolor').val(JSON.stringify(data));
        },
        removeItem: function(el){
            $(el).parent().parent().stop(true,true).fadeOut('200', function(){$(this).remove()});
        },
        getOption: function(){
            var html = '';
            html=  '<option value="background-color">Background</option>' +	'<option value="border-color">Border</option>'+	'<option value="color">Color</option>';
            return html;

        }
    }   

   	return func;
                	
})(jQuery);