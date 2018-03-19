<?php
/**
 * # JV Framework
 * # @version		1.5.x
 * # ------------------------------------------------------------------------
 * # author    PHPKungfu Solutions Co
 * # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 * # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 * # Websites: http://www.phpkungfu.club
 * # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
class JVFrameworkExtensionStyle extends JVFrameworkExtension {
	public function onRenderHead() {
		$url = '';
                if($this ['option']-> get ('styles.customcolor.enable') ) $dthemecolor = 'custom';
                else $dthemecolor = $this ['option']->get ( 'styles.themecolor' );
                
		$templates = JFactory::getApplication ()->getTemplate ( true );
		$name = md5 ( $templates->template . $templates->id . $templates->home );
                if(isset($_COOKIE ['oldstyle'])){
                    if($_COOKIE ['oldstyle'] != $dthemecolor){
                        unset($_COOKIE ['style']);
                        setcookie ( "oldstyle", $dthemecolor );
                    }
                }else{
                    setcookie ( "oldstyle", $dthemecolor );
                }
		$this ['option']->set ( 'template.body.class' , $this ['option']->get ( 'template.body.class' ) . ' ' . current(explode('.', $this['option']->get('styles.background'))) . ' body-'.$this['option']->get('styles.themestyle') );
		if ($this ['option']->get ( 'styles.colorchooser.enable' )) {
			$color = JRequest::getVar ( 'color','' );
			if ($color || (isset ( $_COOKIE ['style'] ) && isset ( $_COOKIE ['style'] [$name] ) && isset ( $_COOKIE ['style'] [$name] ['themecolor'] ))) {
				if ($color) {
					setcookie ( "style[{$name}][themecolor]", $color );
				} else {
					$color = $_COOKIE ['style'] [$name] ['themecolor'];
				}
				$this ['asset']->addLess ( 'colors/' . $color . '/style' );

				if ($this ['option']->get ( 'template.body.class' ))
					$this ['option']->set ( 'template.body.class', $this ['option']->get ( 'template.body.class' ) . ' ' . $color );
				else
					$this ['option']->set ( 'template.body.class', $color );
				
				if ($color == 'reset') {
					unset ( $_COOKIE ['style'] [$name] ['themecolor'] );
				}
			} else {
				setcookie ( "style[{$name}][themecolor]", $dthemecolor );				
				$this ['asset']->addLess ( 'colors/' . $dthemecolor . '/style' );

				
				if ($this ['option']->get ( 'template.body.class' ))
					$this ['option']->set ( 'template.body.class', $this ['option']->get ( 'template.body.class' ) . ' ' . $dthemecolor );
				else
					$this ['option']->set ( 'template.body.class', $dthemecolor );
			}
		} else {
			
			$this ['asset']->addLess (  'colors/' . $dthemecolor . '/style' );
			if ($this ['option']->get ( 'template.body.class' ))
				$this ['option']->set ( 'template.body.class', $this ['option']->get ( 'template.body.class' ) . ' ' . $dthemecolor );
			else
				$this ['option']->set ( 'template.body.class', $dthemecolor );
		}
        
        if($this ['option'] ->get('styles.classstyle') != ''){
        	$this ['option']->set ( 'template.body.class', $this ['option']->get ( 'template.body.class' ) . ' ' . $this ['option'] ->get('styles.classstyle') );    	
        }         
                
	}
	public function beforeRender() {
		if ($this ['option']->get ( 'styles.colorchooser.enable' )) {
			$this ['position']->register ( 'style', $this ['option']->get ( 'styles.colorchooser.position' ) );
		}
		$styles = $this ['option']->get ( 'styles.config' );
		if (! $styles)
			return;
		
		$css = $gfonts = array ();
		foreach ( $styles as $key => $config ) {
			$config = ( array ) $config;
			
			if ($config ['selector']) {
				$config ['css'] = ( array ) $config ['css'];
				
				$font = json_decode ( $config ['css'] ['font-family'] );
				
				if (! isset ( $font->font ))
					$font->font = '';
				
				if ('Google webfont' == $font->type) {
					$gfonts [] = $font->font;
					$font->font = current ( explode ( ':', str_replace ( '+', ' ', $font->font ) ) );
				}
				
				if ($config ['css'] ['font-size'])
					$config ['css'] ['font-size'] = $config ['css'] ['font-size'] . 'px';
				$config ['css'] ['font-family'] = $font->font;
				
				if (isset ( $config ['css'] ['background-image'] ) && $config ['css'] ['background-image']) {
					$config ['css'] ['background-image'] = "url('{$config['css']['background-image']}')";
				}
				
				$css [] = $this ['asset']->buildCss ( $config ['selector'], $config ['css'], $config ['custom-css'] );
			}
		}
		
		// add google font
		if (count ( $gfonts ))
			$this ['asset']->addStyle ( "http://fonts.googleapis.com/css?family=" . implode ( '|', $gfonts ) );
		
		if (count ( $css ))
			$this ['asset']->addInlineStyle ( implode ( '', $css ) );
	}
	public function html() {
		$html = array ();
		$app = JFactory::getApplication ();
		jimport ( 'joomla.filesystem.folder' );
		$files = JFolder::folders ( JPATH_ROOT . '/templates/' . $app->getTemplate () . '/css/colors' );
		$html [] = "<div class='themecolor'>";
		if (is_array ( $files )) {
			foreach ( $files as $key => $val ) {
				$html [] = '<a href="?color=' . $val . '" class="' . $val . '">';
				if ($this ['path']->url ( "theme::css/colors/{$val}/thumbnail.jpg" ))
					$html [] = '<span class="color-list"><img  alt="' . $val . '" title="' . $val . '" src="' . $this ['path']->url ( "theme::css/colors/{$val}/thumbnail.jpg" ) . '"/></span>';
				
				$html [] = '</a>';
			}
		} else {
			$html [] = 'colors.ini not found!';
		}
		$html [] = "</div>";
		
		return implode ( '', $html );
	}
}
