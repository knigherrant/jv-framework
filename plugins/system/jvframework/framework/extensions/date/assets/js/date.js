var jvDate= (function($){
	var FeatureDate = {
			getClientDate: function(jvDateformat){
				var jvDays = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
				var jvShortdays = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
				var jvMonths = ['January','February','March','April','May','June','July','August','September','October','November','December'];
				var jvShortmonths = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
				var jvDateArr = new Array();
				var jvDate = new Date();
				for(var i=0;i<jvDateformat.length;i++){
					jvDateArr[i]=jvDateformat[i];
					switch(jvDateArr[i]){
						case 'l': jvDateArr[i] = jvDays[jvDate.getDay()]; 			break;
						case 'D': jvDateArr[i] = jvShortdays[jvDate.getDay()]; 		break;
						case 'd': jvDateArr[i] = jvDate.getDate(); 					break;
						case 'm': jvDateArr[i] = jvDate.getMonth()+1; 				break;
						case 'M': jvDateArr[i] = jvShortmonths[jvDate.getMonth()]; 	break;
						case 'F': jvDateArr[i] = jvMonths[jvDate.getMonth()]; 		break;
						case 'Y': jvDateArr[i] = jvDate.getFullYear(); 				break;
						default: break;	
					}
				}
				return jvDateArr.join('');
			}
	};
	
	$.extend(this, FeatureDate);

	return this;
})(jQuery);	
			