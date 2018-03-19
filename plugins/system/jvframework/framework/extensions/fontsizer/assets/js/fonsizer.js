var jvFontsizer= (function($){	
	var Fonsizer = {
		init: function(zoomlevel, fontsizer_selecter){
			this.zoomlevel = zoomlevel;
			this.fontsizer_selecter = fontsizer_selecter;
			this.curentLevel = 0;
			this.setDefaultFontSize();
		},	
		createCookie: function(name,value,days) {
			if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				var expires = '; expires='+date.toGMTString();
			}
			else var expires = '';
			document.cookie = name+'='+value+expires+'; path=/';
		},
		readCookie: function(name) {
			var nameEQ = name + '=';
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
					if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
				}
			return null;
		},
		eraseCookie :function(name) {
			createCookie(name,'',-1);
		},
		zoominLetter: function() {
			this.to(1);
		},
		zoomoutLetter: function() {
			this.to(-1);
		},
		to : function(to){
			if(!to) return;
			if($(document).triggerHandler('jvframework_changefontsize',[to, this.curentLevel]) == false) return;
			
			if(Math.abs(this.curentLevel + to) > this.zoomlevel) return;
			
			this.curentLevel += to;
			$(this.fontsizer_selecter).each(function(){
				$(this).css('font-size',  parseInt($(this).css('font-size')) + to);
			});
			this.createCookie('jvCurentLevel', this.curentLevel, 1);
			$(document).trigger('jvframework_changedfontsize',[to,this.curentLevel]);
		},
		resetLetter: function() {
			this.to(0 - this.curentLevel);
		},
		setDefaultFontSize: function(){
			var curentLevel = parseInt(this.readCookie('jvCurentLevel')) || 0;
			this.to(curentLevel);
		}
	};

	return Fonsizer;
})(jQuery);	
