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
  jimport('joomla.filesystem.file');
  jimport('joomla.filesystem.folder');

class JVFrameworkHelperLessc extends JVFrameworkHelper {
    protected $_name            = 'lessc';
    public $tmp_real_path    = null;
    public $path_root         = null;
    public $tmp_path_less    = null;
    public $color            = null;
    public $isRTL              = null;
    public $lessc            = null;
    public $csspath            = null;
    public $fwless            = null;
	public $coreless            = null;
    
    static $kfilepath    = 'less-file-path';
    static $kvarsep      = 'less-content-separator';
    static $krtlsep      = 'rtl-less-content';
    static $rsplitbegin  = '@^\s*\#';
    static $rsplitend    = '[^\s]*?\s*{\s*[\r\n]*\s*content:\s*"([^"]*)";\s*[\r\n]*\s*}[\r\n]*@im';
    static $rswitchrtl   = '@/less/(colors/[^/]*/)?@';
    static $rcomment     = '@/\*[^*]*\*+([^/][^*]*\*+)*/@';
    static $rspace       = '@[\r?\n]{2,}@';
    static $rimport      = '@^\s*\@import\s+"([^"]*)"\s*;@im';
    static $rimportvars  = '@^\s*\@import\s+".*(variables-custom|variables|vars|mixins)\.less"\s*;@im';
    static $_path = null;
    
    
    public function __construct(){
        parent::__construct();
        if(!class_exists('Less_Parser')){
            require_once JV::_('path.findPath', 'classes::lessphp/less/Less.php');
        }
		$tmpl = JV::helper('template');
		$templates = end($tmpl::$_template);
		if(!$templates) $templates = JFactory::getApplication()->getTemplate(true); //fornt end
		
        $this->tmp_real_path  = 'templates/' . $templates->template;
        $this->tmp_path_less = $this->tmp_real_path . '/less';
        $this->path_root = str_replace('\\','/',JPATH_ROOT);
        
        $name = md5 ( $templates->template . $templates->id . $templates->home );
        if(isset( $_COOKIE ['style'] [$name] ['themecolor'] )) $this->color = $_COOKIE ['style'] [$name] ['themecolor'];
        else $this->color = JV::helper('option')->get ( 'styles.themecolor' );
        $this->isRTL = JV::helper('option')->isRTL();
        $this->csspath = $this->tmp_real_path . '/css';
		
		/* path core */
        $basetheme = JV::helper('path')->getPath ( 'basetheme' );
		$basetheme = str_replace('\\','/',end($basetheme));
        $this->coreless =  $basetheme . '/less';
        $this->fwless = ltrim(JV::helper('path')->toURL($this->coreless), '\//');
		$this->tmp_real_path_core = ltrim(str_replace ($this->path_root , '' , $basetheme), '\//');
		$this->path_theme['core'] = $this->tmp_real_path_core;
		$this->path_theme['theme'] = $this->tmp_real_path;
		$this->csspath_core = $this->tmp_real_path_core . '/css';
    }


    public function compile($source, $importdirs){
        $parser = new Less_Parser();
        $parser->SetImportDirs($importdirs);
        $parser->parse($source);
        $output = $parser->getCss();
        return $output;
    }
    
	
	 public function getFiels($fullpath) {
		$files = array();
		foreach ($fullpath as $path){
			$files    = array_merge($files ,JFolder::files($path, '.less', true, true, array('.svn', 'CVS', '.DS_Store', '__MACOSX')));
		}
        return $files;
    }
	
	
    public function compileAll(){
		$fullpath['core'] =  $this->coreless;
        $fullpath['theme'] = $this->path_root . '/' . $this->tmp_path_less;
        $lessFiles = $this->getFiels($fullpath);
        $lessContent  = '';
        $relLessFiles = $files = array();
		
        foreach ($lessFiles as $f){
            $lessContent .= JFile::read($f) . "\n";
			foreach ($fullpath as $k=>$path){
				if(strpos($f,$path) !== false) $relLessFiles[$k][] = ltrim(str_replace($path, '', $f), '/\\');
				else{
					$path = str_replace('/', '\\', $path);
					if(strpos($f,$path) !== false) $relLessFiles[$k][] = ltrim(str_replace($path, '', $f), '/\\');
				}
			}
            
        }   
        $lessFiles = $relLessFiles;
		
        if (preg_match_all('#^\s*@import\s+"([^"]*)"#im', $lessContent, $matches)) {
                foreach ($lessFiles as $type=>$ff) {
					foreach ($ff as $f){
                        if (!in_array($f, $matches[1])) {
                                $files[$type][] = substr($f, 0, -5);
                        }
					}
                }
        }

		
        $this->buildVars($this->color, ($this->isRTL)? 'rtl' : 'ltr');
		$error = array('infographic');
        foreach ($files as $type=>$file) {
			foreach ($file as $f){
				if(!in_array($f, $error)){
					$this->compileCss($this->path_theme[$type] . '/less/' . $f . '.less',  $this->path_theme[$type] . '/css/' . $f . '.css');
					//$this->compileCss($this->tmp_path_less . '/' . $f . '.less',  $this->csspath . '/' . $f . '.css');
				}
			}
        }

    }
    
