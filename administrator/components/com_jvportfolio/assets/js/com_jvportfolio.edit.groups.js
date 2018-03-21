jQuery( function( $ ) {

	var cg = $( '[data-tag="groups"]' ).first()
		,ctrls = $( '[data-tag="controls"]' )
		,tctrl = $( '[data-tmpl="ctrl"]' ).val()
	;

	cg.on( {

		'change.group': function() {

			cg.trigger( 'cache-group' );
			
			ctrls.empty();

			var index 		= this.value
				,controls 	= JV.gcontrol( index );

			if( !controls ) { return; }

			var d = {
				index: index,
				controls: controls
			};

			ctrls.append( $.tmpl( tctrl, d ) );
		},
		'cache-group': function() {

			$( this ).children().not( '[value="' + $( this ) .val() + '"]' )
			.each( function() {

				var 
					index = this.value
					,g = $( '[data-group="' + index + '"]');

				if( g.length ) {

					JV.cvalues[ index ] = {};

					g.children( '.control-group' ).each( function() {

						var i = $( this )
							,label = i.find( '[data-field="label"]' ).val()
							,value = i.find( '[data-field="value"]' ).val()
						;

						JV.cvalues[ index ][ label ] = value;

					} );

				}

			} );
		}

	} ).trigger( 'change.group' );

	
} );