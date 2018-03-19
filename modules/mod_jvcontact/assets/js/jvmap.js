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
var jvmap = new Class({
	//https://developers.google.com/maps/documentation/javascript/reference#MapOptions
	Implements: Options,
	options	: {
		hosturl		: 'http://localhost/joomla25',
		moduleid	: 0,
		jvmapid		: 'jvmap',
		lat			: '10.784513',
		lng			: '106.630744',
		address		: '',
		zoom		: 17,
		zoomControlOptions: {
            style: 1	//google.maps.ZoomControlStyle.SMALL
        },
		mapTypeId	: 'roadmap', //HYBRID ROADMAP SATELLITE TERRAIN
		iconmarker	: '', //administrator/templates/bluestork/images/notice-info.png
		addevent	: 0,
		infotext	: 'I am here'
		
	},
	
	initialize:function(options){ 
		
		this.setOptions(options);
		
		this.showMap();
		
		if(this.options.addevent) this.addEventMap();
		//this.setJVContactButton();
		
	},
	//show map
	showMap:function(){
		this.options.center = this.getLatLng(this.options.lat, this.options.lng);
		this.map = new google.maps.Map($(this.options.jvmapid),this.options);
		this.placeMarker(this.options.lat, this.options.lng,this.options.infotext,this.options.iconmarker);
		
		
		return this.map;
	},
	//add Event for administrator
	addEventMap:function(){
		var This = this;
		google.maps.event.addListener(This.map, 'rightclick', function(event) {
			var 
				lat 	= event.latLng.lat(),
				lng 	= event.latLng.lng(),
				text	= prompt('Info text',''),

				input	= new Element('input.mapmarker',{type:'hidden',name:'jform[params][map_marker][]'})
			;
			
			if(text){
				input.value = lat + '|' + lng + '|' + text;
				input.inject($(This.options.jvmapid),'before');
				
				This.placeMarker(lat,lng,text);
				
			}
        });
	},
	//get center
	getLatLng:function(lat,lng){
		return new google.maps.LatLng(lat, lng);
	},
	//show an icon at options.center
	placeMarker:function(lat,lng,infotext,icon,ani,dragable){
		var This = this;
		var animation = 'google.maps.Animation.'+ani;//DROP - BOUNCE
        var marker = new google.maps.Marker({
          draggable:dragable,//true / false
          icon:icon,
          animation: animation, 
          position: This.getLatLng(lat,lng),
          map: this.map
        });
        
        this.showInfoWindow(marker, 'click', infotext);
       
        return marker;
    },
    showInfoWindow:function(marker, mapevent, message, widthinfo, heightinfo){
        var infowindow = new google.maps.InfoWindow({ 
                content: message,
                size: new google.maps.Size( widthinfo, heightinfo)
            });
        google.maps.event.addListener(marker, mapevent, function() {
            infowindow.open(this.map,marker);
        });
        //marker.position.lat()
        if(this.options.addevent){
        	google.maps.event.addListener(marker, "rightclick", function() {
            	if( confirm("Are you sure remove this marker ?")){
            		
            		$$(".mapmarker").each(function(el){
            			var data = marker.position.lat() + '|' + marker.position.lng() + '|' + message;
    					if(el.value==data){
    						el.destroy();
    						marker.setMap(null);
    					} 
    				});
            		
            	}
            });
        }
        
        
        return;
    },
    //info@joomlavi.com
    setJVContactButton:function(){
        
        var controlDiv = new Element('div');
        var controlUI = new Element('div');
        var controlText = new Element('div');
        
        
        controlUI.style.cursor = 'pointer';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Copyright @Joomlavi 2012 - JV Contact V2.5.8';
        
        controlText.innerHTML = '<a target="_blank" href="http://joomlavi.com">JV Contact</a>';
       
        controlUI.appendChild(controlText);
        controlDiv.appendChild(controlUI);
        
        controlDiv.index = 1;
        
        this.map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(controlDiv);// here
        
    }

});

