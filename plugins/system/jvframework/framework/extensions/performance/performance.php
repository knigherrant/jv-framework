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

class JVFrameworkExtensionPerformance extends JVFrameworkExtension{
    public static $scriptName;
    public static $styleName;

    public function onAfterRoute(){
        if(JFactory::getApplication()->isAdmin()) return;
        if(JFactory::getApplication()->input->get('fleximg')){
            die($this->fleximg());
        }

        if(JFactory::getApplication()->input->get('minify')) return $this->compress(JFactory::getApplication()->input->get('minify', '', 'raw'));
    }

	public function afterRender(){
		if(JFactory::getApplication()->input->get('fleximg')) return;
		if($this['option']->get('global.fleximage.enable')){
			$this['asset']->jQuery();
			$this['asset']->addScript($this['path']->url('extensions::performance/assets/js/jquery.lazyload.js'));
			$this['asset']->addScript($this['path']->url('extensions::performance/assets/js/image.js'));
		}

		$desable = $minify = array();
		$doc    = JFactory::getDocument();
		if ($this['option']->get('global.compress.css') && $desable) {
			$filename  = $this->createFileName('css');
			$cfilename = $this->createFileName('css', true);
                        $listCSS = $cssx = array();
                        foreach($this['asset']->get ( 'stylesheet' ) as $key=>$value){
                            if($value['media']) $cssx[$key] = $value;
                        }
			if($this->isExpire($cfilename)){
				if($this->isExpire($filename)){
					//Get Stylesheets From Head
					$headStylesheet = $this ['asset']->join($doc->_styleSheets, 'stylesheet');
					foreach ($doc->_style as $style){
						$this['asset']->addInlineStyle($style);
					}
					// Reorder Stylesheet
					$this ['asset']->reverse(array('stylesheet'));

                                         foreach($this['asset']->get ( 'stylesheet' ) as $key=>$value){
                                            if(!$value['media']) $listCSS[$key] = $value;
                                        }

                                        //$this['asset']->get ( 'stylesheet' ) = $listCSS;
					$css = $this['asset']->join ( $listCSS ).implode ( '', $this['asset']->get ( 'inlinestyle' ) );
					$this->write ( $filename, $headStylesheet.$css);
				}
				// Reset style
				$this ['asset']->reset (array('stylesheet', 'inlinestyle'));
				$minify['style'] = $filename;
			}else{
				// Reset style
				$this ['asset']->reset (array('stylesheet', 'inlinestyle'));
				$defer = false;
			}

			// Reset document
			$doc->_styleSheets = array(); 
			$doc->_style = array();

			$link = $this['path']->url('theme::min').'/?f='.$this['path']->url('caches::jv/'.$filename);
			$this ['asset']->addStyle($link);
                        if($cssx) foreach($cssx as $f=>$m){
                            $this ['asset']->addStyle($f,$m);
                        }
		}

		if ($this['option']->get('global.compress.js') && $desable) {
			$filename = $this->createFileName('js');
			$cfilename = $this->createFileName('js', true);

			if($this->isExpire($cfilename)){
				if($this->isExpire($filename)){
					// Load phpQuery class
					JVFrameworkLoader::import('classes.phpQuery');

					// Get script from component
					$buffer    = $doc->getBuffer('component');
					$component = phpQuery::newDocumentHTML($buffer);
					foreach (pq('script') as $script){
						$doc->addScriptDeclaration(pq($script)->html());
						pq($script)->remove();
					}
					$doc->setBuffer($component->htmlOuter(), array('type' => 'component', 'name' => '', 'title' => ''));

					// Get Script From Head
					$headScript = $this ['asset']->join($doc->_scripts, 'script');

					foreach ($doc->_script as $script){
						$this['asset']->addInlineScript($script);
					}

					// Reorder Script
					$this ['asset']->reverse(array('script'));

					// Compress JS
					$js = $this['asset']->join ( $this['asset']->get ( 'script' ), 'script' ).implode ( '', $this['asset']->get ( 'inlinescript' ) );

					$this->write ( $filename, $headScript.$js);
				}
				// Reset script
				$this ['asset']->reset(array('script', 'inlinescript'));
                $minify['script'] = $filename;
				$this ['asset']->addScript($this['path']->url('caches::jv/'.$filename));
			}else{
				// Reset script
				$this ['asset']->reset(array('script', 'inlinescript'));
				$link = $this['path']->url('theme::min').'/?f='.$this['path']->url('caches::jv/'.$filename);
				// Add script
				if ($this['option']->get('global.compress.deferload') && !$minify) {
					$this ['asset']->deferLoading($link);
				}else{
					$this ['asset']->addScript($link);
				}
			}

			// Minify
			if(count($minify))
				$this['asset']->addInlineScript(";window.addEvent('domready', function(){ new Request({ url: '".JURI::getInstance()."', data : {minify: '".json_encode($minify)."'} }).send();})");

			// Reset document
			$doc->_scripts = array();
			$doc->_script = array();
		}

		if($this['option']->get('global.compress.gzip')){
			$this['option']->setConfig('gzip', 1);
		}
	}

     
        
