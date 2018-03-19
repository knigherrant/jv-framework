<?php
// no direct access
defined('_JEXEC') or die;

class Jv_shortcode_fieldType {
	
	public static function number($id,$field){
		$return = '<input type="number" name="' . $id . '" value="' .  $field->default  . '" id="jv-generator-attr-' . $id . '" min="' . $field->min . '" max="' . $field->max . '" step="' . $field->step . '" class="jv-generator-attr" />';
		return $return;
	}
	
	public static function select($id, $field){
		// Multiple selects
		$multiple = ( isset( $field->multiple ) ) ? ' multiple' : '';
		$return = '<select name="' . $id . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr"' . $multiple . '>';
		// Create options
			foreach ( $field->values->children() as $value ) {
				// Is this option selected
				$selected = ( $field->default == $value->getName() ) ? ' selected="selected"' : '';
				// Create option
				$return .= '<option value="' . $value->getName() . '"' . $selected . '>' . JText::_($value) . '</option>';
			}
		 
		$return .= '</select>';
		return $return;
	}
	
	public static function slider($id,$field){
		$return = '<div class="jv-generator-range-picker"><input type="number" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" min="' . $field->min . '" max="' . $field->max . '" step="' . $field->step . '" class="jv-generator-attr" /><div class="jv-generator-clearfix"></div></div>';
		return $return;
	}
	
	public static function text( $id, $field ) {
		$return = '<input type="text" name="' . $id . '" value="' .  $field->default  . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr" />';
		return $return;
	}
	
	public static function bool( $id, $field ) {
		$return = '<div class="jv-generator-switch jv-generator-switch-' . $field->default . '"><input type="hidden" name="' . $id . '" value="' .  $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-switch-value" /><label for="jv-generator-attr-' . $id . '"></label></div>';
		return $return;
	}
	
	public static function textarea( $id, $field ) {
		$fieldArr =  array(
			'rows'    => 3,
			'default' => $field->default
		);
		$field = $fieldArr;
		$return = '<textarea name="' . $id . '" id="jv-generator-attr-' . $id . '" rows="' . $field['rows'] . '" class="jv-generator-attr">' . $field['default']  . '</textarea>';
		return $return;
	}
	
	public static function image_source($id,$field){
		# generator source select
		$sources = '<select class="jv-generator-isp-sources">
						<option value="media">'.JText::_('MEDIA').'</option>
						<option value="category">'.JText::_('CATEGORIES').'</option>
						<option selected="selected" value="0">'.JText::_('SELECT_IMAGE_SOURCE').'</option>
					</select>';
		$categories = Jv_shortcodeHelper::select(array(
				'options'  => Jv_shortcodeHelper::getCategories(),
				'multiple' => true,
				'size'     => 10,
				'class'    => 'jv-generator-isp-categories'
		));
		// get dir list
		$dirList = array();
		Jv_shortcodeHelper::getSubDirs('images', '-', $dirList);
		$htmlDirList = '<select id="dir-list" >';
		foreach($dirList as $dir){
			$htmlDirList .= '<option value="'. ($dir->path).'">'.$dir->level.' '.basename($dir->path).'</option>';
		}
		$htmlDirList.= '</select>';
		 
		$baseUrl = JURI::root();
		$return = '<div class="jv-generator-isp" baseUrl="'.$baseUrl.'">' . $sources 
					. '<div class="jv-generator-isp-source jv-generator-isp-source-media">
							<div class="jv-generator-clearfix">'.
							$htmlDirList.
								'<a href="#" class="button button-primary jv-generator-isp-add-media">
									<i class="fa fa-plus"></i>&nbsp;&nbsp;' . JText::_('LOAD_IMAGES') 
								.'</a>
								
							</div>
							<ul id="images-to-select" style="display:none"></ul>
							<div class="add-media-selected" style="display: none;">
								<a class="media-button-select button button-primary" href="#">
									<i class="fa fa-check-square-o" style="line-height:2;">' . JText::_('ADD_SELECTED_IMAGES') .'</i>
								</a>
							</div>
							<div class="cancel-media-selected"  style="display: none;"><a><i class="fa fa-times-circle"></i></a></div>
							<div class="jv-generator-isp-images jv-generator-clearfix">
								<em class="description">' . JText::_('ADD_IMAGE_DESC' ) .'</em>
							</div>
							<div id="file-uploader" class=" jv-generator-isp-upload-media">
								<i class="fa fa-upload"></i>&nbsp;&nbsp;' . JText::_('UPLOAD_IMAGE') 
							.'</div>
						</div>
						<div class="jv-generator-isp-source jv-generator-isp-source-category">
							<em class="description">' 
								.JText::_('SELECT_CATEGORY_DESC') 
							. '</em>' 
							. $categories . 
						'</div>
						<input type="hidden" name="' . $id . '" value="' . $field->default. '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr" />
					</div>';
						
		return $return;
	}
	
