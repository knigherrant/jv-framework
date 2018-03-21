var jCarousel = (function($){
    var func = {
        init: function(countset){
            this.countset = countset;
        },
        addNewSet: function(){
            var seft = this;
            this.countset = this.countset + 1;
            $('#jCarousel-list #jCarousel-container')
            .prepend(
                '<div id="jCarousel-'+ this.countset+ '" class="jCarousel-item">' +
                    '<div class="jCarousel-title">' +
                        '<div class="jCarousel-handle"><span class="ui-icon ui-icon-arrow-4"></span></div>' +
                        '<div onclick="jCarousel.toggle(this)">Title slider - ' + this.countset + '</div>' +
                        '<div class="jCarousel-title-control">' +
                            '<a class="ui-state-default ui-corner-all jCarousel-button" href="javascript:void(0)" onclick="jCarousel.removeItem(this)" title="Remove"><span class="ui-icon ui-icon-close"></span></a>' +
                        '</div>' +
                    '</div>' +
                    '<div>' +
                        '<div class="jCarousel-inputs">' +
                            '<div class="jCarousel-maininfo">' +
                                '<div class="jCarousel-input">' +
                                    '<label>Title</label>' +
                                    '<input  type="text"   class="jCarousel-title" value="jvSlider - '+ this.countset +'"/>' +
                                '</div>' +
								
								'<div class="clr"></div>' +
                                '<div class="jCarousel-input">' +
                                    '<label>Element (.class || #Id)</label>' +
                                    '<input type="text"  value="" class="jCarousel-element"/>' +
                                '</div>' +
								
                                '<div class="clr"></div>' +
								'<div class="jCarousel-input">' +
                                    '<label>Vertical</label>' +
                                    '<select class="jCarousel-vertical">' +
									seft.getOption('vertical') +
									'</select>' +
                                '</div>' +
                                '<div class="clr"></div>' +
								'<div class="jCarousel-input">' +
                                    '<label>Rtl</label>' +
                                   '<select class="jCarousel-rtl">' +
									seft.getOption('rtl') +
									'</select>' +
                                '</div>' +
								 '<div class="clr"></div>' +
								'<div class="jCarousel-input">' +
                                    '<label>Start</label>' +
                                    '<input type="text"  value="1" class="jCarousel-start"/>' +
                                '</div>' +
								'<div class="clr"></div>' +
								'<div class="jCarousel-input">' +
                                    '<label>Offset</label>' +
                                    '<input type="text" value="1" class="jCarousel-offset"/>' +
                                '</div>' +
                                '<div class="clr"></div>' +
                                '<div class="jCarousel-input">' +
                                    '<label>Scroll</label>' +
                                    '<input type="text"  value="3" class="jCarousel-scroll"/>' +
                                '</div>' +
                                
                                '<div class="clr"></div>' +
                                '<div class="jCarousel-input">' +
                                    '<label>Wrap</label>' +
                                    '<input type="text"  value="circular" class="jCarousel-wrap"/>' +
                                '</div>' +
                              
                               
							   '<div class="clr"></div>' +
                                '<div class="jCarousel-input">' +
                                    '<label>Auto</label>' +
                                    '<select class="jCarousel-auto">' +
									seft.getOption('auto') +
									'</select>' +
                                '</div>' +
							   
                                '<div class="clr"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' 
            );
        },
        toggle: function(el){
            $(el).parent().next().slideToggle(200);
        },
        jCarouselSetValue: function(){
            var data = {};
            data['list'] = new Array();
            $.each($('#jCarousel-container .jCarousel-item'), function(i, item){
                data['list'][i] = {};
				data['list'][i].element = $(item).find('input.jCarousel-element').val();
                data['list'][i].title = $(item).find('input.jCarousel-title').val();
                data['list'][i].vertical = $(item).find('select.jCarousel-vertical').val();
                data['list'][i].rtl = $(item).find('select.jCarousel-rtl').val();
                data['list'][i].start = $(item).find('input.jCarousel-start').val();
                data['list'][i].offset = $(item).find('input.jCarousel-offset').val();
                data['list'][i].scroll = $(item).find('input.jCarousel-scroll').val();
                data['list'][i].wrap = $(item).find('input.jCarousel-wrap').val();
                //data['list'][i].height = $(item).find('input.jCarousel-height').val();
                data['list'][i].auto = $(item).find('select.jCarousel-auto').val();
            });
            $('#jform_params_jcarousel_params').val(JSON.stringify(data));
            $('#params_jcarousel_params').val(JSON.stringify(data));
        },
        removeItem: function(el){
            $(el).parent().parent().parent().stop(true,true).fadeOut('200', function(){$(this).remove()});
        },
        getOption: function(type){
                var html = '';
                if(type=='vertical' ){
                        html=  '<option value="false">False</option>' +	'<option value="true">True</option>';
                }else if(type=='auto' || type=='rtl' ){
                        html=  '<option value="0">No</option>' +	'<option value="1">Yes</option>';
                }
                return html;

        }
		

        
    }   
                	
   	return func;
                	
})(jQuery);