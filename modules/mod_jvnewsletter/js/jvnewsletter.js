/**
 # mod_jvnewsletter - JV NEWSLETTER
 # @version        1.0
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 -------------------------------------------------------------------------*/
/*
var opt = {
    modid: 'int',
    lists: 'array' //span.list-api input[type=checkbox]:checked
    modal: 'selector', //#jvnewslater-import-modal
}
*/
var hasJQ = function(){
    try{
        var rs = jQuery;
        return true;
    }
    catch(e){
        return false;
    }
}

if (hasJQ()){
    (function($){
        jvnewsletter = {
            
            init: function(opt){
                var     dlists = opt.lists,
                        cont = opt.lists.length > 0,
                        modalbox = $(opt.modal),
                        enable = true,
                        url = 'index.php?option=com_modules&view=module&layout=edit&id='+opt.modid+'&extra=1&atc=subscribe';
                //code
                $(modalbox).find('#jvnewslater-import-modal-btn-import').click(function(){
                    if(!enable)
                    {
                        alert('Please wait for completed!');
                        return false;
                    }
                    if (!cont)
                    {
                        alert('Please check anyone list to Import!');
                        return false;
                    }
                    var lemail = $(modalbox).find('td>input[type=checkbox]:checked');
                    var emails = [];
                    if (lemail.length <= 0)
                    {
                        alert('Please check anyone email to Import!');
                    }                            
                    $.each(lemail, function(fn){                        
                        var text = $(this).parents('tr').children('.td-name').html(),
                            email = $(this).val(),
                            fname,
                            lname;
                        if (text){
                            var fn = text.split(' ');
                            fname = fn[0];
                            if (fn.length > 1){
                                lname = fn[fn.length -1];
                            }
                        }
                        if (email)
                        {
                            var obj = {
                                email: email,
                                fname: fname,
                                lname: lname                                        
                            };
                            emails.push(obj);
                        }
                    });
                    
                    if (emails.length > 0)
                    {
                        var completed = function()
                        {
                            $(modalbox).find('.jvnewslater-import-modal-checkall').attr('checked', false);
                            alert('Import completed!');
                            console.log('Import completed');
                            enable = true;
                        }
                        var itr = function(id, state){
                            var input = $(modalbox).find('input[value=\"'+id+'\"]');
                            var td = $(input).parent();
                            var tr = $(td).parent();
                            var color = (state)? '#DFF0D8':'#F2DEDE';
                            var icon = (state)? 'icon-ok': 'icon-remove';
                            $(input).remove();
                            $(td).children().remove();
                            $(td).html($('<i>').addClass(icon));
                            //$(tr).addClass(state);
                            $(tr).css('background', color);
                            $(tr).addClass('rs-popover');
                        };
                        var subscibe = function(fn){
                            enable = false;
                            var obj = emails.shift();
                            if (!obj) return fn();
                            
                            var input = $(modalbox).find('input[value=\"'+obj.email+'\"]');
                            var td = $(input).parent();
                            $(input).hide();
                            $(td).append($('<img>').attr('src', '../modules/mod_jvnewsletter/img/loading.gif'));
                                                                
                            $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: (function(){                                            
                                        return {
                                                jvnewsletter_submit: 'true', 
                                                'fname': obj.fname,
                                                'lname': obj.lname,
                                                'email': obj.email,
                                                'lists': dlists
                                            };
                                    })(),
                                    dataType: 'json',
                                    success: function(data){
                                        if (data.state){
                                            itr(data.email, 1);
                                        }
                                        else{
                                            itr(data.email, 0);
                                        }                                                
                                        subscibe(fn);
                                    }
                                });
                        };
                        subscibe(completed);
                    }                    
                    return false;
                });
                $(modalbox).find('.jvnewslater-import-modal-checkall').change(function(){
                    $(modalbox).find('td>input[type=checkbox]').attr('checked', $(this).is(':checked'));
                });
            }
        }
    })(jQuery);

}