	public static function color($id,$field){
		$return = '<span class="jv-generator-select-color">
						<span class="jv-generator-select-color-wheel"></span>
						<input type="text" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-select-color-value" />
					</span>';
		return $return;
	}
	
	public static function shadow( $id, $field){
		$defaults = ( (string)$field->default === 'none' ) ? array ( '0', '0', '0', '#000000' ) : explode( ' ', str_replace( 'px', '', $field->default ) );
		$return = '<div class="jv-generator-shadow-picker">
						<span class="jv-generator-shadow-picker-field">
							<input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="jv-generator-shadow-hos" />
							<small>' . JText::_( 'HORIZONTAL_OFFSET' ) . ' (px)</small>
						</span>
						<span class="jv-generator-shadow-picker-field">
							<input type="number" min="-1000" max="1000" step="1" value="' . $defaults[1] . '" class="jv-generator-shadow-vos" />
							<small>' . JText::_('VERTICAL_OFFSET') . ' (px)</small>
						</span>
						<span class="jv-generator-shadow-picker-field">
							<input type="number" min="-1000" max="1000" step="1" value="' . $defaults[2] . '" class="jv-generator-shadow-blur" />
							<small>' . JText::_('BLUR') . ' (px)</small>
						</span>
						<span class="jv-generator-shadow-picker-field jv-generator-shadow-picker-color">
							<span class="jv-generator-shadow-picker-color-wheel"></span>
							<input type="text" value="' . $defaults[3] . '" class="jv-generator-shadow-picker-color-value" />
							<small>' . JText::_( 'COLOR') . '</small>
						</span>
						<input type="hidden" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr" />
					</div>';
		return $return;
	}
	public static function border($id, $field){
		$defaults = ( (string)$field->default === 'none' ) ? array ( '0', 'none', '#000000' ) : explode( ' ', str_replace( 'px', '', $field->default ) );
		$return = '<div class="jv-generator-border-picker">
						<span class="jv-generator-border-picker-field">
							<input type="number" min="0" max="10" step="1" value="' . $defaults[0] . '" class="jv-generator-border-size" />
							<small>' . JText::_( 'BORDER_SIZE' ) . ' (px)</small>
						</span>
						<span class="jv-generator-border-picker-field">'
						.Jv_shortcodeHelper::select(array('class'=>'jv-generator-border-style','selected'=>$defaults[1], 
														  'options'=>array(
																	'none'=>JText::_('NONE'),
																	'solid'=>JText::_('SOLID'),
																	'dotted'=>JText::_('DOTTED'),
																	'dashed'=>JText::_('DASHED'),
																	'double'=>JText::_('DOUBLE'),
																	'groove'=>JText::_('GROOVE'),
																	'ridge'=>JText::_('RIDGE')														
																	)
															))
							.'<small>' . JText::_('BORDER_STYLE') . '</small>
						</span>
						
						<span class="jv-generator-border-picker-field jv-generator-picker-color">
							<span class="jv-generator-border-picker-color-wheel"></span>
							<input type="text" value="' . $defaults[2] . '" class="jv-generator-border-picker-color-value" />
							<small>' . JText::_( 'COLOR') . '</small>
						</span>
						<input type="hidden" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr" />
					</div>';
		return $return;
	}
	public static function icon( $id, $field){
		$return = ' <input type="text" name="' . $id . '" value="' .$field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-icon-picker-value" />
				    <div class="jv-generator-field-actions">
						<a class="button  jv-generator-field-action" title="'.JText::_('Select Media').'" '
							.'onClick="SqueezeBox.fromElement(this, {handler:\'iframe\', size: {x: 830, y: 600}}); return false;" '
							.'href="index.php?option=com_media&view=images&tmpl=component&asset=&author=&fieldid=jv-generator-attr-' . $id . '" rel="{handler: \'iframe\', size: {x: 800, y: 500}}"><i class="fa fa-image" style="margin-right:5px;"></i> '
							.JText::_('Select Media')
						.'</a>
						<a href="javascript:;" class="button jv-generator-icon-picker-button jv-generator-field-action">
							  <i class="fa fa-folder-open" style="margin-right:5px;"></i>'
							. JText::_(' Icon picker') 
						.'</a>
					</div>
					<div class="jv-generator-icon-picker jv-generator-clearfix">
						<input type="text" class="widefat" placeholder="' . JText::_( 'Filter icons') . '" />
					</div>';
		return $return;
	}
	public static function image( $id, $field){
		$return = ' <input type="text" name="' . $id . '" value="' .$field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-icon-picker-value" />
				    <div class="jv-generator-field-actions">
						<a class="button  jv-generator-field-action" title="'.JText::_('Select Media').'" '
							.'onClick="SqueezeBox.fromElement(this, {handler:\'iframe\', size: {x: 830, y: 600}}); return false;" '
							.'href="index.php?option=com_media&view=images&tmpl=component&asset=&author=&fieldid=jv-generator-attr-' . $id . '" rel="{handler: \'iframe\', size: {x: 800, y: 500}}"><i class="fa fa-image" style="margin-right:5px;"></i> '
							.JText::_('Select Media')
						.'</a>
					</div>';
		return $return;
	}
	
