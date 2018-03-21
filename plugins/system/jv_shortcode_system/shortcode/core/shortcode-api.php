<?php
/**
 * Base on  WordPress API for creating bbcode like tags or what WordPress calls
 * "shortcodes." The tag and attribute parsing or regular expression code is
 * based on the Textpattern tag parser.
 * 
 *  A few examples are below:
 *
 * [shortcode /]
 * [shortcode foo="bar" baz="bing" /]
 * [shortcode foo="bar"]content[/shortcode]
 * 
 * To apply shortcode tags to content:
 *
 * <code>
 * $out = do_shortcode($content);
 * </code>
 *
 * @link http://codex.wordpress.org/Shortcode_API
 */
// no direct access
defined('_JEXEC') or die;
require_once dirname ( __FILE__ ) . '/../functions/shortcodes.php';
/**
 * Container for storing shortcode tags and their hook to call for the shortcode
 *
 * @name $shortcode_tags
 * @var array
 * @global array $shortcode_tags
 */
$shortcode_tags = array();

/**
 * Add hook for shortcode tag.
 * @uses $shortcode_tags
 * @param string $tag Shortcode tag to be searched in post content.
 * @param callable $func Hook to run when shortcode is found.
 */
function add_shortcode($tag, $func) {
	global $shortcode_tags;
	if ( is_callable($func) )
		$shortcode_tags[$tag] = $func;
}

/**
 * Removes hook for shortcode.
 *
 * @since 2.5
 * @uses $shortcode_tags
 *
 * @param string $tag shortcode tag to remove hook for.
 */
function remove_shortcode($tag) {
	global $shortcode_tags;

	unset($shortcode_tags[$tag]);
}

/**
 * Clear all shortcodes.
 * @uses $shortcode_tags
 */
function remove_all_shortcodes() {
	global $shortcode_tags;

	$shortcode_tags = array();
}

/**
 * Whether a registered shortcode exists named $tag
 *
 * @since 3.6.0
 *
 * @global array $shortcode_tags
 * @param string $tag
 * @return boolean
 */
function shortcode_exists( $tag ) {
	global $shortcode_tags;
	return array_key_exists( $tag, $shortcode_tags );
}

/**
 * Whether the passed content contains the specified shortcode
 *
 * @since 3.6.0
 *
 * @global array $shortcode_tags
 * @param string $tag
 * @return boolean
 */
function has_shortcode( $content, $tag ) {
	if ( shortcode_exists( $tag ) ) {
		preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );
		if ( empty( $matches ) )
			return false;

		foreach ( $matches as $shortcode ) {
			if ( $tag === $shortcode[2] )
				return true;
		}
	}
	return false;
}

/**
 * Search content for shortcodes and filter shortcodes through their hooks.
 *
 * If there are no shortcode tags defined, then the content will be returned
 * without any filtering. This might cause issues when plugins are disabled but
 * the shortcode will still show up in the post or content.
 *
 * @since 2.5
 * @uses $shortcode_tags
 * @uses get_shortcode_regex() Gets the search pattern for searching shortcodes.
 *
 * @param string $content Content to search for shortcodes
 * @return string Content with shortcodes filtered out.
 */
function do_shortcode($content) {
	global $shortcode_tags;
	if (empty($shortcode_tags) || !is_array($shortcode_tags)){
		return $content;
	}
	$pattern = get_shortcode_regex();
	return preg_replace_callback( "/$pattern/s", 'do_shortcode_tag', $content );
}

/**
 * Retrieve the shortcode regular expression for searching.
 *
 * The regular expression combines the shortcode tags in the regular expression
 * in a regex class.
 *
 * The regular expression contains 6 different sub matches to help with parsing.
 *
 * 1 - An extra [ to allow for escaping shortcodes with double [[]]
 * 2 - The shortcode name
 * 3 - The shortcode argument list
 * 4 - The self closing /
 * 5 - The content of a shortcode when it wraps some content.
 * 6 - An extra ] to allow for escaping shortcodes with double [[]]
 *
 * @since 2.5
 * @uses $shortcode_tags
 *
 * @return string The shortcode search regular expression
 */
