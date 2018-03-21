jQuery( function( $ ) {
	
	
	var customTagPrefix = '';

	$( document ).delegate( '.chzn-choices input', 'keyup', function( event ) {

		var w 		= $( this ).closest( '.chzn-container' )
			,ctrl 	= w.parent().children( 'select.chzn-done' )
			,octrl 	= ctrl.children('option')
		;
		// Tag is greater than the minimum required chars and enter pressed
		if (this.value && this.value.length >= 3 && (event.which === 13 || event.which === 188)) {

			// Search an highlighted result
			var highlighted = w.find('li.active-result.highlighted').first();

			// Add the highlighted option
			if (event.which === 13 && highlighted.text() !== '')
			{
				// Extra check. If we have added a custom tag with this text remove it
				var customOptionValue = customTagPrefix + highlighted.text();
				octrl.filter(function () { return $(this).val() == customOptionValue; }).remove();

				// Select the highlighted result
				var tagOption = octrl.filter(function () { return $(this).html() == highlighted.text(); });
				tagOption.attr('selected', 'selected');
			}
			// Add the custom tag option
			else
			{
				var customTag = this.value;

				// Extra check. Search if the custom tag already exists (typed faster than AJAX ready)
				var tagOption = octrl.filter(function () { return $(this).html() == customTag; });
				if (tagOption.text() !== '')
				{
					tagOption.attr('selected', 'selected');
				}
				else
				{
					var option = $('<option>');
					option.text(this.value).val(customTagPrefix + this.value);
					option.attr('selected','selected');

					// Append the option an repopulate the chosen field
					ctrl.append(option);
				}
			}

			this.value = '';
			ctrl.trigger('liszt:updated');
			event.preventDefault();

		}
	});

	Joomla.submitbutton = function(task){

		var form = document.getElementById("component-form")
			,$form = $( form )
		;
		
		if (task === "config.cancel.component" || document.formvalidator.isValid( form ) )
		{
			var d = [];

			$form.find( '[data-group]' ).each( function() {

				var e = $( this );

				d.push({
					index: e.attr( 'data-group' ),
					name: e.find( '[data-field="name"]' ).attr( { disabled: true } ).val(),
					controls: e.find( '[data-field="controls"]' ).attr( { disabled: true } ).val()
				});

			} );

			d = JSON.stringify( d );

			$form.append( $( '<input>', { 
				type: 'hidden', name: 'jform[jvpfo_assets]', value: d 
			} ) );

			Joomla.submitform( task, form );
		}
	};

	var t = $( '[data-tmpl="pfo-groups"]' )
		,tv = t.val()
		,groups = JV.items
	;

	
	$( 'body' ).append( t.parent().find( 'style' ) );

	t.closest( '.control-group' ).remove();

	var r = $( '#jvpfoextragroups' ).on( {

		'create-group': function( e, d ) {

			d = $.extend( {index: $.now() }, d );

			var tag = $.tmpl( tv, d );

			$( this ).append( tag );

			tag.find( '.chzn-custom-value' ).chosen( JV.chosen );

		}

	} );

	$( document ).delegate( '[data-action="clone"]', 'click.clone-group', function() {

		r.trigger( 'create-group' );

		return false;

	} ).delegate( '[data-action="remove"]', 'click.remove-group', function() {
	
		var e = $( this );

		if( e.closest( 'form' ).find( '[data-group]' ).length <= 1 ) { return false; }

		e.closest( '[data-group]' ).remove();

		return false;

	} );


	if( !groups || !groups.length ) {

		r.trigger( 'create-group' );

		return false;
	}

	$.each( groups, function() {

		r.trigger( 'create-group', this );

	} );

} );