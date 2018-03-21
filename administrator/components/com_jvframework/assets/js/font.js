var JVFont = new Class({
	fontType: [],
	activeFontType: null,
	value: {},

	initialize: function(el, options){
		this.setOptions(options);

		this.el = $(el);
		this.createFontTypeChooser().inject(this.el, 'before');

		if(this.el.value != '{}'){
			this.value = JSON.decode(this.el.value);

			if(this.value.type){
				this.activeFontType = this.value.type;						
			}				
		}
		
	},

	createFontTypeChooser: function(){
		var self = this;
		this.fontTypeChooser = 	this.createSelect({name: this.el.id+'_fonttype'})
								.addEvent('change', function(){
									self.switchFontType(this.value);
								})

		return this.fontTypeChooser;
	},

	switchFontType: function(type){
		if(type == '') return false;

		this.value.type = type;		
		this.fontType[this.activeFontType].setStyle('display', 'none');
		this.fontType[type].setStyle('display', 'block');
		this.activeFontType = type;

		this.el.value = JSON.encode(this.value);
	},

	setFont: function(font){
		this.value.font = font;
		this.el.value = JSON.encode(this.value);
	},

	__addFontType: function(name){		
		var option = this.createSelectOption(name, name);
		if(name == this.activeFontType){
			option.selected = true;
		}

		this.fontTypeChooser.appendChild(option);
	},

	createSelect: function(options){
		return new Element('select', options);
	},

	createSelectOption: function(value, text){
		return new Element('option', {text: text, value: value})
	},

	createFontChooser: function(name, fonts){
		var self = this;
		var fontChooser = this.createSelect({name: name.replace(/\s+/g,"-").toLowerCase()})			
			.addEvent('change', function(){
				self.setFont(this.value);
			})
			.adopt(this.createSelectOption('', '-- Select Font  --'));
		
		for (var i = 0; i < fonts.length; i++) {		
			var option = this.createSelectOption(fonts[i][0], fonts[i][1]);
			if(fonts[i][0] == this.value.font){
				option.selected = true;
			}
			fontChooser.appendChild(option);
		};

		return new Element('div', {'class':  name.replace(/\s+/g,"-").toLowerCase()}).setStyle('display', 'none').adopt(fontChooser);
	},

	addFontType: function(name, fonts){
		this.__addFontType(name);
		this.fontType[name] = this.createFontChooser(name, JSON.decode(fonts)).inject(this.el, 'before');

		if(!this.activeFontType){
			this.activeFontType = name;
		}
	},

	display: function(){
		this.switchFontType(this.activeFontType);		
	}

});

JVFont.implement(new Options);