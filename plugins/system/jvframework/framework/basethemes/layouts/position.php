<?php
$template = isset($options['layout']) ? $options['layout'] : 'default';
$style = isset($options['style']) && $options['style'] ? $options['style'] : 'jvxhtml';
// load modules
$modules = $this ['position']->load ( $position );

$html  = array();
$n     = count($modules);
$app = JFactory::getApplication();
foreach ($modules as $index => &$module) {
	$options['index'] = $index;
	$options['last']  = $index == $n;
	$options['first'] = $index == 0;
	$options['style'] = $style;
        $xstyle = preg_replace('/^(system|' . $app->getTemplate() . ')\-/i', '', $module->parameter->get('style'));
        if($xstyle) $options['style'] = $xstyle;
	// render module
	$html[] = $this['module']->render($module, $options);
}

// Apply position layout
if(count($html))
	echo $this->render("/positions/{$template}", compact('modules', 'position', 'options', 'html'));

// Do load extensions
if(count($extensions)){
	$fhtml = array();

	foreach ($extensions as $name => $options) {
		foreach ($options as $index => $option){
			$option['index'] = $index;

			$fhtml[] = $this['extension']->render($name, $option);
		}
	}
	array_filter($fhtml);
	echo implode('', $fhtml);
}