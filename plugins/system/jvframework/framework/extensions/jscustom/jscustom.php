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

class JVFrameworkExtensionJSCustom extends JVFrameworkExtension{

	function afterRender() {
            $OWLcarousel = json_decode($this['option']->get('owl_params'));
            $version = $this['option']->get('owl_version', '1.3.3');
            if(isset($OWLcarousel->list)){
                JVJSLib::add('jquery.plugins.imagesloaded');
                $this['asset']->addStyle($this['path']->url("extensions::jscustom/assets/css/owl.carousel_$version.css"));
                $this['asset']->addScript($this['path']->url("extensions::jscustom/assets/js/owl.carousel.min_$version.js"));
                $js = '';
                foreach ($OWLcarousel->list as $o){
                    if(!$o->enable) continue;
                    $params = array();
                    if(!empty($o->params)){
                        $str = preg_replace('/\\n/i', ',', $o->params);
                        $params = explode(',', $str);
                    }   
                    if($version =='2.0.0'){
                        if($this['option']->isRTL()) $params[] = "rtl: true";
                    }
                    else  if($this['option']->isRTL()) $params[] = "direction: 'rtl'";
                    $param = implode(',',$params);
                    if($params) $js .= " $('$o->element').hide().imagesLoaded(function(){ $(this).show().owlCarousel({{$param}});});";
                    else $js .= " $('$o->element').hide().imagesLoaded(function(){ $(this).show().owlCarousel();});";
                    
                }
                $this['asset']->addInlineScript("jQuery(function($){   {$js} });" );	
            }
	}
        
    function getParam($param){
       $data = array();
       foreach($param as $c=>$x){
           if($c !='element' && $c !='title' && $c !='height' ){
               if($x != '' && $x){
                   if($c=='wrap') $data[] = "$c : '$x' ";
                   else $data[] = "$c : $x ";
               }
           }
       }
       if($data) return implode (',', $data);
       return false;
    }
}