<?php JFormFieldJVCustom::import('assignment');?>
{
    name: 'Replace scripts',
    version: '1.0.0',
    config: {
        config: {
            label: 'Replace scripts',
            field: 'multi',
            filter: true,  
            sortable: true,
            'class': 'none',
            buttons:[
                {
                    icon: 'icon-search',
                    label: 'Find from url',
                    callback: (function($){
                        var 
                            inputLink = $('<input>',{
                                type:'text', 
                                placeholder: 'Input url search scripts!...', 
                                value: location.href.split('administrator')[0]
                            }),
                            btnFind = $('<a>',{'class': 'btn', text: 'Find'}).click(function(){
                                list.empty();
                                $.ajax({
                                    url: inputLink.val(),
                                    success: function(resutl){
                                        var tags = $(resutl.split(/<head>|<\/head>/gi)[1]);
                                        tags = tags.filter('script[src]');
                                        list.empty();
                                        tags.each(function(){
                                            var li = $('<li>').append($('<label>').append(
                                                $('<input>',{type: 'checkbox'}),
                                                $('<span>',{text: $(this).attr('src')})
                                            ));
                                            list.append(li);
                                        });
                                    }
                                });
                            }),
                            tools = $('<div>',{'class': 'dialog-findscript-head'}).append(inputLink,btnFind),
                            list = $('<ul>')
                        ;
                        
                        var 
                            head = $('<div>',{'class': 'modal-header'}).append(
                                $('<button>',{type: 'button', 'class': 'close', 'data-dismiss':'modal', text:'x'}),
                                $('<h3>',{text: 'Find javascript file url'})
                            ),
                            body = $('<div>',{'class':'modal-body dialog-findscript'}).append(tools,list),
                            footer = $('<div>',{'class': 'modal-footer'}).append(
                                $('<a>',{'class': 'btn', text: 'Close'}).click(function(){ modal.modal('hide')}),
                                $('<a>',{'class': 'btn  btn-primary', text: 'Add'}).click(function(){
                                    var data = [];
                                    list.children().each(function(){
                                        var li = $(this);
                                        !li.find('input').is(':checked') ||
                                        data.push({
                                            from: li.find('span').text()
                                                    .replace(/\\/g,'\\\\')
                                                    .replace(/\//g,'\\/')
                                                    .replace(/\./g,'\\.')
                                        });
                                    });
                                    
                                    CustomField.fields['jform_params_configs'].data().fields('replacescripts').data().fields('config').data().data({'@data':data});
                                    modal.modal('hide');
                                })
                            ),
                            modal = $('<div>',{'class':"modal hide fade"}).append(head,body,footer)
                        ;
                        return function(){ modal.modal('show');}
                    })(jQuery)
                }
            ],
            item: {
                from: {
                    label: 'Replace from (Reg)',
                    validates: {
                        required: true
                    },
                    field: 'input'
                },
                to:{
                    label: 'To url',
                    field: 'input'
                },
                assignmenu: {
                    field: 'assignment',
                    label: 'Menu Assignment',
                    multicheck: true,
                    data: {results: CustomField.datas.menus},
                    validates: {required: true}
                }
            }
        }
    }
}