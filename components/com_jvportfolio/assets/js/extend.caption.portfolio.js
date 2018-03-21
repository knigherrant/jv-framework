( function( $ ) {

	$.extend( $.fn, {

		hdir: function( o ) {

			var fn = {
				cdir: 'slideFromTop slideFromBottom slideFromLeft slideFromRight slideTop slideLeft',
				getDir: function( coordinates ) {
					// the width and height of the current div
					var w = this.width(),
						h = this.height(),

						// calculate the x and y to get an angle to the center of the div from that x and y.
						// gets the x value relative to the center of the DIV and "normalize" it
						x = ( coordinates.x - this.offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ),
						y = ( coordinates.y - this.offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ),

						// the angle and the direction from where the mouse came in/went out clockwise (TRBL=0123);
						// first calculate the angle of the point,
						// add 180 deg to get rid of the negative values
						// divide by 90 to get the quadrant
						// add 3 and do a modulo by 4  to shift the quadrants to a proper clockwise TRBL (top/right/bottom/left) **/
						direction = Math.round( ( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3 ) % 4;

					return direction;
				},
				getStyle : function( direction ) {
			
					var fromStyle, toStyle
						,slideFromTop 		= { left : '0px', top : '-100%' }
						,slideFromBottom 	= { left : '0px', top : '100%' }
						,slideFromLeft 		= { left : '-100%', top : '0px' }
						,slideFromRight 	= { left : '100%', top : '0px' }
						,slideTop 			= { top : '0px' }
						,slideLeft 			= { left : '0px' }
						,classDir			= ''
					;

					switch( direction ) {
						case 0:
							// from top
							fromStyle = !this.options.inverse ? slideFromTop : slideFromBottom;
							toStyle = slideTop;
							classDir = !this.options.inverse ? 'slideFromTop' : 'slideFromBottom';
							break;
						case 1:
							// from right
							fromStyle = !this.options.inverse ? slideFromRight : slideFromLeft;
							toStyle = slideLeft;
							classDir = !this.options.inverse ? 'slideFromRight' : 'slideFromLeft';
							break;
						case 2:
							// from bottom
							fromStyle = !this.options.inverse ? slideFromBottom : slideFromTop;
							toStyle = slideTop;
							classDir = !this.options.inverse ? 'slideFromBottom' : 'slideFromTop';
							break;
						case 3:
							// from left
							fromStyle = !this.options.inverse ? slideFromLeft : slideFromRight;
							toStyle = slideLeft;
							classDir = !this.options.inverse ? 'slideFromLeft' : 'slideFromRight';
							break;
					};

					return { from : fromStyle, to : toStyle, classDir: classDir };

				},
				setTransit: function( s ) {
					
					var 
						str = []
						,kprop = {
							Webkit: '-webkit-',
							Moz: '-moz-',
							O: '-o-',
							ms: '-ms-'	
						}
						,o = this.options
					;

					$.each( kprop, function( pk, pv ) {
						
						pv += 'transition';

						str.push( s + ' { ' + pv + ': ' + 'all ' + o.speed + 'ms ' + o.easing + ';}' );

					} );

					$( 'body' ).append( $( '<style>', { html: str.join( '\n' ) } ) );

				},
				aa: function( styleCSS, o ) {
					
					var applyStyle = o.support ? 'css' : 'animate';

					this.stop()[ applyStyle ]( styleCSS, $.extend( true, [], { duration : o.speed + 'ms' } ) );	
				},
				support: Modernizr.csstransitions,
				options: $.extend( {
					speed : 300,
					easing : 'ease',
					hoverDelay : 0,
					inverse : false
				}, o ),
				prefix: '[data-tag="hdir"]'
			};

			return this.each( function() {

				var id = !this.id ? ( 'hdir-' + $.now() ) : this.id;
				
				fn.setTransit( '#' + [ id, fn.prefix ].join( ' ' ) );

				$( this ).attr( { id: id } )
				.data( { hdir: fn } )
				.delegate( fn.prefix, 'mouseenter.hdir mouseleave.hdir', function( e ) {

					var $el 		= $( this )
						,efn 		= $el.closest( '[data-hdir]' ).data( 'hdir' )
						,$caption 	= $el.find( '[data-tag="caption"]' )
						,direction 	= efn.getDir.call( $el, { x : e.pageX, y : e.pageY } )
						,styleCSS 	= efn.getStyle( direction )
						,tmhover 	= $el.data( 'tmhover' )
					;

					if( e.type === 'mouseenter' ) {

						$caption.removeClass( efn.cdir ).addClass( styleCSS.classDir ).hide().css( styleCSS.from );

						clearTimeout( tmhover );

						tmhover = setTimeout( function() {

							$caption.show( 0, function() {

								efn.aa.call( $( this ), styleCSS.to, efn.options );

							} );


						}, efn.options.hoverDelay );

						$el.data( { tmhover: tmhover } );

						return false;
					}

					clearTimeout( tmhover );
					
					efn.aa.call( $caption.removeClass( efn.cdir ), styleCSS.from, efn.options );

				} );

			} );
		}

	} );

} )( jQuery );