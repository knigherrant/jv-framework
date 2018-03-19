var OWL = (function($) {
    var func = {
        init: function(countset) {
            this.countset = countset;
        },
        addNewSet: function() {
            var seft = this;
            this.countset = this.countset + 1;
            $('#OWL-list #OWL-container')
                .prepend(
                    '<div id="OWL-' + this.countset + '" class="OWL-item">' +
                    '<div class="OWL-title">' +
                    '<div class="OWL-handle"><span class="ui-icon ui-icon-arrow-4"></span></div>' +
                    '<div onclick="OWL.toggle(this)">Title slider - ' + this.countset + '</div>' +
                    '<div class="OWL-title-control">' +
                    '<label for="enable"><input type="checkbox" checked="checked" class="OWL-enable"><span>Enable</span></label>' +
                    '<a class="ui-state-default ui-corner-all OWL-button" href="javascript:void(0)" onclick="OWL.removeItem(this)" title="Remove"><span class="ui-icon ui-icon-close"></span></a>' +
                    '</div>' +
                    '</div>' +
                    '<div>' +
                    '<div class="OWL-inputs data-input">' +
                    '<div class="OWL-maininfo">' +
                    '<div class="OWL-input">' +
                    '<label>Title</label>' +
                    '<input  type="text"   class="OWL-title" value="jvSlider - ' + this.countset + '"/>' +
                    '</div>' +

                    '<div class="clr"></div>' +
                    '<div class="OWL-input">' +
                    '<label>Element (.class || #Id)</label>' +
                    '<input type="text"  value="" class="OWL-element"/>' +
                    '</div>' +

                    '<div class="clr"></div>' +
                    '<div class="OWL-input">' +
                    '<label>Params</label>' +
                    '<textarea class="OWL-params"></textarea>' +

                    '</div>' +


                    '<div class="clr"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                );
        },
        toggle: function(el) {
            $(el).parent().next().slideToggle(200);
        },
        OWLSetValue: function() {
            var data = {};
            data['list'] = new Array();
            $.each($('#OWL-container .OWL-item'), function(i, item) {
                data['list'][i] = {};
                data['list'][i].enable = $(item).find('.OWL-enable').is(':checked');
                data['list'][i].element = $(item).find('input.OWL-element').val();
                data['list'][i].title = $(item).find('input.OWL-title').val();
                data['list'][i].params = $(item).find('textarea.OWL-params').val();

            });
            $('#jform_params_owl_params').val(JSON.stringify(data));
            $('#params_owl_params').val(JSON.stringify(data));
        },
        removeItem: function(el) {
            $(el).parent().parent().parent().parent().stop(true, true).fadeOut('200', function() {
                $(this).remove()
            });
        },

    }

    return func;

})(jQuery);
