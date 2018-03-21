jQuery.noConflict();
var $ = jQuery;
$(document).ready(function ($) {
	// Prepare data
	var $generator = $('#jv-generator'),
		$search = $('#jv-generator-search'),
		$filter = $('#jv-generator-filter'),
		$filters = $filter.children('a'),
		$choices = $('#jv-generator-choices'),
		$choice = $choices.find('span'),
		$settings = $('#jv-generator-settings'),
		$prefix = $('#jv-compatibility-mode-prefix'),
		$result = $('#jv-generator-result'),
		$selected = $('#jv-generator-selected'),
		ajaxUrl = $("#plg-url").val() + 'index.php?jvaction=jv_shortcode_system';
		mce_selection = '';
	// Focus search field when popup is opened
	$search.focus();
		
	// back to list all shortcode	
	$('#jv-generator').on('click', '.jv-generator-home', function (e) {
		
		// Clear search field
		$search.val('');
		// Hide settings
		$settings.html('').hide();
		// Remove narrow class
		$generator.removeClass('jv-generator-narrow');
		// Show filters
		$filter.show();
		// Show choices panel
		$choices.show();
		$choice.show();
		// Clear selection
		mce_selection = '';
		// Focus search field
		$search.focus();
		e.preventDefault();
	});
	
	// Search field
	$search.on({
		focus: function () {
			// Clear field
			$(this).val('');
			// Hide settings
			$settings.html('').hide();

			// Show choices panel
			$choices.show();
			$choice.css({
				opacity: 1
			});
			// Show filters
			$filter.show();
		},
		blur: function () {},
		keyup: function (e) {
			var val = $(this).val(),
				regex = new RegExp(val, 'gi');
			// Hide all choices
			$choice.css({
				opacity: 0.2
			});
			// Find searched choices and show
			$choice.each(function () {
				// Get shortcode name
				var id = $(this).data('shortcode'),
					name = $(this).data('name'),
					desc = $(this).data('desc'),
					group = $(this).data('group');
				// Show choice if matched
				if (id.match(regex) !== null) $(this).css({
					opacity: 1
				});
				else if (name.match(regex) !== null) $(this).css({
					opacity: 1
				});
				else if (desc.match(regex) !== null) $(this).css({
					opacity: 1
				});
				else if (group.match(regex) !== null) $(this).css({
					opacity: 1
				});
			});
		}
	});


	// Filters
	$filters.click(function (e) {
		//Active
		$filters.removeClass('active');
		$(this).addClass('active');
		// Prepare data
		var filter = $(this).data('filter');
		// If filter All, show all choices
		if (filter === 'all') $choice.css({
			opacity: 1
		});
		// Else run search
		else {
			var regex = new RegExp(filter, 'gi');
			// Hide all choices
			$choice.css({
				opacity: 0.2
			});
			// Find searched choices and show
			$choice.each(function () {
				// Get shortcode name
				var group = $(this).data('group');
				// Show choice if matched
				if (group.match(regex) !== null) $(this).css({
					opacity: 1
				});
			});
		}
		e.preventDefault();
	});
	
	// Click on shortcode choice
	$choice.on('click', function (e) {
		// Prepare data
		var shortcode = $(this).data('shortcode');
		
		// Load shortcode options
		$.ajax({
			type: 'POST',
			url: ajaxUrl+'&task=settings',
			data: {
				shortcode: shortcode
			},
			beforeSend: function () {
				$choices.hide();
				// Show loading animation
				$settings.addClass('jv-generator-loading').show();
				// Add narrow class
				$generator.addClass('jv-generator-narrow');
				// Hide filters
				$filter.hide();
			},
			success: function (data) {
				// Hide loading animation
				$settings.removeClass('jv-generator-loading');
				// Insert new HTML
				$settings.html(data);
				
				// Apply selected text to the content field
				if (typeof mce_selection !== 'undefined' && mce_selection !== '') $('#jv-generator-content').val(mce_selection);
				// Init content of table
				
				// Init range pickers
				$('.jv-generator-range-picker').each(function (index) {
					var $picker = $(this),
						$val = $picker.find('input'),
						min = $val.attr('min'),
						max = $val.attr('max'),
						step = $val.attr('step');
					// Apply noUIslider
					$val.simpleSlider({
						snap: true,
						step: step,
						range: [min, max]
					});
					$val.attr('type', 'text').show();
					$val.on('keyup blur', function (e) {
						$val.simpleSlider('setValue', $val.val());
					});
				});
				// Init switches
				$('.jv-generator-switch').on('click',function (e) {
					// Prepare data
					var $switch = $(this),
						$value = $switch.children('input'),
						is_on = $value.val() === 'yes';
					// Disable
					if (is_on) {;
						// Change value
						$value.val('no').trigger('change');
						$switch.removeClass('jv-generator-switch-yes').addClass('jv-generator-switch-no');
					}
					// Enable
					else {
						// Change value
						$value.val('yes').trigger('change');
						$switch.removeClass('jv-generator-switch-no').addClass('jv-generator-switch-yes');
					}
					e.preventDefault();
				});
				
				
				// Init color pickers
				$('.jv-generator-select-color').each(function (index) {
					$(this).find('.jv-generator-select-color-wheel').filter(':first').farbtastic('.jv-generator-select-color-value:eq(' +
						index + ')');
					$(this).find('.jv-generator-select-color-value').focus(function () {
						$('.jv-generator-select-color-wheel:eq(' + index + ')').show();
					});
					$(this).find('.jv-generator-select-color-value').blur(function () {
						$('.jv-generator-select-color-wheel:eq(' + index + ')').hide();
					});
				});
				// Init shadow pickers
				$('.jv-generator-shadow-picker').each(function (index) {
					var $picker = $(this),
						$fields = $picker.find('.jv-generator-shadow-picker-field input'),
						$hos = $picker.find('.jv-generator-shadow-hos'),
						$vos = $picker.find('.jv-generator-shadow-vos'),
						$blur = $picker.find('.jv-generator-shadow-blur'),
						$colorPicker = {
							value: $picker.find('.jv-generator-shadow-picker-color-value'),
							wheel: $picker.find('.jv-generator-shadow-picker-color-wheel')
						},
						$val = $picker.find('.jv-generator-attr');
					// Init color picker
					$colorPicker.wheel.farbtastic($colorPicker.value);
					$colorPicker.value.focus(function () {
						$colorPicker.wheel.show();
					});
					$colorPicker.value.blur(function () {
						$colorPicker.wheel.hide();
					});
					// Handle text fields
					$fields.on('change blur keyup', function () {
						$val.val($hos.val() + 'px ' + $vos.val() + 'px ' + $blur.val() + 'px ' + $colorPicker.value.val()).trigger('change');
					});
				});
				// init border picker
				$('.jv-generator-border-picker').each(function(){
					var $picker = $(this),
						$inputFields = $picker.find('.jv-generator-border-picker-field input'),
						$selectField = $picker.find('.jv-generator-border-picker-field select'),
						$size = $picker.find('.jv-generator-border-size'),
						$style = $picker.find('.jv-generator-border-style '),
						$colorPicker = {
							value: $picker.find('.jv-generator-border-picker-color-value'),
							wheel: $picker.find('.jv-generator-border-picker-color-wheel')
						},
						$val = $picker.find('.jv-generator-attr');
					 
					// Init color picker
					$colorPicker.wheel.farbtastic($colorPicker.value);
					$colorPicker.value.focus(function () {
						$colorPicker.wheel.show();
					});
					$colorPicker.value.blur(function () {
						$colorPicker.wheel.hide();
					});
					// Handle text fields
					$inputFields.on('change blur keyup', function () {
						$val.val($size.val() + 'px ' + $style.val() +' '+ $colorPicker.value.val()).trigger('change');
					});
					$selectField.on('change',function(){
						$val.val($size.val() + 'px ' + $style.val()+' ' + $colorPicker.value.val()).trigger('change');
					});
					
					
				});
				// init icon picker
				$('.jv-generator-icon-picker-button').each(function(){
					iconpickerClicked(this);
					
				});
				
				//init image source select
				$('.jv-generator-isp').each(function () {
					var $picker = $(this),
						$sources = $picker.find('.jv-generator-isp-sources'),
						$source = $picker.find('.jv-generator-isp-source'),
						$add_media = $picker.find('.jv-generator-isp-add-media'),
						$dir_list = $picker.find('#dir-list');
						$upload_image = $picker.find('.jv-generator-isp-upload-media');
						$images = $picker.find('.jv-generator-isp-images'),
						$cats = $picker.find('.jv-generator-isp-categories'),
						$val = $generator.find('#jv-generator-content'),
						$imagesSelect = $picker.find('#images-to-select');
						mediaUrl = $picker.attr('baseUrl');
						 
					// Update hidden value
					var update = function () {
						var val = 'none',
							content = '',
							source = $sources.val();
						// Media library
						if (source === 'media') {
							var images = [];
							$images.find('span').each(function (i) {
								image = '['+ $prefix.val()+'image';
								image += ' src="'+$(this).data('url')+'"';
								image += ($(this).data('name') !='')?' title="'+$(this).data('name') + '"':'';
								image += ($(this).data('link')?' link="'+$(this).data('link') + '"':'');
								image += ' parent_tag="'+$selected.val()+'"' + ']\n';
								images[i] =image;
							});
							if (images.length > 0) content = images.join('\n');
							 
						}
						// Category
						else if (source === 'category') {
							var categories = $cats.val() || [];
							if (categories.length > 0){
								$.ajax({
									 type: 'POST',
									 url: ajaxUrl+'&task=imagescat',
									 data:{
										cats  : categories,
										limit : $('#jv-generator-attr-limit',$generator).val(),
										prefix: $prefix.val()
									 },
									 success: function(data){
										 $val.val(data).trigger('change');
									 }
								});
							} 
						}
						// Deselect
						else if (source === '0'){
							val = 'none';
						}
						// Other options
						else {
							val = source;
						}
						if (content !== ''){ 
							$val.val(content).trigger('change');
						}
					}
					// Switch source
					$sources.on('change', function (e) {
						var source = $(this).val();
						e.preventDefault();
						$source.removeClass('jv-generator-isp-source-open');
						if (source.indexOf(':') === -1) $picker.find('.jv-generator-isp-source-' + source).addClass('jv-generator-isp-source-open');
						update();
					});
					// Remove image
					$images.on('click', 'span i.fa-times', function () {
						$(this).parent('span').css('border-color', '#f03').fadeOut(300, function () {
							$(this).remove();
							update();
						});
					});
					// Edit image
					$images.on('click','span i.fa-edit',function(){
						var image = $(this).parent();
						var editPopup = '<div id="overlay"></div> <div class="wrap-popup">'
											+'<div id="jvsc-dialog" >'
											+	'<ul>'
											+		'<li>'
											+			'<label class="jvsc-title-lbl" for="jvsc-title" title="">Title</label>'
											+			'<input class="jvsc-title" type="text" size="90" value="'+$(image).data('name')+'" name="jvsc-title">'
											+ 			'<div style="clear: both"></div>'
											+		'</li>'
											+		'<li>'
											+			'<label class="jvsc-link-lbl" for="jvsc-link" title="">Link</label>'
											+			'<input class="jvsc-link" type="text" size="90" name="jvsc-link">'
											+ 			'<div style="clear: both"></div>'	
											+		'</li>'
											+	'</ul>'
											+	'<div data-index="'+$(image).index()+'" style="clear: both; margin:0 20px; padding: 0 10px;">'
											+		'<label></label>'
											+		'<button class="jvsc-dialog-ok btn btn-small" style="margin-left: 10px;">OK</button>'
											+		'<button class="jvsc-dialog-cancel btn btn-small" style="margin-left: 10px;">Cancel</button>'
											+	'</div>'
											+'</div>'
											+'<i class="close-dialog fa fa-times"></i>'
										+'</div>';
						$('.jv-generator-isp-source-media',$picker).append(editPopup);
					});
					// edit done
					$('.jv-generator-isp-source-media',$picker).on('click','.jvsc-dialog-ok',function(){
						// get current image edit
						 index = $(this).parent().data('index');
						 image = $('span',$images).eq(index);
						 // get info edit
						 title = $('.jvsc-title').val();  
						 link = $('.jvsc-link').val();
						 //set data
						 $(image).data('name',title);
						 $(image).data('link',link);
						 // update field
						 update();
						 // remove popup
						 $('.wrap-popup').remove();
						 $('#overlay').remove();
						return false;
					});
					
					// close dialog edit image
					$('.jv-generator-isp-source-media',$picker).on('click','.jvsc-dialog-cancel',function(){
						$('.wrap-popup').remove();
						$('#overlay').remove();
						return false;
					});
					$('.jv-generator-isp-source-media',$picker).on('click','.close-dialog',function(){
						$('.wrap-popup').remove();
						$('#overlay').remove();
						return false;
					});
					
					// Upload image
					var uploader = new qq.FileUploader({
						element: document.getElementById('file-uploader'),
						action:  $("#plg-url").val() + 'index.php',
						allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
					 	params: { type: 'image',task:'upload',jvaction:'jv_shortcode_system'},
					 	onComplete: function(id, fileName, result){
					 		$('.qq-upload-list > li:eq('+id+')').delay(1000).hide(400);
					 		if(result.success ){
					 			$images.find('em').remove();
					 			$images.append('<span data-url="'+result.fileUrl+'" data-name="'+fileName+'">'
										+'<img alt="" src="'+mediaUrl+result.fileUrl +'">'
										+'<i class="fa fa-times"></i>'
										+'<i class="fa fa-edit"></i>'
										+'</span>');
					 			update();
					 		}
					 	}
					});
					
					// add selected class for new image uploaded
					$('li',$imagesSelect).each(function(){
		 				el = $(this);
		 				for(i=0; i<=count; i++){ 
		 					if(el.data('name')== filesName[i]){
		 						el.click();
		 					}
		 				}
		 			});
					//Change folder images
					$dir_list.change(function(){
						if($('li',$imagesSelect).length){
							$imagesSelect.html('');
							$imagesSelect.hide();
							$add_media.click();
						}
					});
					// Add image
					$add_media.click(function (e) {
						e.preventDefault();
						 $.ajax({
							 type: 'POST',
							 url: ajaxUrl+'&task=images',
							 data:{
								folder: $('#dir-list option:selected').val() 
							 },
							 success: function(data){
								 if(data == 'DIR_FALSE'){
									 message = '<li class="jvsc-message" style="color:red;">Not found images shortcode folder!</li>';
									 $imagesSelect.append(message);
									 $imagesSelect.show();
									 //alert("Not found images shortcode folder!");
								 }else if(data == 'IMAGE_NULL'){
									 message = '<li class="jvsc-message" style="color:red;">Not found any image in folder!</li>';
									 $imagesSelect.append(message);
									 $imagesSelect.show();
									//alert("Not found any image in folder!"); 
								 }else{
									 $('#jv-generator-attr-source').val($sources.val() + ':' + $('#dir-list option:selected').val() );
									 images = $.parseJSON(data);
									 if(images.length > 0){
										 if($('li',$imagesSelect).length >0){
											 $('li',$imagesSelect).each(function(){
												 el = $(this);
												 for(i=0; i<images.length ; i++){
													 if(el.data('name')== images[i]){
														 images.splice(i,1);
													 }
												 }
											 });
											 
										 }
										 // hide add_image button
										 $add_media.hide();
										 for(i=0; i<images.length ; i++){
											 image = '<li class="attachment save-ready details selected" data-name="'+images[i]+'">'
												 		+'<div class="attachment-preview">'
											 			+	'<div class="thumbnail">'
											 			+		'<div class="centered">'
											 			+			'<img  src="'+mediaUrl + images[i]+'">'
											 			+		'</div>'
											 			+	'</div>'
														+	'<a class="check" title="Deselect" href="#">'
														+		'<div class="media-modal-icon"></div>'
														+	'</a>'
														+'</div>'
													 +'</li>';	
											 $imagesSelect.append(image);
											 $imagesSelect.show();
										 }
										 $('li',$imagesSelect).each(function(){
											el = $(this);
											el.unbind('click');
											el.click(function(e){
												e.preventDefault();
												if($(this).hasClass('details selected')){
													$(this).removeClass('details selected');
												}else{
													$(this).addClass('details selected');
												}
											});
										 });
										// button add images selected & cancel button
										$('.add-media-selected').show();
										$('.cancel-media-selected').show();
										 
										 $('.cancel-media-selected').click(function(e){
											 e.preventDefault();
											 $add_media.show();
											 $('.add-media-selected').hide();
											 $imagesSelect.html('');
											 $(this).hide();
										 });
										 
										 $('.media-button-select').click(function(e){
											 e.preventDefault();
											 $images.find('em').remove();
											 $add_media.show();
											 $('.add-media-selected').hide();
											 $('.cancel-media-selected').hide();
											 $('li.selected',$imagesSelect).each(function(){
												 imageUrl= $(this).data('name');
												 imageName = imageUrl.split(/[\\/]/).pop();
												 $images.append('<span data-url="'+imageUrl+'" data-name="'+imageName+'">'
													+'<img alt="" src="'+mediaUrl+imageUrl +'">'
													+'<i class="fa fa-times"></i>'
													+'<i class="fa fa-edit"></i>'
													+'</span>');
											 });
											 $imagesSelect.html('');
											 update();
										 });
										// generator image list 
									 }
								 }
							 },
							 error: function (){
								 alert("Ajax request cannot success.");
							 }
						 });
					});
					// Sort images
					$images.sortable({
						revert: 400,
						containment: $picker,
						tolerance: 'pointer',
						stop: function () {
							update();
						}
					});
					
					// Select categories and terms
					$cats.on('change', update);
				});
				
				$selected.val(shortcode);
				
				
				/**
				 * For price table
				 */
				var priceTableContainer = $('.jv-generator-price-table-field-container');
				var columns = priceTableContainer.siblings('.jv-generator-price-columns');
				var rows = priceTableContainer.siblings('.jv-generator-price-rows');
				
				generatePriceTableForm(priceTableContainer, columns.val(), rows.val());
				
				columns.on('change', function(){ generatePriceTableForm(priceTableContainer, columns.val(), rows.val());});
				rows.on('change', function(){ generatePriceTableForm(priceTableContainer, columns.val(), rows.val());});
				
				/**
				 * For table
				 */
				var tableContainer = $('.jv-generator-table-field-container');
				var tableColumns = tableContainer.siblings('.jv-generator-table-columns');
				var tableRows = tableContainer.siblings('.jv-generator-table-rows');
				
				generateTableForm(tableContainer, tableColumns.val(), tableRows.val());
				
				tableColumns.on('change', function(){ generateTableForm(tableContainer, tableColumns.val(), tableRows.val());});
				tableRows.on('change', function(){ generateTableForm(tableContainer, tableColumns.val(), tableRows.val());});
				
				$('.jv-generator-table-apply').trigger('click');
				/**
				 * For Columns
				 */
				var columnsContainer = $('.jv-columns-container');
				var columnButtons = columnsContainer.next().find('span.jv-columns-layout-button');
				columnButtons.on('click', function(){
					generateColumns(columnsContainer, this);
				});
				
				columnsContainer.find('.jv-column i').on('click', function(){
						mergeColumns(columnsContainer, this);
				});

				/**
				 * For Panel
				 */
				var panelContainer = $('.jv-generator-panel-container');
				var panelNumber = $('.jv-generator-panel');
				panelNumber.on('change', function(){generatePanel(panelContainer, this)});
				generatePanel(panelContainer, panelNumber);
				
				/**
				 * For Skillbars
				 */
				var skillbarsContainer = $('.jv-generator-skillbar-container');
				var skillbarNumber = $('.jv-generator-skillbar');
				skillbarNumber.on('change', function(){generateSkillbar(skillbarsContainer, this)});
				generateSkillbar(skillbarsContainer, skillbarNumber);

				/**
				 * For TAbs
				 */
				var tabsContainer = $('.jv-generator-tabs-container');
				var tabNumber = $('.jv-generator-tabs');
				tabNumber.on('change', function(){generateTabs(tabsContainer, this)});
				generateTabs(tabsContainer, tabNumber);

				/**
				 * For User
				 */
				var userContainer = $('.jv-generator-user-container');
				var userNumber = $('.jv-generator-user');
				userNumber.on('change', function(){generateUser(userContainer, this)});
				generateUser(userContainer, userNumber);

				/**
				 * For Counter
				 */
				var counterContainer = $('.jv-generator-counter-container');
				var counterNumber = $('.jv-generator-counter');
				counterNumber.on('change', function(){generateCounter(counterContainer, this)});
				generateCounter(counterContainer, counterNumber);


				/**
				 * For member
				 */
				var memberContainer = $('.jv-generator-member-container');
				var memberNumber = $('.jv-generator-member');
				memberNumber.on('change', function(){generateMember(memberContainer, this)});
				generateMember(memberContainer, memberNumber);

				/**
				 * For step
				 */
				var stepContainer = $('.jv-generator-step-container');
				var stepNumber = $('.jv-generator-step');
				stepNumber.on('change', function(){
					if (this.value > 6) {
						this.value = 6;
					};
					generateStep(stepContainer, this)
				});
				generateStep(stepContainer, stepNumber);

				/**
				 * For imagebox
				 */
				var imageboxContainer = $('.jv-generator-imagebox-container');
				var imageboxNumber = $('.jv-generator-imagebox');
				imageboxNumber.on('change', function(){generateImagebox(imageboxContainer, this)});
				generateImagebox(imageboxContainer, imageboxNumber);

				/**
				 * For IconBox
				 */
				var iconboxContainer = $('.jv-generator-iconbox-container');
				var iconboxNumber = $('.jv-generator-iconbox');
				iconboxNumber.on('change', function(){generateIconbox(iconboxContainer, this)});
				generateIconbox(iconboxContainer, iconboxNumber);

			},
			dataType: 'html'
		});
	});
	
	// Presets manager - Add preset
	$('#jv-generator').on('click', '.jv-preset-new', function (e) {
		// Prepare data
		var $container = $(this).parents('.jv-generator-presets'),
			$list = $('.jv-presets-list'),
			id = new Date().getTime();
		// Ask for preset name
		var name = prompt('Please enter a name for new preset','New preset');
		// Name is entered
		if (name !== '' && name !== null) {
			// Hide default text
			$list.find('b').hide();
			// Add new option
			$list.append('<span data-id="' + id + '"><em>' + name + '</em><i class="fa fa-times"></i></span>');
			// Perform AJAX request
			add_preset(id, name);
		}
	});
	/**
	 * Create new preset with specified name from current settings
	 */
	function add_preset(id, name) {
		// Prepare shortcode name and current settings
		var shortcode = $('.jv-generator-presets').data('shortcode'),
			settings = get_settings();
		// Perform AJAX request
		$.ajax({
			type: 'POST',
			url: ajaxUrl +'&task=add_preset',
			data: {
				id: id,
				name: name,
				shortcode: shortcode,
				settings: settings
			},
			success: function(html){
			}
		});
	}
	function get_settings(){
		// Prepare data
		var query = $selected.val(),
			$settings = $('#jv-generator-settings .jv-generator-attr'),
			content = $('#jv-generator-content').val(),
			data = {};
		// Add shortcode attributes
		$settings.each(function (i) {
			// Prepare field and value
			var $this = $(this),
				value = '',
				name = $this.attr('name');
			// Selects
			if ($this.is('select')) value = $this.find('option:selected').val();
			// Other fields
			else value = $this.val();
			// Check that value is not empty
			if (value == null) value = '';
			// Save value
			data[name] = value;
		});
		// Add content
		data['content'] = content.toString();
		// Return data
		return data;
	}
	
	// Presets manager - remove preset
	$('#jv-generator').on('click', '.jv-presets-list i', function (e) {
		// Prepare data
		var $list = $(this).parents('.jv-presets-list'),
			$preset = $(this).parent('span'),
			id = $preset.data('id');
		// Remove DOM element
		$preset.remove();
		// Show default text if last preset was removed
		if ($list.find('span').length < 1) $list.find('b').show();
		// Perform ajax request
		remove_preset(id);
		// Prevent <span> action
		e.stopPropagation();
		// Prevent default action
		e.preventDefault();
	});

	/**
	 * Remove preset by ID
	 */
	function remove_preset(id) {
		// Get current shortcode name
		var shortcode = $('.jv-generator-presets').data('shortcode');
		// Perform AJAX request
		$.ajax({
			type: 'POST',
			url: ajaxUrl + '&task=remove_preset',
			data: {
				id: id,
				shortcode: shortcode
			}
		});
	}
	
	// Presets manager - load preset
	$('#jv-generator').on('click', '.jv-presets-list span', function (e) {
		// Prepare data
		var shortcode = $('.jv-generator-presets').data('shortcode'),
			id = $(this).data('id'),
			$insert = $('.jv-generator-insert');
		// Hide popup
		//$('.jv-preset-popup').hide();
		// Get the preset
		$.ajax({
			type: 'GET',
			url: ajaxUrl+'&task=load_preset',
			data: {
				id: id,
				shortcode: shortcode
			},
			beforeSend: function () {
				// Disable insert button
				$insert.addClass('button-primary-disabled').attr('disabled', true);
			},
			success: function (data) {
				// Enable insert button
				$insert.removeClass('button-primary-disabled').attr('disabled', false);
				// Set new settings
				apply_preset(data);
			},
			dataType: 'json'
		});
		// Prevent default action
		e.preventDefault();
		e.stopPropagation();
	});
	// apply preset data for setting
	function apply_preset(data) {
		// Prepare data
		var $settings = $('#jv-generator-settings .jv-generator-attr'),
			$content = $('#jv-generator-content');
		// Loop through settings
		$settings.each(function () {
			var $this = $(this),
				name = $this.attr('name');
			// Data contains value for this field
		 
			if (data.hasOwnProperty(name)) {
				// Set new value
				$this.val(data[name]);
				$this.trigger('keyup').trigger('change');
			}
		});
		// Set content
		if (data.hasOwnProperty('content')) $content.val(data['content']).trigger('keyup').trigger('change');
		// Update preview
		update_preview();
	}


	// Insert shortcode
	$('#jv-generator').on('click', '.jv-generator-insert', function (e) {
		// Prepare data
		var shortcode = parse();
		// Save shortcode to div
		$result.text(shortcode);
		// Prevent default action
		e.preventDefault();
		// Insert shortcode
		  window.parent.jvInsertShortCode(shortcode);
		  window.parent.SqueezeBox.close();	
	});
	function parse() {
		// Prepare data
		var query = $selected.val(),
			prefix = $prefix.val(),
			$settings = $('#jv-generator-settings .jv-generator-attr-container:not(.jv-generator-skip) .jv-generator-attr'),
			content = $('#jv-generator-content').val(),
			result = new String('');
		// Open shortcode
		result += '[' + prefix + query;
		// Add shortcode attributes
		$settings.each(function () {
			// Prepare field and value
			var $this = $(this),
				value = '';
			// Selects
			if ($this.is('select')) value = $this.find('option:selected').val();
			// Other fields
			else value = $this.val();
			// Check that value is not empty
			if (value == null) value = '';
			else if (typeof value === 'array') value = value.join(',');
			// Add attribute
			if (value !== '') result += ' ' + $(this).attr('name') + '="' + $(this).val().toString().replace(/"/gi, "'") + '"';
		});
		// End of opening tag
		result += ']';
		// Wrap shortcode if content presented
		if (content != 'false') result += content + '[/' + prefix + query + ']\n';
		// Return result
		return result;
	}

	
	
	$('#jv-generator').on('click', '.btn-up-to-top', function (e) {
		//scroll top
		$('body').animate({scrollTop: 0}, 500);
	});
	// preview shortcode
	$('#jv-generator').on('click', '.jv-generator-toggle-preview', function (e) {
		// Prepare data
		
		
		var $preview = $('#jv-generator-preview'),
			$button = $(this);
		
		// Show preview box
		$preview.addClass('jv-generator-loading').show();
		
		//scroll down		
		$('body').animate({scrollTop: $preview.offset().top}, 500);
		
		// Bind updating on settings changes
		$settings.find('input, textarea, select').on('change keyup blur ', function () {
			update_preview();
		});
		// Update preview box
		update_preview(true);
		var offset = $('#jv-generator-preview').offset();
		$('html').animate({scrollTop: offset.top}, 500);
		// Prevent default action
		e.preventDefault();
	});

	$('#jv-generator').on('click', '.btn-media', function(){
		$(this).magnificPopup({type: 'iframe'}).magnificPopup('open');
		return false;
	});
	var update_preview_timer,
	update_preview_request;

	function update_preview(forced) {
	// Prepare data
		var $preview = $('#jv-generator-preview'),
			shortcode = parse(),
			previous = $result.text();
		// Check forced mode
		forced = forced || false;
		// Break if preview box is hidden (preview isn't enabled)
		if (!$preview.is(':visible')) return; 
		// Check shortcode is changed is this is not a forced mode
		if (shortcode === previous && !forced) return;
		// Run timer to filter often calls
		window.clearTimeout(update_preview_timer);
		update_preview_timer = window.setTimeout(function () {
			update_preview_request = $.ajax({
				type: 'POST',
				url: ajaxUrl+'&task=preview',
				cache: false,
				data: {
					shortcode: shortcode
				},
				beforeSend: function () {
					// Abort previous requests
					if (typeof update_preview_request === 'object') update_preview_request.abort();
					// Show loading animation
					$preview.addClass('jv-generator-loading').html('');
				},
				success: function (data) {
					// Hide loading animation and set new HTML
					$preview.html(data).removeClass('jv-generator-loading');
				},
				dataType: 'html'
			});
		}, 300);
		// Save shortcode to div
		$result.text(shortcode);
	}
	
	/**
	 * Function generatePriceTableForm
	 * 
	 */
	function generatePriceTableForm(container, columns, rows){
		
		var pricetable;
		var currentRows = 0;
		var currentColumns = 0;
		var i, removedNumber, addedNumber, row; 
		if(container.data('pricetable')){
			pricetable = container.data('pricetable');
			currentColumns = pricetable.find('.data-column').size();
			currentRows = pricetable.find('.data-column').eq(0).find('.data-row').size();
		}else{
			pricetable = $('<div>').addClass('data-table');
		}

		
		if(columns < currentColumns){
			removedNumber = currentColumns - columns;
		
			for(i = 0; i < removedNumber; i++){
				pricetable.find('.data-column:last').remove();
			}
		}else{
			addedNumber = columns - currentColumns;
			for(i = 0; i < addedNumber; i++){
				var column = $('<div>').addClass('data-column');
				
				row = $('<div>').addClass('data-row-s');
				row.html('<input type="text" value="Column Title ' + (currentColumns + i + 1) + '" class="data-title" />');
				column.append(row);

				row = $('<div>').addClass('data-row-s');
				row.html('<input type="text" placeholder="Column Sub Title ' + (currentColumns + i + 1) + '" class="data-sub-title" />');
				column.append(row);
				
				// row = $('<div>').addClass('data-row-s');
				// row.html(
				// 	'<input type="text" value="" class="data-image" id="price-table-data-image-' + (currentColumns + i + 1) + '"/>'
				// 	+ '<a rel="{handler: \'iframe\', size: {x: 800, y: 500}}" href="index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=&amp;author=&amp;fieldid=price-table-data-image-' + (currentColumns + i + 1) + '" onclick="SqueezeBox.fromElement(this, {handler:\'iframe\', size: {x: 830, y: 600}}); return false;" title="Select Media" class="button  jv-generator-field-action button-secondary"><i style="margin-right:5px;" class="fa fa-image"></i> Select Media</a>'
				// );
				// column.append(row);
				
				row = $('<div>').addClass('data-row-s');
				row.html('<input type="text" value="Price ' + (currentColumns + i + 1) + '" class="data-price" />');
				column.append(row);
				
				row = $('<div>').addClass('data-row-s');
				row.html('<input type="text" value="" placeholder="Purchase Link ' + (currentColumns + i + 1) + '" class="data-purchase-link" />');
				column.append(row);
				
				
				var addedRows = currentRows ? currentRows : rows;
				for(var j = 0; j < addedRows; j++){
					row = $('<div>').addClass('data-row');
					row.append($('<input>').attr({type: 'text'}).addClass('data-field').val('Data Field ' + (j + 1)));	
					column.append(row);
				}

				row = $('<div>').addClass('data-row-s');
				row.html('<input type="text" value="" placeholder="Class ' + (currentColumns + i + 1) + '" class="data-class" />');
				column.append(row);

				pricetable.append(column);
			}
		}
		if(currentColumns != 0 && rows != currentRows){
			if(rows < currentRows){
				removedNumber = currentRows - rows;
				pricetable.find('.data-column').each(function(){
					for(i = 0; i < removedNumber; i++){
						$(this).find('.data-row:last').remove();
					}
				});
				
			}else{
				addedNumber = rows - currentRows;
				pricetable.find('.data-column').each(function(){
					for(i = 0; i < addedNumber; i++){
						row = $('<div>').addClass('data-row');
						row.append($('<input>').attr({type: 'text'}).addClass('data-field').val('Data Field ' + (currentRows + i + 1)));	
						$(this).append(row);
					}
					
				});
			}
		}	
		var width = 100 / pricetable.find('.data-column').size();
		pricetable.find('.data-column').width(width + '%');
		
		container.append(pricetable);
		container.data('pricetable', pricetable);
		pricetable.find('.data-clear').remove();
		pricetable.append('<div class="data-clear" style="clear: both;"></div>');
		
	}
	
	$('#jv-generator').on('click', '.jv-generator-pricetable-apply',function(){
		var container = $('.jv-generator-price-table-field-container');
		var pricetable = container.data('pricetable');
		if(typeof(pricetable) == 'undefined') return false;		
		var content = '';
		pricetable.find('.data-column').each(function(){
			var title = $(this).find('.data-title').val();
			var sub_title = $(this).find('.data-sub-title').val();
			var price = $(this).find('.data-price').val();
			// var image = $(this).find('.data-image').val();
			var purchase_link = $(this).find('.data-purchase-link').val();
			var columnClass = $(this).find('.data-class').val();
			var data = '';
			$(this).find('.data-row').each(function(){
				data += $(this).find('.data-field').val() + ';';
			});


			data = data.substring(0, data.length - 1);
			content += '[' + $prefix.val() + 'pricecol ';

			if (title !='') 		content += 'title="' + title + '" ';
			if (sub_title !='') 	content += 'sub_title="' + sub_title + '" ';
			if (price !='') 		content += 'price="' + price + '" ';
			if (purchase_link !='') content += 'purchase_link="' + purchase_link + '" ';
			if (data !='') 			content += 'detail="' + data + '" ';
			if (columnClass !='') 			content += 'class="' + columnClass + '" ';

			content += ']\n';
		});
		
		$('#jv-generator-content').html(content);
	});
	
	/**
	 * Function generateTableForm
	 * 
	 */
	function generateTableForm(container, columns, rows){
		var table;
		var currentRows = 0;
		var currentColumns = 0;
		var i, removedNumber, addedNumber, row; 
		if(container.data('table')){
			table = container.data('table');
			currentColumns = table.find('.data-column').size();
			currentRows = table.find('.data-column').eq(0).find('.data-row').size();
		}else{
			table = $('<div>').addClass('data-table');
		}

		
		if(columns < currentColumns){
			removedNumber = currentColumns - columns;
		
			for(i = 0; i < removedNumber; i++){
				table.find('.data-column:last').remove();
			}
		}else{
			addedNumber = columns - currentColumns;
			for(i = 0; i < addedNumber; i++){
				var column = $('<div>').addClass('data-column');
				
				row = $('<div>').addClass('data-row-s');
				row.html('<input type="text" value="Column Title ' + (currentColumns + i + 1) + '" class="data-title" />');
				column.append(row);
				
				var addedRows = currentRows ? currentRows : rows;
				for(var j = 0; j < addedRows; j++){
					row = $('<div>').addClass('data-row');
					row.append($('<input>').attr({type: 'text'}).addClass('data-field').val('Data Field ' + (j + 1)));	
					column.append(row);
				}

				table.append(column);
			}
		}
		
		
		
		if(currentColumns != 0 && rows != currentRows){
			if(rows < currentRows){
				removedNumber = currentRows - rows;
				table.find('.data-column').each(function(){
					for(i = 0; i < removedNumber; i++){
						$(this).find('.data-row:last').remove();
					}
				});
				
			}else{
				addedNumber = rows - currentRows;
				table.find('.data-column').each(function(){
					for(i = 0; i < addedNumber; i++){
						row = $('<div>').addClass('data-row');
						row.append($('<input>').attr({type: 'text'}).addClass('data-field').val('Data Field ' + (currentRows + i + 1)));	
						$(this).append(row);
					}
					
				});
			}
		}	
		var width = 100 / table.find('.data-column').size();
		table.find('.data-column').width(width + '%');
		
		container.append(table);
		container.data('table', table);
		table.find('.data-clear').remove();
		table.append('<div class="data-clear" style="clear: both;"></div>');
		
	}
	
	$('#jv-generator').on('click', '.jv-generator-table-apply',function(){
		
		var container = $('.jv-generator-table-field-container');
		var table = container.data('table');
		if(typeof(table) == 'undefined') return false;		
		var content = '<table>';
		var rows = new Array();
		rows[0] = '';
		table.find('.data-column').each(function(){
			rows[0] += '<th>' + $(this).find('.data-title').val() + '</th>';
			var j = 1;
			$(this).find('.data-row').each(function(){
				var data = '<td>' + $(this).find('.data-field').val() + '</td>' ;
				if(typeof(rows[j]) == 'undefined'){
					rows[j] = data ;
				}else{
					rows[j]  +=  data;
				}
				j++;
			});
		});

		for(var i = 0; i < rows.length; i++){
			content+= '<tr>' + rows[i] + '</tr>';
		}
		content += '</table>';
		$('#jv-generator-content').html(content);
	});
	
	/**
	 * Function generateColumns
	 */
	function generateColumns(container, button){
		var numberCol = $(button).html();
		var col = 12/numberCol;
		container.find('.jv-column').remove();
		for(var i = 0; i < numberCol; i++){
			var column = $('<div>').addClass('jv-column col-xs-12 col-sm-' + col + ' col-md-' + col + ' col-lg-' + col).attr('data-col', col);
			column.append($('<div>').append($('<i>').addClass('fa fa-arrows-h')));		
			container.prepend(column);
			column.find('i').on('click', function(){mergeColumns(container, this)});
		}
		$(button).siblings().removeClass('selected');
		$(button).addClass('selected');
		columnChangeContent(container);
	}
	
	function mergeColumns(container, i){
		var column = $(i).parents('.jv-column');
		var index = column.index();
		var col = column.data('col');
		var colMerged = 0;
		
		if(index == container.find('.jv-column').size() - 1){
			colMerged = column.prev().data('col');
			column.prev().remove();
		}else{
			colMerged = column.next().data('col');
			column.next().remove();
		}
		
		var newCol = col + colMerged;
		column.removeClass('col-xs-12 col-sm-' + col + ' col-md-' + col + ' col-lg-' + col);
		column.addClass('col-xs-12 col-sm-' + newCol + ' col-md-' + newCol + ' col-lg-' + newCol);
		column.attr('data-col', col + colMerged);
		column.data('col', col + colMerged);
		columnChangeContent(container);
	}
	function columnChangeContent(container){
		var content = '';
		container.find('.jv-column').each(function(){
			content += '[' + $prefix.val() + 'column class="' + $(this).attr('class') + '"]';
			content += 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.';
			content += '[/'+ $prefix.val() + 'column]';
			content += "\n";
		});
		
		
		$('#jv-generator-content').html(content);
	}

	function generateSkillbar(container, skillbarNumber){
		var currentNumber = container.find('.jv-generator-skillbar').size();
		
		skillbarNumber = $(skillbarNumber).val();

		if(currentNumber > skillbarNumber){
			for(var i = 0; i < currentNumber - skillbarNumber; i++){
				container.find('.jv-generator-skillbar:last').remove();
			}
		}else{
			for(var i = 0; i < skillbarNumber - currentNumber; i++){
				var skillbar = $('<div>').addClass('jv-generator-skillbar');
				var skillbarHtml = '<div class="jv-generator-attr-container">';
					skillbarHtml += 	'<input type="text" class="jv-generator-icon-picker-value" id="jv-generator-skillbar-icon-' + (currentNumber + i + 1) + '" value="" name="skillbar-icon' + (currentNumber + i + 1) + '" placeholder="skillbar Icon ' + (currentNumber + i + 1) + '"/>';
					skillbarHtml += 	'<div class="jv-generator-field-actions">';
					skillbarHtml += 		'<a class="button jv-generator-icon-picker-button jv-generator-field-action" href="javascript:;"><i style="margin-right:5px;" class="fa fa-folder-open"></i> Icon picker</a>';
					skillbarHtml += 	'</div>';
					skillbarHtml += 	'<div class="jv-generator-icon-picker jv-generator-clearfix"><input type="text" placeholder="Filter icons" class="widefat"></div>';
					skillbarHtml += '</div>';
					skillbarHtml += '<div class="jv-generator-attr-container"><input type="text" class="skillbar-title" name="skillbar-title-' + (currentNumber + i + 1) + '" value="Skillbar Title ' + (currentNumber + i + 1) + '"/></div>';
					skillbarHtml += '<div class="jv-generator-attr-container"><input type="text" class="skillbar-achievement-percent" name="skillbar-achievement-percent-' + (currentNumber + i + 1) + '" value="50"/></div>';
					skillbarHtml += '<div class="jv-generator-attr-container">';
					skillbarHtml += '	<select class="skillbar-style" name="skillbar-style-' + (currentNumber + i + 1) + '">';
					skillbarHtml += '		<option selected value="primary">Primary (default)</option>';
					skillbarHtml += '		<option value="info">Infomation</option>';
					skillbarHtml += '		<option value="success">Success</option>';
					skillbarHtml += '		<option value="warning">Warning</option>';
					skillbarHtml += '		<option value="danger">Danger</option>';
					skillbarHtml += '	</select>'
					skillbarHtml += '</div>';

				skillbar.html(skillbarHtml);
				skillbar.find('.jv-generator-icon-picker-button').each(function(){iconpickerClicked(this)});
				container.append(skillbar);
			}
		}
		
	}

	$('#jv-generator').on('click', '.jv-generator-skillbar-apply',function(){		
		var container = $('.jv-generator-skillbar-container');
		var skillbars = container.find('.jv-generator-skillbar');
		if(skillbars.size() <=0 ) return false;		
		var content = '';
		skillbars.each(function(){
			content += '[' + $prefix.val() + 'skillbar ';
			var icon = $(this).find('.jv-generator-icon-picker-value').val();
			var title = $(this).find('.skillbar-title').val();
			var achievement_percent = $(this).find('.skillbar-achievement-percent').val();
			var style = $(this).find('.skillbar-style').val();
			if (icon !='') content += 'icon="' + icon + '" ';
			content += 'title="' + title + '" achievement_percent="' + achievement_percent + '" icon="' + icon + '" style="' + style + '" ]\n';
		});		
		$('#jv-generator-content').html(content);
	});

	function generatePanel(container, panelNumber){
		var currentNumber = container.find('.jv-generator-panel').size();
		
		panelNumber = $(panelNumber).val();

		if(currentNumber > panelNumber){
			for(var i = 0; i < currentNumber - panelNumber; i++){
				container.find('.jv-generator-panel:last').remove();
			}
		}else{
			for(var i = 0; i < panelNumber - currentNumber; i++){
				var panel = $('<div>').addClass('jv-generator-panel');
				var panelHtml = '<div class="jv-generator-attr-container">';
				panelHtml += '<input type="text" class="jv-generator-icon-picker-value" id="jv-generator-panel-icon-' + (currentNumber + i + 1) + '" value="" name="tab-icon' + (currentNumber + i + 1) + '" placeholder="Tab Icon ' + (currentNumber + i + 1) + '"/>';
				panelHtml += '<div class="jv-generator-field-actions">';
				panelHtml += '<a class="button jv-generator-icon-picker-button jv-generator-field-action" href="javascript:;"><i style="margin-right:5px;" class="fa fa-folder-open"></i> Icon picker</a>';
				panelHtml	+= '</div>';
				panelHtml += '<div class="jv-generator-icon-picker jv-generator-clearfix"><input type="text" placeholder="Filter icons" class="widefat"></div>';
				panelHtml += '</div>';
				panelHtml += '<div class="jv-generator-attr-container"><input type="text" class="panel-title" name="tab-title-' + (currentNumber + i + 1) + '" value="Title ' + (currentNumber + i + 1) + '"/></div>';
				panelHtml += '<div class="jv-generator-attr-container"><textarea class="panel-content " name="tab-content-' + (currentNumber + i + 1) + '">Content ' + (currentNumber + i + 1) + '</textarea></div>';
				panelHtml += '<div class="jv-generator-attr-container"><input type="text" class="panel-class" name="tab-class-' + (currentNumber + i + 1) + '" value="" placeholder = "Panel Class ' + (currentNumber + i + 1) + '"/></div>';
				panel.html(panelHtml);
				panel.find('.jv-generator-icon-picker-button').each(function(){iconpickerClicked(this)});
				container.append(panel);
			}
		}
		
	}

	$('#jv-generator').on('click', '.jv-generator-panel-apply',function(){
		
		var container = $('.jv-generator-panel-container');
		var panel = container.find('.jv-generator-panel');
		if(panel.size() <=0 ) return false;		
		var content = '';
		panel.each(function(){
			content += '[' + $prefix.val() + 'panel ';
			var icon = $(this).find('.jv-generator-icon-picker-value').val();
			var panelTitle = $(this).find('.panel-title').val();
			var panelContent = $(this).find('.panel-content').val();
			var panelClass = $(this).find('.panel-class').val();
			if (icon !='') content += 'icon="' + icon + '" ';
			if (panelClass != '') content += 'class="' + panelClass + '" ';
			content += 'title="' + panelTitle + '"]' + panelContent + '[/' + $prefix.val() + 'panel]\n';
		});
		
		$('#jv-generator-content').html(content);
	});
	
	function generateTabs(container, tabsNumber){
		var currentNumber = container.find('.jv-generator-tab').size();
		
		tabsNumber = $(tabsNumber).val();

		if(currentNumber > tabsNumber){
			for(var i = 0; i < currentNumber - tabsNumber; i++){
				container.find('.jv-generator-tab:last').remove();
			}
		}else{
			for(var i = 0; i < tabsNumber - currentNumber; i++){
				var tab = $('<div>').addClass('jv-generator-tab');
				var tabHtml = '<div class="jv-generator-attr-container">';
				tabHtml += '<input type="text" class="jv-generator-icon-picker-value" id="jv-generator-tab-icon-' + (currentNumber + i + 1) + '" value="" name="tab-icon' + (currentNumber + i + 1) + '" placeholder="Tab Icon ' + (currentNumber + i + 1) + '"/>';
				tabHtml += '<div class="jv-generator-field-actions">';
				tabHtml += '<a class="button jv-generator-icon-picker-button jv-generator-field-action" href="javascript:;"><i style="margin-right:5px;" class="fa fa-folder-open"></i> Icon picker</a>';
				tabHtml	+= '</div>';
				tabHtml += '<div class="jv-generator-icon-picker jv-generator-clearfix"><input type="text" placeholder="Filter icons" class="widefat"></div>';
				tabHtml += '</div>';
				tabHtml += '<div class="jv-generator-attr-container"><input type="text" class="tab-title" name="tab-title-' + (currentNumber + i + 1) + '" value="Tab Title ' + (currentNumber + i + 1) + '"/></div>';
				tabHtml += '<div class="jv-generator-attr-container"><textarea class="tab-content " name="tab-content-' + (currentNumber + i + 1) + '">Tab Content ' + (currentNumber + i + 1) + '</textarea></div>';
				tabHtml += '<div class="jv-generator-attr-container"><input type="text" class="tab-class" name="tab-class-' + (currentNumber + i + 1) + '" value="" placeholder = "Tab Class ' + (currentNumber + i + 1) + '"/></div>';
				tab.html(tabHtml);
				tab.find('.jv-generator-icon-picker-button').each(function(){iconpickerClicked(this)});
				container.append(tab);
			}
		}
		
	}

	$('#jv-generator').on('click', '.jv-generator-tabs-apply',function(){
		
		var container = $('.jv-generator-tabs-container');
		var tabs = container.find('.jv-generator-tab');
		if(tabs.size() <=0 ) return false;		
		var content = '';
		tabs.each(function(){
			content += '[' + $prefix.val() + 'tab ';
			var icon = $(this).find('.jv-generator-icon-picker-value').val();
			var tabTitle = $(this).find('.tab-title').val();
			var tabContent = $(this).find('.tab-content').val();
			var tabClass = $(this).find('.tab-class').val();
			if (icon !='') content += 'icon="' + icon + '" ';
			if (tabClass != '') content += 'class="' + tabClass + '" ';
			content += 'title="' + tabTitle + '"]' + tabContent + '[/' + $prefix.val() + 'tab]\n';
		});
		
		$('#jv-generator-content').html(content);
	});

	function generateUser(container, userNumber){
		var currentNumber = container.find('.jv-generator-user').size();
		
		userNumber = $(userNumber).val();

		if(currentNumber > userNumber){
			for(var i = 0; i < currentNumber - userNumber; i++){
				container.find('.jv-generator-user:last').remove();
			}
		}else{
			for(var i = 0; i < userNumber - currentNumber; i++){
				var user = $('<div>').addClass('jv-generator-user');
				var userHtml  = '<div class="jv-generator-attr-container">';
					userHtml += '<input type="text" value="" class="data-image" id="price-table-data-image-' + (currentNumber + i + 1) + '"/>'
								+ '<a rel="{handler: \'iframe\', size: {x: 800, y: 500}}" href="index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=&amp;author=&amp;fieldid=price-table-data-image-' + (currentNumber + i + 1) + '" onclick="SqueezeBox.fromElement(this, {handler:\'iframe\', size: {x: 830, y: 600}}); return false;" title="Select Media" class="button  jv-generator-field-action button-secondary" style="margin-top:5px; margin-left:0;"><i  class="fa fa-image"></i> Select Media</a>';
					userHtml += '</div>';

					userHtml += '<div class="jv-generator-attr-container"><input type="text" class="user-name" name="user-name-' + (currentNumber + i + 1) + '" value="User name ' + (currentNumber + i + 1) + '"/></div>';
					userHtml += '<div class="jv-generator-attr-container"><input type="text" class="user-position" name="user-position-' + (currentNumber + i + 1) + '" placeholder="Position ' + (currentNumber + i + 1) + '"/></div>';
					userHtml += '<div class="jv-generator-attr-container"><input type="text" class="user-company" name="user-company-' + (currentNumber + i + 1) + '" placeholder="Company ' + (currentNumber + i + 1) + '"/></div>';
					userHtml += '<div class="jv-generator-attr-container"><input type="text" class="user-date" name="user-date-' + (currentNumber + i + 1) + '" placeholder="Date ' + (currentNumber + i + 1) + '"/></div>';
					userHtml += '<div class="jv-generator-attr-container"><div class="jv-generator-range-picker"><input type="number" value="0" class="user-rating" name="user-rating-' + (currentNumber + i + 1) + '"  min="0" max="5" step="1" class="jv-generator-attr" /><div class="clearfix"></div><span class="Jv-generator-attr-desc">Rating ' + (currentNumber + i + 1) + '</span></div></div>';
					userHtml += '<div class="jv-generator-attr-container"><div class="jv-generator-range-picker"><input type="number" value="0" class="user-recommended" name="user-recommended-' + (currentNumber + i + 1) + '"  min="0" max="100" step="5" class="jv-generator-attr" /><div class="clearfix"></div><span class="Jv-generator-attr-desc">Recommended ' + (currentNumber + i + 1) + '</span></div></div>';
					userHtml += '<div class="jv-generator-attr-container"><textarea class="user-content " name="user-content-' + (currentNumber + i + 1) + '">Testimonial Content ' + (currentNumber + i + 1) + '</textarea></div>';
					userHtml += '<div class="jv-generator-attr-container"><input type="text" class="user-class" name="user-class-' + (currentNumber + i + 1) + '" value="" placeholder = "user Class ' + (currentNumber + i + 1) + '"/></div>';
					user.html(userHtml);
					user.find('.jv-generator-range-picker').each(function (index) {
						var $picker = $(this),
							$val = $picker.find('input'),
							min = $val.attr('min'),
							max = $val.attr('max'),
							step = $val.attr('step');
						// Apply noUIslider
						$val.simpleSlider({
							snap: true,
							step: step,
							range: [min, max]
						});
						$val.attr('type', 'text').show();
						$val.on('keyup blur', function (e) {
							$val.simpleSlider('setValue', $val.val());
						});
					});
					container.append(user);
			}
		}
	}


	$('#jv-generator').on('click', '.jv-generator-user-apply',function(){		
		var container = $('.jv-generator-user-container');
		var user = container.find('.jv-generator-user');
		if(user.size() <=0 ) return false;		
		var content = '';
		user.each(function(){
			content += '[' + $prefix.val() + 'user ';

			var userAvatar 			= $(this).find('.data-image').val();
			var userName 			= $(this).find('.user-name').val();
			var userPosition 		= $(this).find('.user-position').val();
			var userCompany 		= $(this).find('.user-company').val();
			var userDate 			= $(this).find('.user-date').val();
			var userRating 			= $(this).find('.user-rating').val();
			var userRecommended 	= $(this).find('.user-recommended').val();
			var userContent 		= $(this).find('.user-content').val();
			var userClass 			= $(this).find('.user-class').val();

									content += 'name="' + userName + '" ';
			if (userAvatar !='') 	content += 'avatar="' + userAvatar + '" ';
			if (userPosition !='') 	content += 'position="' + userPosition + '" ';
			if (userCompany !='') 	content += 'company="' + userCompany + '" ';
			if (userDate !='') 		content += 'date="' + userDate + '" ';
			if (userRating !='0') 	content += 'rating="' + userRating + '" ';
			if (userRecommended !='') content += 'recommended="' + userRecommended + '" ';
			if (userClass != '')	content += 'class="' + userClass + '" ';

			content += ']' + userContent + '[/' + $prefix.val() + 'user]\n';
		});		
		$('#jv-generator-content').html(content);
	});


	function generateMember(container, memberNumber){
		var currentNumber = container.find('.jv-generator-member').size();
		memberNumber = $(memberNumber).val();
		container.addClass('cols-'+ memberNumber);
		if(currentNumber > memberNumber){
			for(var i = 0; i < currentNumber - memberNumber; i++){
				container.find('.jv-generator-member:last').remove();
			}
		}else{
			for(var i = 0; i < memberNumber - currentNumber; i++){
				var member = $('<div>').addClass('jv-generator-member');
				var memberHtml  = '<div class="jv-generator-attr-container">';
					memberHtml += '<input type="text" value="" class="member-image" id="price-table-data-image-' + (currentNumber + i + 1) + '"/>'
								+ '<a rel="{handler: \'iframe\', size: {x: 800, y: 500}}" href="index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=&amp;author=&amp;fieldid=price-table-data-image-' + (currentNumber + i + 1) + '" onclick="SqueezeBox.fromElement(this, {handler:\'iframe\', size: {x: 830, y: 600}}); return false;" title="Select Media" class="button  jv-generator-field-action button-secondary" style="margin-top:5px; margin-left:0;"><i  class="fa fa-image"></i> Select Media</a>';
					memberHtml += '</div>';

					memberHtml += '<div class="jv-generator-attr-container"><input type="text" class="member-name" name="member-name-' + (currentNumber + i + 1) + '" value="Member name ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '<div class="jv-generator-attr-container"><input type="text" class="member-position" name="member-position-' + (currentNumber + i + 1) + '" placeholder="Position ' + (currentNumber + i + 1) + '"/></div>';

					memberHtml += '<div class="jv-generator-attr-container"><div class="row">';
					memberHtml += '<div class="col-sm-6"><input type="text" class="member-website" name="member-website-' + (currentNumber + i + 1) + '" placeholder="Website ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '<div class="col-sm-6"><input type="text" class="member-facebook" name="member-facebook-' + (currentNumber + i + 1) + '" placeholder="Facebook ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '</div><div class="row">';
					memberHtml += '<div class="col-sm-6"><input type="text" class="member-google" name="member-google-' + (currentNumber + i + 1) + '" placeholder="Google+ ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '<div class="col-sm-6"><input type="text" class="member-linkedin" name="member-linkedin-' + (currentNumber + i + 1) + '" placeholder="LinkedIn ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '</div><div class="row">';
					memberHtml += '<div class="col-sm-6"><input type="text" class="member-twitter" name="member-twitter-' + (currentNumber + i + 1) + '" placeholder="Twitter ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '<div class="col-sm-6"><input type="text" class="member-github" name="member-github-' + (currentNumber + i + 1) + '" placeholder="GitHub ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '</div><div class="row">';
					memberHtml += '<div class="col-sm-6"><input type="text" class="member-tumblr" name="member-tumblr-' + (currentNumber + i + 1) + '" placeholder="Tumblr ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '<div class="col-sm-6"><input type="text" class="member-pinterest" name="member-pinterest-' + (currentNumber + i + 1) + '" placeholder="Pinterest ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '</div><div class="row">';
					memberHtml += '<div class="col-sm-6"><input type="text" class="member-instagram" name="member-instagram-' + (currentNumber + i + 1) + '" placeholder="Instagram ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '<div class="col-sm-6"><input type="text" class="member-mail" name="member-mail-' + (currentNumber + i + 1) + '" placeholder="Email ' + (currentNumber + i + 1) + '"/></div>';
					memberHtml += '</div></div>';					
					memberHtml += '<div class="jv-generator-attr-container"><textarea class="member-excerpt " name="member-excerpt-' + (currentNumber + i + 1) + '" placeholder="Excerpt ' + (currentNumber + i + 1) + '"></textarea></div>';
					memberHtml += '<div class="jv-generator-attr-container"><textarea class="member-content " rows="4" name="member-content-' + (currentNumber + i + 1) + '" placeholder="[jv_skillbars style=\'progress-1\' show_percent=\'yes\']\n'
									+'[jv_skillbar title=\'Skillbar Title 1\' achievement_percent=\'50\']\n'
									+'[jv_skillbar title=\'Skillbar Title 2\' achievement_percent=\'90\']\n'
								+'[/jv_skillbars]"></textarea></div>';					
					member.html(memberHtml);
					container.append(member);
			}
		}
		
	}


	$('#jv-generator').on('click', '.jv-generator-member-apply',function(){		
		var container = $('.jv-generator-member-container');
		var member = container.find('.jv-generator-member');
		if(member.size() <=0 ) return false;		
		var content = '';
		member.each(function(){
			var memberImage 		= $(this).find('.member-image').val();
			var memberName 			= $(this).find('.member-name').val();
			var memberPosition 		= $(this).find('.member-position').val();
			var memberWebsite 		= $(this).find('.member-website').val();
			var memberFacebook 		= $(this).find('.member-facebook').val();
			var memberGoogle		= $(this).find('.member-google').val();
			var memberLinkedin	    = $(this).find('.member-linkedin').val();
			var memberTwitter 		= $(this).find('.member-twitter').val();
			var memberGithub 		= $(this).find('.member-github').val();
			var memberTumblr 		= $(this).find('.member-tumblr').val();
			var memberPinterest 	= $(this).find('.member-pinterest').val();
			var memberInstagram 	= $(this).find('.member-instagram').val();
			var memberMail 			= $(this).find('.member-mail').val();
			var memberExcerpt		= $(this).find('.member-excerpt').val();
			var memberContent 		= $(this).find('.member-content').val();

										content += '[' 				+ $prefix.val() 	+ 'member ';

										content += 'name="' 		+ memberName 		+ '" ';
			if (memberImage !='') 		content += 'image="' 		+ memberImage 		+ '" ';
			if (memberPosition !='') 	content += 'position="' 	+ memberPosition 	+ '" ';
			if (memberWebsite !='') 	content += 'website="' 		+ memberWebsite 	+ '" ';
			if (memberFacebook !='') 	content += 'facebook="' 	+ memberFacebook 	+ '" ';
			if (memberGoogle !='') 		content += 'google="' 		+ memberGoogle 		+ '" ';
			if (memberLinkedin !='') 	content += 'linkedin="' 	+ memberLinkedin 	+ '" ';
			if (memberTwitter != '')	content += 'twitter="' 		+ memberTwitter 	+ '" ';
			if (memberGithub != '')		content += 'github="' 		+ memberGithub 		+ '" ';
			if (memberTumblr != '')		content += 'tumblr="' 		+ memberTumblr 		+ '" ';
			if (memberPinterest != '')	content += 'pinterest="' 	+ memberPinterest 	+ '" ';
			if (memberInstagram != '')	content += 'instagram="' 	+ memberInstagram 	+ '" ';
			if (memberMail != '')		content += 'mail="' 		+ memberMail 		+ '" ';
			if (memberExcerpt != '')		content += 'excerpt="' 		+ memberExcerpt 		+ '" ';

										content += ']' 				+ memberContent 	+ '[/' + $prefix.val() + 'member]\n';
		});		
		$('#jv-generator-content').html(content);
	});

	function generateCounter(container, counterNumber){
		var currentNumber = container.find('.jv-generator-counter').size();
		
		counterNumber = $(counterNumber).val();

		if(currentNumber > counterNumber){
			for(var i = 0; i < currentNumber - counterNumber; i++){
				container.find('.jv-generator-counter:last').remove();
			}
		}else{
			for(var i = 0; i < counterNumber - currentNumber; i++){
				var counter = $('<div>').addClass('jv-generator-counter');
				var counterHtml = '<div class="jv-generator-attr-container">';
				counterHtml += '<input type="text" class="jv-generator-icon-picker-value" id="jv-generator-counter-icon-' + (currentNumber + i + 1) + '" value="" name="counter-icon' + (currentNumber + i + 1) + '" placeholder="Counter Icon ' + (currentNumber + i + 1) + '"/>';
				counterHtml += '<div class="jv-generator-field-actions">';
				counterHtml += '<a class="button jv-generator-icon-picker-button jv-generator-field-action" href="javascript:;"><i style="margin-right:5px;" class="fa fa-folder-open"></i> Icon picker</a>';
				counterHtml	+= '</div>';
				counterHtml += '<div class="jv-generator-icon-picker jv-generator-clearfix"><input type="text" placeholder="Filter icons" class="widefat"></div>';
				counterHtml += '</div>';
				counterHtml += '<div class="jv-generator-attr-container"><div class="row">';
				counterHtml += '<div class="col-sm-6"><select name="counter-icon-color-' + (currentNumber + i + 1) + '" class="counter-icon-color"><option value="none" selected="selected">Select icon color</option><option value="primary">Primary (Blue)</option><option value="success">Success (Green)</option><option value="info">Infomation (Violet)</option><option value="warning">Warning (Yellow)</option><option value="danger">Danger (Red)</option></select></div>';
				counterHtml += '<div class="col-sm-6"><select name="counter-icon-background-' + (currentNumber + i + 1) + '" class="counter-icon-background"><option value="none" selected="selected">Select icon background</option><option value="primary">Primary (Blue)</option><option value="success">Success (Green)</option><option value="info">Infomation (Violet)</option><option value="warning">Warning (Yellow)</option><option value="danger">Danger (Red)</option></select></div>';
				counterHtml += '</div></div>';
				counterHtml += '<div class="jv-generator-attr-container"><div class="row">';
				counterHtml += '<div class="col-sm-4"><input type="text" class="counter-prefix" name="counter-prefix-' + (currentNumber + i + 1) + '" placeholder="Prefix ' + (currentNumber + i + 1) + '"/></div>';
				counterHtml += '<div class="col-sm-4"><input type="text" class="counter-digit" name="counter-digit-' + (currentNumber + i + 1) + '" placeholder="Digit ' + (currentNumber + i + 1) + '"/></div>';
				counterHtml += '<div class="col-sm-4"><input type="text" class="counter-suffix" name="counter-suffix-' + (currentNumber + i + 1) + '" placeholder="Suffix ' + (currentNumber + i + 1) + '"/></div>';
				counterHtml += '</div></div>';
				counterHtml += '<div class="jv-generator-attr-container"><div class="row">';
				counterHtml += '<div class="col-sm-6"><input type="text" class="counter-title" name="counter-title-' + (currentNumber + i + 1) + '" value="Title ' + (currentNumber + i + 1) + '"/></div>';
				counterHtml += '<div class="col-sm-6"><input type="text" class="counter-class" name="counter-class-' + (currentNumber + i + 1) + '" placeholder="Class ' + (currentNumber + i + 1) + '"/></div>';
				counterHtml += '</div></div>';
				counter.html(counterHtml);
				counter.find('.jv-generator-icon-picker-button').each(function(){iconpickerClicked(this)});
				container.append(counter);
			}
		}
		
	}


	$('#jv-generator').on('click', '.jv-generator-counter-apply',function(){		
		var container = $('.jv-generator-counter-container');
		var counter = container.find('.jv-generator-counter');
		if(counter.size() <=0 ) return false;		
		var content = '';
		counter.each(function(){
			content += '[' + $prefix.val() + 'counter ';

			var counterIcon 			= $(this).find('.jv-generator-icon-picker-value').val();
			var counterSize 			= $(this).find('.counter-icon-size').val();
			var counterColor 			= $(this).find('.counter-icon-color').val();
			var counterBackground 		= $(this).find('.counter-icon-background').val();
			var counterDigit 			= $(this).find('.counter-digit').val();
			var counterPrefix			= $(this).find('.counter-prefix').val();
			var counterSuffix 			= $(this).find('.counter-suffix').val();
			var counterTitle			= $(this).find('.counter-title').val();
			var counterClass 			= $(this).find('.counter-class').val();

									content += 'title="' + counterTitle + '" ';
			if (counterIcon !='') 	content += 'icon="' + counterIcon + '" ';
			if (counterColor !='none') 	content += 'icon_color="' + counterColor + '" ';
			if (counterBackground !='none') 	content += 'icon_background="' + counterBackground + '" ';
			if (counterDigit !='') 	content += 'digit="' + counterDigit + '" ';
			if (counterPrefix !='') content += 'prefix="' + counterPrefix + '" ';
			if (counterSuffix !='') content += 'suffix="' + counterSuffix + '" ';
			if (counterClass != '')	content += 'class="' + counterClass + '" ';
			content += ']\n';
		});		
		$('#jv-generator-content').html(content);
	});

	function generateStep(container, stepNumber){
		var currentNumber = container.find('.jv-generator-step').size();
		
		stepNumber = $(stepNumber).val();

		if(currentNumber > stepNumber){
			for(var i = 0; i < currentNumber - stepNumber; i++){
				container.find('.jv-generator-step:last').remove();
			}
		}else{
			for(var i = 0; i < stepNumber - currentNumber; i++){
				var step = $('<div>').addClass('jv-generator-step');
				var stepHtml  = '<div class="jv-generator-attr-container">';
					stepHtml += '<input type="text" value="" class="jv-generator-icon-picker-value" id="price-table-data-image-' + (currentNumber + i + 1) + '"/>'
					stepHtml += '<div class="jv-generator-field-actions">';
					stepHtml += '<a class="button jv-generator-icon-picker-button jv-generator-field-action" href="javascript:;"><i style="margin-right:5px;" class="fa fa-folder-open"></i> Icon picker</a>';
					stepHtml += '<a rel="{handler: \'iframe\', size: {x: 800, y: 500}}" href="index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=&amp;author=&amp;fieldid=price-table-data-image-' + (currentNumber + i + 1) + '" onclick="SqueezeBox.fromElement(this, {handler:\'iframe\', size: {x: 830, y: 600}}); return false;" title="Select Media" class="button  jv-generator-field-action button-secondary" style="margin-top:5px; margin-left:0;"><i  class="fa fa-image"></i> Select Media</a>';
					stepHtml += '</div>';
					stepHtml += '<div class="jv-generator-icon-picker jv-generator-clearfix"><input type="text" placeholder="Filter icons" class="widefat"></div>';
					stepHtml += '</div>';

					stepHtml += '<div class="jv-generator-attr-container"><input type="text" class="step-title" name="step-title-' + (currentNumber + i + 1) + '" value="Step title ' + (currentNumber + i + 1) + '"/></div>';
					stepHtml += '<div class="jv-generator-attr-container"><textarea class="step-content" rows="4" name="step-content-' + (currentNumber + i + 1) + '" placeholder="Content ' + (currentNumber + i + 1) + '"></textarea></div>';		
					stepHtml += '<div class="jv-generator-attr-container"><input type="text" class="step-class" name="step-class-' + (currentNumber + i + 1) + '" value="" placeholder = "Step class ' + (currentNumber + i + 1) + '"/></div>';
				step.html(stepHtml);
				step.find('.jv-generator-icon-picker-button').each(function(){iconpickerClicked(this)});
				container.append(step);
			}
		}		
	}
	$('#jv-generator').on('click', '.jv-generator-step-apply',function(){		
		var container = $('.jv-generator-step-container');
		var step = container.find('.jv-generator-step');
		if(step.size() <=0 ) return false;		
		var content = '';
		step.each(function(){
			content += '[' + $prefix.val() + 'step ';

			var stepIcon 			= $(this).find('.jv-generator-icon-picker-value').val();
			var stepTitle 			= $(this).find('.step-title').val();
			var stepClass 			= $(this).find('.step-class').val();
			var stepContent 		= $(this).find('.step-content').val();

									content += 'title="' + stepTitle + '" ';
			if (stepIcon !='') 		content += 'icon="' + stepIcon + '" ';
			if (stepClass !='') 	content += 'class="' + stepClass + '" ';
									content += ']' + stepContent + '[/' + $prefix.val() + 'step]\n';
		});		
		$('#jv-generator-content').html(content);
	});

	function generateImagebox(container, imageboxNumber){
		var currentNumber = container.find('.jv-generator-imagebox').size();
		
		imageboxNumber = $(imageboxNumber).val();

		if(currentNumber > imageboxNumber){
			for(var i = 0; i < currentNumber - imageboxNumber; i++){
				container.find('.jv-generator-imagebox:last').remove();
			}
		}else{
			for(var i = 0; i < imageboxNumber - currentNumber; i++){
				var imagebox = $('<div>').addClass('jv-generator-imagebox');
				var imageboxHtml  = '<div class="jv-generator-attr-container">';
					imageboxHtml += '<input type="text" value="" class="imagebox-image" id="price-table-data-image-' + (currentNumber + i + 1) + '"/>'
					imageboxHtml += '<a rel="{handler: \'iframe\', size: {x: 800, y: 500}}" href="index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=&amp;author=&amp;fieldid=price-table-data-image-' + (currentNumber + i + 1) + '" onclick="SqueezeBox.fromElement(this, {handler:\'iframe\', size: {x: 830, y: 600}}); return false;" title="Select Media" class="button  jv-generator-field-action button-secondary" style="margin-top:5px; margin-left:0;"><i  class="fa fa-image"></i> Select Media</a>';
					imageboxHtml += '</div>';
					imageboxHtml += '<div class="jv-generator-attr-container">';
					imageboxHtml += '<input type="text" value="" class="jv-generator-icon-picker-value" id="price-table-data-image-' + (currentNumber + i + 1) + '"/>'
					imageboxHtml += '<div class="jv-generator-field-actions">';
					imageboxHtml += '<a class="button jv-generator-icon-picker-button jv-generator-field-action" href="javascript:;"><i style="margin-right:5px;" class="fa fa-folder-open"></i> Icon picker</a>';
					imageboxHtml += '</div>';
					imageboxHtml += '<div class="jv-generator-icon-picker jv-generator-clearfix"><input type="text" placeholder="Filter icons" class="widefat"></div>';
					imageboxHtml += '</div>';
					imageboxHtml += '<div class="jv-generator-attr-container"><input type="text" class="imagebox-title" name="imagebox-title-' + (currentNumber + i + 1) + '" value="Title ' + (currentNumber + i + 1) + '"/></div>';
					imageboxHtml += '<div class="jv-generator-attr-container"><textarea class="imagebox-sub-title" rows="4" name="imagebox-sub-title-' + (currentNumber + i + 1) + '" placeholder="Sub title ' + (currentNumber + i + 1) + '"></textarea></div>';		
					imageboxHtml += '<div class="jv-generator-attr-container"><input type="text" class="imagebox-link" name="imagebox-link-' + (currentNumber + i + 1) + '" value="" placeholder = "Link ' + (currentNumber + i + 1) + '"/></div>';
					imageboxHtml += '<div class="jv-generator-attr-container"><input type="text" class="imagebox-class" name="imagebox-class-' + (currentNumber + i + 1) + '" value="" placeholder = "Class ' + (currentNumber + i + 1) + '"/></div>';
				imagebox.html(imageboxHtml);
				imagebox.find('.jv-generator-icon-picker-button').each(function(){iconpickerClicked(this)});
				container.append(imagebox);
			}
		}		
	}

	$('#jv-generator').on('click', '.jv-generator-imagebox-apply',function(){		
		var container = $('.jv-generator-imagebox-container');
		var imagebox = container.find('.jv-generator-imagebox');
		if(imagebox.size() <= 0 ) return false;		
		var content = '';
		imagebox.each(function(){
			content += '[' + $prefix.val() + 'imagebox ';
			var imageboxIcon			= $(this).find('.jv-generator-icon-picker-value').val();
			var imageboxImage			= $(this).find('.imagebox-image').val();
			var imageboxTitle 			= $(this).find('.imagebox-title').val();
			var imageboxSubTitle 		= $(this).find('.imagebox-sub-title').val();
			var imageboxLink 			= $(this).find('.imagebox-link').val();
			var imageboxClass 			= $(this).find('.imagebox-class').val();

											content += 'title="' + imageboxTitle + '" ';
			if (imageboxSubTitle !='') 		content += 'sub_title="' + imageboxSubTitle + '" ';
			if (imageboxImage !='') 		content += 'image="' + imageboxImage + '" ';
			if (imageboxIcon !='') 			content += 'icon="' + imageboxIcon + '" ';
			if (imageboxLink !='') 			content += 'link="' + imageboxLink + '" ';
			if (imageboxClass !='') 		content += 'class="' + imageboxClass + '" ';
											content += ']\n';
		});		
		$('#jv-generator-content').html(content);
	});
	

	//======================== Icon Box ==================
	function generateIconbox(container, iconboxNumber){
		var currentNumber = container.find('.jv-generator-iconbox').size();
		
		iconboxNumber = $(iconboxNumber).val();

		if(currentNumber > iconboxNumber){
			for(var i = 0; i < currentNumber - iconboxNumber; i++){
				container.find('.jv-generator-iconbox:last').remove();
			}
		}else{
			for(var i = 0; i < iconboxNumber - currentNumber; i++){
				var iconbox = $('<div>').addClass('jv-generator-iconbox');
				var iconboxHtml  = '<div class="jv-generator-attr-container">';
					iconboxHtml += '<input type="text" value="" class="jv-generator-icon-picker-value" id="price-table-data-image-' + (currentNumber + i + 1) + '"/>'
					iconboxHtml += '<div class="jv-generator-field-actions">';
					iconboxHtml += '<div class="pull-right" style="margin-top: 5px;"><span class="jv-generator-select-color"><span class="jv-generator-select-color-wheel" style="display: none;"></span><input type="text" name="color" value="#31aae2" id="jv-generator-attr-color" class="jv-generator-attr jv-generator-select-color-value iconbox-color"  style="color: rgb(0, 0, 0); background-color: rgb(49, 170, 226);"></span></div>';
					iconboxHtml += '<a class="button jv-generator-icon-picker-button jv-generator-field-action" href="javascript:;"><i style="margin-right:5px;" class="fa fa-folder-open"></i> Icon picker</a>';
					iconboxHtml += '</div>';
					iconboxHtml += '<div class="jv-generator-icon-picker jv-generator-clearfix"><input type="text" placeholder="Filter icons" class="widefat"></div>';
					iconboxHtml += '</div>';
					iconboxHtml += '<div class="jv-generator-attr-container"><input type="text" class="iconbox-title" name="iconbox-title-' + (currentNumber + i + 1) + '" value="Title ' + (currentNumber + i + 1) + '"/></div>';
					
					iconboxHtml += '<div class="jv-generator-attr-container"><input type="text" class="iconbox-link" name="iconbox-link-' + (currentNumber + i + 1) + '" value="" placeholder = "Link ' + (currentNumber + i + 1) + '"/></div>';
					iconboxHtml += '<div class="jv-generator-attr-container"><textarea class="iconbox-content" rows="4" name="iconbox-content-' + (currentNumber + i + 1) + '" placeholder="Content ' + (currentNumber + i + 1) + '"></textarea></div>';		
					iconboxHtml += '<div class="jv-generator-attr-container"><input type="text" class="iconbox-class" name="iconbox-class-' + (currentNumber + i + 1) + '" value="" placeholder = "Class ' + (currentNumber + i + 1) + '"/></div>';
				iconbox.html(iconboxHtml);
				iconbox.find('.jv-generator-icon-picker-button').each(function(){iconpickerClicked(this)});
				
				container.append(iconbox);
			}
		}
		// Init color pickers
		$('.jv-generator-select-color').each(function (index) {
			$(this).find('.jv-generator-select-color-wheel').filter(':first').farbtastic('.jv-generator-select-color-value:eq(' +
				index + ')');
			$(this).find('.jv-generator-select-color-value').focus(function () {
				$('.jv-generator-select-color-wheel:eq(' + index + ')').show();
			});
			$(this).find('.jv-generator-select-color-value').blur(function () {
				$('.jv-generator-select-color-wheel:eq(' + index + ')').hide();
			});
		});		
	}

	$('#jv-generator').on('click', '.jv-generator-iconbox-apply',function(){		
		var container = $('.jv-generator-iconbox-container');
		var iconbox = container.find('.jv-generator-iconbox');
		if(iconbox.size() <= 0 ) return false;		
		var content = '';
		iconbox.each(function(){
			content += '[' + $prefix.val() + 'icon ';
			var iconboxIcon			= $(this).find('.jv-generator-icon-picker-value').val();
			var iconboxTitle 			= $(this).find('.iconbox-title').val();
			var iconboxContent 		= $(this).find('.iconbox-content').val();
			var iconboxColor 			= $(this).find('.iconbox-color').val();
			var iconboxLink 			= $(this).find('.iconbox-link').val();
			var iconboxClass 			= $(this).find('.iconbox-class').val();
			if (iconboxIcon !='') 			content += 'icon="' + iconboxIcon + '" ';
											content += 'title="' + iconboxTitle + '" ';			
			if (iconboxLink !='') 			content += 'link="' + iconboxLink + '" ';
			if (iconboxClass !='') 			content += 'class="' + iconboxClass + '" ';
											content += ']'+ iconboxContent + '[/' + $prefix.val() + 'icon]\n';
		});		
		$('#jv-generator-content').html(content);
	});
	
	function iconpickerClicked(button){
		
		var $button = $(button),
		$field = $button.parents('.jv-generator-attr-container'),
		$val = $field.find('.jv-generator-icon-picker-value'),
		$iconList = $field.find('.jv-generator-icon-picker'),
		$filterIcon = $iconList.find('input:text');
		
		// get list icon
		$button.on('click', function(){
			$iconList.toggleClass('jv-generator-icon-picker-visiable');
			if($iconList.hasClass('jv-generator-icon-loaded')) return;
			$.ajax({
				type:'post',
				url: ajaxUrl + '&task=icon',
				dataType: 'html',
				beforeSend: function (){
					$filterIcon.hide();
					// show loading animation
					$iconList.addClass('jv-generator-loading');
					// mark icons is loaded
					$iconList.addClass('jv-generator-icon-loaded');
				},
				success: function (data){
					$iconList.removeClass('jv-generator-loading');
					$filterIcon.show();
					$iconList.append(data);
					var $icons = $iconList.children('i');
					$icons.click(function (){
						$val.val('icon:' + $(this).attr('title')).trigger('change');
						$iconList.removeClass('jv-generator-icon-picker-visiable');
					});
					$filterIcon.on({
						keyup:function (){
							// get val of filter
							var val = $(this).val();
							// hide all icons
							$icons.hide();
							// macth regex and show icon matched
							regex = new RegExp(val, 'gi');
							$icons.each(function (){
								//get icon name
								var name = $(this).attr('title');
								if(name.match(regex) !== null) $(this).show();
							});
						},
						focus: function (){
							$(this).val('');
							$icons.show();
						}
					});
				}
			});
		});
	}

	$('[data-toggle="tooltip"]').tooltip();
});
