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

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.plugin.plugin' );
if(!function_exists('jf')){
    function jf($str){
        if($str){
            echo "<pre>";
            print_r($str);
            echo "</pre>";
        }else{
            echo "<pre>";
            var_dump($str);
            echo "</pre>";
        }
    }
}
if(!function_exists('JFString')){
    function JFString($str, $limit = 100, $end_char = '') {
    	if (trim($str) == '' || $limit == 0) return $str;
    	
    	$str = preg_replace( array("/\r|\n/","/\t/","/\s\s+/u"), array(" "," "," "), strip_tags(trim($str)));
    
    	if(strlen($str)>$limit){
    		if(function_exists("mb_substr")) {
    			$str = mb_substr($str, 0, $limit, 'UTF-8');
    		} else {
    			$str = substr($str, 0, $limit);
    		}
    		
    		return rtrim($str).$end_char;
    	} else {
    		return $str;
    	}
    }
}

class plgSystemJVFramework extends JPlugin {
    public function __construct($a,$b){
        parent::__construct($a,$b);
    }	
	
	/**
	 * Init Framework	
	 * Map event
	 */	
	public function onAfterRoute(){
		// Register JV Framework Loader
		if (is_file ( dirname ( __FILE__ ) . '/framework/loader.php')) {
			include_once (dirname ( __FILE__ ) . '/framework/loader.php');
		}

		// Load Framework
		JVFrameworkLoader::import ( 'framework' );
		JV::getInstance ();

                // Fix bug template assign
                JV::helper('event')->fireEvent('onAfterInitialise');

		$app = JFactory::getApplication();
		if($app->isAdmin()){
			$edit = JFactory::getApplication()->input->get('option') == 'com_templates' && JFactory::getApplication()->input->get('task') == 'style.edit';
			if($edit){
				// Check template is support
				$id    = JFactory::getApplication()->input->get('id');
				$db    = JFactory::getDbo();
				$query = $db->getQuery(true);

				$query->select('template')->from('#__template_styles')->where('id='.$id);
				$db->setQuery($query);
				$template = $db->loadResult();

				$path = JPATH_ROOT."/templates/{$template}/version.php";
				if(is_file($path)){
					include_once $path;

					if(isset($framework) && isset($version)){
						$app->redirect("index.php?option=com_jvframework&task=style.edit&id={$id}");
					}
				}
			}

			// Add installer
			if(JFactory::getApplication()->input->get('option') == 'com_installer'){
				//JVFrameworkLoader::import('joomlib.installer.adapters.theme');
				JVFrameworkLoader::import('joomlib.installer.adapters.extension');

				$lang = JFactory::getLanguage();
				$lang->load('plg_system_jvframework', JPATH_ADMINISTRATOR);

				$installer = JInstaller::getInstance();
				$installer->setAdapter('extension', new JVInstallerExtension($installer, JFactory::getDbo()));
				//$installer->setAdapter('theme', new JInstallerTheme($installer, JFactory::getDbo()));
			}
		}

		JV::helper('event')->fireEvent('onAfterRoute');
	}
	
	/**
	 * Map event
	 */
	public function onAfterRender(){	
		JV::helper('event')->fireEvent('onAfterRender');
                // JV::helper('minify')->downScriptInline(); 
                JV::helper('minify')->jSonMinifyHtml();  
	}
        
        public function onBeforeRender(){	
               JV::helper('minify')->jSonOptimize(); 
	}
	
	/**
	 * Map event
	 */
	public function onContentPrepareForm($form, $data) {
		JV::helper('event')->fireEvent('onContentPrepareForm', array($form, $data));
	}
	
	/**
	 * Map event
	 */ 
	public function onContentPrepare($context, &$article, &$params, $page = 0) {
		JV::helper('event')->fireEvent('onContentPrepare', array($context, &$article, &$params, $page));
	}
	
	/**
	 * Map event
	 */
	function onPrepareContent( &$article, &$params, $page ){
		return $this->onContentPrepare('content.article', $article, $params, $page);
	}
	
    function onContentAfterDisplay($context, &$article,&$params){
        //JV::helper('event')->fireEvent('onContentAfterDisplay', array($context, &$article,&$params,JV::helper('option')));  
        return JVFrameworkExtensionRelated::onContentAfterDisplay($context, $article,$params,JV::getInstance ());
    }
}