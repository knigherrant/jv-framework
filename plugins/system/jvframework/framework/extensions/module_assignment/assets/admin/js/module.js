var $JV = jQuery.noConflict();

$JV(function(){

    $JV('.assignment_type').each(function(){
        $JV(this).parents('li, div.control-group').addClass('assignment');
        $JV(this).parents('li, div.control-group').parent().addClass('adminformlist moduleAsignment');
    });

    $JV('.assignment_content_type').each(function(){
        $JV(this).parents('li, div.control-group').addClass('assignment_content_type');
    });

    function hideGroupItem(item){
        $JV(item).hide();
        if($JV(item).next().length && !$JV(item).next().is('.assignment') && !$JV(item).next().is('.assignment_content_type')){
            hideGroupItem($JV(item).next());
        }
    }

    function showGroupItem(item){
        $JV(item).show();
        if($JV(item).next().length && !$JV(item).next().is('.assignment') && !$JV(item).next().is('.assignment_content_type')){
            showGroupItem($JV(item).next());
        }
    }
    function showHide(item){
        if($JV(item).val() > 0){
            showGroupItem($JV(item).parents('li, div.control-group').next());
        }else{
            hideGroupItem($JV(item).parents('li, div.control-group').next());
        }
    }

    $JV('.assignment_enable').each(function(){
        $JV(this).change(function(){
            showHide(this)
        });

        showHide(this);
    });


});