	protected function compress($minify){ 
        $minify = json_decode(stripcslashes($minify));
        foreach($minify as $filename){
            $link    = $_SERVER['SERVER_NAME'].$this['path']->url('theme::min').'/?f='.$this['path']->url('caches::jv/'.$filename);
            $content = $this->curl_download($link);

            if($content){
                $this->write ( $filename.'.php', '');
            }
        }
		exit();
	}

	protected function write($filename, $content) {
		$html = $this['path']->findPath('caches::jv/index.html');
		if(!is_file($html)){
			$html = '<html><body></body></html>';
			$this['path']->write('caches::jv/index.html', $html);
		}

		// Write cache file
		$this['path']->write("caches::jv/{$filename}", $content);

		// Expire time
		$time = time () + 60 * $this['option']->get('global.compress.expires_time', '1440');

		// Write expire file
		$this['path']->write("caches::jv/{$filename}.expire", $time);

		return true;
	}

	protected function createFileName($type, $compress = false){
		if($type == 'css'){
            if(!self::$styleName){
                self::$styleName = md5 ( 'css_'.JURI::getInstance().$this['asset']->getAssetName() ) . '.css';
            }
            if($compress){
                return self::$styleName.'.php';
            }
            return self::$styleName;

        }else{
            if(!self::$scriptName){
                self::$scriptName = md5 ( 'js_'.JURI::getInstance().$this['asset']->getAssetName('script') ) . '.js';
            }
            if($compress){
                return self::$scriptName.'.php';
            }
            return self::$scriptName;
        }
	}

	protected function isExpire($filename){
		$content = $this['path']->read("caches::jv/{$filename}.expire");

		if(time () >= (int) $content){
			// Remove old cache
			$this['path']->remove("caches::jv/{$filename}");
			$this['path']->remove("caches::jv/{$filename}.expire");

			return true;
		}

		return false;
	}