function get_shortcode_regex() {
	global $shortcode_tags;
	$tagnames = array_keys($shortcode_tags);
	$tagregexp = join( '|', array_map('preg_quote', $tagnames) );

	// WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
	// Also, see shortcode_unautop() and shortcode.js.
	return
		  '\\['                              // Opening bracket
		. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
		. "($tagregexp)"                     // 2: Shortcode name
		. '(?![\\w-])'                       // Not followed by word character or hyphen
		. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
		.     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
		.     '(?:'
		.         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
		.         '[^\\]\\/]*'               // Not a closing bracket or forward slash
		.     ')*?'
		. ')'
		. '(?:'
		.     '(\\/)'                        // 4: Self closing tag ...
		.     '\\]'                          // ... and closing bracket
		. '|'
		.     '\\]'                          // Closing bracket
		.     '(?:'
		.         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
		.             '[^\\[]*+'             // Not an opening bracket
		.             '(?:'
		.                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
		.                 '[^\\[]*+'         // Not an opening bracket
		.             ')*+'
		.         ')'
		.         '\\[\\/\\2\\]'             // Closing shortcode tag
		.     ')?'
		. ')'
		. '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
}

/**
 * Regular Expression callable for do_shortcode() for calling shortcode hook.
 * @see get_shortcode_regex for details of the match array contents.
 *
 * @since 2.5
 * @access private
 * @uses $shortcode_tags
 *
 * @param array $m Regular expression match array
 * @return mixed False on failure.
 */
function do_shortcode_tag( $m ) {
	global $shortcode_tags;
	// allow [[foo]] syntax for escaping a tag
	if ( $m[1] == '[' && $m[6] == ']' ) {
		return substr($m[0], 1, -1);
	}

	$tag = $m[2];
	$attr = shortcode_parse_atts( $m[3] );
	if ( isset( $m[5] ) ) {
		// enclosing tag - extra parameter
		
		return $m[1] . call_user_func( $shortcode_tags[$tag], $attr, $m[5], $tag ) . $m[6];
	} else {
		// self-closing tag
		return $m[1] . call_user_func( $shortcode_tags[$tag], $attr, null,  $tag ) . $m[6];
	}
}

/**
 * Retrieve all attributes from the shortcodes tag.
 *
 * The attributes list has the attribute name as the key and the value of the
 * attribute as the value in the key/value pair. This allows for easier
 * retrieval of the attributes, since all attributes have to be known.
 *
 * @since 2.5
 *
 * @param string $text
 * @return array List of attributes and their value.
 */
function shortcode_parse_atts($text) {
	$atts = array();
	$pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
	$text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
	if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {
		foreach ($match as $m) {
			if (!empty($m[1]))
				$atts[strtolower($m[1])] = stripcslashes($m[2]);
			elseif (!empty($m[3]))
				$atts[strtolower($m[3])] = stripcslashes($m[4]);
			elseif (!empty($m[5]))
				$atts[strtolower($m[5])] = stripcslashes($m[6]);
			elseif (isset($m[7]) and strlen($m[7]))
				$atts[] = stripcslashes($m[7]);
			elseif (isset($m[8]))
				$atts[] = stripcslashes($m[8]);
		}
	} else {
		$atts = ltrim($text);
	}
	return $atts;
}

/**
 * Combine user attributes with known attributes and fill in defaults when needed.
 *
 * The pairs should be considered to be all of the attributes which are
 * supported by the caller and given as a list. The returned attributes will
 * only contain the attributes in the $pairs list.
 *
 * If the $atts list has unsupported attributes, then they will be ignored and
 * removed from the final returned list.
 *
 * @param array $pairs Entire list of supported attributes and their defaults.
 * @param array $atts User defined attributes in shortcode tag.
 * @param string $shortcode Optional. The name of the shortcode, provided for context to enable filtering
 * @return array Combined and filtered attribute list.
 */
function shortcode_atts( $pairs, $atts, $shortcode = '' ) {
	$atts = (array)$atts;
	$out = array();
	foreach($pairs as $name => $default) {
		if ( array_key_exists($name, $atts) )
			$out[$name] = $atts[$name];
		else
			$out[$name] = $default;
	}
	return $out;
}

/**
 * Remove all shortcode tags from the given content.
 *
 * @uses $shortcode_tags
 *
 * @param string $content Content to remove shortcode tags.
 * @return string Content without shortcode tags.
 */