    public function compileCss($path, $topath = '', $split = false, $list = null ) {

        $fromdir = dirname($path);
        if (empty ($list)) $list = $this->parse($path);

        if (empty ($list)) return false;
        $content = '';
        $importdirs = array();
        $todir = $topath ? dirname($topath) : $fromdir;
        if (!is_dir($this->path_root . '/' . $todir)) {
                JFolder::create($this->path_root . '/' . $todir);
        }
        $importdirs[$this->path_root . '/' . $fromdir] = './';
        foreach ($list as $f => $import) {
                if ($import) {
                        $importdirs[$this->path_root . '/' . dirname($f)] = $this->relativePath($fromdir, dirname($f));
                        $content .= "\n#".self::$kfilepath."{content: \"{$f}\";}\n";
                        if (is_file($this->path_root . '/' . $f)) {
                                $less_content = file_get_contents($this->path_root . '/' . $f);
                                // remove vars/mixins for template & jvfw less
                                if (preg_match ('@'.preg_quote($this->tmp_real_path, '@') . '/less/@i', $f) || preg_match ('@'.preg_quote($this->fwless, '@') . '/less/@i', $f)) {
                                        $less_content = preg_replace(self::$rimportvars, '', $less_content);
                                }
                                self::$_path = JV::helper('path')->relativePath($fromdir, dirname($f)) . '/';
                                $less_content = preg_replace_callback(self::$rimport, array($this, 'cb_import_path'), $less_content);
                                $content .= $less_content;
                        }else{
                            $content .= '#--------------FILE DOSE NOT EXISTS-------------------';
                        }
                } else {
                        $content .= "\n#".self::$kfilepath."{content: \"{$path}\";}\n";
                        $content .= $f . "\n\n";
                }
        }
        $vars_files = explode('|', $this->getVars('jvurls'));
        // build source
        $source = '';
        // build import vars
        foreach ($vars_files as $var) {
                $vars_path = JV::helper('path')->relativePath($fromdir, dirname($var));
                if ($vars_path) $vars_path .= "/";
                $importdirs[$this->path_root . '/' . dirname($var)] = $vars_path;
                $var_file = $vars_path . basename($var);
                $source .= "@import \"" . $var_file . "\";\n";
        }
        // less content
        $source .= "\n#" . self::$kvarsep . "{content: \"separator\";}\n" . $content;

        
        
        $output = $this->compile($source, $importdirs);

        //remove comments and clean up
        $output = preg_replace(self::$rcomment, '', $output);
        $output = preg_replace(self::$rspace, "\n\n", $output);

        // update url for output
        $file_contents = $this->updateUrl ($output, $path, $todir);

        if ($topath) {
                JFile::write($this->path_root . '/' . $topath, $file_contents);
        } else {
                return $output;
        }
        // write to path
        return true;
        
                
    }

    /**
	 * Compile LESS to CSS
	 * @param   $path   the less file to compile
	 * @return  string  url to css file
	 */
	public function buildCss ($path, $attribute, $return = false) {
                $this->buildVarsOnce();
            
		$rtpl_check		= '@'.preg_quote($this->tmp_real_path, '@') . '/@i';
		$rtpl_less_check		= '@'.preg_quote($this->tmp_real_path, '@') . '/less/@i';

		$app     = JFactory::getApplication();

		$ie8 = preg_match('/MSIE 8\./', $_SERVER['HTTP_USER_AGENT']);

		// get css cached file
		//$subdir  = ($this->isRTL ? 'rtl/' : '') . ($this->color ? $this->color . '/' : '');
                $subdir = '';
                //jf($subdir);
		//$cssdir  = T3_DEV_FOLDER . ($ie8 ? '/ie8' : '') . '/' . $subdir;
                $cssdir  = $this->tmp_real_path . '/dev/' . $subdir;
		$cssfile = $cssdir . str_replace('/', '.', $path) . '.css';

		// modified time
		$less_lm = @filemtime ($this->path_root . '/' . $path);
		$css_lm = @filemtime ($cssfile);
		$vars_lm = $this->getState('vars_last_modified', 0);

                
                
		$list = $this->parse($path);
		if (empty ($list)) return false;

		// prepare output list
		//$split = !$ie8 && !$return && preg_match ($rtpl_less_check, $path) && !preg_match ('/bootstrap/', $path);
                $split = false;
		$output_files = array();
		foreach ($list as $f => $import) {
			if ($import) {
				$css = $cssdir . str_replace('/', '.', $f) . '.css';
				if ($split) $output_files[] = $css;
				$less_lm = max ($less_lm, @filemtime($this->path_root . '/' . $f));
				$css_lm = max ($css_lm, @filemtime($this->path_root . '/' . $css));
			}
		}

		// itself
		$output_files [] = $cssfile;
		// check modified
		$rebuild = $vars_lm > $css_lm || $less_lm > $css_lm;
		if ($rebuild) {
			if ($split) {
				$this->compileCss($path, $cssfile, true, $list);
			} else {
				$this->compileCss($path, $cssfile, false, $list);
			}
		}
                
		if (!$return) {
			// add css
			foreach ($output_files as $css) {
				$this['asset']->addStyle($css, $attribute);
			}
		} else {
			return $cssfile;
		}
	}
    
    
    
