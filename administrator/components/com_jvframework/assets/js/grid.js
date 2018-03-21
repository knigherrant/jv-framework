var JVCustomGrid = (function($) {
    var grid = function(selector, options) {
        selector = $(selector);
        options = $.extend({
            totalGrid : 12,
            maxColumn : 6
        }, options);
        var gridDatas = JSON.parse(selector.children('textarea').val() || '{}');

        var selectColumn = options.changeColumn ? $('<ul>', {'class':'grid-handlers'}).append((function() {
                var ops = $();
                for ( var i = 1; i <= options.maxColumn; i++) {
                    (function() {
                        var btn = $('<a>', {
                            href : 'javascript:void(0)'
                        }).text(i).click(function() {
                                li.parent().children('.active').removeClass('active');
                                var index = li.addClass('active').index() + 1;
                                changeColumns(index, gridDatas[index]);
                            }), li = $('<li>').append(btn);
                        ops.push(li[0])
                    })()
                }
                return ops;
            })()) : false, gridPanel = $('<div>', {
                'class' : 'grids'
            }), changeColumns = function(count, data) {
                data = data || [];
                count = parseInt(count) || options.maxColumn;
                gridPanel.empty();
                var du = options.totalGrid % count, chan = parseInt(options.totalGrid
                    / count);
                selectColumn
                && selectColumn.children('li:eq(' + (count - 1) + ')')
                    .addClass('active')
                for ( var i = 0; i < count; i++) {
                    var label = $('<span>'), newColumn = $('<div>').append(label), countGrid = data[i]
                        || (i < du ? chan + 1 : chan);
                    i + 1 >= count || newColumn.resizable(resizeOp)
                    gridPanel.append(newColumn);

                    label.text(countGrid);
                    newColumn.css('width', countGrid * gridSize);
                }
                setData();
            },
            setData = function() {
                var data = [];
                gridPanel.children('div').each(function() {
                    data.push(parseInt(($(this).width()) / gridSize));
                });
                gridDatas[data.length] = data;
                selector.children('textarea').val(JSON.stringify(gridDatas));
            };
        selector.append(selectColumn, gridPanel);

        var target, next, targetWidth, nextWidth, gridSize = Math
            .floor(804 / options.totalGrid), resizeOp = {
            grid : gridSize,
            minWidth : gridSize,
            handles : 'e',
            start : function(e, ui) {
                target = $(this);
                next = target.next();
                if (next.length === 0)
                    return false;
                targetWidth = target.width();
                nextWidth = next.width();
                target.resizable('option','maxWidth',parseInt(targetWidth + nextWidth - gridSize+5));
            },
            resize : function(e, ui) {
                toWidth = targetWidth + nextWidth - ui.size.width;
                next.css('width', toWidth).children('span').text(parseInt((toWidth + 1) / gridSize));

                target.children('span').text(parseInt((ui.size.width + 1) / gridSize));
                setData();
            }
        };

        changeColumns(options.maxColumn, gridDatas[options.maxColumn]);
    }
    return grid;
})(jQuery)