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

class JVFrameworkHelperPath extends JVFrameworkHelper {
	protected static $paths = array ();
	protected $_name = 'path';
        protected static $srcurl = null;

        public function addPath($newpath = array(), $type = 'layouts') {
		if (! isset ( self::$paths [$type] )) {
			self::$paths [$type] = array ();
		}

		$paths = &self::$paths [$type];
		settype ( $newpath, 'array' );

		foreach ( $newpath as $path ) {
			if (! in_array ( $path, $paths ) && $path) {
				array_unshift ( $paths, trim ( $path ) );
			}
		}

		return $paths;
	}

	public function findPath($file, $type = 'layouts') {
		if (strpos($file, '::')){
			list ( $type, $file ) = explode ( '::', $file );			
		}
		if (! isset ( self::$paths [$type] )) {
			self::$paths [$type] = array ();
		}
                $paths = &self::$paths [$type];
		return JPath::find ( $paths, $file );
	}
	
	public function write($file, $content) {
		if (strpos($file, '::')){
			list ( $type, $file ) = explode ( '::', $file );
		}		
		$path = current($this->getPath($type));
		
		if($path){
			$path = $path.'/'.$file;
			JFile::write($path, $content);
			
			return $path;
		}
		
		return false;
	}
	
	public function read($file) {	
		$path = $this->findPath($file);
		
		if($path)
			return JFile::read($path);
		
		return false;
	}
	
	public function remove($file) {
		$path = $this->findPath($file);
	
		if($path)
			return JFile::delete($path);
	
		return false;
	}
	
	public function getPath($type) {
		return $this->addPath('', $type);
	}
	
	public function url($file, $type = 'layouts') {
		$path = $this->findPath($file, $type);
		if(!$path){
			return false;
		}
		
		return $this->toURL($path);
	}
	
	public function toURL($path) {
		$path = str_replace(JPATH_ROOT.DIRECTORY_SEPARATOR, '', str_replace('/', DIRECTORY_SEPARATOR, $path));
		$url = str_replace(DIRECTORY_SEPARATOR, '/', $path);
		
		return JURI::root(true) .'/'. $url;
	}
	
	public function getUrl($type) {
		return $this->toURL($this->getPath($type));
	}

        
        public function urlLess($file, $theme){
            $less = $this->findPath('less::' . $file. '.less');
            if(!$less) $less = $this->findPath('less.core::' . $file. '.less');
            if(!$less) $less = $this->findPath($theme .'/' . $file. '.less');
            if($less) return $this->getRelPath ($less);
            return false;
        }

        public function getRelPath($file){
            $rel_path = str_replace(JPATH_ROOT, '', $file);
            return str_replace('\\','/', ltrim($rel_path, '/\\'));
        }



        public function getAllPath($file, $type, $relative = false)
	{
            $return = array();
            $path = $this->findPath($file, $type);
            $relpath = $this->getRelPath($path);
            if (file_exists($path)) $return[] = ($relative ? $relpath : $path);
            return $return;
	}
        
        public function cleanPath($path)
	{

		$dirs = explode('/', rtrim(preg_replace('#^(\./)+#', '', $path), '/'));

		$offset = 0;
		$sub = 0;
		$subOffset = 0;
		$root = '';

		if (empty($dirs[0])) {
			$root = '/';
			$dirs = array_splice($dirs, 1);
		}

		$newDirs = array();
		foreach ($dirs as $dir) {
			if ($dir !== '..') {
				$subOffset--;
				$newDirs[++$offset] = $dir;
			} else {
				$subOffset++;
				if (--$offset < 0) {
					$offset = 0;
					if ($subOffset > $sub) {
						$sub++;
					}
				}
			}
		}

		if (empty($root)) {
			$root = str_repeat('../', $sub);
		}

		return $root . implode('/', array_slice($newDirs, 0, $offset));
	}

	public function relativePath($path1, $path2 = '')
	{
		// config params
		if ($path2 == '') {
			$path2 = $path1;
			$path1 = getcwd();
		}

		// absolute path 		//has protocol						//data protocol
		if ($path2[0] === '/' || strpos($path2, '://') !== false || strpos($path2, 'data:') === 0) {
			return $path2;
		}

		//Remove starting, ending, and double / in paths
		$path1 = trim($path1, '/');
		$path2 = trim($path2, '/');
		while (substr_count($path1, '//')) $path1 = str_replace('//', '/', $path1);
		while (substr_count($path2, '//')) $path2 = str_replace('//', '/', $path2);

		//create arrays
		$arr1 = explode('/', $path1);
		if ($arr1 == array('')) $arr1 = array();
		$arr2 = explode('/', $path2);
		if ($arr2 == array('')) $arr2 = array();
		$size1 = count($arr1);
		$size2 = count($arr2);

		//now the hard part :-p
		$path = '';
		for ($i = 0; $i < min($size1, $size2); $i++) {
			if ($arr1[$i] == $arr2[$i]) continue;
			else $path = '../' . $path . $arr2[$i] . '/';
		}
		if ($size1 > $size2)
			for ($i = $size2; $i < $size1; $i++)
				$path = '../' . $path;
		else if ($size2 > $size1)
			for ($i = $size1; $i < $size2; $i++)
				$path .= $arr2[$i] . '/';

		return rtrim($path, '/');
	}

	public function updateUrl($css, $src)
	{
                
		self::$srcurl = rtrim($src, '/');

		$css = preg_replace_callback('/@import\\s+([\'"])(.*?)[\'"]/', array($this, 'replaceurl'), $css);
		$css = preg_replace_callback('/url\\(\\s*([^\\)\\s]+)\\s*\\)/', array($this, 'replaceurl'), $css);

		return $css;
	}

	public function replaceurl($matches)
	{
		$isImport = ($matches[0][0] === '@');
		// determine URI and the quote character (if any)
		if ($isImport) {
			$quoteChar = $matches[1];
			$uri = $matches[2];
		} else {
			// $matches[1] is either quoted or not
			$quoteChar = ($matches[1][0] === "'" || $matches[1][0] === '"')
				? $matches[1][0]
				: '';
			$uri = ($quoteChar === '')
				? $matches[1]
				: substr($matches[1], 1, strlen($matches[1]) - 2);
		}

		// root-relative       protocol (non-data)             data protocol
		if ($uri[0] !== '/' && strpos($uri, '://') === false && strpos($uri, 'data:') !== 0) {
			$uri = self::cleanPath(self::$srcurl . '/' . $uri);
		}

		return $isImport
			? "@import {$quoteChar}{$uri}{$quoteChar}"
			: "url({$quoteChar}{$uri}{$quoteChar})";
	}
        
}