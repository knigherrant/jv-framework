{
    filter: true,
    id: 'slidesource',
    field: 'multi',
    label: 'Slide source',
    sortable: true,
    'class': 'blue',
    title: 'Get source from list images.(Click '+' to add new image.)',
    value: {"@data":[{"input":{"title":"Slide 1","path":"modules\/mod_jvslidepro\/images\/1.jpg","desc":"Description 1","@state":{"field":"panel"}},"article":{"@data":"","@state":{"data":null,"field":"select2"}},"k2article":{"@data":"","@state":{"data":null,"field":"select2"}},"@state":{"selected":"input","toggle":false,"field":"filter"}},{"input":{"title":"Slide 2","path":"modules\/mod_jvslidepro\/images\/2.jpg","desc":"<a href=\"http:\/\/joomlavi.com\">Description 2<\/a>","@state":{"field":"panel"}},"article":{"@data":"1","@state":{"data":{"text":"Getting Started","id":"1"},"field":"select2"}},"k2article":{"@data":"","@state":{"data":null,"field":"select2"}},"@state":{"selected":"input","toggle":false,"field":"filter"}},{"input":{"title":"Slide 3","path":"modules\/mod_jvslidepro\/images\/3.jpg","desc":"<a href=\"http:\/\/joomlavi.com\">Description 3<\/a>","@state":{"field":"panel"}},"article":{"@data":"","@state":{"data":null,"field":"select2"}},"k2article":{"@data":"","@state":{"data":null,"field":"select2"}},"@state":{"selected":"input","toggle":false,"field":"filter"}},{"input":{"title":"Slide 4","path":"modules\/mod_jvslidepro\/images\/4.jpg","desc":"","@state":{"field":"panel"}},"article":{"@data":"","@state":{"data":null,"field":"select2"}},"k2article":{"@data":"","@state":{"data":null,"field":"select2"}},"@state":{"selected":"input","toggle":false,"field":"filter"}}]},
    item: {
        field: 'filter',
        label: 'Slide with',
        selected: 'input',
        'class': 'source-listitem',
        item:{
            input: {
                label: 'Input image url',
                field: 'panel',
                'class': 'slideinput',
                item: {
                    title: {
                        field: 'input',
                        type: 'text',
                        label: 'Image title',
                        title: 'Input image title for slide.'
                    },
                    path: {
                        field: 'input',
                        loop: 'media',
                        type: 'text',
                        'class': 'imgpath',
                        label: 'Image path',
                        events: {
                            ct_created: function(){
                                var 
                                    self = arguments.callee,
                                    $this = $(this),
                                    img = $('<img>'),
                                    div = $('<div>',{'class':'slide-preview'}).append(img),
                                    parent,
                                    input = $this.children('input')
                                ;
                                
                                input.change(function(){
                                    var 
                                        src = input.val()
                                    ;
                                    if(src.indexOf('http') != 0) src = '../' + src;
                                    
                                    $('<img>',{src: src}).imagesLoaded(function(e,success){
                                        if(!success.length) img.attr('src','../modules/mod_jvslidepro/assets/404-not-found.gif');
                                        else img.attr('src',src);
                                    });
                                });
                                var btnSelect = $('<a>',{
                                    href: 'javascript:void(0)',
                                    'class': 'modal btn btn-selectimage',
                                    title: 'Select an image from com media',
                                    text: 'Select'
                                }).tooltip().click(function(e){
                                    e.preventDefault();
                                    var lastCallBack = window.jInsertFieldValue;
                                    window.jInsertFieldValue = function(val){
                                        input.val(val);
                                        input.change();
                                    }
                                    SqueezeBox.open('index.php?option=com_media&view=images&tmpl=component&asset=35&author=7&fieldid=jform_images_image_intro&folder=',{
                                        handler: "iframe",
                                        size: {x: 800, y: 595},
                                        onClose: function(){
                                            window.jInsertFieldValue = lastCallBack;
                                        }
                                    });
                                    
                                    return false;
                                });
                                input.before(btnSelect);
                                setTimeout(function(){
                                    parent = $this.parents('.ct-panel-body:first').before(div);
                                    if(input.val()) input.change();
                                },0);
                            }
                        },
                        validates:{required:true},
                        title: 'Input your path of image. ("./" will be replace the root site ).'
                    },
                    thumb:{
                        field: 'input',
                        loop: 'mediathumb',
                        type: 'text',
                        'class': 'imgpath',
                        label: 'Thumbnails',
                        events: {
                            ct_created: function(){
                                var 
                                    self = arguments.callee,
                                    $this = $(this),
                                    input = $this.children('input')
                                ;
                                var btnSelect = $('<a>',{
                                    href: 'javascript:void(0)',
                                    'class': 'modal btn btn-selectimage',
                                    title: 'Select an image from com media',
                                    text: 'Select'
                                }).tooltip().click(function(e){
                                    e.preventDefault();
                                    var lastCallBack = window.jInsertFieldValue;
                                    window.jInsertFieldValue = function(val){
                                        input.val(val);
                                        input.change();
                                    }
                                    SqueezeBox.open('index.php?option=com_media&view=images&tmpl=component&asset=35&author=7&fieldid=jform_images_image_intro&folder=',{
                                        handler: "iframe",
                                        size: {x: 800, y: 595},
                                        onClose: function(){
                                            window.jInsertFieldValue = lastCallBack;
                                        }
                                    });
                                    
                                    return false;
                                });
                                input.before(btnSelect);
                                setTimeout(function(){
                                    if(input.val()) input.change();
                                },0);
                            }
                        },
                        title: 'Input your path of image. ("./" will be replace the root site ).'
                    },
                    desc: {
                        field: 'textarea',
                        type: 'text',
                        label: 'Description',
                        autoHeight: true,
                        title: 'Input image description.'
                    }                                
                }
            },
            youtube: {
                label: 'Youtube video',
                field: 'panel',
                'class': 'slideinput',
                item: {
                    title: {
                        field: 'input',
                        type: 'text',
                        label: 'Video title',
                        title: 'Input video title for slide.'
                    },
                    url: {
                        field: 'input',
                        type: 'text',
                        label: 'Youtube url',
                        title: 'Input youtube url.'
                    },
                    path: {
                        use: 'media',
                        label: 'Image cover',
                        title: 'Input your path of image. ("./" will be replace the root site ).'
                    },
                    thumb:{
                        use: 'mediathumb'
                    },
                    desc: {
                        field: 'textarea',
                        type: 'text',
                        label: 'Description',
                        autoHeight: true,
                        title: 'Input image description.'
                    }                                
                }
            },
            article: {
                field: 'panel',
                label: 'Choose article',
                item:{
                    from: {
                        field: 'select2',
                        minimumInputLength: 1,
                        label: 'Select article',
                        validates:{required:true},
                        ajax: {
                            dataType: 'json',
                            data: function (term, page) { 
                                return { 
                                    jvcts: 'modules/mod_jvslidepro/libs/findarticle.php',
                                    term: term
                                };
                            },
                            results: function (data, page) { return {results: data};}
                        }
                    },
                    path: {
                        field: 'select2',
                        label: 'Show image',
                        value: 'full',
                        item:{
                            none: 'None',
                            intro: 'Image Intro',
                            full: 'Image Full'
                        },
                        title: 'Select image to slide, if full image is null it will auto select intro image, it\'s none if both has empty.'
                    },
                    readmore: {
                        field: 'input',
                        label: 'Show readmore',
                        value: 'Read more',
                        title: 'Input this text to read more buttons, empty to disable read more button.'
                    },
                    thumb: {
                        field: 'input',
                        type: 'checkbox',
                        label: 'Thumb with image intro'
                    }
                }
            },
            k2article: {
                field: 'panel',
                label: 'Choose k2 article',
                item: {
                    from: {
                        field: 'select2',
                        minimumInputLength: 1,
                        label: 'Choose k2 article',
                        validates:{required:true},
                        ajax: {
                            dataType: 'json',
                            data: function (term, page) { 
                                return { 
                                    jvcts: 'modules/mod_jvslidepro/libs/findk2article.php',
                                    term: term
                                };
                            },
                            results: function (data, page) { return {results: data};}
                        }
                    },
                    path: {
                        field: 'select2',
                        label: 'Show image',
                        value: 'full',
                        item:{
                            none: 'None',
                            intro: 'Image Intro',
                            full: 'Image Full'
                        },
                        title: 'Select image to slide, if full image is null it will auto select intro image, it\'s none if both has empty.'
                    },
                    readmore: {
                        field: 'input',
                        label: 'Show readmore',
                        value: 'Read more',
                        title: 'Input this text to read more buttons, empty to disable read more button.'
                    },
                    thumb: {
                        field: 'input',
                        type: 'checkbox',
                        label: 'Thumb with image intro'
                    }
                }
            },
            folder: {
                label: 'Form folder',
                field: 'panel',
                item: {
                    path: {
                        field: 'input',
                        label: 'Path',
                        placeholder: './modules/mod_jvslidepro/images',
                        value: './modules/mod_jvslidepro/images'
                    },
                    filter: {
                        field: 'input',
                        label: 'Filter regex',
                        value: '.'
                    },
                    accept:{
                        field: 'select2',
                        tokenSeparators: [' '],
                        tags:['PNG','JPG','GIF','BMP'],
                        label: 'Accept exts',
                        validates:{required:true},
                        value: ['PNG','JPG','GIF','BMP'],
                        placeholder: 'PNG JPG GIF BMP',
                    }
                }
            },
            queryarticle:{
                label: 'Query articles',
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
                        value: 0
                    },
                    limit: {
                        label: 'Limit items',
                        field: 'input',
                        value: 5
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
                    path: {
                        field: 'select2',
                        label: 'Show image',
                        value: 'full',
                        item:{
                            none: 'None',
                            intro: 'Image Intro',
                            full: 'Image Full'
                        },
                        title: 'Select image to slide, if full image is null it will auto select intro image, it\'s none if both has empty.'
                    },
                    readmore: {
                        field: 'input',
                        label: 'Show readmore',
                        value: 'Read more',
                        title: 'Input this text to read more buttons, empty to disable it.'
                    },
                    thumb: {
                        field: 'input',
                        type: 'checkbox',
                        label: 'Thumb with image intro'
                    }
                }
            },
            queryK2:{
                label: 'Query K2 articles',
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
                        value: 0
                    },
                    limit: {
                        label: 'Limit items',
                        field: 'input',
                        value: 5
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
                    path: {
                        field: 'select2',
                        label: 'Show image',
                        value: 'full',
                        item:{
                            none: 'None',
                            intro: 'Image Intro',
                            full: 'Image Full'
                        },
                        title: 'Select image to slide, if full image is null it will auto select intro image, it\'s none if both has empty.'
                    },
                    readmore: {
                        field: 'input',
                        label: 'Show readmore',
                        value: 'Read more',
                        title: 'Input this text to read more buttons, empty to disable it.'
                    },
                    thumb: {
                        field: 'input',
                        type: 'checkbox',
                        label: 'Thumb with image intro'
                    }
                }
            }
        }
    }
}