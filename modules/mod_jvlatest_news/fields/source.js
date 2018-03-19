window.addEvent('domready', function(){
	var source = $('jform_params_source').value; switchSource(source);  
	$('jform_params_source').addEvent('change', function(el){
	     source = this.value; switchSource(source);
	});
});


function showContentArt(){
    $('article-options').getParent().setStyle('display', '');
}
function hideContentArt(){
    $('article-options').getParent().setStyle('display', 'none');
}
function hideK2Item(){
    $('k2item-options').getParent().setStyle('display', 'none');
}
function showK2Item(){
    $('k2item-options').getParent().setStyle('display', '');
}
function hideContentCat(){
    //$('jform_params_catid').getParent().setStyle('display', 'none');
    //$('jform_params_catid').getParent().getPrevious().setStyle('display', 'none');
    $('jform_params_catid').getParent().getParent().setStyle('display', 'none');
    $('jform_params_catid').getParent().getParent().getPrevious().setStyle('display', 'none');
}
function showContentCat(){
    $('jform_params_catid').getParent().getParent().setStyle('display', '');
    $('jform_params_catid').getParent().getParent().getPrevious().setStyle('display', '');
}


function hideK2Cat(){
    $('jform_params_k2catid').getParent().setStyle('display', 'none');
    $('jform_params_k2catid').getParent().getPrevious().setStyle('display', 'none');
}

function showK2Cat(){
    $('jform_params_k2catid').getParent().setStyle('display', '');
    $('jform_params_k2catid').getParent().getPrevious().setStyle('display', '');
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