<?php
/**
 # JV Framework
 # @version		2.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );	

class JVFrameworkExtensionModule_assignment extends JVFrameworkExtension{
    public static $query = null;
    

    public function onGetModules(&$modules) {
        if(JFactory::getApplication()->input->getBool('tp')) return true;
        foreach ( $modules as $index => $module ) {
            if($this->checkCustom($module)) $module->title = $this->getTitle($module->title);
            if(!$this->assigmentCheck($module)){
                unset($modules[$index]);
            }
        }
    }
    
    public function checkCustom($module){
        $params = new JRegistry ( $module->params );
        $moduleAssignments = $params->get('module_assignment');
        return !empty($moduleAssignments->content->customtitle->custom);
    }
    
    public function getTitle($title){
        if(!$this->hasSpan($title)) return $title;
        $sub = $tt = '';
        $title = explode('||',$title);
        if(isset($title[1])) $sub = '<em>'.$title[1].'</em>';
        $first = $last = explode(' ',$title[0]); 
        array_shift($last);
        if($last) $tt = implode(' ',$last);
        $ttMod = '<span>'.$first[0].'</span> '.$tt.$sub;
        return  $ttMod;
    }
    
    public function hasSpan($title){
        $preg = '/<span>/i';
        return preg_match($preg, $title);
    }


    public function assigmentCheck($module){
        // get active menu
        $active    = JFactory::getApplication()->getMenu()->getActive();
        if(!$active){
            $active = JFactory::getApplication()->getMenu()->getDefault();
        }
        $menuQuery = $this->getQuery();

        $load = false; 

        // by menu item id
        $itemid = $this->getItemid($module->id);
        if(in_array($active->id, $itemid)) $load = true;
        if(isset($module->menuid)){
            if($active->id == $module->menuid || ($module->menuid <= 0 && $module->menuid != '')){
                $load = true;
            }
        }

       
        // by url query
        $params = new JRegistry ( $module->params );
        $moduleAssignments = $params->get('module_assignment');

        $include = $exclude = array();
        
        if($moduleAssignments){
            foreach($moduleAssignments as $assigns){
                foreach($assigns as $assign){
                    if(@$assign->enable) {
                        $isMenuItem = true;
                            if(isset($assign->query) && is_object($assign->query)){
                                foreach($assign->query as $key => $value){
                                    $json = '{}';
                                    if(isset($menuQuery[$key])){
                                        if(is_array($value)){
                                            foreach($value as &$val){
                                                if(preg_match('#::#i', $val)){
                                                    list($val, $json) = explode('::', $val);
                                                }
                                            }

                                            if(!in_array($menuQuery[$key], array_values($value))){
                                                 $isMenuItem = false; break;
                                            }
                                        }else{
                                            if(preg_match('#::#i', $value)){
                                                list($value, $json) = explode('::', $value);
                                            }
                                            if($value && !$menuQuery[$key] == $value){ $isMenuItem = false; break;}
                                        }

                                        $json = json_decode($json);
                                        foreach($json as $k => $v){
                                            $assign->query->$k = $v;
                                        }

                                    }else{
                                       $isMenuItem = false; break;
                                    }
                                }
                            }

                        if($isMenuItem){
                            if($assign->include){
                                $include[] = $assign->query;
                            }else{
                                $exclude[] = $assign->query;
                            }
                        }
                    }
                }
            }
        }


        if(count($exclude)){
            $load = false;
        }elseif(count($include)){
            $load = true;
        }
        return $load;
    }

    public function getQuery(){
        if(is_null(self::$query)){
            // For sef
            $query = $_REQUEST;
          /*  if(!count($query)){
                $menu = $application->getMenu();
                $query = $menu->getActive()->query;
            }

            if(!isset($query['layout'])){
                $query['layout'] = $application->input->get('layout');
            }
          */
            foreach($query as &$val){
                if(is_string($val)){
                    $val = current(explode(':', $val));
                }
            }


            self::$query = $query;
        }

        return self::$query;
    }

	// Add parameter
	public function onContentPrepareForm($form, $data) {
            
            if (JFactory::getApplication()->input->get ( 'option' ) == 'com_modules' && JFactory::getApplication()->input->get ( 'layout' ) == 'edit') {
                JHtml::_('jquery.framework');
                        $doc = JFactory::getDocument();
                        if(version_compare(JVERSION, '3', '>=')){
                                Jhtml::_('bootstrap.framework');
                                $doc->addScript(JUri::root(true).'/media/jui/js/chosen.jquery.min.js');
                        }
                        $doc->addScript($this['path']->url('extensions::module_assignment/assets/admin/js/module.js'));
                        $doc->addStyleSheet($this['path']->url('extensions::module_assignment/assets/admin/css/module.css'));


                $form->loadFile ( dirname ( __FILE__ ) .  '/config/content.xml' );
                $hasK2 = is_dir(JPATH_ADMINISTRATOR.'/components/com_k2/elements');
                if($hasK2){
                    //$form->addFieldPath(JPATH_ADMINISTRATOR.'/components/com_k2/elements');
                    //$form->loadFile ( dirname ( __FILE__ ) .  '/config/k2.xml' );
                }
                $form->addFieldPath(dirname ( __FILE__ ) .  '/fields');
                //jf($form);
            }
	}
        public function getItemid($menuid){
            $db = JFactory::getDbo();
            $items = $db->setQuery("SELECT menuid FROM #__modules_menu WHERE moduleid='$menuid'")->loadObjectList();
            $itemid = array();
            foreach($items as $item) $itemid[] = $item->menuid;
            return $itemid;
        }
        
}