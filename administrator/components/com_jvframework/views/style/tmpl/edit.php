<?php
/**
 # com_jvframwork - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
//no direct access
defined( '_JEXEC' ) or die( 'Retricted Access' );
$doc = JFactory::getDocument();
//JHtml::_('formbehavior.chosen', 'select');
$doc->addScriptDeclaration("
jQuery(function() {		
	var jvtab = new JVtab({activeIndex: 1});	
	var groups = $$('div.fieldGroup');	
	if(groups){		
		groups.each(function(el){
			var title   = el.getElement('h3 span');		
			var content = new Element('div').addClass('content').adopt(el.getChildren('ul'));
			jvtab.add(jvtab.trim(title.get('text')), content);		
			el.getElement('h3').dispose();	
		});
	}
	// Display tab
	jvtab.display($$('fieldset.adminform')[0]);
	
	$$('span.subTab').each(function(el){
		var li   = el.getParent().getParent();		
		var next = li.getNext();		
		if(next)
			next.addClass('subTab');
		
		next.set('title', el.getChildren().get('text'));		
		li.dispose();
	});	
		
	var tabs = $$('div.tab-content x');		
        //return;	// remove subtabs
	if(tabs){
		tabs.each(function(el, index){
		
			var Subtab = new JVtab({
					activeIndex: 0, 
					tabSelector: 'subTab'+index,
					tabhandlerSelector: 'sub-tab-handlers',
					tabContentSelector: 'sub-tab-contents'					
				});	 			
			var groups = el.getElements('ul.fields li');	
			if(groups){
				var subContent, subTitle;
		 
				groups.each(function(elm){ 
					if(elm.hasClass('subTab')){
						subTitle   = Subtab.trim( elm.get('title') );
						subContent = new Element('ul').addClass('fields');						
					}
		
					var next = elm.getNext();
					subContent.adopt(elm)
					if(next){	
						if(next.hasClass('subTab')){	
							Subtab.add(subTitle, (new Element('div').adopt(subContent)));	
						}
					}else{		
						Subtab.add(subTitle, (new Element('div').adopt(subContent)));
					}	
				});	
			}		
			Subtab.display(el).show();	
		
		});
	}
		
	$$('span.spacer').each(function(el){
		el.getParent().setStyles({'float' : 'none', 'clear': 'both'})
	});	
	
 	setTimeout(function(){
 		jvtab.show();
 	}, 100);
	
	$$('ul.fields textarea').each(function(el){	
		el.getParent().addClass('jv-textarea');				
	});	
	
	$$('ul.fields input[type=text]').each(function(el){
		if(el.attributes.readonly) return;
		
		new Element('span', {'class': 'clear'})
			.setStyles({ position : 'absolute', top: 23, right: 15, cursor: 'pointer' })
			.addEvent('click', function(){el.value = ''})
			.adopt ( new Element('span', {'class': 'icon', 'text': 'x'}) )		
			.inject(el, 'after');		
	});
	
	setTimeout(function(){
		$$('.fields li > select, .fields > li > div > select').each(function(el){
			
			if(el.multiple == true) return;			
			var spanValue = new Element('span', {'class': 'select', 'text': el.getSelected().get('text')});		
			//new Element('span', {'class': 'select-r'})
				//.setStyles({ display: 'block', overflow: 'hidden', position: 'absolute', 'min-width': 184})			
			//	.adopt ( new Element('span', {'class': 'select-l'}) .adopt (spanValue) ) 
			//	.inject(el, 'before');
			
			el.setStyles({ position: 'relative', 'z-index': '5', opacity: 0 });	
			el.addClass('style');		
			el.addEvent('change', function(){
				spanValue.set('text', el.getSelected().get('text'));
			});

			if(el.hasClass('jcombobox')) {
				Joomla.combobox.transform(el);	
				el.addEvent('keyup', function(e){
					spanValue.set('text',  el.getSelected().get('text'));
				});
			}
		});	
		
		
		$$('.spacer').each(function(el){el.getParent().addClass('spacer');});
		
		$$('.ui-tabs-panel').show();
		
	}, 300)	
        jQuery('.global').JVSort({
            0:'1', 1:'0',  2:'2', 3:'3', 4:'8', 5:'5',6:'4', 7:'6',  8:'9', 9:'10', 10:'7'
        });

        jQuery('.extension').JVSort({
            0:'2',1:'3',2:'0',3:'1',4:'4',5:'5'
        });


    });
        
        

");
?>
<script type="text/javascript">
    Joomla.submitbutton = function(task) { 
        if (task == 'style.buildLess'){
            jQuery('#clearCache').fadeIn();
            jQuery('body').addClass('.loading');
            jQuery.ajax({
                url : 'index.php?option=com_jvframework&task=buildLess&id=' + '<?php echo $this->item->id; ?>'

            }).success(function(data){
                jQuery('#clearCache').html(data).fadeOut(); 
                setTimeout('addLoading()',900);
                jQuery('body').removeClass('loading');
            })
            return false;
        }else{
            Joomla.submitform(task, document.getElementById('adminForm'));
        }
    }
</script>
<form action="<?php echo JRoute::_('index.php?option=com_jvframework&id='.$this->item->id);?>" method="post" name="adminForm" id="adminForm" class="adminform paramform clearfix">
    <div class="width-100 fltlft">
		<fieldset class="adminform">	
                    

                <button  id="toolbar-reset" class="btn btn-small btn-success" onclick="Joomla.submitbutton('style.reset')" href="#">
               	<span></span>
                <?php echo JText::_('Reset to default'); ?>
                </button>
 
                    
	   	 <?php $fieldSets = $this->form->getFieldsets(); ?>   	 
                    
                
	   	 <?php foreach ($fieldSets as $name => $fieldSet) : 
					   	 
	   	 ?>
	   	 	<div class="fieldGroup<?php echo isset($fieldSet->class) ? ' '.$fieldSet->class: '';?>">
	   	 		<h3 class="title">
		        	<span class="<?php echo strtolower($name); ?>">
		        		<?php echo JText::_($fieldSet->label); ?> 
		        	</span>
		        </h3>
		        <?php $fields = $this->jvForm->getFieldset($name); 
                        //$fields = $this->form->getFieldset($name); 
		        if(count($fields)):
		        ?>
                        <?php $fieldx = array();
                        foreach ($fields as $f){
                                $field = array(
                                    "type" => @$f->type,
                                    "label" => $f->label,
                                    "input" => $f->input
                                );
                                $fieldx[] = (object) $field;
                        } 
                       
                        ?> 
		        <ul class="fields">
				<?php for ($i=0; $i<count($fieldx); $i++) { ?>
                                        <?php 
                                        if($fieldx[$i]->type =='group') echo "<li>";
                                        else if($fieldx[$i]->type != 'end')  echo "<div>";   ?>
                                                <?php if($fieldx[$i]->label) echo  $fieldx[$i]->label; ?>
                                                <?php if($fieldx[$i]->input) echo $fieldx[$i]->input; ?>
                                         <?php 
                                        if($fieldx[$i]->type =='end') echo "</li>";
                                        else echo "</div>";
                                        ?>
				<?php } ?>
                        </ul>
                        <?php endif;?>
			</div>
		 <?php endforeach; ?>
		 </fieldset>
	 </div>
	<div>		
    	<input type="hidden" name="layoutname" id="layoutname" value=""/>	
		<input type="hidden" name="cachetype" id="cachetype" value=""/>	
		<input type="hidden" name="action" id="action" value=""/>	
		<input type="hidden" name="task" value="" />	
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<div class="copyright">
    <a target="_blank" href="http://phpkungfu.club"><img src="components/com_jvframework/assets/images/logo2.png" alt="Logo" /></a>  
</div>
<div id="clearCache">
    <img src="<?php echo JURI::base(); ?>components/com_jvframework/assets/images/loading.gif" />
</div>