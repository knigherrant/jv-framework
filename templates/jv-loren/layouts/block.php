<?php
if(is_array($positions)){
	$html = array();
	$count= count($positions);
	$layout = isset($options['layout']) && $options['layout'] ? $options['layout'] : 'equalize';
	$style = isset($options['style']) && $options['style'] ? $options['style'] : 'jvxhtml';
	
	if(isset($options['position-layout'])){
		$options['layout'] = $options['position-layout'];
		unset($options['position-layout']);
	}else{
		unset($options['layout']);
	}
	
	foreach ( $positions as $position ) : 
		if($this ['position']->count ( $position )):
			 $option = $options;
			 unset($option['class']);
			 $html[] = $this ['position']->render ( $position . '.' . $style, $option );
		endif; 	
	endforeach;
}
if(!isset($options['class'])){
	$options['class'] = '';
}
//$options['class'] .= ' row';
if(isset($options['grid-mode'])){
	$options['class'] .= 'row-'.$options['grid-mode'];
}
echo $this->render("/blocks/{$layout}", compact('block', 'options', 'html', 'count' )); 