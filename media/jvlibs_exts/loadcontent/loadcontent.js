var JVLoadContent = (function($){
    var caches = {};
    return $.extend(function(call,callback){
        if(!window.JVAjaxCall) return;
        if($.type(call) == 'string') call = {call: call, cache: true};
        if(call.args && $.type(call.args) != 'array') call.args = [call.args];
        
        callback = callback || {
            buttons: false
        };
        if($.type(callback) !== 'function'){
            var ops = callback;
            callback = function(rs){
                ops.title = ops.title || rs.title;
                ops.content = rs.content;
                var modal = JVAjaxCall.modal(ops);
                modal.modal('show');
                caches[call.call] = modal;
            }
        }
        if(call.cache && caches[call.call]) caches[call.call].modal('show');
        else JVAjaxCall.call($.extend(call.data,{jvloadcontent: call.call, args: JSON.stringify(call.args)}),function(rs){
            callback(rs.jvloadcontent);
        });
    },{
        
    });
})(jQuery)