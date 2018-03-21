jQuery.fn.logo = function(id){
    var $this = jQuery(this),
        val = $this.children(':selected').val(),
        ul = $this.parent().parent().parent('ul.fields'),
        image = ul.find('#'+id+'extension_logo_image').parent().parent(),
        text = ul.find('#'+id+'extension_logo_text').parent(),
        slogan = ul.find('#'+id+'extension_logo_slogan').parent(),
        selectText = function(){image.hide();text.fadeIn();slogan.fadeIn();},
        selectImage = function (){text.hide();slogan.hide();image.fadeIn();};
    if(val=='text')  selectText(); 
    else  selectImage();
}
jQuery.fn.JVSort = function(items){
    var ul = jQuery(this).find('ul.fields');
    if(!items || !ul.length) return;
    var content = new Array();
    ul.find('li').each(function(i){
        content.push(this);
    })
    var newContent = new Array();
    jQuery.each(items,function(i,v){
        newContent[i] = content[v];
    });
    jQuery.each(newContent,function(){
         ul.append(this);
    });
    
}

jQuery.fn.jcolor = function(){
    var $this = jQuery(this),
        css = jQuery('#params_styles_customcolor_css-lbl').parent(),
        color = jQuery('#params_styles_customcolor_color-lbl').parent(),
        theme = jQuery('#params_styles_themecolor-lbl').parent().parent();
    if($this.attr('for') =='params_styles_customcolor_enable1'){
        css.fadeOut();
        color.fadeOut();
        theme.fadeIn();
    }else{
        theme.fadeOut();
        css.fadeIn();
        color.fadeIn();

    }
}

jQuery(document).ready(function(){
    jQuery('#jform_params_extension_logo_type').logo('jform_params_');
    jQuery('#jform_params_extension_logo_type').change(function(){
        jQuery(this).logo('jform_params_');
    });
    jQuery('#params_extension_logo_type').logo('params_');
    jQuery('#params_extension_logo_type').change(function(){
        jQuery(this).logo('params_');
    });
    
    /* custom color */
    /*
    jQuery('#params_styles_customcolor_enable input').each(function(){
        if(jQuery(this).is(':checked')) jQuery(jQuery(this).next()).jcolor();
    })
    var jcolor = jQuery('#params_styles_customcolor_enable label');
    jcolor.click(function(){
        jQuery(this).jcolor();
    })
    */
    /* end custom color */
    jQuery('.btn-clearcache').click(function(){
        jQuery(this).attr('disabled','disabled');
        jQuery('#clearCache').fadeIn();
        jQuery('body').addClass('.loading');
        jQuery.ajax({
            url:'index.php?option=com_jvframework&task=clear'
        }).done(function( msg ) {
            jQuery('#clearCache').fadeOut().html(msg); 
            setTimeout('addLoading()',900);
            jQuery('body').removeClass('loading');
            jQuery('.btn-clearcache').removeAttr('disabled');
        })
        return false;
    })
    
})
function addLoading(){
    jQuery('#clearCache').html('<img src="components/com_jvframework/assets/images/loading.gif" />');
}
function log(data){
    console.log(data);
}