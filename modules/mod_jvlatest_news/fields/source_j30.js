jQuery(function($){
    var source = $('#jform_params_source').val();   
    switchSource(source);
    $('#jform_params_source').change(function() {
        source = $(this).val(); switchSource(source);
    })
   
});

function showContentArt(){
    jQuery('a[href="#options-article"]').parent().show();
}
function hideContentArt(){
    jQuery('a[href="#options-article"]').parent().hide();
}
function hideK2Item(){
    jQuery('a[href="#options-k2item"]').parent().hide();
}
function showK2Item(){
    jQuery('a[href="#options-k2item"]').parent().show();
}
function hideContentCat(){
    jQuery('#jform_params_catid').parent().parent().parent().hide();
    jQuery('#jform_params_catid').parent().parent().parent().prev().hide();
}
function showContentCat(){
    jQuery('#jform_params_catid').parent().parent().parent().show();
    jQuery('#jform_params_catid').parent().parent().parent().prev().show();
}
function hideK2Cat(){
    jQuery('#jform_params_k2catid').parent().parent().hide();
    jQuery('#jform_params_k2catid').parent().parent().prev().hide();
}
function showK2Cat(){
    jQuery('#jform_params_k2catid').parent().parent().show();
    jQuery('#jform_params_k2catid').parent().parent().prev().show();
}
function switchSource(source){
    switch(source){
        case 'content':
            hideK2Cat();
            hideK2Item();
            showContentArt();
            showContentCat();
            break;
        case 'k2content':
            hideContentCat();
            hideContentArt();
            showK2Cat();
            showK2Item();
            break;
    }
}

