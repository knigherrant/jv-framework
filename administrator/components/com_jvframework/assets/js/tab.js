var JVtab = new Class({
	options:{
		activeIndex: 		0,
		tabSelector: 		'jvframework-tab',
		tabhandlerSelector: 'tab-handlers',
		tabContentSelector: 'tab-contents',
		titleTemplate: 		'<span class="icon %s"><span class="tab-text">%s</span></span>',
		contentTemplate: 	'%s',
		tabEffect: 			{}
	},

	tab: null,
	tabHandler: null,
	tabContent: null,
	numtab: 0,

	initialize: function(options){
		this.setOptions(options);
		this.prepare();
	},

	prepare: function(){
		var activeIndex = Cookie.read(this.options.tabSelector + 'activeIndex');
		if(activeIndex){
			this.options.activeIndex = activeIndex;
		}

		this.tab = new Element ('div', { id: this.options.tabSelector});
		this.tabHandler = new Element ('div', { 'class': this.options.tabhandlerSelector}).inject(this.tab);
		this.tabContent = new Element ('div', { 'class': this.options.tabContentSelector}).inject(this.tab);
	},	

	add: function(title, content){		
		var tab = {};
		tab.handler = this.createTitle(title, content).inject(this.tabHandler);
		tab.content = this.createContent(title, content).inject(this.tabContent);
		tab.fx      = new Fx.Reveal(tab.content, this.options.tabEffect).dissolve();
		tab.index   = this.numtab;
		
		if (!this.active && this.options.activeIndex == tab.index) { this.active = tab; };

		var that = this;

		tab.handler.addEvent('click', function(){
			that.hide(that.active);
			that.show(tab);
		});

		this.numtab ++;

		return tab;
	},

	createTitle: function(title, content){
		title = Element ('h3', {'class': 'handle '+title.replace(/\s+/g,"-").toLowerCase()})
					.set('html', this.sprintf(this.options.titleTemplate, [title.replace(/\s+/g,"-").toLowerCase(),title]))
		
		return title;		
	},

	createContent: function(title, content){
		content = new Element ('div', {'class': 'tab-content ' + title.replace(/\s+/g,"-").toLowerCase()})
						.adopt(content);

		return content;
	},

	sprintf: function(format, args){
		var i = 0;
		var text = format.replace(/%s/gi, function(match, contents, offset, s) {
			var txt = args[i]; i++;
	        return txt;
	    });

	    return text;
	},

	show: function(tab){
		if(!tab){
			tab = this.active;
		}
		if(!tab) return;
		
		Cookie.write(this.options.tabSelector + 'activeIndex', tab.index);
		this.active = tab;
		tab.handler.addClass('active');
		tab.fx.reveal();
		
	},

	hide: function(tab){
		if(!tab) return;
		
		tab.handler.removeClass('active');
		tab.fx.dissolve();
	},

	display: function(selector){
		this.tab.inject(selector);
		return this;
	},
	
	trim: function (str) {
	    if(!str || typeof str != 'string')
	        return null;

	    return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
	}

});

JVtab.implement(new Events);
JVtab.implement(new Options);