function strip_shortcodes( $content ) {
	global $shortcode_tags;

	if (empty($shortcode_tags) || !is_array($shortcode_tags))
		return $content;

	$pattern = get_shortcode_regex();

	return preg_replace_callback( "/$pattern/s", 'strip_shortcode_tag', $content );
}

function strip_shortcode_tag( $m ) {
	// allow [[foo]] syntax for escaping a tag
	if ( $m[1] == '[' && $m[6] == ']' ) {
		return substr($m[0], 1, -1);
	}

	return $m[1] . $m[6];
}

function jv_ecssc( $atts ) {
	return ( $atts['class'] ) ? ' ' . trim( $atts['class'] ) : '';
}
/**
 * Load js or css for shortcode
 * 
 * @uses Jv_Shortcodes
 * 
 * @param string $type type of asset ( js or css, inline)
 * @param string $filename Name of asset will be load
 */
function jv_query_asset($type, $filename, $content=null){
	$mainframe = JFactory::getApplication();
	$assetsUrl = JURI::root().'plugins/system/jv_shortcode_system/shortcode/assets/';
	
	if ( $mainframe->isAdmin() ) { 
		if($type === 'css'){
			return '<link type="text/css" href="'.$assetsUrl.'css/'.$filename.'.css'.'" rel="stylesheet">';
		}elseif($type ==='js'){
			return '<script type="text/javascript" src="'.$assetsUrl.'js/'.$filename.'.js'.'"></script>';
		}else{
			if($content['type']==='css'){
				return '<style>'.$content['val'].'</style>';
			}else{
				return '<script type="text/javascript">'.$content['val'].'</script>';
			}
		}		 
	}else{
		# get template path is in used
		$app = JFactory::getApplication();
		$template = $app->getTemplate();
		$templatePath = JPATH_SITE . '/templates/' .$template.'/html/jv_shortcode_system';
		$templateURI = JURI::root() . '/templates/' .$template.'/html/jv_shortcode_system';
		$document =  JFactory::getDocument();
		$header = $document->getHeadData();
		$styles = $header['styleSheets'];
		
		if($type === 'css'){
			# check has file in template forlder 
			
			# check if font-awesome is loaded
			if($filename == 'font-awesome.min'){
				$loadFontAwesome = true;
				foreach($styles as $style => $file){
					if(substr_count($style,'/font-awesome') )
					{
						$loadFontAwesome = false;
						break;
					} 
				}
				if($loadFontAwesome){
					$document->addStyleSheet($assetsUrl.'css/'.$filename.'.css');
				}
			}else if($filename == 'bootstrap'){
				$loadBoostrap = true;
				foreach($styles as $style => $file){
					if(substr_count($style,'/bootstrap') )
					{
						$loadBoostrap = false;
						break;
					}
				}
				if($loadBoostrap){
					$document->addStyleSheet($assetsUrl.'css/'.$filename.'.css');
				}
			}else if(file_exists($templatePath.'/css/'.$filename.'.css')){
				# if has : load from temp folder
				$document->addStyleSheet($templateURI.'/css/'.$filename.'.css');
			}else{
				#if not: load from plugin folder
				$document->addStyleSheet($assetsUrl.'css/'.$filename.'.css');
			}
			return;
			
		}elseif($type === 'js'){
			# check has file in template forlder 
			if(file_exists($templatePath.'/js/'.$filename.'.js')){
				# if has : load from temp folder
				$url = $templateURI.'/js/'.$filename.'.js';
			}else{
				#if not: load from plugin folder
				$url = $assetsUrl.'js/'.$filename.'.js';
			}
			
			# check if is load jquery
			if($filename === 'jquery')
			{	
				$hasJquery = false;
				#find jquery in head
				
				$scripts = $header['scripts'];
				$loadJquery = true;
				
				foreach($scripts as $scriptName => $scriptData)
				{
					if(substr_count($scriptName,'/jquery') )
					{
					 	$loadJquery = false;
						break;
					} 
				}
				
				if($loadJquery){
					$document->addScript($url);
					return;
				}
			}else{
				$document->addScript($url);
				return ;
			}
		}else{
			if($content['type']=== 'css'){
				$document->addStyleDeclaration($content['val']);
			}else{
				$document->addScriptDeclaration($content['val']);
			}
			
		}
			
		return '';
	}
}

