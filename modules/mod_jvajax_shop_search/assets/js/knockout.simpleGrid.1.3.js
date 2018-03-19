(function($){
    // Private function
    function getColumnsForScaffolding(data) {
        if ((typeof data.length !== 'number') || data.length === 0) {
            return [];
        }
        var columns = [];
        for (var propertyName in data[0]) {
            columns.push({ headerText: propertyName, rowText: propertyName });
        }
        return columns;
    }

    ko.simpleGrid = {
        // Defines a view model class you can use to populate a grid
        viewModel: function (configuration) {
            this.data = configuration.data;
            this.currentPageIndex = ko.observable(0);
            this.pageSize = configuration.pageSize || 5;
            this.pagePos = configuration.pagePos || 'top';
			this.source = configuration.source;

            // If you don't specify columns configuration, we'll use scaffolding
            this.columns = configuration.columns || getColumnsForScaffolding(ko.utils.unwrapObservable(this.data));

            this.itemsOnCurrentPage = ko.computed(function () {
                var startIndex = this.pageSize * this.currentPageIndex();
				if(this.source == 'virtuemart'){
					setTimeout(function(){
						Virtuemart.product($("form.product"));
					}, 500);
				}
                return this.data().slice(startIndex, startIndex + this.pageSize);
            }, this);

            var self = this;
            this.data.subscribe(function(val){
                /*if(self.currentPageIndex() >= val.length){
                    if(val.length -1 >= 0){
                        self.currentPageIndex(val.length -1);
                    }
                }*/
                self.currentPageIndex(0);
            });
            this.maxPageIndex = ko.computed(function () {
                return Math.ceil(ko.utils.unwrapObservable(this.data).length / this.pageSize) - 1;
            }, this);

            this.gridPrev = function(data){
                if(data.currentPageIndex())
                    data.currentPageIndex(data.currentPageIndex()-1)
            }
            this.gridNext = function(data){
                if(data.currentPageIndex() < data.maxPageIndex())
                    data.currentPageIndex(data.currentPageIndex()+1)
            }
        }
    };

// Templates used to render the grid
    var templateEngine = new ko.nativeTemplateEngine();

    templateEngine.addTemplate = function(templateName, templateMarkup) {
        $('body').append("<script type='text/html' id='" + templateName + "'>" + templateMarkup + "<" + "/script>");
    };

    $(function(){
        templateEngine.addTemplate("ko_simpleGrid_grid", "\
            <table class=\"ko-grid table table-striped table-bordered\" cellspacing=\"0\">\
                <thead>\
                    <tr data-bind=\"foreach: columns\">\
                       <th data-bind=\"text: headerText\"></th>\
                    </tr>\
                </thead>\
                <tbody data-bind=\"foreach: itemsOnCurrentPage\">\
                   <tr data-bind=\"foreach: $parent.columns\">\
                       <td data-bind=\"text: typeof rowText == 'function' ? rowText($parent) : $parent[rowText] \"></td>\
                    </tr>\
                </tbody>\
            </table>");
        templateEngine.addTemplate("ko_simpleGrid_pageLinks", "\
            <div class=\"ko-grid-pageLinks pagination\">\
                <ul>\
                <li><a href=\"javascript:void(0)\" data-bind=\"click: $root.gridPrev\">Prev</a></li>\
                <!-- ko foreach: ko.utils.range(0, maxPageIndex) -->\
                    <li data-bind=\"css: { active: $data == $root.currentPageIndex() }\">\
                    <a href=\"#\" data-bind=\"text: $data + 1, click: function() { $root.currentPageIndex($data) }\">\
                    </a>\
                    </li>\
                <!-- /ko -->\
                <li><a href=\"javascript:void(0)\" data-bind=\"click: $root.gridNext\">Next</a></li>\
                </ul>\
            </div>");
    });


// The "simpleGrid" binding
    ko.bindingHandlers.simpleGrid = {
        init: function() {
            return { 'controlsDescendantBindings': true };
        },
        // This method is called to initialize the node, and will also be called again if you change what the grid is bound to
        update: function (element, viewModelAccessor, allBindingsAccessor) {
            var viewModel = viewModelAccessor(), allBindings = allBindingsAccessor();

            // Empty the element
            while(element.firstChild)
                ko.removeNode(element.firstChild);

            // Allow the default templates to be overridden
            var gridTemplateName      = allBindings.simpleGridTemplate || "ko_simpleGrid_grid",
                pageLinksTemplateName = allBindings.simpleGridPagerTemplate || "ko_simpleGrid_pageLinks";

            if(viewModel.pagePos == 'top' || viewModel.pagePos == 'both'){
                // Render the page links
                var pageLinksContainer = element.appendChild(document.createElement("DIV"));
                ko.renderTemplate(pageLinksTemplateName, viewModel, { templateEngine: templateEngine }, pageLinksContainer, "replaceNode");
            }

            // Render the main grid
            var gridContainer = element.appendChild(document.createElement("DIV"));
            ko.renderTemplate(gridTemplateName, viewModel, { templateEngine: templateEngine }, gridContainer, "replaceNode");

            if(viewModel.pagePos == 'bottom' || viewModel.pagePos == 'both'){
                // Render the page links
                var pageLinksContainer = element.appendChild(document.createElement("DIV"));
                ko.renderTemplate(pageLinksTemplateName, viewModel, { templateEngine: templateEngine }, pageLinksContainer, "replaceNode");
            }
        }
    };
})(jQuery);