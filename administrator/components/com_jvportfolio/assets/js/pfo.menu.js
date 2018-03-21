
jQuery( function( $ ) {

	var tcontent = $( '#attrib-pfolayout' )
		,breakpoint = tcontent.find( '.breakpoint' )
		,preview = tcontent.find( '.preview' )
		,tmpl = {
			tname: tcontent.find( '[data-tmpl="tname"]' ).val()
			,tcontent: tcontent.find( '[data-tmpl="tcontent"]' ).val()
			,ipfo: tcontent.find( '[data-tmpl="pfo-item"]' ).val()
		}
		,bp = {}
		,dlm = 5
		,win = $( window )
		,msizer = $( '#pfo-msizer' )
		,pfo = tcontent.find( '.pfo' )
		,doc = $( document )
		,sizer = pfo.parent().children( '.sizer' )
	;
	
	pfo.shuffle( { itemSelector: '.item', sizer: sizer } );

	/* make color for element in portfolio */
	function gc() {
		var r = 1 + Math.floor(Math.random() * 255);
		var g = 1 + Math.floor(Math.random() * 255);
		var b = 1 + Math.floor(Math.random() * 255);
		return "rgb(" + ( [ r, g, b ].join( ',' ) + ')' );
	}

	/* get items in portfolio */
	function getPfoItem() {

		return ( dpfo = this.data( 'shuffle' ) ) && ( dpfo[ '$items' ] );

	}

	/* layout: events */
	tcontent.on( {
		'setStyleElement': function( e, field ) {
			
			var id = field.attr( 'id' )
				,prefixs = 'style-e-'
				,html  = ''
			;

			id = id ? id : ( 'shuffle-' + field.index() );
			
			field.attr( { id: id } );

			tcontent.find( '#' + prefixs + id ).remove();

			$.each( JV.bpn, function( tag, tagn ) {

				var d = field.attr( 'data-' + tag );

				if( d && JSON.validate( d ) ) {
				
					d = JSON.parse( d );

					var css = '';

					css += d.w ? ('width: ' + ( ( parseInt( d.w ) / 12 ) * 100 ) + '%;' ) : '';
					css += d.h ? ('height: ' + d.h + '!important;' ) : '';

					if( css ) {

						html += '#attrib-pfolayout.' + tag + ' .preview .pfo .item#' + id + ' { ';
						html += css;
						html += ' }\n';
							
					}
					
				}

			} );

			tcontent.append( $( '<style>', { id: prefixs + id, html: html } ) );

			pfo.shuffle('update');
		},
		'setStyleElementDefault': function( e, tag, field ) {
			
			var d = {}
				,prefixs = 'style-e-default-'
				,html = ''
				,id = '#' + prefixs + tag
				,w = 0
			;

			field.find( '[data-field]' ).each( function() {
				var e = $( this );
				d[ e.attr( 'data-field') ] = e.val();
			} );

			tcontent.find( id ).remove();
			
			w = ( 10 / parseInt( d.w ) ) * 10 + '%';

			html += '#attrib-pfolayout.' + tag + ' .preview .pfo .item { ';
			html += d.w ? ('width: ' + w ) : '';
			html += d.h ? (';height: ' + d.h ): '';
			html += '}';

			tcontent.append( $( '<style>', { id: ( prefixs + tag ), html: html } ) );
			
			sizer.css( { width: w } )

			pfo.shuffle('update');
		},
		'buildElementSpecial': function( evt, items ) {

			if( $.isEmptyObject( items ) ) { return false; }

			var e = $( this );

			$.each( items, function( i, item ) {
				
				var fields = getPfoItem.call( pfo )
					,field
					,lm = 0
				;

				if( !fields || !fields.length ) { lm = dlm; } 

				if( ( fields.length - 1 ) < i ) { lm = fields.length + dlm; }

				if( lm ) { 
					
					e.trigger( 'load-more' );
					fields = getPfoItem.call( pfo );

				}

				field = fields.eq( i - 1 );

				$.each( JV.bpn, function( tag, tagn ) {

					field.attr( 'data-' + tag, JSON.stringify( item[ tag ] ) );
					
				} );

				e.trigger( 'setStyleElement', [ field ] );

			} );

		}
	} );

	/* element sizer: event */
	msizer.on( {
		'processValue': function() {
			var e = $( this )
				,c = e.data( 'field' )
				,df = { w: '', h: '' }
			;

			$.each( JV.bpn, function( tag, tagn ) {
				
				var d = c.attr( 'data-' + tag );
				
				if( d && JSON.validate( d ) ) {

					d = JSON.parse( d );

					e.trigger( 'setValue', [ tag, d ] );	

				}else {

					e.trigger( 'setValue', [ tag, df ] );
				}

			} );
		},
		'setValue': function( e, tag, d ) {

			var e = $( this );

			$.each( d, function( n, v ) {
				
				var f = e.find( '[data-tag="' + tag + '"] [data-field="' + n + '"]' );

				f.val( v );

				if( f.is( 'select' ) && f.hasClass( 'chzn-done' ) ) {
					
					f.trigger( 'liszt:updated' );

				}

			});
		},
		'cacheValue': function() {

			var e = $( this )
				,f = e.data( 'field' )
			;

			e.find( '[data-tag]' ).each( function() {
	
				var a = da = {}, wpiece = $( this );

				wpiece.find( '[data-field]' ).each( function() {

					var piece = $( this );

					da[ piece.attr( 'data-field' ) ] = piece.val();
				} );

				a[ 'data-' + wpiece.attr( 'data-tag' ) ] = JSON.stringify( da );

				f.attr( a );
			} );

			tcontent.trigger( 'setStyleElement', [ f ] );
		}
	} ).delegate( '[data-action="save"]', 'click.save', function() {
		
		var e = $( this ).closest( '.modal' );

		e
		.trigger( 'cacheValue' )
		.modal( 'hide' );

		pfo.shuffle('update');

		return false;
	} );

	/* breakpoint: events */
	breakpoint.on( {
			
		'abp': function(  e, data ) {

			var e = $( this )
				,tname = e.find( '[data-tag="title"]')
				,tcontent = e.find( '[data-tag="content"]' )
			;
			
			data.dtmpl = $.extend( { name: JV.tname, index: $.now() }, data.dtmpl );

			tname.append( $.tmpl( data[ 'tname-tmpl' ], data.dtmpl ) );
			
			tcontent.append( $.tmpl( data[ 'tcontent-tmpl' ], data.dtmpl ) );
		},

		'obp': function( e, i ) {
				
			$( this ).find( '[data-toggle="pill"]' ).eq( i ).tab( 'show' );

		}

	} ).delegate( '[data-toggle="pill"]', 'shown.bs.tab', function() {

		$.each( JV.bpn, function( tag, tagn ) { tcontent.removeClass( tag ); } );
		
		var tag = $( this ).attr( 'data-value' );

		tcontent
		.addClass( tag )
		.trigger( 'setStyleElementDefault', [ tag, $( this.hash ) ] );

	} ).delegate( '[data-field]', 'change.bp', function() {
		
		$( this ).closest( '[data-tag="bp"]' )
		.find( '.active [data-toggle="pill"]' ).trigger( 'shown.bs.tab' );

	} );

	/* pfo: update layout when layout change */
	doc.delegate( '[href="#attrib-pfolayout"]', 'shown.bs.tab', function() {
			
		pfo.shuffle('update');

	} );

	/* breakpoint: fill cache to form */
	bp = JV.bp && ( 'defaults' in JV.bp ) ? JV.bp.defaults : JV.bpd;

	/* preview: fill cache to element */
	pfo.one( 'done.shuffle', function() {

		JV.bp && ( 'special' in JV.bp ) && tcontent.trigger( 'buildElementSpecial', [ JV.bp.special ] );		

	} );
	

	$.each( bp, function( p, d ) { 

		var i = {
			dtmpl: $.extend( { index: p, bp: p, name: JV.bpn[ p ] }, d )
			,'tname-tmpl': tmpl.tname
			,'tcontent-tmpl': tmpl.tcontent
		};

		breakpoint.trigger( 'abp', [ i ] );

	} );

	breakpoint.trigger( 'obp', [ 0 ]);


	tcontent.append( $( '[data-tag="customlayout"]' ) );

	/* preview - part: load more item */
	tcontent.on( {

		'load-more': function( evt, l ) {
			
			l = !l ? dlm : l;

			for( var i = 0; i < l; i++ ) {

				var e = $.tmpl( tmpl.ipfo, { color: gc } );

				pfo.append( e ).shuffle( 'appended', e );
	
			}
			pfo.shuffle('update');
		}
	} )
	.delegate( '[data-action="load-more"]', 'click.load-more', function() {

		tcontent.trigger( 'load-more' );

		return false;

	} )
	.trigger( 'load-more' )
	.delegate( '.item', 'click.shuffle-item', function() {
		
		var field = $( this );

		msizer.data( { field: field } )
		.trigger( 'processValue' )
		.modal( 'show' );

		return false;
		
	} );

	/* insert into data to database */
	doc.on( {
		'submit-layout-device': function() {

			/* breakpoint */
			var dbp = {};
			breakpoint.find( '[data-bp].tab-pane' ).each( function() {
				var e = $( this );
				dbp[ e.attr( 'data-bp' ) ] = {
					w: e.find( '[data-field="w"]' ).val(),
					h: e.find( '[data-field="h"]' ).val()
				};
			} );

			/* items */	
			var items = {};
			( ipfo = getPfoItem.call( pfo ) ) && ipfo.filter( '[data-md]' ).each( function() {
				
				var e = $( this ), item = {};

				$.each( JV.bpn, function( tag, tagn ) {

					( a = e.attr( 'data-' + tag ) ) && JSON.validate( a ) && ( item[ tag ] = JSON.parse( a ) );

				} );

				$.isEmptyObject( item ) || ( items[ e.index() + 1 ] = item );

			} );

			/* push data to field with id #jform_params_layoutdevice */

			$( this ).find( '#jform_params_layoutdevice' ).val( JSON.stringify( {
				
				defaults: dbp
				
				,special: items

			} ) );
		}
	} );

	tcontent.closest( 'form' ).get( 0 ).addEvent( 'onsubmit', function() {
		
		doc.trigger( 'submit-layout-device' );

	} );

} );