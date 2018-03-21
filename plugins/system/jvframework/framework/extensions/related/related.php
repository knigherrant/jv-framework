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
JVFrameworkLoader::import('classes.phpQuery');
class JVFrameworkExtensionRelated extends JVFrameworkExtension{
    
	function beforeRender() {}
        
        public static function onContentAfterDisplay($context, &$article,&$params,$JV){
            
            $options = $JV::helper('option');
            $param = $options->get('related');
            $option = JRequest::getVar('option');
            $view = JRequest::getVar('view');
            $j2 = $k2 = false;
            if($option=='com_content' && $view=='article') $j2=true;
            if($option=='com_k2' && $view=='item') $k2=true;
            if( !$j2 && !$k2 ) return'';
			if(empty($param->k2catid)) $param->k2catid = array();
			if(empty($param->catid)) $param->catid = array();
            if(empty($param->catid) && empty($param->k2catid)) return '';
            if(!in_array($article->catid, (array)$param->catid) &&  !in_array($article->catid, (array)$param->k2catid) ) return '';
            $param->article = $article;
            $param->option = $option;
            $param->view = $view;
            if(!empty($j2)){
                require_once dirname(__FILE__).'/helpers/j2content.php';  
                $related = new j2Content($param);
            }else if(!empty($k2)){
                return;
                //require_once dirname(__FILE__).'/helpers/k2content.php';   
                //$related = new k2Content($param);
            }else{
                return;
            }
            $data = $related->getItems();
            $JV::helper('option')->set('data',$data);
            $html = $JV['template']->render('extensions::related/html');
            //jf($html);
            return $html;
        }
        
        
        
        
}
