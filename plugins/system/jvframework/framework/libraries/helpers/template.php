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

class JVFrameworkHelperTemplate extends JVFrameworkHelper {
	protected $_name = 'template';
	protected $_alias = array();
	protected $_unloads = array();
	public    $document = null;
        static $_template = array();
	
	public function __construct() {
		parent::__construct();
		$this->document = JFactory::getDocument();
	}
	
	public function __get($key){
		switch($key){
			case 'document':
				return $this->document;
			break;
			case 'params':
				return $this['option'];
				break;
			default:
				return isset($this->document->{$key}) ? $this->document->{$key} : '';
				break;
		}
	}
	 
	public function countModules($key){
		return $this['position']->count($key);
	}
	
        public function loadTemplate($tmpl){
		if(empty($tmpl->id) ){
			$db = JFactory::getDbo ();
			$id = $db->setQuery('SELECT id FROM #__template_styles WHERE home=1 AND template=' . $db->quote ( $tmpl->template ))->loadObject();
			$tmpl->home = 1;
			$tmpl->id = $id->id;
			self::$_template[$tmpl->id] = $tmpl;
			
		}
		return self::$_template[$tmpl->id];
	}
        
        public function isModule($name){
            $name = explode('/',$name);
            if($name[0]=='modules' && $name[1]) return true;
            return false;
        }


        public function render($name, $params = array()) {
            //jf($name);
		if(isset($this->_unloads[$name])){
			return false;
		}
		
		if(isset($this->_alias[$name])){
			$name = $this->_alias[$name];
		}
		
                if($this->isModule($name)){
                    static $chrome;
                    include_once JPATH_THEMES . '/system/html/modules.php';
                    $chromePath = JPATH_THEMES . '/' . $this->document->template . '/html/modules.php';
                    if (!isset($chrome[$chromePath])){
                        if (file_exists($chromePath)){
                            include_once $chromePath;
                        }
                        $chrome[$chromePath] = true;
                    }
                    $module = $params['module'];
                    $attribs = $params['options'];
                    $params = $params['params'];
                    //if($attribs['style'] =='jvxhtmlx') jf($module);
                    
                    
                    //add edit
                    $app = JFactory::getApplication();
                    $user = JFactory::getUser();
                    $frontediting = ($app->isSite() && $app->get('frontediting', 1) && !$user->guest);
                    $menusEditing = ($app->get('frontediting', 1) == 2) && $user->authorise('core.edit', 'com_menus');
                    //end
                    
                    $chromeMethod = 'modChrome_' . $attribs['style'];
                    if (function_exists($chromeMethod)){
                        $module->style = $attribs['style'];
                        ob_start();
                            $chromeMethod($module, $params, $attribs);
                            $module->content = ob_get_contents();
                            // add edit
                            if ($frontediting && trim($module->content) != '' && $user->authorise('module.edit.frontend', 'com_modules.module.' . $module->id)){
				$displayData = array('moduleHtml' => &$module->content, 'module' => $module, 'position' => $module->position, 'menusediting' => $menusEditing);
				JLayoutHelper::render('joomla.edit.frontediting_modules', $displayData);
                            }
                            //end
                        ob_end_clean();
                    }
                    return $module->content;
                }else{
                    $type = 'layouts';
                    if (strpos($name, '::')){
                            list ( $type, $name ) = explode ( '::', $name );
                    }
                    $path = $this['path']->findPath($name.'.php', $type);
                    if(is_file($path)){
                            ob_start();
                            extract($params);
                            require $path;
                            return ob_get_clean();
                    }
                }
	}
	
	public function alias ($name, $alias){
		$this->_alias[$name] = $alias;
	}
	
	public function unLoad ($name){
		if(isset($this->_alias[$name])){
			$name = $this->_alias[$name];
		}
		$this->_unloads[$name] = 1;
	}	
}
?>