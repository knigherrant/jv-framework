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

// No direct access
defined('_JEXEC') or die();

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
/**
 * JVMinify class provides extended template tools used for JV framework
 *
 * @package JVFW
 */
class JVFrameworkHelperMinify extends JVFrameworkHelper {
	/**
	 * Known Valid CSS Extension Types
	 * @var array
	 */
         protected $_name            = 'minify';
    
	public static $cssexts = array('.css', '.css1', '.css2', '.css3');

	/**
	 * Known valid js extension
	 * @var array
	 */
	public static $jsexts = array('.js');

	public static $jstools = array(
		'jsmin' => 'JSMin',
		'closurecompiler' => 'Minify_JS_ClosureCompiler'
		);

	public static $jstool = 'jsmin';

	public static $exclude = '';

	/**
	 * @param $css
	 * @return string
	 */
	public static function minifyCss( $css ) {
		$css = preg_replace( '#\s+#', ' ', $css );
		$css = preg_replace( '#/\*.*?\*/#s', '', $css );
		$css = str_replace( '; ', ';', $css );
		$css = str_replace( ': ', ':', $css );
		$css = str_replace( ' {', '{', $css );
		$css = str_replace( '{ ', '{', $css );
		$css = str_replace( ', ', ',', $css );
		$css = str_replace( '} ', '}', $css );
		$css = str_replace( ';}', '}', $css );

		return trim( $css );
	}

	/**
	 * @param $js
	 * @return string
	 */
	public static function minifyJs( $js ){
                if (! class_exists ( 'JSMin' )) {	
                        require_once JV::_('path.findPath', 'classes::minify/JSMin.php');
                }
		return call_user_func_array(array(self::$jstools[self::$jstool], 'minify'), array($js));
	}

	/**
	 * 
	 * Check and convert to css real path
	 * @param  string  $url  url to check
	 * @return  mixed  the css file path or false if not exist in server
	 */
	public static function cssPath($url = '') {
		
		//exclude
		if(self::$exclude && preg_match(self::$exclude, $url)){
			return false;
		}

		$url = preg_replace('#[?\#]+.*$#', '', $url);
		$base = JURI::base();
		$root = JURI::root(true);
		$ret = false;

		if(substr($url, 0, 2) === '//'){ //check and append if url is omit http
			$url = JURI::getInstance()->getScheme() . ':' . $url; 
		}

		//check for css file extensions
		foreach ( self::$cssexts as $ext ) {
			if (strlen($ext) <= strlen($url) && substr_compare($url, $ext, -strlen($ext), strlen($ext)) === 0) {
				$ret = true;
				break;
			}
		}

		if($ret){
			if (preg_match('/^https?\:/', $url)) { //is full link
				if (strpos($url, $base) === false){
					// external css
					return false;
				}

				$path = JPath::clean(JPATH_ROOT . '/' . substr($url, strlen($base)));
			} else {
				$path = JPath::clean(JPATH_ROOT . '/' . ($root && strpos($url, $root) === 0 ? substr($url, strlen($root)) : $url));
			}

			return is_file($path) ? $path : false;
		}

		return false;
	}

	/**
	 * 
	 * Check and convert to css real path
	 * @param  string  $url  url to check
	 * @return  mixed  the css file path or false if not exist in server
	 */
	public static function jsPath($url = '') {

		//leave any javascript file that have parameter (K2 is an example)
		if(preg_match('@[?#]+.*$@', $url)){
			//return false;
		}

		//exclude
		if(self::$exclude && preg_match(self::$exclude, $url)){
			return false;
		}

		//clean
		$url = preg_replace('@[?#]+.*$@', '', $url);
		$base = JURI::base();
		$root = JURI::root(true);
		$ret = false;

		if(substr($url, 0, 2) === '//'){ //check and append if url is omit http
			$url = JURI::getInstance()->getScheme() . ':' . $url; 
		}

		//check for css file extensions
		foreach ( self::$jsexts as $ext ) {
			if (strlen($ext) <= strlen($url) && substr_compare($url, $ext, -strlen($ext), strlen($ext)) === 0) {
				$ret = true;
				break;
			}
		}

		if($ret){
			if (preg_match('/^https?\:/', $url)) { //is full link
				if (strpos($url, $base) === false){
					// external css
					return false;
				}

				$path = JPath::clean(JPATH_ROOT . '/' . substr($url, strlen($base)));
			} else {
				$path = JPath::clean(JPATH_ROOT . '/' . ($root && strpos($url, $root) === 0 ? substr($url, strlen($root)) : $url));
			}

			return is_file($path) ? $path : false;
		}

		return false;
	}

