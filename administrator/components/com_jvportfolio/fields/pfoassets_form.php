<textarea data-tmpl="pfo-groups" class="hidden">
	<div id="group-${index}" class="alert alert-success" data-group="${index}">

		<div class="close dropdown">
		  	<button class="btn btn-small" data-toggle="dropdown">
		  		<?php echo JText::_('COM_JVPORTFOLIO_CONFIG_GROUP_ACTION')?>
		  		<span class="caret"></span>
		  	</button>
		  	<ul class="dropdown-menu pull-right">
		    	<li><a href="#group-${index}" data-action="clone"><?php echo JText::_('COM_JVPORTFOLIO_CONFIG_GROUP_CLONE')?></a></li>
		    	<li><a href="#group-${index}" data-action="remove"><?php echo JText::_('COM_JVPORTFOLIO_CONFIG_GROUP_REMOVE')?></a></li>
		  	</ul>
		</div>

		<div class="control-group">
			<div class="control-label">
				<?php echo JText::_('COM_JVPORTFOLIO_CONFIG_GROUP_NAME')?>	
			</div>
			<div class="controls">
				<input type="text" 
				class="input-xxlarge"
				value="${name}" 
				name="jform[groups][${index}][name]" data-field="name">
			</div>
		</div>

		<div class="control-group">
			<div class="control-label">
				<?php echo JText::_('COM_JVPORTFOLIO_CONFIG_GROUP_CONTROLS')?>
			</div>
			<div class="controls">
				<select 
				name="jform[groups][${index}][controls][]" 
				class="chzn-custom-value input-xxlarge"
				data-field="controls" multiple>
				<option value=""></option>
				{{each( i, v ) controls}}
				<option value="${v}" selected="">${v}</option>
				{{/each}}
				</select>
			</div>
		</div>

	</div>
</textarea>
<style>
	#jvpfoextragroups .close { opacity: 1; font-size: inherit; }
</style>
<?php 
$data 	= JComponentHelper::getParams( 'com_jvportfolio' );
$groups = $data->get( 'jvpfo_assets', '' );
?>
<script type="text/javascript">
	window.JV = jQuery.extend( window.JV, {

		items: ( function( p ) { return p || 0; } )( <?php echo $groups; ?> ),
		chosen: {
			"custom_group_text": "Custom controls",
			"disable_search_threshold":0,
			"allow_single_deselect":true,
			"placeholder_text_multiple":"Select some controls",
			"placeholder_text_single":"Select an control",
			"no_results_text":"Add a control"
		}

	} );
</script>
<script src="<?php echo "{$assest}js/com_jvportfolio.groups.js"; ?>"></script>