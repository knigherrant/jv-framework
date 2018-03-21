<div class="groups">
	<div class="control-group g-choice">
		<h4><?php echo JText::_( 'COM_JVPORTFOLIO_EXTRA_FIELDS' ); ?></h4>
		<?php echo JHtml::_( 'select.genericlist', $groups, 'groups', 'class="input-xxlarge" data-tag="groups"', 'value', 'text', $gid ); ?>
	</div>
	<div class="control-group" data-tag="controls"></div>
</div>

<script type="text/javascript">
	
	window.JV = jQuery.extend( window.JV, {
		gcontrols: ( function( p ) { return p || 0; } )( <?php echo json_encode( $gControls ); ?> ),
		gcontrol: function( i ) {

			if( !this.gcontrols || !this.gcontrols[ i ] ) { return false; }

			return this.gcontrols[ i ];
		},
		cvalues: ( function( p ) { return p || 0; } )( <?php echo( is_array( $controls ) ? $this->value : '' ); ?> ),
		cvalue: function( i, v ) {

			if( !this.cvalues || !this.cvalues[ i ] ) { return ""; }

			return !this.cvalues[ i ][ v ] ? '' : this.cvalues[ i ][ v ];
		}
	} );

</script>
<?php $uassets = JUri::base( true ) . '/components/com_jvportfolio/assets/'; ?>
<script src="<?php echo $uassets . 'js/com_jvportfolio.edit.groups.js'; ?>"></script>

<textarea class="hidden" data-tmpl="ctrl">
	<div data-group="${index}">
		{{each( i, v) controls}}
		<div class="control-group">
			<div class="control-label">
				${ v }
				<input type="hidden" name="" data-field="label" value="${ v }">
			</div>
			<div class="controls">
				<input type="text" class="xx-large" 
				data-field="value" value="${ JV.cvalue( index, v ) }">
			</div>
		</div>
		{{/each}}
	</div>
</textarea>