	/**
	 * @param   string  $url  url to refine
	 * @return  string  the refined url
	 */
	public static function fixUrl($url = ''){
		return ($url[0] === '/' || strpos($url, '://') !== false) ? $url : JURI::base(true) . '/' . $url;
	}

        
        public static function minifyCSSInline($tpls){
            $space = '/\s+/i';
            foreach ($tpls as $k=>&$data){
                $data = self::minifyCss($data);
                $data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $data);
                // remove tabs, spaces, newlines, etc.
                $data = str_replace(array("\r\n", "\r", "\n", "\t", 'Â  ', 'Â Â Â  ', 'Â Â Â  '), '', $data);
            }
            //$data = preg_replace($space, ' ', $data);
            return $tpls;
        }

         public static function minifyJSInline($jsInline){
            return $jsInline;
            foreach ($jsInline as $k=>&$data){
                /* remove comments */
                $data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $data);
                /* remove tabs, spaces, newlines, etc. */
                //$data = str_replace(array("\r\n","\r","\n","\t"), "\n", $data);
                $data = preg_replace("/\\n+/", "\n", $data);
                /* remove other spaces before/after ; */
                //$data = preg_replace(array('(( )+{)','({( )+)'), '{', $data);
                //$data = preg_replace(array('(( )+})','(}( )+)','(;( )*})'), '}', $data);
                //$data = preg_replace(array('(;( )+)','(( )+;)'), ';', $data);

            }
            //$data = preg_replace($space, ' ', $data);
            return $jsInline;
        }

        public function downScriptInline(){
		
            $app = JFactory::getApplication();
            if ($app->isAdmin()) return;
            $buffer = JResponse::getBody();    
			//if IE <!--[if lt IE]> <![endif]-->
			preg_match_all("/<\!--\[if\s+lt\s+IE\s+\d][^>]*>(.*)<\!\[endif\]-->/Uis", $buffer, $matchesie);
			foreach( @$matchesie[0] as $itemie )
            {  
                $buffer = str_replace( $itemie, '', $buffer );
            }
			//get script
            preg_match_all("/<script[^>]*>(.*)<\/script>/Uis", $buffer, $matches);
            foreach( @$matches[0] as $item )
            {  
                $buffer = str_replace( $item, '', $buffer );
            }
			$buffer = str_replace( '</body>', implode( '', @$matchesie[ 0 ] ) . '</body>', $buffer );
            $buffer = str_replace( '</body>', implode( '', @$matches[ 0 ] ) . '</body>', $buffer );
            JResponse::setBody( $buffer );
        }
        
        public function jSonOptimize(){
            $compress = $this ['option']->get('global.compress.css_js', 0);
            $app = JFactory::getApplication();
            if($compress){
               self::optimizecss();
               self::optimizejs();
            }
        }
        
        public function jSonMinifyHtml(){
            return;
            $app = JFactory::getApplication();
            $compress = $this ['option']->get('global.compress.html', 0);
			$doc = JFactory::getDocument();
            if ($app->getName() != 'site' || !$compress || $doc->getType() !== 'html'){
                return;
            }
            
            $buffer = $app->getBody();
            $buffer = JVMinify_HTML::minify($buffer);
            $app->setBody($buffer);
        }
        
        /**
	 * @param   $tpl  template object
	 * @return  bool  optimize success or not
	 */
	public static function optimizecss()
	{
		$outputpath = JPATH_ROOT . '/cache/jv/css';
		$outputurl = JURI::root(true) . '/cache/jv/css';
		
		if (!JFile::exists($outputpath)){
			JFolder::create($outputpath);
			@chmod($outputpath, 0755);
		}

		if (!is_writeable($outputpath)) {
			return false;
		}
		
		$doc = JFactory::getDocument();

		//======================= Group css ================= //
		$mediagroup = array();
		$cssgroups = array();
		$stylesheets = array();
		$ielimit = 40950;
		$selcounts = 0;
		$regex = '/\{.+?\}|,/s'; //selector counter
		$csspath = '';

		// group css into media
		$mediagroup['all'] = array();
		$mediagroup['screen'] = array();


		foreach ($doc->_styleSheets as $url => $stylesheet) {
                        if(isset($stylesheet['attribs']['media'])) $stylesheet['media'] = $stylesheet['attribs']['media'];
			$media = isset($stylesheet['media']) ? $stylesheet['media'] : 'all';
			if (empty($mediagroup[$media])) {
				$mediagroup[$media] = array();
			}
			$mediagroup[$media][$url] = $stylesheet;
		}
		foreach ($mediagroup as $media => $group) {
			$stylesheets = array(); // empty - begin a new group
			foreach ($group as $url => $stylesheet) {
				$url = self::fixUrl($url);

				if ($stylesheet['mime'] == 'text/css' && ($csspath = self::cssPath($url))) {
					$stylesheet['path'] = $csspath;
					$stylesheet['data'] = file_get_contents($csspath);

					$selcount = preg_match_all($regex, $stylesheet['data'], $matched);
					if(!$selcount) {
						$selcount = 1; //just for sure
					}

					//if we found an @import rule or reach IE limit css selector count, break into the new group
                                        //preg_match('#@import\s+.+#', $stylesheet['data']) || 
					if ($selcounts + $selcount >= $ielimit) {
						if(count($stylesheets)){
							$cssgroup = array();
							$groupname = array();
							foreach ( $stylesheets as $gurl => $gsheet ) {
								$cssgroup[$gurl] = $gsheet;
								$groupname[] = $gurl;
							}

							$cssgroup['groupname'] = implode('', $groupname);
							$cssgroup['media'] = $media;
							$cssgroups[] = $cssgroup;
						}

						$stylesheets = array($url => $stylesheet); // empty - begin a new group
						$selcounts = $selcount;
					} else {

						$stylesheets[$url] = $stylesheet;
						$selcounts += $selcount;
					}

				} else {
					// first get all the stylsheets up to this point, and get them into
					// the items array
					if(count($stylesheets)){
						$cssgroup = array();
						$groupname = array();
						foreach ( $stylesheets as $gurl => $gsheet ) {
							$cssgroup[$gurl] = $gsheet;
							$groupname[] = $gurl;
						}

						$cssgroup['groupname'] = implode('', $groupname);
            			$cssgroup['media'] = $media;
						$cssgroups[] = $cssgroup;
					}

					//mark ignore current stylesheet
					$cssgroup = array($url => $stylesheet, 'ignore' => true);
					$cssgroups[] = $cssgroup;

					$stylesheets = array(); // empty - begin a new group
				}
			}

			if(count($stylesheets)){
				$cssgroup = array();
				$groupname = array();
				foreach ( $stylesheets as $gurl => $gsheet ) {
					$cssgroup[$gurl] = $gsheet;
					$groupname[] = $gurl;
				}

				$cssgroup['groupname'] = implode('', $groupname);
				$cssgroup['media'] = $media;
				$cssgroups[] = $cssgroup;
			}
		}

		//======================= Group css ================= //

		$output = array();
		foreach ($cssgroups as $cssgroup) {
			if(isset($cssgroup['ignore'])){
				unset($cssgroup['ignore']);
				unset($cssgroup['groupname']);
				unset($cssgroup['media']);
				foreach ($cssgroup as $furl => $fsheet) {
					$output[$furl] = $fsheet;
				}
			} else {
				$media = $cssgroup['media'];
				$groupname = 'css-' . substr(md5($cssgroup['groupname']), 0, 5) . '.css';
				$groupfile = $outputpath . '/' . $groupname;
				$grouptime = JFile::exists($groupfile) ? @filemtime($groupfile) : -1;
				$rebuild = $grouptime < 0; //filemtime == -1 => rebuild

				unset($cssgroup['groupname']);
				unset($cssgroup['media']);
				foreach ($cssgroup as $furl => $fsheet) {
					if(!$rebuild && @filemtime($fsheet['path']) > $grouptime){
						$rebuild = true;
					}
				}

				if($rebuild){
					$cssdata = array();
					foreach ($cssgroup as $furl => $fsheet) {
						//$cssdata[] = "/*===============================";
						//$cssdata[] = $furl;
						//$cssdata[] = "===============================*/";

						$cssmin = self::minifyCss($fsheet['data']);
						$cssmin = JV::helper('path')->updateUrl($cssmin, JV::helper('path')->relativePath($outputurl, dirname($furl)));

						$cssdata[] = $cssmin;
					}

					$cssdata = implode("\n", $cssdata);
					if (!JFile::write($groupfile, $cssdata)) {
						// cannot write file, ignore minify
						return false;
					}
					$grouptime = @filemtime($groupfile);
					@chmod($groupfile, 0644);
				}
				//.'?t='.($grouptime % 1000)
				$output[$outputurl . '/' . $groupname] = array(
					'mime' => 'text/css',
					'media' => $media == 'all' ? NULL : $media,
					'attribs' => array()
					);
			}
		}
                $doc->_style = self::minifyCSSInline($doc->_style);
                
                $doc->_styleSheets =  $output;
	}

	/**
	 * Optimize javascript
	 * @param $tpl
	 * @return bool
	 */
	public static function optimizejs(){
		$outputpath = JPATH_ROOT . '/cache/jv/js';
		$outputurl = JURI::root(true) . '/cache/jv/js';

		if (!JFile::exists($outputpath)){
			JFolder::create($outputpath);
			@chmod($outputpath, 0755);
		}

		if (!is_writeable($outputpath)) {
			return false;
		}
                $doc = JFactory::getDocument();
		//======================= Group css ================= //
		$jsgroups = array();
		$scripts = array();
		foreach ($doc->_scripts as $url => $script) {

			$url = self::fixUrl($url);
                        $script['mime'] = 'text/javascript';

			if ($script['mime'] == 'text/javascript' && ($jspath = self::jsPath($url))) {
				$script['path'] = $jspath;
				$script['data'] = file_get_contents($jspath);
				$scripts[$url] = $script;

			} else {
				// first get all the stylsheets up to this point, and get them into
				// the items array
				if(count($scripts)){
					$jsgroup = array();
					$groupname = array();
					foreach ( $scripts as $gurl => $gsheet ) {
						$jsgroup[$gurl] = $gsheet;
						$groupname[] = $gurl;
					}

					$jsgroup['groupname'] = implode('', $groupname);
					$jsgroups[] = $jsgroup;
				}

				//mark ignore current script
				$jsgroup = array($url => $script, 'ignore' => true);
				$jsgroups[] = $jsgroup;
				$scripts = array(); // empty - begin a new group
			}
		}

		if(count($scripts)){
			$jsgroup = array();
			$groupname = array();
			foreach ( $scripts as $gurl => $gsheet ) {
				$jsgroup[$gurl] = $gsheet;
				$groupname[] = $gurl;
			}

			$jsgroup['groupname'] = implode('', $groupname);
			$jsgroups[] = $jsgroup;
		}

		//======================= Group js ================= //

		$output = array();
		foreach ($jsgroups as $jsgroup) {
			if(isset($jsgroup['ignore'])){

				unset($jsgroup['ignore']);
				foreach ($jsgroup as $furl => $fsheet) {
					$output[$furl] = $fsheet;
				}

			} else {

				$groupname = 'js-' . substr(md5($jsgroup['groupname']), 0, 5) . '.js';
				$groupfile = $outputpath . '/' . $groupname;
				$grouptime = JFile::exists($groupfile) ? @filemtime($groupfile) : -1;
				$rebuild = $grouptime < 0; //filemtime == -1 => rebuild

				unset($jsgroup['groupname']);
				foreach ($jsgroup as $furl => $fsheet) {
					if(!$rebuild && @filemtime($fsheet['path']) > $grouptime){
						$rebuild = true;
					}
				}

				if($rebuild){

					$jsdata = array();
					foreach ($jsgroup as $furl => $fsheet) {
						//$jsdata[] = "\*===============================";
						//$jsdata[] = $furl;
						//$jsdata[] = "===============================*/;";

						$jsmin    = $fsheet['data'];

						//already minify?
						if(!preg_match('@.*\.min\.js.*@', $furl)){
							$jsmin = self::minifyJs($fsheet['data']);
						}

						$jsdata[] = $jsmin.';';
					}

					$jsdata = implode("\n", $jsdata);
					if (!JFile::write($groupfile, $jsdata)) {
						// cannot write file, ignore optimize
						return false;
					}
					$grouptime = @filemtime($groupfile);
					@chmod($groupfile, 0644);
				}
				//.'?t='.($grouptime % 1000)
				$output[$outputurl . '/' . $groupname] = array(
					'mime' => 'text/javascript',
					'defer' => false,
					'async' => false
				);
			}
		}

                $doc->_script = self::minifyJSInline($doc->_script);
		//apply the change make change
		$doc->_scripts = $output;
	}
}

