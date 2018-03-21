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

class JVFrameworkExtensionMenu extends JVFrameworkExtension{
    protected $moduleid;

    public function beforeRender(){
        if($this['option']->get('menu.position', 'menu')){
            $this['position']->register('menu', $this['option']->get('menu.position', 'menu'));
        }
    }

    public function afterRender(){
        $doc = JFactory::getDocument();
        $doc->addScript($this['path']->url('extensions::menu/assets/site/js/menu.js'));
        $doc->addScriptDeclaration("
            jQuery(function(){
                new JVMenu('#".$this->moduleid."',{
                    main: {
                        delay: {$this['option']->get('menu.main_delay',300)},
                        duration: {$this['option']->get('menu.main_duration',300)},
                        effect: '{$this['option']->get('menu.main_effect','fade')}',
                        easing: '{$this['option']->get('menu.main_easing')}'
                    },
                    sub: {
                        delay: {$this['option']->get('menu.sub_delay',300)},
                        duration: {$this['option']->get('menu.sub_duration',300)},
                        effect: '{$this['option']->get('menu.sub_effect','fade')}',
                        easing: '{$this['option']->get('menu.sub_easing')}'
                    },
                    responsive: {$this['option']->get('menu.responsive',1024)}
                });
            })
        ");
    }
    public function html($options = array()) {
        ob_start();?>
       
           <!-- <a class="flexMenuToggle" href="JavaScript:void(0);" ></a>-->

        <?php
        return ob_get_clean();
    }

	public function onRenderModule(&$module, &$params) {
		if($module->module != 'mod_menu') return;	
		
		$html = array();
		
		if ($params->get('jvmenutyle') == 'flex' || $params->get('jvmenutyle') == 'flex_df') {
			$module->content = $this->flexMenu( $module, $params );
			
		}
	}
	
	protected function flexMenu($module, JRegistry $params ){					
		if( $params->get('jvmenutyle') ==  'flex_df'){	
			$params->merge($this['option']->getOptions());
			$params->set ( 'flexmenu_style', 'horizontal');
		}
		// Menu id
		$menu_id = "fxmenu{$module->id}";
		$params->set('menu_id', $menu_id);
        $this->moduleid = $menu_id;
		
		// Menu class
		$menu_class = 'menu fxmenu cssmenu ' . $params->get ( 'class_sfx' );
		if($params->get ( 'flexmenu_style') == 'dropline' || $params->get ( 'flexmenu_style') == 'horizontal'){
			$menu_class .= ' dropmenu';
		}
		$params->set('menu_class', $menu_class);		
		require_once dirname ( __FILE__ ) . "/classes/helper.php";
		require_once dirname ( __FILE__ ) . "/classes/flexmenu.php"; 		
		
		$flexmenu = new FlexMenu ( $params );
		
		return $flexmenu->render ();
	}

	public function swap($ob){		
		if (is_object($ob) || is_array($ob)) {			
			foreach ($ob as $key => &$val) {
				if(is_string($val)){
					if($val == 'right'){
						$val = 'left';
					}elseif($val == 'left'){
						$val = 'right';
					}
				}else{
					$this->swap($val);
				}				
			}
		}else{
			return false;
		}
	}
	
	// Add parameter
	public function onContentPrepareForm($form, $data) {
            
		if ($form->getName() == 'com_menus.item') {
			JHtml::_('behavior.framework');
			$doc = JFactory::getDocument();
			$doc->addStyleSheet($this['path']->url('extensions::menu/assets/admin/css/menu.css'));			
			JHtml::_('jquery.framework');
			JHtml::_('bootstrap.framework');
			if(version_compare(JVERSION, '3', '>=')){
			
				Jhtml::_('bootstrap.framework');
				$doc->addScript(JUri::root(true).'/media/jui/js/chosen.jquery.min.js');				
			}
			$doc->addScript($this['path']->url('extensions::menu/assets/admin/js/menu.js'));
			
			JForm::addFieldPath(dirname ( __FILE__ ) .  '/fields');
			$form->loadFile ( dirname ( __FILE__ ) .  '/config/menu.xml' );
		}
	
		if ( (JFactory::getApplication()->input->get ( 'option' ) == 'com_modules' || JFactory::getApplication()->input->get ( 'option' ) == 'com_advancedmodules' )
                        && JFactory::getApplication()->input->get ( 'layout' ) == 'edit') {
			$postData = JFactory::getApplication()->input->get('jform', '', 'array');
			$isMenu = isset($postData['module']) && $postData['module'] == 'mod_menu' || isset($data->module) && $data->module == 'mod_menu';
			if(!$isMenu){
				return;
			}
			
			JHtml::_('behavior.framework');
			$doc = JFactory::getDocument();
			if(version_compare(JVERSION, '3', '>=')){
				
			JHtml::_('jquery.framework');
				Jhtml::_('bootstrap.framework');
				$doc->addScript(JUri::root(true).'/media/jui/js/chosen.jquery.min.js');
			}
			$doc->addScript($this['path']->url('extensions::menu/assets/admin/js/module.js'));
			$doc->addStyleSheet($this['path']->url('extensions::menu/assets/admin/css/module.css'));
			$form->addFieldPath(dirname ( __FILE__ ) .  '/fields');
			$form->loadFile ( dirname ( __FILE__ ) .  '/config/module.xml' );
		}
	}
}
