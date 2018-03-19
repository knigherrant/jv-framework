
var JVTabsAdmin = window.JVTabsAdmin || (function($){
    return $.extend(function(ops){
        var
            btnPanel = $(ops.button),
            button = $('<a>',{ 
                href: 'javascript:void(0)',
                'class': 'btn', 
                id: 'btnJVTabs'
            }).append('JV Tabs...').prependTo(btnPanel),
            editor = ops.editor,
            selection = editor.selection,
            params = new CustomField({
                field: 'panel',
                'class': 'none',
                item: {
                    tabs: {
                        field: 'multi',
                        label: 'Tabs',
                        filter: true,
                        sortable: true,
                        'class': 'linehead-left',
                        item: {
                            field: 'filter',
                            label: 'Tab from',
                            item:{
                                position: {
                                    field: 'panel',
                                    label: 'Choose position',
                                    item:{
                                        position: {
                                            field: 'select2',
                                            label: 'Choose position',
                                            data: {results: CustomField.datas.positions},
                                            validates: {required: true}
                                        }
                                    }
                                },
                                article: {
                                    field: 'panel',
                                    label: 'Choose Aricle',
                                    item:{
                                        id: {
                                            field: 'select2',
                                            minimumInputLength: 1,
                                            label: 'Select article',
                                            validates:{required:true},
                                            ajax: {
                                                dataType: 'json',
                                                data: function (term, page) { 
                                                    return { 
                                                        jvtabaction: 'find_article',
                                                        term: term
                                                    };
                                                },
                                                results: function (data, page) { return {results: data};}
                                            }
                                        },
                                        render: {
                                            field: 'select2',
                                            label: 'Render',
                                            validates:{required:true},
                                            value: 'intro',
                                            item:{
                                                intro: 'Intro',
                                                full: 'Full article',
                                                text: 'Only text'
                                            }
                                        }
                                    }
                                },
                                queryarticle:{
                                    label: 'Query articles',
                                    field: 'panel',
                                    item:{
                                        cate: {
                                            field: 'select2',
                                            label: 'Categories',
                                            tags: [],
                                            tokenSeparators: [' '],
                                            title: 'Please input category id with int.'
                                        },
                                        incate:{
                                            field: 'input',
                                            type: 'checkbox',
                                            value: true,
                                            label: 'In categories',
                                            title: 'On: Select in categories. Off: Select not in categories'
                                        },
                                        author: {
                                            field: 'select2',
                                            label: 'Authors',
                                            tags: [],
                                            tokenSeparators: [' '],
                                            title: 'Please input category id with int.'
                                        },
                                        inauthor:{
                                            field: 'input',
                                            type: 'checkbox',
                                            value: true,
                                            label: 'In authors',
                                            title: 'On: Select in authors. Off: Select not in authors'
                                        },
                                        order:{
                                            field: 'select2',
                                            label: 'Order by',
                                            value: 'ordering',
                                            item: {
                                                ordering: 'Ordering',
                                                publish_up: 'Date Publish',
                                                created: 'Date created',
                                                hits: 'Hits point'
                                            }
                                        },
                                        dir: {
                                            field: 'select2',
                                            label: 'Order direction',
                                            value: 'ASC',
                                            item: {
                                                'ASC': 'Ascending (ASC)',
                                                'DESC': 'Descending (DESC)'
                                            }
                                        },
                                        offset: {
                                            label: 'Start offsset',
                                            field: 'input',
                                            value: 0,
                                            validates:{number: true}
                                        },
                                        limit: {
                                            label: 'Limit items',
                                            field: 'input',
                                            value: 5,
                                            validates:{number: true}
                                        },
                                        featured: {
                                            field: 'select2',
                                            label: 'Filter',
                                            value: 'show',
                                            item: {
                                                show: 'All article',
                                                hide: 'No Featured',
                                                only: 'Only Featured'
                                            }
                                        },
                                        render: {
                                            field: 'select2',
                                            label: 'Render',
                                            validates:{required:true},
                                            value: 'intro',
                                            item:{
                                                intro: 'Intro',
                                                full: 'Full article',
                                                text: 'Only text'
                                            }
                                        }
                                    }
                                },
                                k2item: {
                                    field: 'panel',
                                    label: 'Choose K2 item',
                                    item:{
                                        id: {
                                            field: 'select2',
                                            minimumInputLength: 1,
                                            label: 'Select k2 item',
                                            validates:{required:true},
                                            ajax: {
                                                dataType: 'json',
                                                data: function (term, page) { 
                                                    return { 
                                                        jvtabaction: 'find_k2',
                                                        term: term
                                                    };
                                                },
                                                results: function (data, page) { return {results: data};}
                                            }
                                        },
                                        render: {
                                            field: 'select2',
                                            label: 'Render',
                                            validates:{required:true},
                                            value: 'intro',
                                            item:{
                                                intro: 'Intro',
                                                text: 'Only text'
                                            }
                                        }
                                    }
                                },
                                queryk2:{
                                    label: 'Query K2 items',
                                    field: 'panel',
                                    item:{
                                        cate: {
                                            field: 'select2',
                                            label: 'From categories (id)',
                                            tags: [],
                                            tokenSeparators: [' '],
                                            title: 'Please input category id with int.'
                                        },
                                        order:{
                                            field: 'select2',
                                            multiple: true,
                                            label: 'Order by',
                                            item: {
                                                publish_asc: 'Publish up ASC',
                                                publish_desc: 'Publish up DESC',
                                                ordering_asc: 'Ordering ASC',
                                                ordering_desc: 'Ordering DESC',
                                                hits_asc: 'Hits ASC',
                                                hits_desc: 'Hits DESC'
                                            }
                                        },
                                        offset: {
                                            label: 'Start offsset',
                                            field: 'input',
                                            value: 0,
                                            validates:{number: true}
                                        },
                                        limit: {
                                            label: 'Limit items',
                                            field: 'input',
                                            value: 5,
                                            validates:{number: true}
                                        },
                                        featured: {
                                            field: 'select2',
                                            label: 'Filter',
                                            value: 'all',
                                            item: {
                                                all: 'All article',
                                                nofeatured: 'No Featured',
                                                onlyfeatured: 'Only Featured'
                                            }
                                        },
                                        render: {
                                            field: 'select2',
                                            label: 'Render',
                                            validates:{required:true},
                                            value: 'intro',
                                            item:{
                                                intro: 'Intro',
                                                text: 'Only text'
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    config:{
                        field: 'group',
                        label: 'Config',
                        style: 'margin-top: 20px',
                        item: {
                            effect: {
                                field: 'select2',
                                label: 'Effect type',
                                value: 'fade',
                                item:{
                                    fade: 'Fade',
                                    vslide: 'Vertical slide',
                                    hslide: 'Horizontal slide',
                                    vdrop: 'Vertical drop',
                                    hdrop: 'Horizontal drop'
                                }
                            },
                            duration:{
                                field: 'input',
                                label: 'Duration',
                                value: 500,
                                validates:{number: true}
                            },
                            auto: {
                                field: 'input',
                                label: 'Auto time (ms)',
                                title: 'Set 0 to disable auto.',
                                value: 0,
                                validates:{number: true}
                            },
                            navPos: {
                                field: 'select2',
                                label: 'Nav position',
                                value: 'top',
                                item:{
                                    top: 'Top',
                                    right: 'Right',
                                    bottom: 'Bottom',
                                    left: 'Left',
                                }
                            },
                            maxHeight:{
                                field: 'input',
                                label: 'Max height',
                                value: 'none',
                                validates:{reg: /^none$|^[0-9]+(%|px|em)?$/i}
                            },
                            minHeight: {
                                field: 'input',
                                label: 'Min height',
                                value: '100',
                                validates:{reg: /^[0-9]+(%|px|em)?$/i}
                            },
                            navSlide: {
                                field: 'input',
                                type: 'checkbox',
                                label: 'Nav slide',
                                value: true
                            },
                            load: {
                                field: 'select2',
                                label: 'Render with',
                                value: 'all',
                                item: {
                                    all: 'All',
                                    cache: 'Cache'
                                }
                            }
                        }
                    }
                }
            }),
            editNode = function(node){
                var node = $(node);
                params.data().clear();
                if(node.is('a.jvtabs')){
                    params.data().data(JSON.parse(node.html()));
                }
                dialog.modal('show');
            },
            shorParams = function(data){
                
                return data;
            }
        ;
        var
            btnApply = $('<button>',{type: 'button', 'class': 'btn btn-primary', 'data-dismiss':'modal'}).append('Save'),
            btnCancel = $('<button>',{type: 'button', 'class': 'btn btn-default', 'data-dismiss':'modal'}).append('Close'),
            btnClose = $('<button>',{type:'button','class':"close", 'data-dismiss':"modal", 'aria-hidden':"true"}).html('&times;'),
            head = $('<div>',{'class': 'modal-header'}).append(btnClose,$('<h4>').append('JV Tabs config')),
            body = $('<div>',{'class': 'modal-body'}).append(params),
            footer = $('<div>',{'class': 'modal-footer'}).append(btnApply,btnCancel),
            dialog = $('<div>',{'class': 'modal fade',id:'jvtabsconfig'}).append(head,body,footer)
        ;
        btnApply.click(function(){
            if(params.data().validate() > 0) return false;
            
            var 
                node = $(selection.getNode()),
                data = JSON.stringify(shorParams(params.data().data()))
            ;
            
            if(node.is('a.jvtabs')){
                node.html(data);
                return;
            }
            var newTab = $('<a>',{'class':'jvtabs',contentEditable: false}).html(data)[0];
            if(node.is('img')){
                node.after(newTab);
            }else{
                selection.setNode(newTab);
            }
        });
        var doc = $(editor.getDoc())
            .on('dblclick','a.jvtabs',function(){
                editNode(this);
            }).on('click','a.jvtabs',function(){ 
                $(this).addClass('focus');
            }).bind('mouseup',function(e){            
                doc.find('a.jvtabs.focus').not(e.target).removeClass('focus');
            });
        
        
        button.click(function(){
            editNode(selection.getNode());
        });
        
        
    },{
        
    });
})(jQuery);