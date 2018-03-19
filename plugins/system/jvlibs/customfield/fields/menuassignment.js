(function($){
    CustomField.assignment = function(){
        var
            html = $('<div>',{'class':'ct ct-assignment'}),
            field = new CustomField({
                field: 'select2',
                title: this.title,
                label: this.label,
                createSearchChoice: function(){ 
                    return false
                },
                value: 0,
                item:{
                    0: 'On all pages',
                    '-': 'No page',
                    1: 'Only on the pages selected',
                    '-1': 'On all pages except those selected'
                }
            }),
            input = field.find('input.ct-select2-input').bind('select2-selecting',function(e){
                if(e.val == -1 || e.val == 1){
                    menus.is(':visible') || menus.slideDown();
                }else{
                    menus.is(':visible') && menus.slideUp();
                }
            }),
            buildMenus = function(data,parent){
                $.each(data,function(){
                    var
                        icon = $('<i>',{'class': 'icon-ok'}),
                        label = $('<span>').text(this.text),
                        tools = $('<div>',{'class':'controls btn-group'}).click(false),
                        line = $('<div>').append(icon, label, tools).click(function(){li.toggleClass('ct-checked')}),
                        li = $('<li>').append(line)
                    ;
                    li.data().item = this;
                    if(this.children && this.children.length){
                        var ul = $('<ul>');
                        li.append(ul);
                        buildMenus(this.children,ul);
                        
                        var 
                            toggleActive = $('<a>',{
                                href:'javascript:void(0)',
                                'class':'btn btn-mini ct-toggleall',
                                title: 'Click to toggle check/uncheck chilren menus.'
                            }).tooltip().append($('<i>',{'class':'icon-ok'})).click(function(){
                                var lis = ul.find('li');
                                toggleActive.toggleClass('active');
                                toggleActive.hasClass('active')?lis.filter(':not(.ct-checked)').addClass('ct-checked'):lis.filter('.ct-checked').removeClass('ct-checked');
                            }),
                            toggleVisible= $('<a>',{
                                href:'javascript:void(0)',
                                'class':'btn btn-mini ct-togglshow show-item',
                                title: 'Click to toggle show/hide.'
                            }).tooltip().append($('<i>',{'class':'icon-plus'})).click(function(){
                                var lis = ul.find('li');
                                toggleVisible.toggleClass('show-item');
                                ul.slideToggle();
                            })
                        ;
                        tools.append(toggleActive,toggleVisible);
                    } 
                    parent.append(li);
                });
            },
            ul = $('<ul>',{'class':'ct-assign-menus'}),
            head = $('<div>',{'class': 'head'}).append($('<span>').append('Select menus')).click(function(){
                ul.slideToggle();
            }),
            menus = $('<div>',{'class':'ct-round'}).append(head,ul)
        ;
        field.click(function(){
            //if()
        });
        buildMenus(CustomField.datas.menus,ul);
        $.extend(html.data(),{
            validate: function(){ return 0},
            data: function(val){
                if(val != undefined){
                    input.val(val.selected);
                    input.trigger('change');
                    if(val.selected == -1 || val.selected == 1) menus.show();
                    ul.find('li').each(function(){
                        var li = $(this)
                        if($.inArray(li.data().item.id,val.checked) > 0){
                            $(this).addClass('ct-checked');
                        }else $(this).removeClass('ct-checked');
                    });
                    return;
                }
                var 
                    selected = input.val(),
                    checkeds = []
                ;
                if(selected == 1 || selected == -1){
                    ul.find('li.ct-checked').each(function(){
                        checkeds.push($(this).data().item.id);
                    });
                }
                return {
                    selected: selected,
                    checked: checkeds
                };
            },
            clear: function(){}
        });
        return html.append(field,menus);
    }
})(jQuery);
