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

class JVFrameworkExtensionLayout extends JVFrameworkExtension{

    public function beforeRender(){
        $params = $this['option'];

        // Layout width
        $width = json_decode($params->get('layouts.middle'), true);
        list($sidebar_a, $content, $sidebar_b) = $width[3];

        //
        $params->set('template.sidebar-a.class', 'col-md-'.$sidebar_a);
        $params->set('template.sidebar-b.class', 'col-md-'.$sidebar_b);
        $params->set('template.content.class'  , 'col-md-'.$content);

        $hasSidebarA = $this['block']->count('left');
        $hasSidebarB = $this['block']->count('right');
        $hasSidebars = $hasSidebarA + $hasSidebarB;

        $templates = JFactory::getApplication()->getTemplate(true);
        if(empty($templates->id)) $templates = $this['template']->loadTemplate($templates);
        $name = md5($templates->template.$templates->id.$templates->home);

        // Layout type
        //$layout = JFactory::getApplication()->input->get('l');
        $layout = $params->get('global.type', 'sb-c-sb');
        if($layout || (isset($_COOKIE['jvlayout']) && isset($_COOKIE['jvlayout'][$name]) && isset($_COOKIE['jvlayout'][$name]['type']))){
            if($layout){
                setcookie("jvlayout[{$name}][type]", $layout);
            }else {
                $layout = $_COOKIE['jvlayout'][$name]['type'];
            }
            if($layout == 'reset'){
                unset($_COOKIE['jvlayout'][$name]['type']);
                $layout = '';
            }
        }
        if(!$layout){
            $layout = $params->get('global.type', 'sb-c-sb');
            setcookie("jvlayout[{$name}][type]", $layout);
        }
        
        switch ($layout){

            case 'sb-c-sb' :
                $push = $sidebar_a;
                // Set style
                if(!$hasSidebarA){
                    $content += $sidebar_a;
                    $push -= $sidebar_a;
                }
                if(!$hasSidebarB){
                    $content += $sidebar_b;
					$jvoffset = 12 ;
                } else {
                        $jvoffset = 12 - $sidebar_b;
                }
//              $params->set('template.sidebar-a.class', "col-md-{$sidebar_a} pull{$content}");
                $params->set('template.body.class'  , "layout-default");
                if($push){
                   $params->set('template.content.class'  , " col-md-{$content}  col-md-offset-{$push}");
                    $params->set('template.sidebar-a.class', " col-md-{$sidebar_a} col-md-jvoffset-{$jvoffset}");
                 } else {
                    $params->set('template.content.class'  , "col-md-{$content}");
                    $params->set('template.sidebar-a.class', "col-md-{$sidebar_a}");
                 }
                break;

            case 'c-sb-sb' :
                // Set style
                if(!$hasSidebarA){
                    $content += $sidebar_a;
                }
                 $params->set('template.body.class'  , "layout-main-left-right");
                if(!$hasSidebarB){
                    $content += $sidebar_b;
                }

                $params->set('template.content.class'  , 'col-md-'.($content));

                break;

            case 'sb-sb-c' :
                $push = $sidebar_a + $sidebar_b;

                // Set style
                if(!$hasSidebarA){
                    $content += $sidebar_a;
                    $push -= $sidebar_a;
                }

                if(!$hasSidebarB){
                    $content += $sidebar_b;
                    $push -= $sidebar_b;
                }
                $params->set('template.body.class'  , "layout-left-right-main");
//                $params->set('template.sidebar-a.class', "col-md-{$sidebar_a} pull{$content}");
//                $params->set('template.sidebar-b.class', "col-md-{$sidebar_b} pull{$content}");
//                $params->set('template.content.class'  , "col-md-{$content} push{$push}");


                $params->set('template.sidebar-a.class', "col-md-{$sidebar_a} ");
                $params->set('template.sidebar-b.class', "col-md-{$sidebar_b}");
                $params->set('template.content.class'  , "col-md-{$content}");


                break;
           case 'mobile':
               $params->set('template.body.class'  , "layout-mobile");
                $basePath  = current($this['path']->getPath('basetheme'));
		$themePath = JPATH_THEMES.'/'.JFactory::getApplication()->getTemplate();

                // Mobile path
                $this['path']->addPath($basePath.'/layouts/mobiles', 'theme');			
                $this['path']->addPath($themePath.'/layouts/mobiles', 'theme');
                $this['path']->addPath($basePath.'/layouts/mobiles', 'layouts');
                $this['path']->addPath($themePath.'/layouts/mobiles', 'layouts');
                $this['path']->addPath($basePath.'/layouts/mobiles/html', 'override');
                $this['path']->addPath($themePath.'/layouts/mobiles/html', 'override');

                if($this['browser']->isiPhone()){
                        // Mobile path
                        $this['path']->addPath($themePath.'/layouts/mobiles/iphone', 'theme');
                        $this['path']->addPath($themePath.'/layouts/mobiles/iphone', 'layouts');
                        $this['path']->addPath($themePath.'/layouts/mobiles/iphone/html', 'override');
                }
                


                if($this['browser']->isAndroidOS()){
                        // Mobile path
                        $this['path']->addPath($themePath.'/layouts/mobiles/android', 'theme');
                        $this['path']->addPath($themePath.'/layouts/mobiles/android', 'layouts');
                        $this['path']->addPath($themePath.'/layouts/mobiles/android/html', 'override');
                }
                
	
		
		// Position Alias
		$positions = $this['option']->get('global.allmobile.positions');		
		if(is_object($positions)){
			foreach ($positions as $position => $option) {
				if($option->alias){
					$this['position']->alias($position, $option->alias);
					$this['option']->set('position.'.$option->alias, $option);
				}else{
					$this['option']->set('position.'.$position, $option);
				}				
			}			
		}	
               break;
        }

        $layouts = $params->get('layouts.block');
        if(!$layouts){
            return false;
        }

        foreach ($layouts as $key => $layout) {
            if(is_object($layout)){
                if(isset($layout->positions)){
                    $positions = $layout->positions;
                    if(is_object($positions)){
                        foreach ($positions as $position => $option) {
                            if($option->alias){
                                $this['position']->alias($position, $option->alias);
                            }

                            $this['option']->set('position.'.$position, $option);
                        }
                    }
                    unset($layout->positions);
                }

                foreach ($layout as $k => $v){
                    $this['option']->set('block.'.$key.'.'.$k, $v);
                }
            }

        }
    }
}