class JVMinify_HTML {
    /**
     * @var boolean
     */
    protected $_jsCleanComments = true;

    /**
     * "Minify" an HTML page
     *
     * @param string $html
     *
     * @param array $options
     *
     * 'cssMinifier' : (optional) callback function to process content of STYLE
     * elements.
     *
     * 'jsMinifier' : (optional) callback function to process content of SCRIPT
     * elements. Note: the type attribute is ignored.
     *
     * 'xhtml' : (optional boolean) should content be treated as XHTML1.0? If
     * unset, minify will sniff for an XHTML doctype.
     *
     * @return string
     */
    public static function minify($html, $options = array()) {
        $min = new self($html, $options);
        return $min->process();
    }


    /**
     * Create a minifier object
     *
     * @param string $html
     *
     * @param array $options
     *
     * 'cssMinifier' : (optional) callback function to process content of STYLE
     * elements.
     *
     * 'jsMinifier' : (optional) callback function to process content of SCRIPT
     * elements. Note: the type attribute is ignored.
     *
     * 'jsCleanComments' : (optional) whether to remove HTML comments beginning and end of script block
     *
     * 'xhtml' : (optional boolean) should content be treated as XHTML1.0? If
     * unset, minify will sniff for an XHTML doctype.
     */
    public function __construct($html, $options = array())
    {
        $this->_html = str_replace("\r\n", "\n", trim($html));
        if (isset($options['xhtml'])) {
            $this->_isXhtml = (bool)$options['xhtml'];
        }
        if (isset($options['cssMinifier'])) {
            $this->_cssMinifier = $options['cssMinifier'];
        }
        if (isset($options['jsMinifier'])) {
            $this->_jsMinifier = $options['jsMinifier'];
        }
        if (isset($options['jsCleanComments'])) {
            $this->_jsCleanComments = (bool)$options['jsCleanComments'];
        }
    }