	public static function pricetable($id, $field){
		$values = explode(',', $field->default);
		if(!isset($values[1])){
			$values[1] = $values[0];
		}
		
		$return = '<input type="text" name="' . $id .'" value="' . $values[0] . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-price-columns"/>';
		$return .= '<p>' . JText::_('JV_GENERATOR_ATTR_PRICE_ROW') . '</p>';
		$return .= '<input type="text" name="jv-generator-price-rows-' . $id .'" value="' . $values[1] . '" id="jv-generator-attr-price-rows-' . $id . '" class="jv-generator-attr jv-generator-price-rows"/>'; 
		$return .= '<div class="jv-generator-price-table-field-container">';
		$return .= '</div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-pricetable-apply button-secondary">
							  <i class="fa fa-folder-open" style="margin-right:5px;"></i>'
							. JText::_('Apply') 
						.'</a></div>';
		return $return;
	}
	
	public static function columns($id, $field){
		$value = $field->default;
		$col = 12/$value;
		$return = '<div class="jv-columns">';
		$return .= '<div class="jv-columns-container">';
		for($i = 0; $i < $value; $i++){
			$return .= '<div class="jv-column col-xs-' . $col . ' col-sm-' . $col . ' col-md-' . $col . ' col-lg-' . $col . '" data-col="' .$col . '"><div><i class="fa fa-arrows-h"></i></div></div>';
		}
		$return .= '<div style="clear: both;"></div>' ;
		$return .= '</div>';
		$return .= '<div class="jv-columns-layout-buttons">';
		for($i = 1; $i <= 6; $i++){
			if($i == 5){continue;}
			$return .= '<span class="jv-columns-layout-button ' . ($i == $value ? 'selected'  : '') .'">' . $i . '</span>';
		}

		$return .= '</div>';
		$return .= '</div>';
		return $return;
	}

	public static function table($id, $field){
		$values = explode(',', $field->default);
		if(!isset($values[1])){
			$values[1] = $values[0];
		}
	
		$return = '<input type="text" name="' . $id .'" value="' . $values[0] . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-table-columns"/>';
		$return .= '<p>' . JText::_('JV_GENERATOR_ATTR_TABLE_ROW') . '</p>';
		$return .= '<input type="text" name="jv-generator-table-rows-' . $id .'" value="' . $values[1] . '" id="jv-generator-attr-table-rows-' . $id . '" class="jv-generator-attr jv-generator-table-rows"/>';
		$return .= '<div class="jv-generator-table-field-container">';
		$return .= '</div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-table-apply button-secondary">
							  <i class="fa fa-folder-open" style="margin-right:5px;"></i>'
				. JText::_('Apply')
				.'</a></div>';
		return $return;
	}
	
