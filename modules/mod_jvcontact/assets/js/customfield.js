/*
 # mod_jvcontact - JV Contact
 # @version		3.0.1
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/
var CustomField;


function restoreCustomField(){
	//container
	$('container').set('text','');
	new CustomField({type:'name',name:'name'});
	new CustomField({type:'email',name:'email'});
	new CustomField({type:'subjectfield',name:'subject'});
	new CustomField({type:'textarea',name:'message'});
	return;
}


window.addEvent('domready',function(){
	/*
	var mysort = new Sortables('container',{
		clone:true,
		handle:'.handler',
		opacity:'0.3'
	});
	*/

	CustomField = new Class({
		
		options	: {
			type:'',
			name:''
		},
		// create new on click button add field
		initialize:function(options){ 
			
			if(options) this.options = options;
			icustom++;
			this.prefixname = 'jform[params][customfield]['+ icustom +']';
			//mysort.addItems(this.addField());
			this.addField();
		},
		// on click button add Field
		addField:function(){
			var 
				container 	= $('container'),
				inputtype 	= this.options.type ? this.options.type : $('listtype').value,
					
				block	  	= new Element('div.jvrows.subject.'+inputtype),
				validate  	= new Element('div.control-group'),
				handler		= new Element('h3.handler'),
				icontitle 	= new Element('span.icons').set('text','New '+ inputtype),
				icondelete 	= new Element('span.icondelete'),
				content 	= new Element('div.content.hidden'),
				
				cftype  = this.addRow('Type','input.cftype',{type:'text','value':inputtype,name:this.fixName('type')}).addClass('hidden'),
				cfname  = this.addRow('Name','input.required',{type:'text',id:this.fixName('name'),name:this.fixName('name')}),
				cftitle = this.addRow('Title','input.required',{type:'text',id:this.fixName('title'),name:this.fixName('title')})
			;
			
			validate.innerHTML = '<div class="control-group"><div class="control-label"><label>Validate</label></div><div class="controls"><select name="'+this.prefixname+'[validate]" class="inputbox"><option value="none">None</option><option value="require">Require</option><option value="numberic">Number</option><option value="email">Email</option></select></div></div>';
			
			content.adopt(cftype);		
			content.adopt(cfname);		
			content.adopt(cftitle);
			
			handler.adopt(icontitle);
			
			switch(inputtype){
				case 'name':
					// check field email exists ? alert() : add field
					
					if($$('.name')[0]){
						alert('Only one Name field!');
						return;
					}else{
						//cftype.getChildren('.cftype')[0].value = 'text';
						cfname.getElements('input')[0].value = 'name';
						validate.getElements('select')[0].value = 'require';
						cfname.addClass('hidden');
						validate.addClass('hidden');
					}
					
					break;
				case 'subjectfield':
					// check field email exists ? alert() : add field
					if($$('.subjectfield')[0]){
						alert('Only one Subject field!');
						return;
					}else{
						//cftype.getChildren('.cftype')[0].value = 'text';
						handler.adopt(icondelete);
						cfname.getElements('input')[0].value = 'subject';
						validate.getElements('select')[0].value = 'require';
						cfname.addClass('hidden');
						validate.addClass('hidden');
					}
					
					break;
				case 'email':
					// check field email exists ? alert() : add field
					if($$('.email')[0]){
						alert('Only one Email field!');
						return;
					}else{
						//cftype.getChildren('.cftype')[0].value = 'text';
						cfname.getElements('input')[0].value = 'email';
						validate.getElements('select')[0].value = 'email';
						cfname.addClass('hidden');
						validate.addClass('hidden');
					}
					
					break;
					
				case 'radio':
				case 'select':
				case 'checkbox':
					handler.adopt(icondelete);
					content.adopt(this.addRow('Option','textarea.required',{id:this.fixName('option'),name:this.fixName('option')}));
					//joomla 30
					block.setStyle('padding-left','0');
					break;
				case 'text':
				case 'textarea':
					handler.adopt(icondelete);
					break;
			}
			
			content.adopt(validate);
			
			block.adopt(handler);
			block.adopt(content);
			
			container.adopt(block);
			return block;
		},

		// add row
		addRow:function(labeltext,tag,options){
			var 
				row   = new Element('div.control-group'),
				divlabel = new Element('div.control-label'),
				divinput = new Element('div.controls'),
				label = new Element('label').set('text',labeltext).inject(divlabel),
				input = new Element(tag,options).inject(divinput)
					
			;
			if(options.id){
				label.setProperty('for',options.id);
			}
			if(options.value){
				input.value = options.value;
			}
			
			row.adopt(divlabel).adopt(divinput);
			return row;
		},
		fixName:function(name){
			return this.prefixname + '[' + name + ']';
		}
		
	});
	$('btnaddfield').addEvent('click', function(event){
		new CustomField();
	});
	$('container').addEvent('click', function(e){
		var 
			target = e.target,
			content = target.getParent().getNext(),
			row = target.getParent().getParent()
		;
		
		
		switch(target.getProperty('class')){
			case 'icons':
				if(content.hasClass('hidden')){
					content.removeClass('hidden');
				}else{
					content.addClass('hidden');
				}
				break;
			case 'icondelete':
				
				new Fx.Morph(row).start({
					'height':0,
					'opacity':0.3,
					'padding':0
				}).chain(function(){
						row.destroy();
					});
				
				break;
		}
	});
	
	
	if($('container').innerHTML==''){
		restoreCustomField();
		$('jform[params][customfield][1][title]').value='Name';
		$('jform[params][customfield][2][title]').value='Email';
		$('jform[params][customfield][3][title]').value='Subject';
		$('jform[params][customfield][4][name]').value='message';
		$('jform[params][customfield][4][title]').value='Message';
	}
	
	Joomla.submitbutton = function(task) {
	
		if(task!='module.cancel'){
			if($('jform_params_mailto').value=='' && $('jform_params_mailto2').value==''){
				var options = $('jform_params_mailto').getChildren();
				if(options.length == 1){
					$('jform_params_mailto').selectedIndex = 0;
					Joomla.submitform(task, document.getElementById('module-form'));
				}else{
					alert('Please select or input a recipient email!');
					$('recipients-options').click();
					
				}
				
			}else{
				Joomla.submitform(task, document.getElementById('module-form'));
			}
		}else{
			Joomla.submitform(task, document.getElementById('module-form'));
		}
	};
});


