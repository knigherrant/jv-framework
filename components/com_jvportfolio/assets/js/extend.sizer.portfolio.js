jQuery( function( $ ) {
    
    var fn = {
        DEFAULT: 'default'
        ,screen: {
            md: ''
            ,sm: '@media (min-width: 768px) and (max-width: 979px)'    
            ,xs: '@media (max-width: 767px)'
        }, 
        getWidth: function( w ) {
            return this == fn.DEFAULT ? ( ( 10 / parseInt( w ) ) * 10 ) : ( ( parseInt( w ) / 12 ) * 100 )    
        },
        buildCss: function( items, s, id ) {
            
            var html = ''
                ,self = this
                ,screen = this.screen
                ,highlight = ''//( id === self.DEFAULT ) ? '' : '!important;'
            ;
            
            $.each( items, function( tag, d ) {
                
                var css = '';

                css += d.w ? [ 'width:', self.getWidth.call( id, d.w ) + '%', highlight ].join( ' ' ) : '';
                css += d.h ? [ '\n;height:', d.h, highlight ].join( ' ' ) : '';

                if( css ) {

                    css = [ s, '{', css, '}\n' ].join( ' ' );
                    
                    html += ( tag in screen ) && screen[ tag ] ? ( [ screen[ tag ], '{\n', css, '}\n' ].join( ' ' ) ) : css;
                }
                    
            } );
            
            $( 'body' ).append( $( '<style>', { id: 'shuffle-' + id, html: html } ) );
        }
    };
    
    $( document ).on( 'sizer-element.shuffle', function( evt, pfo, s ) {
        
        if( !s ) { return false; }
        
        pfo.one( {
            
            'buildElementSpecial': function( e, items, s ) {
                
                $.each( items, function( order, d ) {
                    
                    var id = s + ':nth-child(' + order + ')';
                    
                    fn[ 'buildCss' ].call( fn, d, id, $.now() );
                        
                } );   
            },
            'done.shuffle': function() {
                

                JV.bp 
                && ( 'defaults' in JV.bp ) 
                && !$.isEmptyObject( JV.bp.defaults ) 
                && fn[ 'buildCss' ].call( fn, JV.bp.defaults, s, fn.DEFAULT );
                
                JV.bp && ( 'special' in JV.bp ) && pfo.trigger( 'buildElementSpecial', [ JV.bp.special, s ] );
                
                pfo.shuffle( 'update' );
                
            }
            
        } );
        
    } );
    
} );