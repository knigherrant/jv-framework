$JVREMOVE = jQuery.noConflict();
$JVREMOVE(function($){
	$('a.removeCompare').click(function(){
            var a = $(this);
            $.ajax({
                url :"index.php?option=com_jvvmhelper&task=removeCompare&&product_id="+a.attr('data-id'),
                dataType : 'json'
            }).done(function(data){
                if(data.ok) a.parents('tr.jrow').fadeOut();
            })
	});
});
$JVREMOVE(function($){
	$('a.removeWishlist').click(function(){
            var a = $(this);
            $.ajax({
                url :"index.php?option=com_jvvmhelper&task=removeWishlist&&product_id="+a.attr('data-id'),
                dataType : 'json'
            }).done(function(data){
                if(data.ok) a.parents('li.vm-wishlist--item').fadeOut();
                else alert('Error!');
            })
	});
});