    /**
     * Minify the markeup given in the constructor
     * 
     * @return string
     */
    public function process()
    {
        if ($this->_isXhtml === null) {
            $this->_isXhtml = (false !== strpos($this->_html, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML'));
        }
        
        $this->_replacementHash = 'MINIFYHTML' . md5($_SERVER['REQUEST_TIME']);
        $this->_placeholders = array();
        
        // replace SCRIPTs (and minify) with placeholders
        $this->_html = preg_replace_callback(
            '/(\\s*)<script(\\b[^>]*?>)([\\s\\S]*?)<\\/script>(\\s*)/i'
            ,array($this, '_removeScriptCB')
            ,$this->_html);
        
        // replace STYLEs (and minify) with placeholders
        $this->_html = preg_replace_callback(
            '/\\s*<style(\\b[^>]*>)([\\s\\S]*?)<\\/style>\\s*/i'
            ,array($this, '_removeStyleCB')
            ,$this->_html);
        
        // remove HTML comments (not containing IE conditional comments).
        $this->_html = preg_replace_callback(
            '/<!--([\\s\\S]*?)-->/'
            ,array($this, '_commentCB')
            ,$this->_html);
        
        // replace PREs with placeholders
        $this->_html = preg_replace_callback('/\\s*<pre(\\b[^>]*?>[\\s\\S]*?<\\/pre>)\\s*/i'
            ,array($this, '_removePreCB')
            ,$this->_html);
        
        // replace TEXTAREAs with placeholders
        $this->_html = preg_replace_callback(
            '/\\s*<textarea(\\b[^>]*?>[\\s\\S]*?<\\/textarea>)\\s*/i'
            ,array($this, '_removeTextareaCB')
            ,$this->_html);
        
        // trim each line.
        // @todo take into account attribute values that span multiple lines.
        $this->_html = preg_replace('/^\\s+|\\s+$/m', '', $this->_html);
        
        // remove ws around block/undisplayed elements
        $this->_html = preg_replace('/\\s+(<\\/?(?:area|base(?:font)?|blockquote|body'
            .'|caption|center|col(?:group)?|dd|dir|div|dl|dt|fieldset|form'
            .'|frame(?:set)?|h[1-6]|head|hr|html|legend|li|link|map|menu|meta'
            .'|ol|opt(?:group|ion)|p|param|t(?:able|body|head|d|h||r|foot|itle)'
            .'|ul)\\b[^>]*>)/i', '$1', $this->_html);
        
        // remove ws outside of all elements
        $this->_html = preg_replace(
            '/>(\\s(?:\\s*))?([^<]+)(\\s(?:\s*))?</'
            ,'>$1$2$3<'
            ,$this->_html);
        
        // use newlines before 1st attribute in open tags (to limit line lengths)
        $this->_html = preg_replace('/(<[a-z\\-]+)\\s+([^>]+>)/i', "$1\n$2", $this->_html);
        
        // fill placeholders
        $this->_html = str_replace(
            array_keys($this->_placeholders)
            ,array_values($this->_placeholders)
            ,$this->_html
        );
        // issue 229: multi-pass to catch scripts that didn't get replaced in textareas
        $this->_html = str_replace(
            array_keys($this->_placeholders)
            ,array_values($this->_placeholders)
            ,$this->_html
        );
        return $this->_html;
    }
    
    protected function _commentCB($m)
    {
        return (0 === strpos($m[1], '[') || false !== strpos($m[1], '<!['))
            ? $m[0]
            : '';
    }
    
    protected function _reservePlace($content)
    {
        $placeholder = '%' . $this->_replacementHash . count($this->_placeholders) . '%';
        $this->_placeholders[$placeholder] = $content;
        return $placeholder;
    }

    protected $_isXhtml = null;
    protected $_replacementHash = null;
    protected $_placeholders = array();
    protected $_cssMinifier = null;
    protected $_jsMinifier = null;

    protected function _removePreCB($m)
    {
        return $this->_reservePlace("<pre{$m[1]}");
    }
    
    protected function _removeTextareaCB($m)
    {
        return $this->_reservePlace("<textarea{$m[1]}");
    }

    protected function _removeStyleCB($m)
    {
        $openStyle = "<style{$m[1]}";
        $css = $m[2];
        // remove HTML comments
        $css = preg_replace('/(?:^\\s*<!--|-->\\s*$)/', '', $css);
        
        // remove CDATA section markers
        $css = $this->_removeCdata($css);
        
        // minify
        $minifier = $this->_cssMinifier
            ? $this->_cssMinifier
            : 'trim';
        $css = call_user_func($minifier, $css);
        
        return $this->_reservePlace($this->_needsCdata($css)
            ? "{$openStyle}/*<![CDATA[*/{$css}/*]]>*/</style>"
            : "{$openStyle}{$css}</style>"
        );
    }

    protected function _removeScriptCB($m)
    {
        $openScript = "<script{$m[2]}";
        $js = $m[3];
        
        // whitespace surrounding? preserve at least one space
        $ws1 = ($m[1] === '') ? '' : ' ';
        $ws2 = ($m[4] === '') ? '' : ' ';

        // remove HTML comments (and ending "//" if present)
        if ($this->_jsCleanComments) {
            $js = preg_replace('/(?:^\\s*<!--\\s*|\\s*(?:\\/\\/)?\\s*-->\\s*$)/', '', $js);
        }

        // remove CDATA section markers
        $js = $this->_removeCdata($js);
        
        // minify
        $minifier = $this->_jsMinifier
            ? $this->_jsMinifier
            : 'trim';
        $js = call_user_func($minifier, $js);
        
        return $this->_reservePlace($this->_needsCdata($js)
            ? "{$ws1}{$openScript}/*<![CDATA[*/{$js}/*]]>*/</script>{$ws2}"
            : "{$ws1}{$openScript}{$js}</script>{$ws2}"
        );
    }

    protected function _removeCdata($str)
    {
        return (false !== strpos($str, '<![CDATA['))
            ? str_replace(array('<![CDATA[', ']]>'), '', $str)
            : $str;
    }
    
    protected function _needsCdata($str)
    {
        return ($this->_isXhtml && preg_match('/(?:[<&]|\\-\\-|\\]\\]>)/', $str));
    }
}