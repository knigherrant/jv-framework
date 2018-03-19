
(function($){
	$.extend($.fn, {
		newSlide: function(o) {
			var doc = $(this);
			return this.delegate('[data-action="new-slide"]', 'click.new-slide', function(){
                
                var d = { index: $.now() };
                
				doc.trigger('load-data-field', [ $(this), d ]);
                
                
			}).on({
				'load-data-field': function( e, p, d ){
                    
                    var index = d ? d.index : $.now();
                    
                    d = $.extend( {
                        index: index,
                        ease: '',
                        bgpositionend: '',
                        bgpositionstart: '',
                        bgposition: '',
                        bgrepeat: '',
                        bgfit: '',
                        kenburns: 'off',
                        saveperformance: '',
                        content: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                        state: '1'
                    }, d );
                    
                    var
						tname = p.closest('li')
						,tcontent = $(p.data('target'))
						,content = $.tmpl(o.tcontent, d )
					;
	                
	                tcontent.append(content);                                               
					$.tmpl(o.tname, {index: index}).insertBefore(tname);

					$( '[href="#slide-' + d.index + '"]' ).tab('show');

					content.schosen();
	                var ominicolor = JV.ominicolors;
	                ominicolor.change = function(v){
	                    $(this).trigger('change');        
	                };
					content.find('.minicolors').each(function(){
						$(this).minicolors(ominicolor);
					});
					content.find('[data-change-editor]').each(function(){
						$(this).trigger('change');
					});
					content.find('[data-field="title"]').each(function(){
						$(this).trigger('keyup.field-title');
					});
					content.sbutton();

					// load children
					doc.trigger('load-child', d);
				},
				'load-child': function(e, d) {
					if(!d || !d.items) { return false; }
					$.each( d.items, function(i, item){
						
						item = $.extend(item, {id: $.now(), index: d.index});

						var s = $( '#layer-zlayer'.replace(/zlayer/, d.index) + '> [data-tag="mark-content"]' );

						doc.trigger('add-layer', [ s, item ] );
					});
				}
			}).delegate( '[data-tag="timeline"] > .item', 'show.bs.tooltip', function() {
                var 
                    e = $( this )
                    ,mce = tinymce.get( e.find( '[data-mce]' ).first().attr( 'data-mce' ) )
                ;
                
                if( !mce ){ return; }   
                
                e.attr( 'data-original-title', mce.getContent() );
            } );
		},
		removeSlide: function(){
			return this.delegate('[data-action="remove-slide"]', 'click.remove-slide', function(){
				
                var p = $(this)
                    ,pn = $( p.attr( 'data-target-title' ) )
                    ,bpn = pn.prev()
                    ,apn = pn.next()
                ;
                
                if( !window.confirm( p.attr( 'data-msg' ) ) ){ return false; }
                
                p.attr( 'disabled', 'disabled' );
				
                $( p.attr('data-target') ).remove();
				
                pn.remove();
                
                if( bpn.length )
                {
                    bpn.children( '[data-toggle="tab"]' ).click();
                    
                }else
                {
                    apn.children( '[data-toggle="tab"]' ).click();
                }
			})
		},
		sdrag: function(){
			return this.each(function(){
				$(this).draggable({
					containment: 'parent',
					grid: [5,5],
                    handle: '.handle',
                    stop: function() {
                        $( this ).bindLayerPosition();
                    }
				});
			});
		},
		jvtinymce: function(){
			
            $( document ).delegate( '[data-action="input-mce-gsource"]', 'click', function() {
                
                var e = $( this )
                    ,eid = e.attr( 'data-editor' )
                    ,editor = tinymce.get( eid )
                ;
                
                if( !editor ) { return false; }
                
                
                 editor.windowManager.open({
                    title: 'File Manager',
                    file: tinyMCE.baseURL + '/plugins/filemanager/dialog.php?editor=' + eid + '&lang=' + tinymce.settings.language + '&subfolder=' + tinymce.settings.subfolder + '&field_id=' + e.attr( 'data-el' ) + '&type=' + e.attr( 'data-type' ) + '&base_url=' + JV.base_url,
                    filetype: 'all',
                    classes: 'filemanager',
                    width: 900,
                    height: 600,
                    inline: 1
                });
        
                return false;    
            } );
              

			tinymce.PluginManager.add('dlayer', function(editor, url) {
        

                // Ads a menu item to the file menu
                editor.addButton('clonelayer', {
                	title: 'Clone Layer',
                	icon: 'copy',
                	onclick: function(){
                		var el = $(editor.targetElm)
                            ,index = el.closest( '[data-tag="editor"]' ).attr( 'id' ).replace( 'editor-', '')  
                            ,item = $.extend( el.closest('[data-tag="drag"]').jsonf(), {
                        	    id: $.now(), 
                        	    index: index
                       	    } )
                            , s = $( [ '#layer-zlayer'.replace( /zlayer/, index ), '[data-tag="mark-content"]' ].join( ' > ') )
                        ;

						$( document ).trigger('add-layer', [ s, item ] );
                	}
                }); 
                                  
                // Adds a menu item to the file menu
                editor.addButton('dlayer', {
                    title: 'Delete layer',
                    icon: 'times', 
                    onclick: function() {
                        
                        var el = $(editor.targetElm)
                            ,m = el.closest('[data-tag="drag"]')
                        ; 
                        
                        if( !window.confirm( m.attr( 'data-msg' ) ) )
                        {
                            return false;
                        }  
                        
                        editor.destroy();
                        $( m.attr('data-timeline') ).remove();
                        m.remove();   
                    }
                });

            });
            
            tinymce.PluginManager.add('jvtransition', function(editor, url) {
                var 
                	layer = $(editor.targetElm).closest('[data-tag="drag"]')
                	,sg = function(){ return '[data-group="zgroup"]'.replace(/zgroup/, this) }
                	,sf = function(){ return '[data-field="zfield"]'.replace(/zfield/, this) }
                	,f = {
                		g: function(){
                			var d = {};
                			layer.find( sg.call(this) ).each(function(){
                				var k = $(this).data('field');
								!k || ( d[ k ] = this.value );
                			});
							return d;
                		},
                		s: function(d){
                			var fields = layer.find( sg.call(this) );
                			$.each(d, function(k, v){
								fields.filter( sf.call(k) ).val( v ).trigger('change');
                			});
                		},
						p: function(d) {
							
							layer.toLayerPosition();
						},
						c: function( e ) {
							var d = e.control.rootControl.toJSON();
								editor.fire( 'deactivate' );
								// save data
								f.s.call( 'pos-style', d );
								// reposition
								f.p.call( this, d );
								editor.fire( 'activate' );
						}
					}
				;
                
        
                // Adds a menu item to the file menu
                editor.addMenuItem('align_pos_style', {
                    text: 'Position & Styling',
                    context: 'tools',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Layer General',
                            bodyType: "tabpanel",
                            data: f.g.call( 'pos-style' ),
                            body: 
                            [
                            	{
									title: "Position",
									type: "form",
									items: [
										{
											type: 'listbox', 
											name: 'pos', label: 'Position',
											values: [                          
												{ value: '', text: 'none', onclick: f.c },
												{ value: 'lt', text: 'Left top', onclick: f.c },
												{ value: 'lc', text: 'Left center', onclick: f.c },
												{ value: 'lb', text: 'Left bottom', onclick: f.c },
												{ value: 'ct', text: 'Center top', onclick: f.c },
												{ value: 'cc', text: 'Center', onclick: f.c },
												{ value: 'cb', text: 'Center bottom', onclick: f.c },
												{ value: 'rl', text: 'Right left', onclick: f.c },
												{ value: 'rc', text: 'Right center', onclick: f.c },
												{ value: 'rb', text: 'Right bottom', onclick: f.c }
											]
										},
										{
											type: "container",
											label: "Offset",
											layout: "flex",
											direction: "row",
											align: "center",
											spacing: 5,
											items: [{
												name: "x",
												type: "textbox",
												maxLength: 5,
												size: 3,
												ariaLabel: "X",
												onkeyup: f.c
											},
											{
												type: "label",
												text: "x"
											},
											{
												name: "y",
												type: "textbox",
												maxLength: 5,
												size: 3,
												ariaLabel: "Y",
												onkeyup: f.c
											}]
										},
										{
											type: 'listbox', 
											name: 'ws', label: 'White Space',
											values: [                          
												{ value: 'normal', text: 'Normal', onclick: f.c},
												{ value: 'pre', text: 'Pre', onclick: f.c},
												{ value: 'nowrap', text: 'No-wrap', onclick: f.c},
												{ value: 'pre-wrap', text: 'Pre-Wrap', onclick: f.c},
												{ value: 'pre-line', text: 'Pre-Line', onclick: f.c}
											]
										},
										{
											type: "container",
											label: "Dimensions",
											layout: "flex",
											direction: "row",
											align: "center",
											spacing: 5,
											items: [{
												name: "mw",
												type: "textbox",
												maxLength: 5,
												size: 3,
												ariaLabel: "Max width",
												onkeyup: f.c
											},
											{
												type: "label",
												text: "x"
											},
											{
												name: "mh",
												type: "textbox",
												maxLength: 5,
												size: 3,
												ariaLabel: "Max height",
												onkeyup: f.c
											}]
										}	
									]
								},
								{
									title: "Styling",
									type: "form",
									items: [
										{
											type: 'listbox', 
											name: 'zstyle', label: 'Style',
											values: ( function( p ) {
                                                var rs = [];
                                                function a ()
                                                {
                                                    $( editor.targetElm )
                                                    .parent( '[data-tag="drag"]' )
                                                    .find( '[name="zstyle"]' )
                                                    .val( this.value() ).trigger( 'change' );
                                                }
                                                $.each( p, function() {
                                                    
                                                    rs.push( { text: this.text, value: this.value, onclick: a } );
                                                    
                                                } );
                                                return rs;
                                            } )( JV.zstyle )
										},
										{
											name: "zid",
											type: "textbox",
											label: "Id",
											onkeyup: f.c
										},
										{
											name: "zclass",
											type: "textbox",
											label: "Class",
											size: 50,
											onkeyup: f.c
										}	
									]
								},
								{
									title: 'Parallax Setting',
									type: 'form',
									items: [
										{
											type: 'listbox',
											name: 'parallax_level',
											label: 'Level',
											values: [
												{ value: '-', text: 'No movement' },
												{ value: '1', text: '1' },
												{ value: '2', text: '2' },
												{ value: '3', text: '3' },
												{ value: '4', text: '4' },
												{ value: '5', text: '5' },
												{ value: '6', text: '6' },
												{ value: '7', text: '7' },
												{ value: '8', text: '8' },
												{ value: '9', text: '9' },
												{ value: '10', text: '10' }
											]
										}
									]
								}
                            ],
							onsubmit: function() {
								var d = this.toJSON();
								// save data
								f.s.call( 'pos-style', d );
								// reposition
								f.p.call( this, d );
							}
                        });    
                    }
                });

                function d_looptype() {
					var key = this.value()
					,nd = ( key || '' ).replace( '-', '_' )
					,dr = function() {
						editor.windowManager.open({
							title: 'Loop Animation',
							data: f.g.call('loop'),
							body: [
								{
									type: "container",
									label: "Speed",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [
										{
											name: "speed",
											type: "textbox",
											maxLength: 5,
											size: 3,
											ariaLabel: "Loop speed"
										},
										{
											type: "label",
											text: "(0.00 - 10.00)"
										}
									]
								},
								{
									type: 'listbox',
									minWidth: 350,
									name: 'loop_easing', label: 'Easing',
									values: JV.easing 
								},
								{
									name: nd + "_startdeg",
									type: "textbox",
									maxLength: 5,
									size: 3,
									label: "Start Degree"
								},
								{
									type: "container",
									label: "End Degree",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										name: nd + "_enddeg",
										type: "textbox",
										maxLength: 5,
										size: 3,
										label: "End Degree"
									},
									{
										type: "label",
										text: "(-720 - 720)"
									}]
								},
								{
									type: "container",
									label: "x Origin",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										name: nd + "_xorigin",
										type: "textbox",
										maxLength: 5,
										size: 3,
										ariaLabel: "x Origin"
									},
									{
										type: "label",
										text: "%"
									}]
								},
								{
									type: "container",
									label: "y Origin",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										name: nd + "_yorigin",
										type: "textbox",
										maxLength: 5,
										size: 3,
										ariaLabel: "y Origin"
									},
									{
										type: "label",
										text: "% (-250% - 250%)"
									}]
								}
							], 
							onsubmit: function(){
								f.s.call('loop', this.toJSON());	
							}	
						});
					},
					dialog = {
						'rs-pendulum': dr, 
						'rs-rotate': dr,
						'rs-slideloop': function() {
							editor.windowManager.open({
								title: 'Loop Animation',
								data: f.g.call('loop'),
								body: [
									{
										name: "type",
										type: "textbox",
										maxLength: 5,
										size: 3,
										hidden: true,
										value: nd
									},{
										type: "container",
										label: "Speed",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "speed",
											type: "textbox",
											maxLength: 5,
											size: 3,
											ariaLabel: "Loop speed"
										},
										{
											type: "label",
											text: "(0.00 - 10.00)"
										}]
									},
									{
										type: 'listbox',
										minWidth: 350,
										name: 'loop_easing', label: 'Easing',
										values: JV.easing 
									},
									{
										type: "container",
										label: "x Start Pos.",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "rs_slideloop_xstart",
											type: "textbox",
											maxLength: 5,
											size: 3,
											label: "x Start Pos."
										},
										{
											type: "label",
											text: "px"
										}]
									},
									{
										type: "container",
										label: "x End Pos.",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "rs_slideloop_xend",
											type: "textbox",
											maxLength: 5,
											size: 3,
											label: "x End Pos."
										},
										{
											type: "label",
											text: "px (-2000px - 2000px)"
										}]
									},
									{
										type: "container",
										label: "y Start Pos.",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "rs_slideloop_ystart",
											type: "textbox",
											maxLength: 5,
											size: 3,
											ariaLabel: "y Start Pos."
										},
										{
											type: "label",
											text: "px"
										}]
									},
									{
										type: "container",
										label: "y End Pos.",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "rs_slideloop_yend",
											type: "textbox",
											maxLength: 5,
											size: 3,
											ariaLabel: "y End Pos."
										},
										{
											type: "label",
											text: "px (-2000px - 2000px)"
										}]
									}
								],
								onsubmit: function(){
									f.s.call('loop', this.toJSON());
								}	
							});
						}, 
						'rs-pulse': function() {
							editor.windowManager.open({
								title: 'Loop Animation',
								data: f.g.call('loop'),
								body: [
									{
										name: "type",
										type: "textbox",
										maxLength: 5,
										size: 3,
										hidden: true,
										value: nd
									},{
										type: "container",
										label: "Speed",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "speed",
											type: "textbox",
											maxLength: 5,
											size: 3,
											ariaLabel: "Loop speed"
										},
										{
											type: "label",
											text: "(0.00 - 10.00)"
										}]
									},
									{
										type: 'listbox',
										minWidth: 350,
										name: 'loop_easing', label: 'Easing',
										values: JV.easing 
									},
									{
										name: "rs_pulse_zoomstart",
										type: "textbox",
										maxLength: 5,
										size: 3,
										label: "Start Zoom"
									},
									{
										type: "container",
										label: "End Zoom",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "rs_pulse_zoomend",
											type: "textbox",
											maxLength: 5,
											size: 3,
											label: "End Zoom"
										},
										{
											type: "label",
											text: "(0.00 - 20.00)"
										}]
									}
								],
								onsubmit: function(){
									f.s.call('loop', this.toJSON());
								}	
							});
						}, 
						'rs-wave': function() {
							editor.windowManager.open({
								title: 'Loop Animation',
								data: f.g.call('loop'),
								body: [
									{
										name: "type",
										type: "textbox",
										maxLength: 5,
										size: 3,
										hidden: true,
										value: nd
									},{
										type: "container",
										label: "Speed",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "speed",
											type: "textbox",
											maxLength: 5,
											size: 3,
											ariaLabel: "Loop speed"
										},
										{
											type: "label",
											text: "(0.00 - 10.00)"
										}]
									},
									{
										type: 'listbox',
										minWidth: 350,
										name: 'loop_easing', label: 'Easing',
										values: JV.easing 
									},
									{
										type: "container",
										label: "x Origin",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "rs_wave_xorigin",
											type: "textbox",
											maxLength: 5,
											size: 3,
											label: "x Origin"
										},
										{
											type: "label",
											text: "%"
										}]
									},
									{
										type: "container",
										label: "y Origin",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "rs_wave_yorigin",
											type: "textbox",
											maxLength: 5,
											size: 3,
											label: "y Origin"
										},
										{
											type: "label",
											text: "% (-250% - 250%)"
										}]
									},
									{
										type: "container",
										label: "Angle",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "rs_wave_angle",
											type: "textbox",
											maxLength: 5,
											size: 3,
											ariaLabel: "Angle."
										},
										{
											type: "label",
											text: "(0-360)"
										}]
									},
									{
										type: "container",
										label: "Radius",
										layout: "flex",
										direction: "row",
										align: "center",
										spacing: 5,
										items: [{
											name: "rs_wave_radius",
											type: "textbox",
											maxLength: 5,
											size: 3,
											ariaLabel: "Radius"
										},
										{
											type: "label",
											text: "px (0px - 2000px)"
										}]
									}
								],
								onsubmit: function(){
									f.s.call('loop', this.toJSON());
								}	
							});	
						}
					}[key]();
                }

                function transitcustom(t){
                	var p = t;
                	t = 'custom-transit-ztype'.replace(/ztype/, t);
                	editor.windowManager.open({
						title: 'Custom animation',
						data: f.g.call( t ),
						body: [
							{
								type: "container",
								label: "Transition",
								layout: "flex",
								direction: "row",
								align: "center",
								spacing: 20,
								minWidth: 300,
								items: [{
									type: "container",
									label: "X",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										type: "label",
										text: "X:"
									},{
										type: 'textbox', 
										name: 'movex' + p,
										size: 5
									},
									{
										type: "label",
										text: "px"
									}]
								},
								{
									type: "container",
									label: "Y",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										type: "label",
										text: "Y:"
									},{
										type: 'textbox', 
										name: 'movey' + p,
										size: 5
									},
									{
										type: "label",
										text: "px"
									}]
								},
								{
									type: "container",
									label: "Z",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										type: "label",
										text: "Z:"
									},{
										type: 'textbox', 
										name: 'movez' + p,
										size: 5
									},
									{
										type: "label",
										text: "px"
									}]
								}]
							},
							{
								type: "container",
								label: "Rotation",
								layout: "flex",
								direction: "row",
								align: "center",
								spacing: 20,
								minWidth: 350,
								items: [{
									type: "container",
									label: "x",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										type: "label",
										text: "X:"
									},{
										type: 'textbox', 
										name: 'rotationx' + p,
										size: 5
									},
									{
										type: "label",
										text: "deg"
									}]
								},
								{
									type: "container",
									label: "y",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										type: "label",
										text: "Y:"
									},{
										type: 'textbox', 
										name: 'rotationy' + p,
										size: 5
									},
									{
										type: "label",
										text: "deg"
									}]
								},
								{
									type: "container",
									label: "z",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										type: "label",
										text: "Z:"
									},{
										type: 'textbox', 
										name: 'rotationz' + p,
										size: 5
									},
									{
										type: "label",
										text: "deg"
									}]
								}]
							},
							{
								type: "container",
								label: "Scale",
								layout: "flex",
								direction: "row",
								align: "center",
								spacing: 20,
								minWidth: 300,
								items: [{
									type: "container",
									label: "x",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										type: "label",
										text: "X:"
									},{
										type: 'textbox', 
										name: 'scalex' + p,
										size: 5
									},
									{
										type: "label",
										text: "%"
									}]
								},
								{
									type: "container",
									label: "y",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										type: "label",
										text: "Y:"
									},{
										type: 'textbox', 
										name: 'scaley' + p,
										size: 5
									},
									{
										type: "label",
										text: "%"
									}]
								}]
							},
							{
								type: "container",
								label: "Skew",
								layout: "flex",
								direction: "row",
								align: "center",
								spacing: 20,
								minWidth: 300,
								items: [{
									type: "container",
									label: "x",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										type: "label",
										text: "X:"
									},{
										type: 'textbox', 
										name: 'skewx' + p,
										size: 5
									},
									{
										type: "label",
										text: "px"
									}]
								},
								{
									type: "container",
									label: "y",
									layout: "flex",
									direction: "row",
									align: "center",
									spacing: 5,
									items: [{
										type: "label",
										text: "Y:"
									},{
										type: 'textbox', 
										name: 'skewy' + p,
										size: 5
									},
									{
										type: "label",
										text: "px"
									}]
								}]
							},
							{
								type: "container",
								label: "Opacity",
								layout: "flex",
								direction: "row",
								align: "center",
								spacing: 5,
								items: [{
									type: 'textbox', 
									name: 'captionopacity' + p,
									minWidth: 360
								},
								{
									type: "label",
									text: "%"
								}]
							},
							{
								type: "container",
								label: "Perspective",
								layout: "flex",
								direction: "row",
								align: "center",
								spacing: 5,
								items: [{
									type: 'textbox', 
									name: 'captionperspective' + p,
									minWidth: 360
								},
								{
									type: "label",
									text: "px"
								}]
							},
							{
								type: "container",
								label: "Origin",
								layout: "flex",
								direction: "row",
								align: "center",
								spacing: 20,
								minWidth: 300,
								items: [{
									type: 'textbox', 
									name: 'origin' + p
								},
								{
									type: "label",
									text: "x% y%"
								}]
							}
						],
						onsubmit: function(){
							f.s.call( t, this.toJSON() );
						}
                	});
                };
                
                // Adds a menu item to the file menu
                editor.addMenuItem('jvtransition', {
                    text: 'Animation',
                    context: 'tools',
                    onclick: function() {
                        
                        // Open window
                        editor.windowManager.open({
                            title: 'Layer Animation',
                            bodyType: "tabpanel",
                            data: f.g.call( 'transit' ),
                            body: [
                            	{
									title: "Start Transition",
									type: "form",
									items: [
										{
											type: 'listbox',
											minWidth: 300,
											name: 'animationin', label: 'Animation name',
											values: [                          
												{ value: 'tp-fade', text: 'Fade'},
												{ value: 'sft', text: 'Short from Top'},
												{ value: 'sfb', text: 'Short from Bottom'},
												{ value: 'sfr', text: 'Short from Right'},
												{ value: 'sfl', text: 'Short from Left'},
												{ value: 'lft', text: 'Long from Top'},
												{ value: 'lfb', text: 'Long from Bottom'},
												{ value: 'lfr', text: 'Long from Right'},
												{ value: 'lfl', text: 'Long from Left'},
												{ value: 'skewfromright', text: 'Skew From Long Right'},
												{ value: 'skewfromleft', text: 'Skew From Long Left'},
												{ value: 'skewfromrightshort', text: 'Skew From Short Right'},
												{ value: 'skewfromleftshort', text: 'Skew From Short Left'},
												{ value: 'randomrotate', text: 'Random Rotate'},
												{ value: 'customin', text: 'Custom', onselect: function() { transitcustom('in') } }
											]
										},
										{
											type: 'listbox', 
											name: 'easing', label: 'Easing',
											size: 100,
											values: JV.easing 
										},
										{
											type: "container",
											label: "Speed",
											layout: "flex",
											direction: "row",
											align: "center",
											spacing: 5,
											items: [{
												type: 'textbox', 
												name: 'speedin',
												size: 5,
												values: JV.aname 
											},
											{
												type: "label",
												text: "ms"
											}]
										},
										{
											type: 'listbox', 
											name: 'splitin',
											label: 'Split Text per',
											values: JV.splitin 
										},
										{
											type: "container",
											label: "Split Delay",
											layout: "flex",
											direction: "row",
											align: "center",
											spacing: 5,
											items: [{
												type: 'textbox', 
												name: 'splitdelayin',
												size: 5
											},
											{
												type: "label",
												text: "ms (keep it low i.e. 1- 200)"
											}]
										}	
									]
                            	},
                            	{
									title: "End Transition (optional)",
									type: "form",
									items: [
										{
											type: 'listbox', 
											minWidth: 350,
											name: 'animationout', label: 'Animation name',
											values: [
												{ value: 'auto', text: 'Choose Automatic' },
												{ value: 'fadeout', text: 'Fade Out' },
												{ value: 'stt', text: 'Short to Top' },
												{ value: 'stb', text: 'Short to Bottom' },
												{ value: 'stl', text: 'Short to Left' },
												{ value: 'str', text: 'Short to Right' },
												{ value: 'ltt', text: 'Long to Top' },
												{ value: 'ltb', text: 'Long to Bottom' },
												{ value: 'ltl', text: 'Long to Left' },
												{ value: 'ltr', text: 'Long to Right' },
												{ value: 'skewtoright', text: 'Skew To Right' },
												{ value: 'skewtoleft', text: 'Skew To Left' },
												{ value: 'skewtorightshort', text: 'Skew To Right Short' },
												{ value: 'skewtoleftshort', text: 'Skew To Left Short' },
												{ value: 'randomrotateout', text: 'Random Rotate Out' },
												{ value: 'customout', text: 'Custom', onselect: function(){ transitcustom('out')}  }
											] 
										},
										{
											type: 'listbox', 
											name: 'easingout', label: 'Easing',
											size: 100,
											values: JV.easing 
										},
										{
											type: "container",
											label: "Speed",
											layout: "flex",
											direction: "row",
											align: "center",
											spacing: 5,
											items: [{
												type: 'textbox', 
												name: 'speedout',
												size: 5,
												values: JV.aname 
											},
											{
												type: "label",
												text: "ms"
											}]
										},
										{
											type: 'listbox', 
											name: 'splitout',
											label: 'Split Text per',
											values: JV.splitin 
										},
										{
											type: "container",
											label: "Split Delay",
											layout: "flex",
											direction: "row",
											align: "center",
											spacing: 5,
											items: [{
												type: 'textbox', 
												name: 'splitdelayout',
												size: 5
											},
											{
												type: "label",
												text: "ms (keep it low i.e. 1- 200)"
											}]
										}	
									],
									onsubmit: function(){
										f.s.call( 'transit', this.toJSON() );
									}
                            	},
                            	{
									title: "Loop Animation",
									type: "form",
									items: [
										{
											type: 'listbox', 
											name: 'loop_type',
											label: 'Type',
											values: [
												{ value: 'none', text: 'Disabled' },
												{ value: 'rs-pendulum', text: 'Pendulum', onselect: d_looptype },
												{ value: 'rs-rotate', text: 'Rotate', onselect: d_looptype },
												{ value: 'rs-slideloop', text: 'Slideloop', onselect: d_looptype },
												{ value: 'rs-pulse', text: 'Pulse', onselect: d_looptype},
												{ value: 'rs-wave', text: 'Wave', onselect: d_looptype }
											]
										}	
									]
                            	}       
                            ],
                            onsubmit: function(e) {                             
								f.s.call( 'transit', this.toJSON() );                                                                   
                            }
                        });           
                    }
                });
                editor.addButton('jvtransition', {
                    title: 'Animation',
                    icon: 'unlink',
                    onclick: function() {
                        editor.menuItems.jvtransition.onclick();
                    }
                } );

                // Timing & Sort
                editor.addMenuItem('jvtiming', {
                    text: 'Timing & Sort',
                    context: 'tools',
                    onclick: function() {
                    	
                        // Open window
                        editor.windowManager.open({
                            title: 'Timing & Sort',
                            data: (function(){
                            	var r = layer.find('[name="timeline"]').val().split(";");

                            	return {
                            		from: r[0],
                            		to: r[1],
                            		zindex: layer.find('[name="zIndex"]').val()
                            	};
                            })(),
                            body: [
                            	{
                            		label: 'Time',
                            		type: 'container',
                            		layout: 'flex',
                            		direction: 'row',
                            		align: 'center',
                            		spacing: 5,
                            		items: [
										{
											name: 'from',
											type: 'textbox'
										},
										{
											type: 'label',
											text: 'ms'	
										},
										{
											name: 'to',
											type: 'textbox'
										},
										{
											type: 'label',
											text: 'ms'	
										}
                            		]
                            	},
                            	{
                            		label: 'z-index',
                            		type: 'textbox',
                            		name: 'zindex'
                            	}
                            ],
                            onsubmit: function(){
                            	var d = this.toJSON()
                            		,tl = layer.find('[name="timeline"]')
                            	;

                            	$( layer.attr( 'data-timeline' ) ).find( '.divtimeline' ).append( tl );
								tl.data( 'ionRangeSlider' ).update({
									from: d.from,
									to: d.to
								});
								layer.append( tl );
								
								layer.find('[name="zIndex"]').val( d.zindex );
								
                            }
                        });
                    }
                });

            });

			tinymce.PluginManager.add("jvmedia", function(a, b) {
			    function c(a) {
			        return -1 != a.indexOf(".mp3") ? "audio/mpeg" : -1 != a.indexOf(".wav") ? "audio/wav" : -1 != a.indexOf(".mp4") ? "video/mp4" : -1 != a.indexOf(".webm") ? "video/webm" : -1 != a.indexOf(".ogg") ? "video/ogg" : -1 != a.indexOf(".swf") ? "application/x-shockwave-flash" : ""
			    }

			    function d(b) {
			        var c = a.settings.media_scripts;
			        if (c)
			            for (var d = 0; d < c.length; d++)
			                if (-1 !== b.indexOf(c[d].filter)) return c[d]
			    }

			    function e() {
			        function b(a) {
			            var b, c, f, g;
			            b = d.find("#width")[0], c = d.find("#height")[0], f = b.value(), g = c.value(), d.find("#constrain")[0].checked() && e && j && f && g && (a.control == b ? (g = Math.round(f / e * g), c.value(g)) : (f = Math.round(g / j * f), b.value(f))), e = f, j = g
			        }

			        function c() {
			            k = h(this.value()), this.parent().parent().fromJSON(k)
			        }
			        function onSubmit( evt, din ) {
			        	a.setContent( g( din ) );
			        	$( a.targetElm ).closest( '[data-tag="drag"]' ).find( '[data-field="content"]' ).val( a.getContent() );
			        }

			        a.fire( 'deactivate' );
			        $( '#' + a.id ).closest( '[data-tag="drag"]' ).find( '[data-tag="media"]' ).modal( 'show' )
			        .one( 'cmedia', onSubmit );
			    }

			    function f() {
			        var b = a.selection.getNode();
			        return b.getAttribute("data-mce-object") ? a.selection.getContent() : void 0
			    }

			    function g(e) {
			        var f = "";
			        if (!e.source1 && (tinymce.extend(e, h(e.embed)), !e.source1)) return "";
			        if (e.source2 || (e.source2 = ""), e.poster || (e.poster = ""), e.source1 = a.convertURL(e.source1, "source"), e.source2 = a.convertURL(e.source2, "source"), e.source1mime = c(e.source1), e.source2mime = c(e.source2), e.poster = a.convertURL(e.poster, "poster"), e.flashPlayerUrl = a.convertURL(b + "/moxieplayer.swf", "movie"), tinymce.each(l, function(a) {
			                var b, c, d;
			                if (b = a.regex.exec(e.source1)) {
			                    for (d = a.url, c = 0; b[c]; c++) d = d.replace("$" + c, function() {
			                        return b[c]
			                    });
			                    e.source1 = d, e.type = a.type, e.width = e.width || a.w, e.height = e.height || a.h
			                }
			            }), e.embed) f = k(e.embed, e, !0);
			        else {
			            var g = d(e.source1);
			            g && (e.type = "script", e.width = g.width, e.height = g.height), e.width = e.width || 300, e.height = e.height || 150, tinymce.each(e, function(b, c) {
			                e[c] = a.dom.encode(b)
			            }), "iframe" == e.type ? f += '<iframe src="' + e.source1 + '" width="' + e.width + '" height="' + e.height + '"></iframe>' : "application/x-shockwave-flash" == e.source1mime ? (f += '<object data="' + e.source1 + '" width="' + e.width + '" height="' + e.height + '" type="application/x-shockwave-flash">', e.poster && (f += '<img src="' + e.poster + '" width="' + e.width + '" height="' + e.height + '" />'), f += "</object>") : -1 != e.source1mime.indexOf("audio") ? a.settings.audio_template_callback ? f = a.settings.audio_template_callback(e) : f += '<audio controls="controls" src="' + e.source1 + '">' + (e.source2 ? '\n<source src="' + e.source2 + '"' + (e.source2mime ? ' type="' + e.source2mime + '"' : "") + " />\n" : "") + "</audio>" : "script" == e.type ? f += '<script src="' + e.source1 + '"></script>' : f = a.settings.video_template_callback ? a.settings.video_template_callback(e) : '<video width="' + e.width + '" height="' + e.height + '"' + (e.poster ? ' poster="' + e.poster + '"' : "") + ' controls="controls">\n<source src="' + e.source1 + '"' + (e.source1mime ? ' type="' + e.source1mime + '"' : "") + " />\n" + (e.source2 ? '<source src="' + e.source2 + '"' + (e.source2mime ? ' type="' + e.source2mime + '"' : "") + " />\n" : "") + "</video>"
			        }
			        return f
			    }

			    function h(a) {
			        var b = {};
			        return new tinymce.html.SaxParser({
			            validate: !1,
			            allow_conditional_comments: !0,
			            special: "script,noscript",
			            start: function(a, c) {
			                if (b.source1 || "param" != a || (b.source1 = c.map.movie), ("iframe" == a || "object" == a || "embed" == a || "video" == a || "audio" == a) && (b.type || (b.type = a), b = tinymce.extend(c.map, b)), "script" == a) {
			                    var e = d(c.map.src);
			                    if (!e) return;
			                    b = {
			                        type: "script",
			                        source1: c.map.src,
			                        width: e.width,
			                        height: e.height
			                    }
			                }
			                "source" == a && (b.source1 ? b.source2 || (b.source2 = c.map.src) : b.source1 = c.map.src), "img" != a || b.poster || (b.poster = c.map.src)
			            }
			        }).parse(a), b.source1 = b.source1 || b.src || b.data, b.source2 = b.source2 || "", b.poster = b.poster || "", b
			    }

			    function i(b) {
			        return b.getAttribute("data-mce-object") ? h(a.serializer.serialize(b, {
			            selection: !0
			        })) : {}
			    }

			    function j(b) {
			        if (a.settings.media_filter_html === !1) return b;
			        var c = new tinymce.html.Writer;
			        return new tinymce.html.SaxParser({
			            validate: !1,
			            allow_conditional_comments: !1,
			            special: "script,noscript",
			            comment: function(a) {
			                c.comment(a)
			            },
			            cdata: function(a) {
			                c.cdata(a)
			            },
			            text: function(a, b) {
			                c.text(a, b)
			            },
			            start: function(a, b, d) {
			                if ("script" != a && "noscript" != a) {
			                    for (var e = 0; e < b.length; e++)
			                        if (0 === b[e].name.indexOf("on")) return;
			                    c.start(a, b, d)
			                }
			            },
			            end: function(a) {
			                "script" != a && "noscript" != a && c.end(a)
			            }
			        }, new tinymce.html.Schema({})).parse(b), c.getContent()
			    }

			    function k(a, b, c) {
			        function d(a, b) {
			            var c, d, e, f;
			            for (c in b)
			                if (e = "" + b[c], a.map[c])
			                    for (d = a.length; d--;) f = a[d], f.name == c && (e ? (a.map[c] = e, f.value = e) : (delete a.map[c], a.splice(d, 1)));
			                else e && (a.push({
			                    name: c,
			                    value: e
			                }), a.map[c] = e)
			        }
			        var e, f = new tinymce.html.Writer,
			            g = 0;
			        return new tinymce.html.SaxParser({
			            validate: !1,
			            allow_conditional_comments: !0,
			            special: "script,noscript",
			            comment: function(a) {
			                f.comment(a)
			            },
			            cdata: function(a) {
			                f.cdata(a)
			            },
			            text: function(a, b) {
			                f.text(a, b)
			            },
			            start: function(a, h, i) {
			                switch (a) {
			                    case "video":
			                    case "object":
			                    case "embed":
			                    case "img":
			                    case "iframe":
			                        d(h, {
			                            width: b.width,
			                            height: b.height
			                        })
			                }
			                if (c) switch (a) {
			                    case "video":
			                        d(h, {
			                            poster: b.poster,
			                            src: ""
			                        }), b.source2 && d(h, {
			                            src: ""
			                        });
			                        break;
			                    case "iframe":
			                        d(h, {
			                            src: b.source1
			                        });
			                        break;
			                    case "source":
			                        if (g++, 2 >= g && (d(h, {
			                                src: b["source" + g],
			                                type: b["source" + g + "mime"]
			                            }), !b["source" + g])) return;
			                        break;
			                    case "img":
			                        if (!b.poster) return;
			                        e = !0
			                }
			                f.start(a, h, i)
			            },
			            end: function(a) {
			                if ("video" == a && c)
			                    for (var h = 1; 2 >= h; h++)
			                        if (b["source" + h]) {
			                            var i = [];
			                            i.map = {}, h > g && (d(i, {
			                                src: b["source" + h],
			                                type: b["source" + h + "mime"]
			                            }), f.start("source", i, !0))
			                        }
			                if (b.poster && "object" == a && c && !e) {
			                    var j = [];
			                    j.map = {}, d(j, {
			                        src: b.poster,
			                        width: b.width,
			                        height: b.height
			                    }), f.start("img", j, !0)
			                }
			                f.end(a)
			            }
			        }, new tinymce.html.Schema({})).parse(a), f.getContent()
			    }
			    var l = [{
			            regex: /youtu\.be\/([\w\-.]+)/,
			            type: "iframe",
			            w: 425,
			            h: 350,
			            url: "//www.youtube.com/embed/$1"
			        }, {
			            regex: /youtube\.com(.+)v=([^&]+)/,
			            type: "iframe",
			            w: 425,
			            h: 350,
			            url: "//www.youtube.com/embed/$2"
			        }, {
			            regex: /vimeo\.com\/([0-9]+)/,
			            type: "iframe",
			            w: 425,
			            h: 350,
			            url: "//player.vimeo.com/video/$1?title=0&byline=0&portrait=0&color=8dc7dc"
			        }, {
			            regex: /vimeo\.com\/(.*)\/([0-9]+)/,
			            type: "iframe",
			            w: 425,
			            h: 350,
			            url: "//player.vimeo.com/video/$2?title=0&amp;byline=0"
			        }, {
			            regex: /maps\.google\.([a-z]{2,3})\/maps\/(.+)msid=(.+)/,
			            type: "iframe",
			            w: 425,
			            h: 350,
			            url: '//maps.google.com/maps/ms?msid=$2&output=embed"'
			        }],
			        m = tinymce.Env.ie && tinymce.Env.ie <= 8 ? "onChange" : "onInput";
			    a.on("ResolveName", function(a) {
			        var b;
			        1 == a.target.nodeType && (b = a.target.getAttribute("data-mce-object")) && (a.name = b)
			    }), a.on("preInit", function() {
			        var b = a.schema.getSpecialElements();
			        tinymce.each("video audio iframe object".split(" "), function(a) {
			            b[a] = new RegExp("</" + a + "[^>]*>", "gi")
			        });
			        var c = a.schema.getBoolAttrs();
			        tinymce.each("webkitallowfullscreen mozallowfullscreen allowfullscreen".split(" "), function(a) {
			            c[a] = {}
			        }), a.parser.addNodeFilter("iframe,video,audio,object,embed,script", function(b, c) {
			            for (var e, f, g, h, i, j, k, l, m = b.length; m--;)
			                if (f = b[m], f.parent && ("script" != f.name || (l = d(f.attr("src"))))) {
			                    for (g = new tinymce.html.Node("img", 1), g.shortEnded = !0, l && (l.width && f.attr("width", l.width.toString()), l.height && f.attr("height", l.height.toString())), j = f.attributes, e = j.length; e--;) h = j[e].name, i = j[e].value, "width" !== h && "height" !== h && "style" !== h && (("data" == h || "src" == h) && (i = a.convertURL(i, h)), g.attr("data-mce-p-" + h, i));
			                    k = f.firstChild && f.firstChild.value, k && (g.attr("data-mce-html", escape(k)), g.firstChild = null), g.attr({
			                        width: f.attr("width") || "300",
			                        height: f.attr("height") || ("audio" == c ? "30" : "150"),
			                        style: f.attr("style"),
			                        src: tinymce.Env.transparentSrc,
			                        "data-mce-object": c,
			                        "class": "mce-object mce-object-" + c
			                    }), f.replace(g)
			                }
                        
			        }), a.serializer.addAttributeFilter("data-mce-object", function(a, b) {
			            for (var c, d, e, f, g, h, i, k = a.length; k--;)
			                if (c = a[k], c.parent) {
			                    for (i = c.attr(b), d = new tinymce.html.Node(i, 1), "audio" != i && "script" != i && d.attr({
			                            width: c.attr("width"),
			                            height: c.attr("height")
			                        }), d.attr({
			                            style: c.attr("style")
			                        }), f = c.attributes, e = f.length; e--;) {
			                        var l = f[e].name;
			                        0 === l.indexOf("data-mce-p-") && d.attr(l.substr(11), f[e].value)
			                    }
			                    "script" == i && d.attr("type", "text/javascript"), g = c.attr("data-mce-html"), g && (h = new tinymce.html.Node("#text", 3), h.raw = !0, h.value = j(unescape(g)), d.append(h)), c.replace(d)
			                }
			        })
			    }), a.on("ObjectSelected", function(a) {
			        var b = a.target.getAttribute("data-mce-object");
			        ("audio" == b || "script" == b) && a.preventDefault()
			    }), a.on("objectResized", function(a) {
			        var b, c = a.target;
			        c.getAttribute("data-mce-object") && (b = c.getAttribute("data-mce-html"), b && (b = unescape(b), c.setAttribute("data-mce-html", escape(k(b, {
			            width: a.width,
			            height: a.height
			        })))))
			    }), a.addButton("jvmedia", {
			        tooltip: "Insert/edit video",
			        icon: "media",
			        onclick: e,
			        stateSelector: ["img[data-mce-object=video]", "img[data-mce-object=iframe]"]
			    }), a.addMenuItem("jvmedia", {
			        icon: "media",
			        text: "Insert video",
			        onclick: e,
			        context: "insert",
			        prependToContext: !0
			    })
			});
            
            tinymce.PluginManager.add( 'jvlayerpos', function( editor, url ) {
                
                function a()
                {
                    editor.fire( 'deactivate' );
                    var e = $( editor.targetElm ).parent( '[data-tag="drag"]' );
                    e.find( '[name="pos"]' ).val( this.value() );
                    e.toLayerPosition().bindLayerPosition();
                    editor.focus();
                    editor.fire( 'activate' );
                }
                
                editor.addButton( 'jvlayerpos', {
                    title: 'Layer General',
                    icon: 'alignjustify',
                    onclick: function() {
                    	editor.menuItems.align_pos_style.onclick();
                    }
                } );
                
            } );

	        return this;
		},
		stinymce: function() {
            tinymce.init({
                selector: '#' + this.attr('id'),
                inline: true,
                theme: "modern",
                plugins: [
                    "code", 
                    "dlayer jvtransition image jvmedia jvlayerpos"
                ],
                toolbar1: "insertfile image jvmedia | code jvslayer clonelayer jvlayerpos jvtransition dlayer",
                toolbar2: "",
                subfolder: '', 
                image_advtab: true,
                relative_urls: false,
                forced_root_block: false,
                removed_menuitems: "newdocument bold italic strikethrough subscript superscript underline visualaid",
                setup: function(editor) {
                    editor
                    .on('keyup', function(e) {
                        
                        var layer = $( editor.targetElm ).parent( '[data-tag="drag"]');
               
                        layer.find( '[name="content"]' ).val( editor.getContent() );

                        layer.toLayerPosition().bindLayerPosition();
                       
                    })
                    .on( 'change', function() {
                    	editor.fire( 'keyup' );
                    } );
                }
           });   
               
			return this;
		},
		addLayer: function(o){
			o = $.extend(o, {
				tmpl: $('[data-tmpl="layer"]').html()
			});
			var doc = $(document);
			return this.delegate('[data-action="add-layer"]', 'click.add-layer', function(){
				var 
					$this = $(this)
					,s = $( $this.data('layer') )
					,d = {
						id: $.now()
						,index: $this.data('index')
						,content: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
						,zstyle: 'mediumwhitebg'
						,pos: 'cc'
					}
				;

				doc.trigger('add-layer', [ s, d ] );
				
			}).delegate('[data-field="zstyle"]', 'change', function(){
				var s = $(this).parent( '[data-tag="drag"]' ).children( '[data-tag="mce"]' );
				$.each( JV.zstyle, function(){
					s.removeClass( this.value );
				});
				s.addClass( this.value );
			}).on({
				'add-layer': function(e, t, d){
					$.each(d, function(k, v) {
						if($.type(v) === 'object') {
							$.extend(d, v);
							d[v] = undefined;	
						}
					});

					if( d.loop && d.loop_type && ( loop_type = d.loop[ d.loop_type ]) ) {
						$.each( loop_type, function(k, v) {
							d[ k ] = v;
						});
					}
					
					var layer = $.tmpl(o.tmpl, d);
					t.append(layer);
					layer.find('[data-tag="mce"]').html(d.content);
					layer.find('[data-field="content"]').val(d.content);
					layer.find('[data-field="zstyle"]').trigger('change');
					layer.sdrag().children('[data-tag="mce"]').stinymce();

					layer.sbutton().schosen()
					.find( '[data-tag="yt"], [data-tag="vimeo"]' ).each( function() {

						var e = $( this );

						e.qsource( e.attr( 'data-tag' ) );

					} );

					layer.imagesLoaded( function() {
						layer.toLayerPosition();
					} );

					doc.trigger('make-timeline', [ t.closest('[data-tag="editor"]').closest( '.tab-panel' ).find('[data-tag="timeline"]'), d ]);
				},
				'make-timeline': function(e, t, d){

					// make sort
					t.children().length || t.sortable({
						containment: 'parent',
						handle: '.handle',
						stop: function(){
							$(this).children().each(function(i){
								$(this).find('[data-tag="zindex"]').val(i);
							});
						}
					});
					// make item
					$.each(JV.orange, function(k, v){
						if( !(k in d) || !d[k] ) {
							d[k] = v;
						}
					});

					var s = $.tmpl( $(t.data('child')).val(), d);
					s.find('[data-tag="range"]').ionRangeSlider();
					t.append( s );

					s.xtooltip();
                    
                    s.find( '.divtimeline [data-tag]' ).each( function() {
                        
                        var f = $( this );
                        
                        $( '[name="' + f.attr( 'data-gchild' ) + '"]' ).append( f );
                        
                        
                    } );
				}
			});
		},
        sbox: function(o) {
            o.imageok.on({
                'fieldid': function(e, f){
                    $(this).find('[data-tag="image"]').attr( 'src', f );
                }
            });
            return this.delegate('[data-tag="browse-img"]', 'click.browse-img', function(){
                
                $( $( this ).attr( 'data-target' ) )
                .trigger( 'fieldid', [ this.href ] )
                .modal('show');
                
                return false;
            });
        },
        beditor: function() {
            function b(d) {
                if( 'background-image' in d ) {
                    d['background-image'] = 'url(zurl)'.replace(/zurl/, d['background-image']);
                }
                return d;
            }
            return this.delegate('[data-tag="layer"]', 'editor-change', function(e, a){
                $(this).css(a);    
            }).delegate('[data-change-editor]', 'change', function(){
                var f = $(this)
                    ,a = {}
                ;
                a[f.data('kcss')] = this.value;
                b(a);
                $(f.data('change-editor')).trigger('editor-change', [a])
            });
        },
        loadCache: function(o) {

    		var doc = this;

        	if(!JSON.validate(o.c)) { return this; }

        	$.each(JSON.decode(o.c), function(id, item){
        		
        		item.index = id;

        		doc.trigger('load-data-field', [o.p, item]);
        		
        	});

        	$('[href^="#slide-"]').first().tab('show');

			return this;
        },
        toggleEditor: function(){
        	return this.delegate('[data-mce]', 'click.data-mce', function(){

    			var es = tinymce.editors,
    				eid = $(this).data('mce')
    			;
    			!es.length || $.each(es, function(i, e){
    				if( e.id === eid) {
    					e.focus(); e.fire('activate');		
    				}else {
    					e.fire('deactivate');
    				}
    			});
    			
        	}).delegate( '[data-filter]', 'click', function() {
        		var mce = tinymce.get( $( this ).attr( 'data-filter' ) );
        		!mce || mce.menuItems.jvtiming.onclick();
        	} );
        },
        inlineConfig: function(d){
        	var 
        		t = this.first()
        		,m = t.find('[data-tmpl="inline-settings"]')
        		,s = $.tmpl( m.val(), d )
        	;
               
        	m.replaceWith( s );
        	s.sbutton();
        	s.schosen();
        	s.sminicolors();
        	t.delegate('[data-active="save"]', 'click', function(){
        		var delay = t.find('[data-field="delay"]').val();
    			delay = JV.toNum.call(delay) || 9000;
    			JV.orange.to = delay,
				JV.orange.max = delay;

				// re-build range
				//t.trigger('re-build');
				t.trigger('build-sizer');

				return false;
        	}).on({
        		're-build': function(){
        		    t.trigger('build-range');
                    t.trigger('build-sizer');	
        		},
                'build-range': function(){
                    $('[data-tag="range"]').each(function(){

                        var r = $(this).data('ionRangeSlider');
                        !r || r.update({ max: JV.orange.max });
                        
                    });      
                },
                'build-sizer': function(){
                    $('#layer-sizer').remove();
                    var s = '.com_jvss .tab-content .tab-pane [data-tag="layer"].layer {width: zw;height: zhpx;min-height: initial;} [data-tag="mark-content"] {width: mwpx;height: zhpx;}'
                    	,w = t.find('[data-field="width"]').val()
                    	,h = t.find('[data-field="height"]').val()
                        ,zw = t.find('[name="slider_type"]:checked').val().match(/fullwidth/) ? '100%' : ( w + 'px' )
                    ;
                    s = s.replace(/zw/, zw);
                    s = s.replace(/zh/g, h);
                    s = s.replace(/mw/, w);
                    $('<style>', { id: 'layer-sizer', html: s}).appendTo('body');
                                                             
                },
                'include-css': function() {
                	var s = $('<style>');
                	$('body').append( s );
                	s.load('index.php?option=com_jvss&task=item.includeCss');
                }
        	});
            t
            .trigger('build-sizer')
            .trigger('include-css');
        	return this;
        },
        toObject: function() {
        	var d = {};
        	this.each(function(){
        		
        		var t = $(this);

        		if( this.type && this.type.match(/radio/) ) {
        			d[ t.attr( 'data-field' ) ] = $( this.name ).val();
        		}
        		d[ t.attr( 'data-field' ) ] = t.val();
        	});
        	return d;
        },
        qtitle: function(){
        	return this.delegate('[data-field="title"]', 'keyup.field-title', function(){
        		$( $(this).data( 'view' ) ).text( this.value || 'Slide' );
        	});
        },
        cloneSlide: function(){
        	var doc = this;
        	return this.delegate('[data-action="clone"]', 'click.clone-slide', function(e){
        		var t = $(this)
        			,r = $( t.attr( 'data-region' ) )
        		;

        		if( !window.confirm( t.attr( 'data-msg' ) ) ) { return false; }
        		
        		d = $.extend( r.jsonf(), { index: e.timeStamp });
        		doc.trigger('load-data-field', [ $( t.attr( 'data-builder' ) ), d ] );
        	});
        },
        sortSlide: function(){
        	var ms = '> li:not(.no-drag)';
        	function s( e, ui ){
        		$(this).find( ms ).each( function() {
        			var e = $( $( this ).children( 'a' ).attr( 'href' ) );
        			e.parent().append( e );
        		} )
        	}
        	function i(){
        		$(this).sortable({
        			items: ms,
        			containment: 'parent',
        			stop: s
        		})
        	}
        	return this.each(i);
        },
        bindLayerPosition: function(){
            var htmlLayer = $(this)
                ,objLayer = htmlLayer.find( '[data-field="pos"]' ).val()
                ,layerWidth = htmlLayer.outerWidth()
                ,layerHeight = htmlLayer.outerHeight()
                
                ,container = htmlLayer.closest( '[data-tag="layer"]' ).children('[data-tag="mark-content"]')
                ,totalWidth = container.width()
                ,totalHeight = container.height()
                
                ,position = htmlLayer.position()
                ,posTop = Math.round( position.top )
                ,posLeft = position.left
                
                ,updateY,updateX;
            ;
            objLayer = objLayer || 'lt';
            var objLayer = {
                align_hor: objLayer.substr( 0, 1 ),
                align_vert: objLayer.substr( 1, 1 )    
            };
            switch(objLayer.align_hor){
                case "l":
                    updateX = posLeft;
                break;
                case "r":
                    updateX = totalWidth - posLeft - layerWidth;
                break;
                case "c":
                    updateX = posLeft - ( totalWidth - layerWidth ) / 2;
                    updateX = Math.round( updateX );
                break;
            }

            switch(objLayer.align_vert){
                case "t":
                    updateY = posTop;
                break;
                case "b":
                    updateY = totalHeight - posTop - layerHeight;
                break;
                case "c":
                    updateY = posTop - ( totalHeight - layerHeight ) / 2;
                    updateY = Math.round( updateY );
                break;
            }
            
            htmlLayer.find( '[data-field="x"]' ).val( updateX );
            htmlLayer.find( '[data-field="y"]' ).val( updateY );
        },
        toLayerPosition: function(){
            var htmlLayer = $(this)
                ,objLayer = htmlLayer.find( '[data-field="pos"]' ).val()
                ,layerWidth = htmlLayer.outerWidth()
                ,layerHeight = htmlLayer.outerHeight()
                
                ,container = htmlLayer.closest( '[data-tag="layer"]' ).children('[data-tag="mark-content"]')
                ,oc			= container.offset()
                ,totalWidth = container.width()
                ,totalHeight = container.height()
                
                ,layerPos = {}                          
                
                ,left = htmlLayer.find( '[data-field="x"]' ).val()
                ,top = htmlLayer.find( '[data-field="y"]' ).val()
                
                ,objCss = {}
            ;
            
            left = JV.toNum.call( left );
            top = JV.toNum.call( top );
            objLayer = objLayer || 'lt';
            var objLayer = {
                align_hor: objLayer.substr( 0, 1 ),
                align_vert: objLayer.substr( 1, 1 )    
            };
            switch(objLayer.align_hor){
                default:
                case "l":
                    objCss["right"] = "auto";
                    objCss["left"]  = left + "px";

                break;
                case "r":
                    objCss["left"]  = "auto";
                    objCss["right"] = left + "px";
                break;
                case "c":
                    var realLeft 	= ( totalWidth - layerWidth ) / 2;
                    realLeft 		= Math.round( realLeft ) + left;
                    objCss["left"] 	= realLeft + "px";
                    objCss["right"] = "auto";
                break;
            }

            //handle vertical
            switch(objLayer.align_vert){
                default:
                case "t":
                    objCss["bottom"] = "auto";
                    objCss["top"] = top + "px";
                break;
                case "c":
                    var realTop         = ( totalHeight - layerHeight ) / 2;
                    realTop 			= Math.round( realTop ) + top;
                    objCss["top"]       = realTop + "px";
                    objCss["bottom"]    = "auto";
                break;
                case "b":
                    objCss["top"]       = "auto";
                    objCss["bottom"]    = top + "px";
                break;
            }
            
            return htmlLayer.css( objCss );
        },
        posLayer: function(){
            var t = this;
            return t.on({
                're-pos-layer': function(){
                    $('.editor.active [data-tag="drag"]').each(function(){
                        $(this).toLayerPosition(); 
                    });
                }
            }).delegate('[href^="#editor-"], #inline-config [data-active="save"]', 'click', function(){
                t.trigger( 're-pos-layer' );
            });
        },
        sminicolors: function(){

        	return this.each( function() {

        		$( this ).find('.minicolors').each(function(){
					
					$(this).minicolors( JV.ominicolors );

				});
        	} );	
        },
        schosen: function(){
			
        	return this.each( function(){

        		var e = $( this );
        		
        		e.find('select:not(.chzn-custom-value):not([data-tag="yt"]):not([data-tag="vimeo"])')
        		.chosen(JV.ochosen.normal);
				
				e.find('.chzn-custom-value').chosen(JV.ochosen.custom);

        	} );	
        },
        sbutton: function(){

        	return this.each( function(){
				
				var e = $( this );

        		e.find('.radio.btn-group label').addClass('btn');
				e.find('.btn-group label:not(.active)').click(function() {
					var label = $(this);
					var input = $('#' + label.attr('for'));

					if (!input.prop('checked')) {
						label.closest('.btn-group').find('label').removeClass('active btn-success btn-danger btn-primary');
						if (input.val() == '') {
							label.addClass('active btn-primary');
						} else if (input.val() == 0) {
							label.addClass('active btn-danger');
						} else {
							label.addClass('active btn-success');
						}
						input.prop('checked', true);
						input.trigger('change');
					}
				});
				e.find('.btn-group input[checked=checked]').each( function() {
					if ($(this).val() == '') {
						$('label[for=' + $(this).attr('id') + ']').addClass('active btn-primary');
					} else if ($(this).val() == 0) {
						$('label[for=' + $(this).attr('id') + ']').addClass('active btn-danger');
					} else {
						$('label[for=' + $(this).attr('id') + ']').addClass('active btn-success');
					}
				});
        	} );	
        },
        renderlayout: function( layouts ) {
            
            if( !layouts || !layouts.length ) { return false; }
            
            var 
            	  lm 		= layouts.length
				, uprogress = 100 / lm
                , i 		= 0
                , m 		= this.first()
            ;
            
            m.modal( 'show' ).on({
                
                'setProgress': function( e, v ) {
                    
                    $( this ).trigger( 'setValue', v * uprogress );

                },
                'progressed': function() {

            		m
					.modal( 'hide' )
					.trigger( 'setValue', 0 )
					.trigger( 'applyConfig' )
					;
                },
                'setValue': function( e, v ) {
                	$( this ).find( '.progress .bar' ).css( { width: v + '%' } );
                }
            });
            
            function run() {
                
                var layout = layouts[ i ];    
                
                if( !layout ) {
                    
                    m.trigger( 'progressed' );
                    
                    return false;
                }
                
                $( layout.selector ).load( location.href, layout.param, run );

                i ++;

                m.trigger( 'setProgress', i );
            }
            
            run( ); 
            
            return this;
        },
        qsource: function( t ) {

			t = t ? t: 'yt';

			var key = {
				yt: {
					data: 'feed.entry',
					value: 'videoId',
					text: 'title',
					q: 'q',
					url: JV.UYT,
					poster: 'http://img.youtube.com/vi/zvidz/hqdefault.jpg'
				},
				vimeo: {
					data: 'data',
					value: 'uri',
					text: 'name',
					q: 'query',
					url: JV.UVIMEO,
					poster: 'https://i.vimeocdn.com/video/zvidz_640.webp'
				}
			};

			function V( data ) {

				function jkey ( ) {
					
					return $.isArray( this ) ? this.join( '.' ) : '';

				}

				var str 	= $.trim( this )
					,ckey 	= 'data'
					,end 	= 0
				;

				if( !str ) { return 0; }

				$.each( str.split( ), function() {

					var nkey = jkey.call( [ ckey, this ] );

					if( !eval( nkey ) ) { 

						end = eval( ckey ); 

						return end;
					}

					ckey = nkey;

				} );

				if( !end ) { return eval( jkey.call( [ 'data', str ] ) ); }

				return end;
			}

			function vimeoId( u ) { 

				var s = u.match( /\d+$/ );

				return s ? s.shift() : 0;
			}

			function C( data ) {
					
				var results = []
					,entry = V.call( key[ t ].data, data )
				;

				if( !entry || !entry.length ) { return results; }

				$.each( entry, function() {
					
					var item 	= this
						,value 	= V.call( key[ t ].value, item )
						,text 	= V.call( key[ t ].text, item )
					;

					if( t === 'vimeo' ) { value = vimeoId( value ); }

					if( value && text ) {

						results.push( { value: value, text: text } );

					}

				} );

				return results;

			}

			var P = {
				url: key[ t ].url, 
				jsonTermKey: key[ t ].q
			};

			return this.each( function() {

				var e = $( this )
					,vid = e.attr('data-vid')
				;
				e.ajaxChosen( P, function( d ) {
					
					var rs = C( d );
					
					rs = !rs || !$.isArray( rs ) ? [] : rs; 
					
					!vid || rs.push( { value: vid, text: vid } );

					return rs;
					
				} ).on( {

					'change.source': function() {
						
						var e = $( this )
							,poster = key[ t ].poster
						;

						poster = poster.replace( 'zvidz', e.val() );

						e.closest( '.modal' )
						.find( '[data-field="poster"]' ).val( poster );

					}

				} );

			} );

		},
		cmedia: function() {
			
			return this.delegate( '[data-action="save"]', 'click.schange', function() {
				
				var e = $( this ).closest( '.modal' )
					,fill = JV.toNum.call( e.find( '[data-field="fullwidth"]:checked' ).val() )
					,w = e.find( '[data-field="video_width"]' ).val() || 320
					,h = e.find( '[data-field="video_height"]' ).val() || 240
					,d = { 
						source1: 'https://vimeo.com/110940290', 
						poster: '', 
						width: w, 
						height: h,
						embed: ''
					}
				;
				
				e.trigger( 'cmedia', d ).modal( 'hide' );

				return false;

			} );
		},
        cloneLayer: function() {
            
            return this.delegate( '[data-action="clone-layer"]', 'click.clone-layer', function() {
                
                var t = tinymce.get( $( this ).attr( 'data-target' ) );
                
                !t || t.buttons.clonelayer.onclick();
            } );
        },
        removeLayer: function() {
            
            return this.delegate( '[data-action="remove-layer"]', 'click.remove-layer', function() {
                
                var 
                    e = $( this )
                    ,t = tinymce.get( e.attr( 'data-target' ) )
                ;
                
                !t || t.buttons.dlayer.onclick();
                
            } );
        }
	});
})(jQuery);