	public function onAfterRender(){
		if(!$this['option']->get('global.fleximage.enable')) return;
		if(JFactory::getApplication()->isAdmin()) return;

        // CSS selector to apply
        $selector = $this['option']->get('global.fleximage.selector');
        if(!$selector){
            return;
        }
		// Load phpQuery class
		JVFrameworkLoader::import('classes.phpQuery');

		// Find all images
		$doc = phpQuery::newDocumentHTML(JResponse::getBody());
		$images = pq($selector);

		foreach ( $images as $node ) {
			$src = pq($node)->attr('src');

            $replace = JURI::base(true).'/';
            if(strpos($src, $replace) === 0){
                $src = substr($src, strlen($replace));
            }
            //  Image size
            $imgSize = @getimagesize ($src);

            if (is_array($imgSize)){
                if(!preg_match('#http(s?):\/\/#', $src) && $src){
                    $fximages = $this['option']->get('global.fleximage');
                    $size = $excludes = array();
                    $isExclude = false;

                    foreach ($fximages as $key => $option){
                        if(is_object($fximages)){
                            if(is_object($option) && $option->enable){
                                $size[$key] = $option;

                                if($option->exclude){
                                    $excludes = explode("\n", $option->exclude);
                                    foreach ($excludes as $exclude){
                                        list($min, $max) = explode('-', $exclude);
                                        if($min <= $imgSize[0] && $imgSize[0] <= $max){
                                            $isExclude = true;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if(!$isExclude){
                        pq($node)->removeAttr('border')->after(pq('<noscript/>')->append(pq($node)->clone()));
                        pq($node)->addClass('fleximg hidden')->attr('data-url', base64_encode($src).'')->attr('src', $this['path']->url('extensions::performance/assets/images/ajax-loader.gif'));
                    }
                }
            }
		}

		// Replace self closing tag
		$unary = '/<(area|base|basefont|br|col|frame|hr|img|input|isindex|link|meta|param)(?(?=\s)([^>]+))>/i';
		JResponse::setBody(preg_replace($unary, '<$1$2 />', $doc->html()));
	}

	public function resize($img, $option){
        if(!$option->enable) return $img;
		if(!class_exists('PhpThumbFactory')){
			require_once $this['path']->findPath('classes::images/ThumbLib.inc.php');
		}

        // Fileinfo
        $info = pathinfo($img);
		$imgSize = getimagesize ($img);
		if (!is_array($imgSize)){
			return $img;
		}

		$width = round(($imgSize[0] * ((int)$option->width / 100)));
		$heigh = round(($imgSize[1] * ((int)$option->width / 100)));

		if($width < $option->min_width && $imgSize[0] > $option->min_width){
			$ratio = $option->min_width/$imgSize[0];
			$heigh = round($imgSize[1] * $ratio);
			$width = $option->min_width;
		}

		// Resize path
		$path = JPATH_ROOT."/cache/jv/resized/{$width}_{$info['filename']}.{$info['extension']}";

		if(!is_dir(dirname($path))){
			JFolder::create(dirname($path));
		}

		if(!is_file($path)){
			// Resize
			$thumb = new GdThumb($img, array('jpegQuality' => isset($option->quality) ? $option->quality : 100));
			$thumb->adaptiveResize($width, $heigh);
			$thumb->save($path, $info['extension']);
		}

		return $path;
	}

	protected function fleximg() {
		// get window width
		$browser_width =JFactory::getApplication()->input->get('s');

		// Image src
		$src = base64_decode(JFactory::getApplication()->input->get('src'));

		// Fleximage option
		$fximages = $this['option']->get('global.fleximage');

		// Supported screen
		$sizes = array(480,768,980,1200,1900); // 1100
		foreach ($sizes as $size){
			if($browser_width >= $size){
				$width = $fximages->{$size};
				$width->screen = $size;
			}
		}

        if(isset($width))
            $imgPath = $this['cache']->cache()->call(array($this, 'resize'), $src, $width);
        else
            $imgPath = $this['cache']->cache()->call(array($this, 'resize'), $src, $fximages->{480});

        $this->displayGraphicFile($imgPath);
	}


	/**
	 * Add Cache Setting
	 *
	 * @param string $content
	 *        	content to add code.
	 * @param string $type
	 *        	content type
	 * @access public
	 * @return string content.
	 */
	protected function addCacheSetting($content, $type = 'css') {
	$type = ($type == 'css') ? 'text/css' : 'text/javascript';
		ob_start();?>
		ob_start ("ob_gzhandler");header("Content-type: <?php echo $type ?>; charset: UTF-8");header("Cache-Control: must-revalidate"); header("Expires: " . gmdate("D, d M Y H:i:s", time() + (60 * <?php echo $this['option']->get('global.compress.expires_time', '1440'); ?>)) . " GMT"); header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()) . " GMT"); header("ETag: \'3e86-410-3596fbbc\'");<?php
		$option = ob_get_clean();

		return "<?php {$option} ?>" . $content;
	}

	public function curl_download($Url){

		// is cURL installed yet?
		if (!function_exists('curl_init')){
			die('Sorry cURL is not installed!');
		}

		// OK cool - then let's create a new cURL resource handle
		$ch = curl_init();

		// Now set some options (most are optional)

		// Set URL to download
		curl_setopt($ch, CURLOPT_URL, $Url);

		// Set a referer
		curl_setopt($ch, CURLOPT_REFERER, JURI::base());

		// User agent
		curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");

		// Include header in result? (0 = yes, 1 = no)
		curl_setopt($ch, CURLOPT_HEADER, 0);

		// Should cURL return or print out the data? (true = return, false = print)
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Timeout in seconds
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		// Download the given URL, and return output
		$output = curl_exec($ch);

		// Close the cURL resource, and free system resources
		curl_close($ch);

		return $output;
	}

	function displayGraphicFile ($graphicFileName) {
		$fileModTime = gmdate('D, d M Y H:i:s', filemtime($graphicFileName)).' GMT';

		// Getting headers sent by the client.
		$headers = $this->getRequestHeaders();

		// Checking if the client is validating his cache and if it is current.
		if ( isset($headers['If-Modified-Since']) && ($headers['If-Modified-Since'] == $fileModTime)) {
		// Client's cache IS current, so we just respond '304 Not Modified'.
			header('Last-Modified: '.$fileModTime, true, 304);
		} else {
			$fileType = getimagesize($graphicFileName);
			// Image not cached or cache outdated, we respond '200 OK' and output the image.
			header('Last-Modified: '.$fileModTime, true, 200);
			header('Content-type: '.$fileType['mime']);
			header('Content-transfer-encoding: binary');
			header('Content-length: '.filesize($graphicFileName));
			header("Cache-Control: must-revalidate");
			header("Expires: " . gmdate("D, d M Y H:i:s", time() + (60 * 1440)) . " GMT");

			echo readfile($graphicFileName); die;
		}
	}

	function getRequestHeaders() {
		if (function_exists("apache_request_headers")) {
			if($headers = apache_request_headers()) {
				return $headers;

			}
		}
		$headers = array();
		// Grab the IF_MODIFIED_SINCE header
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			$headers['If-Modified-Since'] = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
		}
		return $headers;
	}
}

