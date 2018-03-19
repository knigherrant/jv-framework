jQuery( function( $ ) {
    
    var layouts = [
        {
            selector: '[data-tag="slides"]',
            param: { tmpl: 'slides', format: 'ajax' }
        },
        {
            selector: '[data-tmpl="layer"]',
            param: { tmpl: 'layer', format: 'ajax' }
        },
        {
            selector: '[data-tag="wsconfig"]',
            param: { tmpl: 'sconfig', format: 'ajax' }
        },
        {
            selector: '[data-tag="wscss"]',
            param: { tmpl: 'scss', format: 'ajax' }
        },
        {
            selector: '[data-tag="wsimport"]',
            param: { tmpl: 'simport', format: 'ajax' }
        }
    ];
    var rl = $( '#render_layout' );

    rl.renderlayout( layouts )
    .one({
        'applyConfig': function(){
            var sconfig = $('#jform_sconfig').val();
            sconfig = JSON.validate( sconfig ) ? JSON.decode( sconfig ) : {};
            sconfig = $.extend({
                slider_type: 'fullwidth',
                min_height: 0,
                width: 960,
                height: 350,
                auto_height: 'off',
                force_full_width: 'off',
                fullscreen_offset_container: '',
                fullscreen_offset_size: '',
                full_screen_align_force: 'off',
                delay: 9000,
                shuffle: 'off',
                lazy_load: 'off',
                use_wpml: 'off',
                enable_static_layers: 'off',
                next_slide_on_window_focus: 'off',
                start_js_after_delay: 0,
                stop_slider: 'off',
                stop_after_loops: 0,
                stop_at_slide: 2,
                show_timerbar: 'top',
                loop_slide: 'loop',
                shadow_type: 2,
                background_color: '#e9e9e9',
                background_dotted_overlay: 'none',
                stop_on_hover: 'on',
                keyboard_navigation: 'off',
                navigation_style: 'round',
                navigaion_type: 'bullet',
                navigation_arrows: 'solo',
                navigaion_always_on: 0,
                hide_thumbs: 200,
                navigaion_align_hor: 'center',
                navigaion_align_vert: 'bottom',
                navigaion_offset_hor: 0,
                navigaion_offset_vert: 20,
                leftarrow_align_hor: 'left',
                leftarrow_align_vert: 'center',
                leftarrow_offset_hor: 20,
                leftarrow_offset_vert: 0,
                rightarrow_align_hor: 'right',
                rightarrow_align_vert: 'center',
                rightarrow_offset_hor: 20,
                rightarrow_offset_vert: 0,
                thumb_width: 100,
                thumb_height: 50,
                thumb_amount: 5,
                use_spinner: 0,
                spinner_color: '#fff',
                use_parallax: 'off',
                disable_parallax_mobile: 'off',
                parallax_type: 'mouse',
                parallax_bg_freeze: 'off',
                parallax_level_1:5, 
                parallax_level_2:10,
                parallax_level_3:15,
                parallax_level_4:20,
                parallax_level_5:25,
                parallax_level_6:30,
                parallax_level_7:35,
                parallax_level_8:40,
                parallax_level_9:45,
                parallax_level_10:50,
                touchenabled: 'on',
                swipe_velocity: 75,
                swipe_min_touches: 1,
                drag_block_vertical: false,
                disable_on_mobile: 'off',
                disable_kenburns_on_mobile: 'off',
                hide_slider_under: 0,
                hide_defined_layers_under: 0,
                hide_all_layers_under: 0,
                hide_arrows_on_mobile: 'off',
                hide_bullets_on_mobile: 'off',
                hide_thumbs_on_mobile: 'off',
                hide_thumbs_under_resolution: 0,
                hide_thumbs_delay_mobile: 1500,
                start_with_slide: 0,
                first_transition_active: false,
                first_transition_type: 'fade',
                first_transition_duration: 300,
                first_transition_slot_amount: 7
            }, sconfig);
            $('#inline-config').inlineConfig( sconfig );

            window.JV = jQuery.extend(window.JV, {
                imageok: $('#imageok'),
                orange: {
                    min: 0,
                    from: 500,
                    to: sconfig.delay || 9000,
                    max: sconfig.delay || 9000,
                    timeline: '500;8000'
                },
                zstyle: [                          
                    { value: '', text: 'none'},
                    { value: 'black', text: 'black'},
                    { value: 'boxshadow', text: 'boxshadow'},
                    { value: 'excerpt', text: 'excerpt'},
                    { value: 'grassfloor', text: 'grassfloor'},
                    { value: 'large_bg_black', text: 'large_bg_black'},
                    { value: 'large_bold_black', text: 'large_bold_black'},
                    { value: 'large_bold_darkblue', text: 'large_bold_darkblue'},
                    { value: 'large_bold_grey', text: 'large_bold_grey'},
                    { value: 'large_bold_white', text: 'large_bold_white'},
                    { value: 'large_text', text: 'large_text'},
                    { value: 'largeblackbg', text: 'largeblackbg'},
                    { value: 'largegreenbg', text: 'largegreenbg'},
                    { value: 'largepinkbg', text: 'largepinkbg'},
                    { value: 'largewhitebg', text: 'largewhitebg'},
                    { value: 'lightgrey_divider', text: 'lightgrey_divider'},
                    { value: 'medium_bg_asbestos', text: 'medium_bg_asbestos'},
                    { value: 'medium_bg_darkblue', text: 'medium_bg_darkblue'},
                    { value: 'medium_bg_orange', text: 'medium_bg_orange'},
                    { value: 'medium_bg_red', text: 'medium_bg_red'},
                    { value: 'medium_bold_orange', text: 'medium_bold_orange'},
                    { value: 'medium_bold_red', text: 'medium_bold_red'},
                    { value: 'medium_grey', text: 'medium_grey'},
                    { value: 'medium_light_black', text: 'medium_light_black'},
                    { value: 'medium_light_red', text: 'medium_light_red'},
                    { value: 'medium_light_white', text: 'medium_light_white'},
                    { value: 'medium_text', text: 'medium_text'},
                    { value: 'medium_thin_grey', text: 'medium_thin_grey'},
                    { value: 'mediumlarge_light_darkblue', text: 'mediumlarge_light_darkblue'},
                    { value: 'mediumlarge_light_white', text: 'mediumlarge_light_white'},
                    { value: 'mediumlarge_light_white_center', text: 'mediumlarge_light_white_center'},
                    { value: 'mediumwhitebg', text: 'mediumwhitebg'},
                    { value: 'modern_big_bluebg', text: 'modern_big_bluebg'},
                    { value: 'modern_big_redbg', text: 'modern_big_redbg'},
                    { value: 'modern_medium_fat', text: 'modern_medium_fat'},
                    { value: 'modern_medium_fat_white', text: 'modern_medium_fat_white'},
                    { value: 'modern_medium_light', text: 'modern_medium_light'},
                    { value: 'modern_small_text_dark', text: 'modern_small_text_dark'},
                    { value: 'noshadow', text: 'noshadow'},
                    { value: 'roundedimage', text: 'roundedimage'},
                    { value: 'small_light_white', text: 'small_light_white'},
                    { value: 'small_text', text: 'small_text'},
                    { value: 'small_thin_grey', text: 'small_thin_grey'},
                    { value: 'thinheadline_dark', text: 'thinheadline_dark'},
                    { value: 'thintext_dark', text: 'thintext_dark'},
                    { value: 'very_big_black', text: 'very_big_black'},
                    { value: 'very_big_white', text: 'very_big_white'},
                    { value: 'very_large_text', text: 'very_large_text'}
                ],
                easing: [                          
                    { value: 'Linear.easeNone', text: 'Linear.easeNone'},
                    { value: 'Power0.easeIn', text: 'Power0.easeIn  (linear)'},
                    { value: 'Power0.easeInOut', text: 'Power0.easeInOut  (linear)'},
                    { value: 'Power0.easeOut', text: 'Power0.easeOut  (linear)'},
                    { value: 'Power1.easeIn', text: 'Power1.easeIn'},
                    { value: 'Power1.easeInOut', text: 'Power1.easeInOut'},
                    { value: 'Power1.easeOut', text: 'Power1.easeOut'},
                    { value: 'Power2.easeIn', text: 'Power2.easeIn'},
                    { value: 'Power2.easeInOut', text: 'Power2.easeInOut'},
                    { value: 'Power2.easeOut', text: 'Power2.easeOut'},
                    { value: 'Power3.easeIn', text: 'Power3.easeIn'},
                    { value: 'Power3.easeInOut', text: 'Power3.easeInOut'},
                    { value: 'Power3.easeOut', text: 'Power3.easeOut'},
                    { value: 'Power4.easeIn', text: 'Power4.easeIn'},
                    { value: 'Power4.easeInOut', text: 'Power4.easeInOut'},
                    { value: 'Power4.easeOut', text: 'Power4.easeOut'},
                    { value: 'Quad.easeIn', text: 'Quad.easeIn  (same as Power1.easeIn)'},
                    { value: 'Quad.easeInOut', text: 'Quad.easeInOut  (same as Power1.easeInOut)'},
                    { value: 'Quad.easeOut', text: 'Quad.easeOut  (same as Power1.easeOut)'},
                    { value: 'Cubic.easeIn', text: 'Cubic.easeIn  (same as Power2.easeIn)'},
                    { value: 'Cubic.easeInOut', text: 'Cubic.easeInOut  (same as Power2.easeInOut)'},
                    { value: 'Cubic.easeOut', text: 'Cubic.easeOut  (same as Power2.easeOut)'},
                    { value: 'Quart.easeIn', text: 'Quart.easeIn  (same as Power3.easeIn)'},
                    { value: 'Quart.easeInOut', text: 'Quart.easeInOut  (same as Power3.easeInOut)'},
                    { value: 'Quart.easeOut', text: 'Quart.easeOut  (same as Power3.easeOut)'},
                    { value: 'Quint.easeIn', text: 'Quint.easeIn  (same as Power4.easeIn)'},
                    { value: 'Quint.easeInOut', text: 'Quint.easeInOut  (same as Power4.easeInOut)'},
                    { value: 'Quint.easeOut', text: 'Quint.easeOut  (same as Power4.easeOut)'},
                    { value: 'Strong.easeIn', text: 'Strong.easeIn  (same as Power4.easeIn)'},
                    { value: 'Strong.easeInOut', text: 'Strong.easeInOut  (same as Power4.easeInOut)'},
                    { value: 'Strong.easeOut', text: 'Strong.easeOut  (same as Power4.easeOut)'},
                    { value: 'Back.easeIn', text: 'Back.easeIn'},
                    { value: 'Back.easeInOut', text: 'Back.easeInOut'},
                    { value: 'Back.easeOut', text: 'Back.easeOut'},
                    { value: 'Bounce.easeIn', text: 'Bounce.easeIn'},
                    { value: 'Bounce.easeInOut', text: 'Bounce.easeInOut'},
                    { value: 'Bounce.easeOut', text: 'Bounce.easeOut'},
                    { value: 'Circ.easeIn', text: 'Circ.easeIn'},
                    { value: 'Circ.easeInOut', text: 'Circ.easeInOut'},
                    { value: 'Circ.easeOut', text: 'Circ.easeOut'},
                    { value: 'Elastic.easeIn', text: 'Elastic.easeIn'},
                    { value: 'Elastic.easeInOut', text: 'Elastic.easeInOut'},
                    { value: 'Elastic.easeOut', text: 'Elastic.easeOut'},
                    { value: 'Expo.easeIn', text: 'Expo.easeIn'},
                    { value: 'Expo.easeInOut', text: 'easeInOut'},
                    { value: 'Expo.easeOut', text: 'Expo.easeInOut'},
                    { value: 'Sine.easeIn', text: 'Expo.easeOut'},
                    { value: 'Sine.easeInOut', text: 'Sine.easeInOut'},
                    { value: 'Sine.easeOut', text: 'Sine.easeOut'},
                    { value: 'SlowMo.ease', text: 'SlowMo.ease'},
                    { value: 'easeOutBack', text: 'easeOutBack'},
                    { value: 'easeInQuad', text: 'easeInQuad'},
                    { value: 'easeOutQuad', text: 'easeOutQuad'},
                    { value: 'easeInOutQuad', text: 'easeInOutQuad'},
                    { value: 'easeInCubic', text: 'easeInCubic'},
                    { value: 'easeOutCubic', text: 'easeOutCubic'},
                    { value: 'easeInOutCubic', text: 'easeInOutCubic'},
                    { value: 'easeInQuart', text: 'easeInQuart'},
                    { value: 'easeOutQuart', text: 'easeOutQuart'},
                    { value: 'easeInOutQuart', text: 'easeInOutQuart'},
                    { value: 'easeInQuint', text: 'easeInQuint'},
                    { value: 'easeOutQuint', text: 'easeOutQuint'},
                    { value: 'easeInOutQuint', text: 'easeInOutQuint'},
                    { value: 'easeInSine', text: 'easeInSine'},
                    { value: 'easeOutSine', text: 'easeOutSine'},
                    { value: 'easeInOutSine', text: 'easeInOutSine'},
                    { value: 'easeInExpo', text: 'easeInExpo'},
                    { value: 'easeOutExpo', text: 'easeOutExpo'},
                    { value: 'easeInOutExpo', text: 'easeInOutExpo'},
                    { value: 'easeInCirc', text: 'easeInCirc'},
                    { value: 'easeOutCirc', text: 'easeOutCirc'},
                    { value: 'easeInOutCirc', text: 'easeInOutCirc'},
                    { value: 'easeInElastic', text: 'easeInElastic'},
                    { value: 'easeOutElastic', text: 'easeOutElastic'},
                    { value: 'easeInOutElastic', text: 'easeInOutElastic'},
                    { value: 'easeInBack', text: 'easeInBack'},
                    { value: 'easeInOutBack', text: 'easeInOutBack'},
                    { value: 'easeInBounce', text: 'easeInBounce'},
                    { value: 'easeOutBounce', text: 'easeOutBounce'},
                    { value: 'easeInOutBounce', text: 'easeInOutBounce'}
                ],
                splitin: [
                    { value: 'none', text: 'No Split'},
                    { value: 'chars', text: 'Char Based'},
                    { value: 'words', text: 'Word Based'},
                    { value: 'lines', text: 'Line Based'}
                ] ,
                toNum: function(){
                    return $.isNumeric(this) ? parseFloat(this) : 0;
                },
                parseUnit: function(u) {
                    if( !this ) { return 0 }
                    return this.replace( new RegExp(u), '' );
                },
                inTransit: function(m, s) {

                    if( !s || !m ) { return false; }

                    switch( $.type( s ) ) {

                        case 'string':
                            return s.match( new RegExp( m ) ) ? 1 : 0;
                        break;

                        case 'array':
                            return $.inArray( m, s ) > -1 ? 1 : 0;
                        break;
                    }
                    return false;
                },
                selected: function( s1, s2 ) {
                    return s1 == s2 ? "selected=selected" : '';
                },
                checked: function( s1, s2 ) {
                    return s1 == s2 ? "checked=checked" : '';
                }
            }); 

            window = $.extend(window, {
                jInsertFieldValue: function(v, fid) {
                    var target = $('#' + fid)
                        ,path = JV.imageok.data('path') + v
                    ;
                    target.val( path ).trigger('change'); 
                },
                jModalClose: function() {
                    JV.imageok.modal('hide');
                } 
            });

            $(document).newSlide({
                tname: $('[data-tmpl="tab-name"]').val(),
                tcontent: $('[data-tmpl="tab-content"]').val()
            })
            .qtitle()
            .sbox({ imageok: JV.imageok })
            .jvtinymce()
            .removeSlide()
            .addLayer()
            .beditor()
            .loadCache({
                c: $('[data-tmpl="cache"]').val(),
                p: $('[data-action="new-slide"]')
            })
            .toggleEditor()
            .cloneSlide()
            .posLayer()
            .cmedia()
            .cloneLayer()
            .removeLayer(); 

            $('[data-tag="sortslide"]').sortSlide();
            
            /*var slayer = $( '#slayer-general' ).sbutton().draggable( {
                    handle: '.modal-header'
                } ),
                seditor = CodeMirror.fromTextArea( slayer.find( '#viewsource' ).get( 0 ), {
                    lineNumbers: true,
                    mode: "text/html",
                    matchBrackets: true
                })
            ;   
            
            slayer.delegate( '[href="#sconfig-source-code"]', 'shown.bs.tab', function() {
                
                seditor.refresh();
                    
            } );*/


            // INCLUDE CUSTOME CSS 
            var ecss = document.getElementById("jform_customcss")
                ,editor = CodeMirror.fromTextArea( ecss, {
                    lineNumbers: true,
                    extraKeys: {
                        "Ctrl-Space": "autocomplete",
                        "F11": function(cm) {
                          cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                        },
                        "Esc": function(cm) {
                          if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                        }
                    },
                    mode: {name: "css", globalVars: true}
                })
            ;
            editor.setSize( '100%', 600 );
            
            editor.on( 'keydown', function() {
                
                ecss.value = editor.getValue();
                
            } );
            
            $( ecss ).closest( '.modal' ).on( 'shown.bs.modal', function() {
                
                editor.refresh();
                   
            } );  window.editor = editor;

            var form = $('#item-form').on({

                'beforeSubmit': function() {

                    var e = $( this )
                        ,f = {
                            '[name="jform[params]"]': '[data-tag="slides"]',
                            '[name="jform[sconfig]"]': '[data-tag="wsconfig"]'
                        }
                    ;
                    
                    $.each( f, function( n, kv ) {
                        
                        e.find( n ).val( JSON.stringify( $( kv ).jsonf() ) );
                            
                    } );
                }

            });

            Joomla.submitbutton = function(task)
            {
                if (task == 'item.cancel') {

                    window.location.href = JV.back_url;

                    return;
                }
                else {

                    if(task.match(/inline-config|inline-scss|inline-simport/)) {
                        $('#' + task.replace('item.', '')).modal('show');
                        return false;
                    }
                    
                    if( task.match( /inline-sexport/ ) )
                    {
                        window.open( JV.sexport_url );
                        
                        return false;
                    }

                    rl
                    .addClass( 'no-animate' ).trigger( 'setValue', 0 )
                    .modal( 'show' )
                    .removeClass( 'no-animate' ).trigger( 'setValue', 30 );

                    var btns = $( '#toolbar .btn' ).each( function() { $( this ).attr( 'disabled', true ); } )
                        ,etask = form.find( '[name="task"]' )
                        ,isAjax = ( task == 'item.apply' )
                    ;

                    if (task != 'item.cancel' && document.formvalidator.isValid( form.get(0) ) ) {
                               

                        rl.trigger( 'setValue', 40 );

                        etask.val( task );

                        form.trigger( 'beforeSubmit' );

                        rl.trigger( 'setValue', 100 );                            

                        if( !isAjax )
                        {
                            Joomla.submitform( task, form.get( 0 ) );


                            return;
                        }
                    
                        $.post( form.attr( 'action' ), form.serialize() )
                        .done( function( h ) {

                            var $h = $( h );
                              
                            rl
                            .addClass( 'no-animate' ).trigger( 'setValue', 100 )
                            .modal( 'hide' )
                            .removeClass( 'no-animate' ).trigger( 'setValue', 0 );

                            $( '#system-message-container' ).replaceWith( $h.find( '#system-message-container' ) );

                            form.find( '[data-field="token"]' ).replaceWith( $h.find( '[data-field="token"]' ) );
                            form.find( '[name="jform[id]"]' ).replaceWith( $h.find( '[name="jform[id]"]' ) );

                            var ids = window.location.href.match( /id=\d+/ )
                                ,cid = [ 'id', form.find( '[name="jform[id]"]' ).val() ].join( '=' )
                            ;

                            if( !ids || ( ids && !$.inArray( cid, ids ) ) )
                            {
                                var nurl = JV.nurl.replace( /id=\d+/, cid );

                                window.history.pushState( document.title, {}, nurl );

                                form.attr( 'action', nurl );
                            }

                            btns.each( function() { $( this ).attr( 'disabled', false ); } );

                        } );
                        
                    }
                    else {
                        Joomla.renderMessages({error: [Joomla.JText._('JGLOBAL_VALIDATION_FORM_FAILED')]})
                    }
                }
            }        
        }
    });
} );