	public static function tabs($id, $field){
		$return = '<input type="text" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-tabs"/>';
		$return .= '<div class="jv-generator-tabs-container clearfix"></div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-tabs-apply button-secondary">
							  <i class="fa fa-folder-open" style="margin-right:5px;"></i>'
				. JText::_('Apply')
				.'</a></div>';
		return $return;
	}

	public static function skillbar($id, $field){
		$return = '<input type="text" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-skillbar"/>';
		$return .= '<div class="jv-generator-skillbar-container clearfix"></div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-skillbar-apply button-secondary">
							  <i class="fa fa-folder-open" style="margin-right:5px;"></i>'
				. JText::_('Apply')
				.'</a></div>';
		return $return;
	}

	public static function panel($id, $field){
		$return = '<input type="text" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-panel"/>';
		$return .= '<div class="jv-generator-panel-container clearfix"></div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-panel-apply button-secondary">
							  <i class="fa fa-folder-open" style="margin-right:5px;"></i>'
				. JText::_('Apply')
				.'</a></div>';
		return $return;
	}

	public static function counter($id, $field){
		$return = '<input type="text" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-counter"/>';
		$return .= '<div class="jv-generator-counter-container clearfix"></div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-counter-apply button-secondary">
							  <i class="fa fa-folder-open" style="margin-right:5px;"></i>'
				. JText::_('Apply')
				.'</a></div>';
		return $return;
	}

	public static function user($id, $field){
		$return = '<input type="text" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-user"/>';
		$return .= '<div class="jv-generator-user-container clearfix"></div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-user-apply button-secondary">
							  <i class="fa fa-folder-open" style="margin-right:5px;"></i>'
				. JText::_('Apply')
				.'</a></div>';
		return $return;
	}

	public static function member($id, $field){
		$return = '<input type="text" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-member"/>';
		$return .= '<div class="jv-generator-member-container clearfix"></div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-member-apply button-secondary">
						<i class="fa fa-folder-open" style="margin-right:5px;"></i>'
				. JText::_('Apply')
				.'</a></div>';
		return $return;
	}

	public static function step($id, $field){
		$return = '<input type="text" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-step"/>';
		$return .= '<div class="jv-generator-step-container clearfix"></div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-step-apply button-secondary">
						<i class="fa fa-folder-open" style="margin-right:5px;"></i>'
				. JText::_('Apply')
				.'</a></div>';
		return $return;
	}

	public static function imagebox($id, $field){
		$return = '<input type="number" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-imagebox"/>';
		$return .= '<div class="jv-generator-imagebox-container clearfix"></div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-imagebox-apply button-secondary">
						<i class="fa fa-folder-open" style="margin-right:5px;"></i>'
				. JText::_('Apply')
				.'</a></div>';
		return $return;
	}

	public static function iconbox($id, $field){
		$return = '<input type="number" name="' . $id . '" value="' . $field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-iconbox"/>';
		$return .= '<div class="jv-generator-iconbox-container clearfix"></div>';
		$return .= '<div style="margin-top: 10px;"><a href="javascript:void(0)" class="button jv-generator-iconbox-apply button-secondary">
						<i class="fa fa-folder-open" style="margin-right:5px;"></i>'
				. JText::_('Apply')
				.'</a></div>';
		return $return;
	}
	
	public static function file( $id, $field){
		$return = ' <input type="text" name="' . $id . '" value="' .$field->default . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr jv-generator-file-value" />
				    <div class="jv-generator-field-actions">
						<a class="button  jv-generator-field-action" title="'.JText::_('Select Media').'" '
							.'onClick="SqueezeBox.fromElement(this, {handler:\'iframe\', size: {x: 830, y: 600}}); return false;" '
							.'href="index.php?option=com_media&view=images&tmpl=component&asset=&author=&fieldid=jv-generator-attr-' . $id . '" rel="{handler: \'iframe\', size: {x: 800, y: 500}}"><i class="fa fa-image" style="margin-right:5px;"></i> '
							.JText::_('Select Media')
						.'</a>
					</div>';
		return $return;
	}
	public static function uid($id, $field){
		$return = '<input type="text" readonly="readonly" name="' . $id . '" value="' . time() . '-' . uniqid() . '" id="jv-generator-attr-' . $id . '" class="jv-generator-attr readonly"/>';
		return $return;
	}
}