    public function cb_import_path ($match) {
            $f = $match[1];
            $newf = JV::helper('path')->cleanPath(self::$_path . $f);
            return str_replace($f, $newf, $match[0]);
    }
    
    
    public function parse($path) {
        $rtpl_check		= '@'.preg_quote($this->tmp_real_path, '@') . '/@i';

        $rtpl_less_check		= '@'.preg_quote($this->tmp_real_path, '@') . '/less/@i';
        $less_rel_path = preg_replace($rtpl_less_check, '', $path);
        $less_rel_dir = dirname($less_rel_path);
        $less_rel_dir = $less_rel_dir == '.' ? '' : $less_rel_dir . '/';
        // check path
        $realpath = realpath($this->path_root . '/' . $path);
        if (!is_file($realpath)) {
                return false;
        }
        // get file content
		
		
		
		
        $content = file_get_contents($realpath);

        //remove vars.less
        $content = preg_replace(self::$rimportvars, '', $content);
        // split into array, separated by the import
        $arr = preg_split(self::$rimport, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        $arr[] = $less_rel_path;
        $arr[] = '';

		
		
		
        $list = array();
        $rtl_list = array();
        $list[$path] = '';
        $import = false;
        
        foreach ($arr as $chunk) {
                if ($import) {
                        $import = false;
                        $import_url = JV::helper('path')->cleanPath($this->tmp_path_less.'/'.$less_rel_dir.$chunk);
                        // if $url in template, get all its overrides
                        if (preg_match ($rtpl_less_check, $import_url)) {
                                $less_rel_url = JV::helper('path')->cleanPath($less_rel_dir.$chunk);

								
                                $array = JV::helper('path')->getAllPath( $less_rel_url ,'less' , true);
                                if ($this->color) {
                                        $array = array_merge($array, JV::helper('path')->getAllPath('colors/'.$this->color.'/'.$less_rel_url, 'less' , true));
                                }
								
                                foreach ($array as $f) {
                                        // add file in template only
                                        if (preg_match ($rtpl_check, $f)) {
                                            
                                                $list [$f] = JV::helper('path')->relativePath(dirname($path), $f);
                                        }
                                }
                                // rtl overrides
                                if ($this->isRTL) {
                                        $array = JV::helper('path')->getAllPath('less/rtl/'.$less_rel_url, true);
                                        if ($this->color) {
                                                $array = array_merge($array, JV::helper('path')->getAllPath('less/rtl/colors/'.$this->color.'/'.$less_rel_url, true));
                                        }

                                        foreach ($array as $f) {
                                                // add file in template only
                                                if (preg_match ($rtpl_check, $f)) {
                                                        $rtl_list [$f] = JV::helper('path')->relativePath(dirname($path), $f);
                                                }
                                        }
                                }
                        } else {
                                $list [$import_url] = $chunk;
                                // rtl override
                                if ($this->isRTL) {
                                        $rtl_url = preg_replace ('/\/less\//', '/less/rtl/', $import_url);
                                        if (is_file(JPATH_ROOT.'/'.$rtl_url)) {
                                                $rtl_list [$rtl_url] = JV::helper('path')->relativePath(dirname($path), $rtl_url);
                                        }
                                }
                        }
                } else {
                        $import = true;
                        $list [$chunk] = false;
                }
            }
            // remove itself
            unset($list[$path]);
            // join rtl
            if ($this->isRTL) {
                    $list ["\n\n#" . self::$krtlsep . "{content: \"separator\";}\n\n"] = false;
                    $list = array_merge($list, $rtl_list);
            }
            return $list;
	}
    

   

    public static function relativePath($topath, $path, $default = null){
        $rel = JV::helper('path')->relativePath($topath, $path);
        return $rel ? $rel . '/' : './';
    }

    public function getVars($name = '') {
            return $this->getState('vars_' . ($name ? $name.'_' : '') . 'content');
    }

    /**
     * get value from cache
     */
    public static function getState ($key, $default = null) {
            $app = JFactory::getApplication();
            $keysfx = $app->getUserState('current_key_sufix');
            // cache key
            $ckey   = $key.$keysfx;
            /*
            $group = 'jvfw';
            $cache = JCache::getInstance('output', array(
                    'lifetime' => 25200,
                    'caching'	=> true,
                    'cachebase' => JPATH_ROOT.'/'
            ));

            // get cache
            $data  = $cache->get($ckey, $group);
             */
            return  $app->getUserState($ckey, $default);
    }

    
    /**
     * store value to cache
     */
    public static function setState ($key, $value) {
            $app = JFactory::getApplication();
            $keysfx = $app->getUserState('current_key_sufix');
            // cache key
            $ckey   = $key.$keysfx;
            /*
            $group = 't3';
            $cache = JCache::getInstance('output', array(
                    'lifetime' => 25200,
                    'caching'	=> true,
                    'cachebase' => JPATH_ROOT.'/'
            ));
             * 
             */
            //if (!$cache->store($value, $ckey, $group)) {
            $app->setUserState($ckey, $value);
            //}
    }
    
    
    
    public function updateUrl ($css, $path, $output_dir) {
        //update path and store to files
        $split_contents = preg_split(self::$rsplitbegin . self::$kfilepath . self::$rsplitend, $css, -1, PREG_SPLIT_DELIM_CAPTURE);
        $file_contents  = array();
        $file       		= $path;
        $isfile         = false;
        $output         = '';

        // split
        foreach ($split_contents as $chunk) {
                if ($isfile) {
                        $isfile  = false;
                        $file = $chunk;
                } else {
                        $content = JV::helper('path')->updateUrl (trim($chunk), JV::helper('path')->relativePath($output_dir, dirname($file)));
                        $file_contents[$file] = (isset($file_contents[$file]) ? $file_contents[$file] : '') . "\n" . $content . "\n\n";
                        $output .= $content . "\n";
                        $isfile = true;
                }
        }

        return trim($output);
    }
    
    
    public function buildVars($theme = null, $dir = null) {
        $app  = JFactory::getApplication();
        // detect RTL
        if ($dir === null) {
                $doc = JFactory::getDocument();
                $dir = $doc->direction;
        }
        $path = $this->path_root . '/' . $this->tmp_path_less . '/vars.less';
       
        if(!is_file($path)){
                echo JText::_('VARS LESS DOSE NOT EXISTS!');
                exit;
        }     
        
        $last_modified = filemtime($path);
        $vars_content          = file_get_contents($path);
        $vars_urls = array();
        preg_match_all('#^\s*@import\s+"([^"]*)"#im', $vars_content, $matches);
        if (count($matches[0])) {
                foreach ($matches[1] as $url) {
                        $path = JV::helper('path')->cleanPath($this->path_root . '/' . $this->tmp_path_less . '/' . $url);
                        if (file_exists($path)) {
                                $last_modified = max($last_modified, filemtime($path));
                                $vars_urls[] = JV::helper('path')->cleanPath($this->tmp_path_less . '/' . $url);
                        }
                }
        }

        // add override variables
        $paths = array();
        if ($this->color && $app->isSite()) {
            $paths[] = $this->tmp_path_less . "/colors/{$this->color}/variables.less";
            $paths[] = $this->tmp_path_less . "/colors/{$this->color}/variables-custom.less";
        }else{
            $colors = JFolder::folders($this->path_root . '/'. $this->tmp_real_path . '/css/colors/');
            if($colors) foreach ($colors as $color){
                $paths[] = $this->tmp_path_less . "/colors/{$color}/variables.less";
                $paths[] = $this->tmp_path_less . "/colors/{$color}/variables-custom.less";
            }
        }
        if ($dir == 'rtl') {
                //$paths[] = $this->tmp_path_less . "/rtl/variables.less";
        }

        foreach ($paths as $file) {
                if (is_file($this->path_root . '/' . $file)) {
                        $last_modified = max($last_modified, filemtime($this->path_root . '/' . $file));
                        $vars_urls[] = $file;
                }
        }

        if ($this->getState('vars_last_modified') != $last_modified) {
                $this->setState('vars_last_modified', $last_modified);
        }
        $this->setState('vars_jvurls_content', implode('|', $vars_urls));
    }
    
    /**
	 * Build vars only one per request
	 */
    public function buildVarsOnce(){
            // build less vars, once only
            static $vars_built = false;
            if (!$vars_built) {
                    $this->buildVars();
                    $vars_built = true;
            }
    }
    
}
