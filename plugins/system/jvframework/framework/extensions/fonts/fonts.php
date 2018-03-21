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


class JVFrameworkExtensionFonts extends JVFrameworkExtension{

	function afterRender() {
            $config = new JVCustomParam($this['option']->get('fonts'));

            $doc = JFactory::getDocument();
            foreach($config as $font){
                if(!count($font->assign)) break;
				$weight = $subsets =  array();
				if($font->weight) foreach ($font->weight as $x){
					$weight[] = $x;
				}
                                if($font->subsets) foreach ($font->subsets as $x){
					$subsets[] = $x;
				}
				$jfont = preg_replace ('/\s+/','+',$font->font);
				$path_prefix = "http";
				if (count($doc->params)) {
					if ($doc->params->get('force_ssl') == 2) $path_prefix = "https";
				}
		$sub = '';
                if($subsets) $sub = '&subset=' . implode (',',$subsets); 		
                if($weight)$doc->addStyleSheet($path_prefix . '://fonts.googleapis.com/css?family='.$jfont . ':' . implode (',',$weight) . $sub );
                else $doc->addStyleSheet($path_prefix . '://fonts.googleapis.com/css?family='.$jfont . $sub);
				
                $fonts = $font->assign->restore();
                $doc->addStyleDeclaration(implode(',', $fonts)."{font-family: '{$font->font}',  serif;}");
            }
	}
}