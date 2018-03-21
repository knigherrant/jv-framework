<?php
/**
 # JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
		
JVFrameworkLoader::import ( 'functions' );
JVFrameworkLoader::import ( 'classes.helper' );
JVFrameworkLoader::import ( 'classes.extension' );
JVFrameworkLoader::import ( 'helpers.path' );

class JV extends JVFrameworkHelperLoader {	
	protected static $instance = null;
	
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new JV ();
			self::$instance->addHelper(new JVFrameworkHelperPath());
				
			$path = dirname(__FILE__);
			self::$instance['path']->addPath($path, 'framework');
			self::$instance['path']->addPath($path.'/helpers', 'helpers');
                        self::$instance['path']->addPath($path.'/helpers/bbcodes', 'bbcodes');
			self::$instance['path']->addPath($path.'/classes', 'classes');
			self::$instance['path']->addPath(JPATH_ROOT.'/templates', 'templates');
			self::$instance['path']->addPath(JPATH_ROOT.'/cache', 'caches');
			
			$basePath  = dirname($path).'/basethemes'; // Theme path
			self::$instance['path']->addPath(dirname($path).'/basethemes' , 'basetheme');
			self::$instance['path']->addPath(dirname($path).'/basethemes' , 'theme');
                        
			$template = JPATH_THEMES.'/'.JFactory::getApplication()->getTemplate();
			$input = JFactory::getApplication()->input;
			if(JFactory::getApplication()->isAdmin() && $input->getString('task') =='buildLess' ){
				$id = $input->get('id');
				JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_templates/tables');
				$table = JTable::getInstance($type = 'Style', $prefix = 'TemplatesTable', $config = array());
				$table->load($id);
				$tmpl = new stdClass;
				$tmpl->template = $table->template;
				JV::helper('template')->loadTemplate($tmpl);
				$template = JPATH_ROOT.'/templates/' . $tmpl->template;
			}

			self::$instance['path']->addPath( $template , 'theme');
			
			self::$instance['path']->addPath($basePath.'/less' , 'less.core');
				self::$instance['path']->addPath($template .'/less' , 'less');
				self::$instance['path']->addPath($template .'/compiled' , 'compiled');
			// Extensions path
			self::$instance['path']->addPath(dirname($path).'/extensions', 'extensions');	
			
			// HTML path
			self::$instance['path']->addPath($basePath.'/html', 'override');
			
			// Layout path			
			self::$instance['path']->addPath($basePath.'/layouts', 'layouts');
			
			// Require theme config
			self::$instance->getConfig();
			
			// Init JV Framework Feature
			self::$instance['extension']->init();
		}
	
		return self::$instance;
	}
	
	/**
	 * Initialize
	 * 
	 * @access public
	 * @return void
	 */
	public function initialise() {		
		# Register Event JVFrameworkFeature*::afterInitialise()
		$this['event']->fireEvent ( 'afterInitialise' );
	}
	
	/**
	 * Render doccument
	 * 
	 * @access public
	 * @return string $html
	 */
	public function render($layout) {
		# Register Event JVFrameworkFeature*::beforeRender()
		$this['event']->fireEvent ( 'beforeRender' );
		
		$html = $this['template']->render('layouts::'.$layout);
		
		preg_match_all('#<jdoc:include\ type="([^"]+)" (.*)\/>#iU', $html, $matches);

		$template_tags = array();
		for ($i = count($matches[0]) - 1; $i >= 0; $i--)
		{
			$type = $matches[1][$i];
			$attribs = empty($matches[2][$i]) ? array() : JUtility::parseAttributes($matches[2][$i]);
			$name = isset($attribs['name']) ? $attribs['name'] : null;
			
			// Separate buffers to be executed first and last
			if ($type == 'position' || $type == 'block')
			{
				$template_tags[$matches[0][$i]] = array('type' => $type, 'name' => $name, 'attribs' => $attribs);
			}
		}		
		
		$replace = array();
		$with = array();
		
		foreach ($template_tags as $jdoc => $args)
		{
			if(in_array($args['type'], array('block', 'position'))){
				$replace[] = $jdoc;
				$with[] = $this->getBuffer($args['type'], $args['name'], $args['attribs']);
			}
		}
		
		$html = str_replace($replace, $with, $html);
		
		# Register Event JVFrameworkFeature*::afterRender()
		$this['event']->fireEvent ( 'afterRender', array (&$html) );
		
		// Put asset to head
		$this['asset']->toHead();
			
		return $html;
	}	
	
	/**
	 * Render xml
	 *
	 * @access public
	 * @return string $html
	 */
	public function renderXML($layout){
		# Register Event JVFrameworkFeature*::beforeRender()
		$this['event']->fireEvent ( 'beforeRender' );
		
		$config = $this['path']->findPath('style.config.php');	
		if(is_file($config))
			require $config;
		
		$html = $this['xtemplate']->render('layouts::'.$layout);		
		$doc = phpQuery::newDocumentHTML($html);	
			
		// Render block
		foreach (pq('block') as $template){
			$subcontent = '';
			$temp = pq($template);
			$name = $temp->attr('name');
		
			if($this['block']->count($name)){	
				$subcontent = $temp->html();
			}
		
			$temp->replaceWith($subcontent);
		}
			
		foreach (pq('positions') as $template){
			$subcontent = '';
			$temp = pq($template);
			$count = $temp->attr('count');
				
			if($this['position']->count($count)){
				$subcontent = $temp->html();
			}
				
			$temp->replaceWith($subcontent);
		}
		
		// Render position
		foreach (pq('position') as $template){
			$subcontent = '';
			$temp = pq($template);
			$name = $temp->attr('name');
				
			if($this['position']->count($name)){
				$subcontent = $temp->html();
			}
				
			$temp->replaceWith($subcontent);
		}	
		$html = $doc->html();
		
		preg_match_all('#<include\ type="([^"]+)" (.*)></include>#iU', $html, $matches);		
		$template_tags = array();
		for ($i = count($matches[0]) - 1; $i >= 0; $i--)
		{
			$type = $matches[1][$i];
			$attribs = empty($matches[2][$i]) ? array() : JUtility::parseAttributes($matches[2][$i]);
			$name = isset($attribs['name']) ? $attribs['name'] : null;
		
			// Separate buffers to be executed first and last
			if ($type == 'position' || $type == 'block')
			{
				$template_tags[$matches[0][$i]] = array('type' => $type, 'name' => $name, 'attribs' => $attribs);
			}
		}
		
		$replace = array();
		$with = array();
		
		foreach ($template_tags as $jdoc => $args)
		{
			if(in_array($args['type'], array('block', 'position'))){
				$replace[] = $jdoc;
				$with[] = $this->getBuffer($args['type'], $args['name'], $args['attribs']);
			}
		}
		
		$html = str_replace($replace, $with, $html);
		$html = str_replace('<include type="head"></include>', '<jdoc:include type="head" />', $html);
		$html = str_replace('<include type="component"></include>', '<jdoc:include type="component" />', $html);
		
		# Register Event JVFrameworkFeature*::afterRender()
		$this['event']->fireEvent ( 'afterRender', array (&$html) );
		
		// Put asset to head
		$this['asset']->toHead();
		
		return $html;
	} 
	public function getBuffer($type = null, $name = null, $attribs = array()){
		if(is_null($type) || is_null($name)){
			return;
		}
		
		switch ($type){
			case 'position':
				foreach($attribs as $attrib => $value){
					$this['option']->set('position.'.$name.'.'.$attrib, $value);
				}
				
				return $this['position']->render($name);
				break;
				
			case 'block':
				foreach($attribs as $attrib => $value){
					$this['option']->set('block.'.$name.'.'.$attrib, $value);
				}
				
				return $this['block']->render($name);
				break;
		}
		
		return;
	}

	/**
	 * Method to get theme config
	 *	
	 * @return void
	 */
	protected function getConfig(){
		$config = $this['path']->findPath('theme::config.php');
		
		if(is_file($config))
			require_once self::$instance['path']->findPath('config.php', 'theme');
	}
	
	/**
	 * Method to call helper method
	 *
	 * @param  string method ex: helper.method
	 * @return void
	 */
	public static function _($key){
	
		list($class, $method) = explode('.', $key);
	
		if(is_object(self::$instance[$class]) == false)
			return false;
	
		$call = array(self::$instance[$class], $method);
	
		if (is_callable($call))
		{
			$args = func_get_args();
			array_shift($args);
				
			return self::call($call, $args);
				
		} else {
			return false;
		}
	
	}
	
	/**
	 * Method to quickload helper
	 *
	 * @param string $name
	 * @return object helper
	 */
	public static function helper($name){
		return self::$instance[$name];
	}	
		
	/**
	 * Function caller method
	 *
	 * @param   string  $function  Function or method to call
	 * @param   array   $args      Arguments to be passed to function
	 *
	 * @return  mixed   Function result or false on error.
	 *
	 * @see     http://php.net/manual/en/function.call-user-func-array.php
	 * @since   11.1
	 */
	public static function call($function, $args){
		if (is_callable($function)){
			// PHP 5.3 workaround
			$temp = array();
			foreach ($args as &$arg)
			{
				$temp[] = &$arg;
			}
			return call_user_func_array($function, $temp);
		}else{
			
			return false;
		}
	}
}