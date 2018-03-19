var JVAjaxShopSearchModel = (function($){
    ko.bindingHandlers.numeric = {
        init: function (element, valueAccessor) {
            $(element).on("keydown", function (event) {
                // Allow: backspace, delete, tab, escape, and enter
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
                    // Allow: Ctrl+A
                    (event.keyCode == 65 && event.ctrlKey === true) ||
                    // Allow: . , f1-f12
                    (event.keyCode == 188 || event.keyCode == 190 || event.keyCode == 110 || (event.keyCode >=112 && event.keyCode <=123)) ||
                    // Allow: home, end, left, right
                    (event.keyCode >= 35 && event.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                else {
                    // Ensure that it is a number and stop the keypress
                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                        event.preventDefault();
                    }
                }
            });
        }
    };

    ko.bindingHandlers.sliderValue = {
        init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
            var params = valueAccessor();

            // Check whether the value observable is either placed directly or in the paramaters object.
            if (!(ko.isObservable(params) || params['value']))
                throw "You need to define an observable value for the sliderValue. Either pass the observable directly or as the 'value' field in the parameters.";

            // Identify the value and initialize the slider
            var valueObservable;
            if (ko.isObservable(params)) {
                valueObservable = params;
                $(element).slider({value: ko.unwrap(params)});
            }
            else {
                valueObservable = params['value'];
                // Replace the 'value' field in the options object with the actual value
                params['value'] = ko.unwrap(valueObservable);
                $(element).slider(params);
            }

            // Make sure we update the observable when changing the slider value
            $(element).on('slide', function (ev) {
                valueObservable(ev.value);
            });

        },
        update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
            var modelValue = valueAccessor();
            var valueObservable;
            if (ko.isObservable(modelValue))
                valueObservable = modelValue;
            else
                valueObservable = modelValue['value'];

            $(element).slider('setValue', valueObservable());
        }
    };

    return function(options){
        var self = this;
        self.loading = ko.observable(false);
        self.name = ko.observable('');
        self.from = ko.observable('');
        self.to = ko.observable('');
        self.products = ko.observableArray();
        self.col = ko.observable(options.max_cols);
        self.relatedPage = ko.observable(1);
        self.source = ko.observable(options.source);
        self.show_image = ko.observable(options.show_image);
        self.show_title = ko.observable(options.show_title);
        self.show_price = ko.observable(options.show_price);
        self.show_desc = ko.observable(options.show_desc);
        self.show_addtocart = ko.observable(options.show_addtocart);
        self.image_pos = ko.observable(options.image_pos);
        self.image_align = ko.observable(options.image_align);
        self.pagination_position = ko.observable(options.pagination_position);

        self.gridProductsModel = new ko.simpleGrid.viewModel({
            data: self.products,
            pagePos: self.pagination_position(),
			source: self.source(),
            columns: [
                {product_id: "product_id"}
            ],
            pageSize: options.max_cols*options.max_rows
        });


        if(options.price_style == 'slider'){
            self.priceSlider = ko.observable([options.price_slider_min, options.price_slider_max]);
            var defaultFrom = options.price_slider_min;
            var defaultTo = options.price_slider_max;
            self.priceSlider.subscribe(function(value){
                if(value[0] == defaultFrom && value[1] == defaultTo){
                    defaultFrom = '';
                    defaultTo = ''
                }else{
                    self.from(value[0]);
                    self.to(value[1]);
                }
            });
        }

        self.search = ko.computed(function() {
            if(!self.name() && !self.to() && !self.from()) {self.products([]); return;}
            self.loading(true);
            $.ajax({
                url: 'index.php?plugin=jvajax_shop_search',
                type: 'post',
                dataType: 'json',
                data: {
                    task: 'search',
                    source: self.source(),
                    name: self.name(),
                    from: self.from(),
                    to: self.to(),
                    cid: options.cid,
                    currency: options.currency,
                    desc_limit_char: options.desc_limit_char,
                    Itemid: options.Itemid,
                    current_url: options.current_url
                },
                success: function(data){
                    self.loading(false);
                    self.products(data);
                    if(self.show_addtocart() && self.source() == 'virtuemart') {
                        setTimeout(function(){
                            Virtuemart.product($("form.product"));
                        }, 200);
                    }
                }
            });
        }).extend({ throttle: 500 });

        self.isRelated = function(value, currPage){
            for(var i=1; i<=self.relatedPage(); i++) if(currPage - value == i || value - currPage == i) return true;
            return false;
        }

        self.checkShowPage = function(max, currPage, value){
            if(value == 1 || value == max) return true;
            return isRelated = self.isRelated(value, currPage);
        }
        self.showPage = function(max, currPage, value){
            max = max + 1;
            currPage = currPage + 1;
            value = value + 1;

            if(!self.checkShowPage(max, currPage, value) && self.checkShowPage(max, currPage, value-1) && self.checkShowPage(max, currPage, value+1)) return true;
            else return self.checkShowPage(max, currPage, value);
        }

        if(options.show_style == 'popup'){
            $('body').click(function(event){
                if(!$(event.target).parents('#jvajax_shop_search'+options.moduleid).length){
                    self.products([]);
                }
            });
        }

    }
})($JVAS);