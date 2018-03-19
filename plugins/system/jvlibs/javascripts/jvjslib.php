<?php
  /**
# plugin system jvjquerylib - JV JQuery Libraries
# @versions: 1.5.x,1.6.x,1.7.x,2.5.x
# ------------------------------------------------------------------------
# author    PHPKungfu Solutions Co
# copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
# @license - http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL or later.
# Websites: http://www.phpkungfu.club
# Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');
define('JVJSLIB_PATH', JVLIBS_PATH.'javascripts/');
define('JVJSLIB_URI', JVLIBS_URI.'javascripts/');
class JVJSLib{
    public static $libs;
    public static $loaded = array();
    public function __construct($config){
        $data = json_decode(file_get_contents(JVJSLIB_PATH.'data.js'));
        $libs = self::$libs = new JVDataObject($data);
        self::repairDatas($libs);
        
        if(!(JVERSION < '3.0')){
            $libs['jquery.js'] = JUri::root(true)."/media/jui/js/jquery.min.js,".
                    JUri::root(true)."/media/jui/js/jquery-noconflict.js,".
                    JUri::root(true)."/media/jui/js/jquery-migrate.min.js";
            if(JFactory::getApplication()->isAdmin()){
                $libs['jquery.bootstrap.js'] = JUri::root(true)."/media/jui/js/bootstrap.min.js";
                $libs['jquery.bootstrap.css'] = JUri::root(true)."/media/jui/css/bootstrap.min.css,".JUri::root(true)."/media/jui/css/bootstrap-extended.css,".JUri::root(true)."/media/jui/css/bootstrap-responsive.min.css";
            } 
        }else{
            $libs['jquery.bootstrap.css'] .= ','. JVJSLIB_URI."jquery/bootstrap/css/bootstrap-fix25.css";
        }
        $bootstrapStyle = $config->get('bootstrapstyle','none');
        $app = JFactory::getApplication();
        if(
            $bootstrapStyle == 'none' ||
            ($bootstrapStyle == 'site' && $app->isAdmin()) ||
            ($bootstrapStyle == 'admin' && $app->isSite())
        ) unset($libs['jquery.bootstrap.css']);
    }
    private static function repairDatas($datas){
        if(empty($datas) || is_string($datas)) return;
        foreach($datas as $key => &$data){
            if($key == 'js' || $key == 'css'){
                $fs = explode(',',$data);
                foreach($fs as &$url) $url = JVJSLIB_URI.$url;
                $datas[$key] = implode(',',$fs);
                continue;
            }
            self::repairDatas($data);
        }
    }
    
    public static function add($keys = null){
        if(empty($keys)) return;
        $keys = explode(',',$keys);
        foreach($keys as $key){
            if(isset(self::$loaded[$key])) continue;
            self::$loaded[$key] = true;
            if(!isset(self::$libs->$key)) self::$libs->$key = array();
            $data = self::$libs->$key;
            if(isset($data->require)) self::add($data->require);
            if(isset($data->js)) self::addJS(explode(',',$data->js));
            if(isset($data->css)) self::addCSS(explode(',',$data->css));
        }
    }
    
    private static function addJS($files = array()){
        foreach($files as $file) JFactory::getDocument()->addScript($file);
    }
    private static function addCSS($files = array()){
        foreach($files as $file) JFactory::getDocument()->addStyleSheet($file);
    }
}

abstract class JHtmlJquery
{
    /**
     * @var    array  Array containing information for loaded files
     * @since  3.0
     */
    protected static $loaded = array();

    /**
     * Method to load the jQuery JavaScript framework into the document head
     *
     * If debugging mode is on an uncompressed version of jQuery is included for easier debugging.
     *
     * @param   boolean  $noConflict  True to load jQuery in noConflict mode [optional]
     * @param   mixed    $debug       Is debugging mode on? [optional]
     *
     * @return  void
     *
     * @since   3.0
     */
    public static function framework($noConflict = true, $debug = null)
    {
        JVJSLib::add('jquery');
        return;
    }

    /**
     * Method to load the jQuery UI JavaScript framework into the document head
     *
     * If debugging mode is on an uncompressed version of jQuery UI is included for easier debugging.
     *
     * @param   array  $components  The jQuery UI components to load [optional]
     * @param   mixed  $debug       Is debugging mode on? [optional]
     *
     * @return  void
     *
     * @since   3.0
     */
    public static function ui(array $components = array('core'), $debug = null)
    {                                                                                       
        JVJSLib::add('jquery.ui.interactions');
        return;
    }
    public static function token($name = 'csrf.token')
	{
		// Only load once
		if (!empty(static::$loaded[__METHOD__][$name]))
		{
			return;
		}

		static::framework();
		JHtml::_('form.csrf', $name);

		$doc = JFactory::getDocument();

		$doc->addScriptDeclaration(
<<<JS
;(function ($) {
	$.ajaxSetup({
		headers: {
			'X-CSRF-Token': Joomla.getOptions('$name')
		}
	});
})(jQuery);
JS
		);

		static::$loaded[__METHOD__][$name] = true;
	}
}

if(JFactory::getApplication()->isSite()){

abstract class JHtmlBootstrap
{
	/**
	 * @var    array  Array containing information for loaded files
	 * @since  3.0
	 */
	protected static $loaded = array();

	/**
	 * Add javascript support for the Bootstrap affix plugin
	 *
	 * @param   string  $selector  Unique selector for the element to be affixed.
	 * @param   array   $params    An array of options.
	 *                             Options for the affix plugin can be:
	 *                             - offset  number|function|object  Pixels to offset from screen when calculating position of scroll.
	 *                                                               If a single number is provided, the offset will be applied in both top
	 *                                                               and left directions. To listen for a single direction, or multiple
	 *                                                               unique offsets, just provide an object offset: { x: 10 }.
	 *                                                               Use a function when you need to dynamically provide an offset
	 *                                                               (useful for some responsive designs).
	 *
	 * @return  void
	 *
	 * @since   3.1
	 */
	public static function affix($selector = 'affix', $params = array())
	{
		$sig = md5(serialize(array($selector, $params)));

		if (!isset(static::$loaded[__METHOD__][$sig]))
		{
			// Include Bootstrap framework
			static::framework();

			// Setup options object
			$opt['offset'] = isset($params['offset']) ? $params['offset'] : 10;

			$options = JHtml::getJSObject($opt);

			// Attach the carousel to document
			JFactory::getDocument()->addScriptDeclaration(
				"(function($){
					$('#$selector').affix($options);
					})(jQuery);"
			);

			// Set static array
			static::$loaded[__METHOD__][$sig] = true;
		}

		return;
	}

	/**
	 * Add javascript support for Bootstrap alerts
	 *
	 * @param   string  $selector  Common class for the alerts
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function alert($selector = 'alert')
	{
		// Only load once
		if (isset(static::$loaded[__METHOD__][$selector]))
		{
			return;
		}

		// Include Bootstrap framework
		static::framework();

		// Attach the alerts to the document
		JFactory::getDocument()->addScriptDeclaration(
			"(function($){
				$('.$selector').alert();
				})(jQuery);"
		);

		static::$loaded[__METHOD__][$selector] = true;

		return;
	}

	/**
	 * Add javascript support for Bootstrap buttons
	 *
	 * @param   string  $selector  Common class for the buttons
	 *
	 * @return  void
	 *
	 * @since   3.1
	 */
	public static function button($selector = 'button')
	{
		// Only load once
		if (isset(static::$loaded[__METHOD__][$selector]))
		{
			return;
		}

		// Include Bootstrap framework
		static::framework();

		// Attach the alerts to the document
		JFactory::getDocument()->addScriptDeclaration(
			"(function($){
				$('.$selector').button();
				})(jQuery);"
		);

		static::$loaded[__METHOD__][$selector] = true;

		return;
	}

	/**
	 * Add javascript support for Bootstrap carousels
	 *
	 * @param   string  $selector  Common class for the carousels.
	 * @param   array   $params    An array of options for the modal.
	 *                             Options for the modal can be:
	 *                             - interval  number  The amount of time to delay between automatically cycling an item.
	 *                                                 If false, carousel will not automatically cycle.
	 *                             - pause     string  Pauses the cycling of the carousel on mouseenter and resumes the cycling
	 *                                                 of the carousel on mouseleave.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function carousel($selector = 'carousel', $params = array())
	{
		$sig = md5(serialize(array($selector, $params)));

		if (!isset(static::$loaded[__METHOD__][$sig]))
		{
			// Include Bootstrap framework
			static::framework();

			// Setup options object
			$opt['interval'] = isset($params['interval']) ? (int) $params['interval'] : 5000;
			$opt['pause']    = isset($params['pause']) ? $params['pause'] : 'hover';

			$options = JHtml::getJSObject($opt);

			// Attach the carousel to document
			JFactory::getDocument()->addScriptDeclaration(
				"(function($){
					$('.$selector').carousel($options);
					})(jQuery);"
			);

			// Set static array
			static::$loaded[__METHOD__][$sig] = true;
		}

		return;
	}

	/**
	 * Add javascript support for Bootstrap dropdowns
	 *
	 * @param   string  $selector  Common class for the dropdowns
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function dropdown($selector = 'dropdown-toggle')
	{
		// Only load once
		if (isset(static::$loaded[__METHOD__][$selector]))
		{
			return;
		}

		// Include Bootstrap framework
		static::framework();

		// Attach the dropdown to the document
		JFactory::getDocument()->addScriptDeclaration(
			"(function($){
				$('.$selector').dropdown();
				})(jQuery);"
		);

		static::$loaded[__METHOD__][$selector] = true;

		return;
	}

	/**
	 * Method to load the Bootstrap JavaScript framework into the document head
	 *
	 * If debugging mode is on an uncompressed version of Bootstrap is included for easier debugging.
	 *
	 * @param   mixed  $debug  Is debugging mode on? [optional]
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function framework($debug = null)
	{
		// Only load once
		if (!empty(static::$loaded[__METHOD__]))
		{
			return;
		}
        JVJSLib::add('jquery.bootstrap');
		static::$loaded[__METHOD__] = true;

		return;
	}

	/**
	 * Add javascript support for Bootstrap modals
	 *
	 * @param   string  $selector  The ID selector for the modal.
	 * @param   array   $params    An array of options for the modal.
	 *                             Options for the modal can be:
	 *                             - backdrop  boolean  Includes a modal-backdrop element.
	 *                             - keyboard  boolean  Closes the modal when escape key is pressed.
	 *                             - show      boolean  Shows the modal when initialized.
	 *                             - remote    string   An optional remote URL to load
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function modal($selector = 'modal', $params = array())
	{
		$sig = md5(serialize(array($selector, $params)));

		if (!isset(static::$loaded[__METHOD__][$sig]))
		{
			// Include Bootstrap framework
			static::framework();

			// Setup options object
			$opt['backdrop'] = isset($params['backdrop']) ? (boolean) $params['backdrop'] : true;
			$opt['keyboard'] = isset($params['keyboard']) ? (boolean) $params['keyboard'] : true;
			$opt['show']     = isset($params['show']) ? (boolean) $params['show'] : true;
			$opt['remote']   = isset($params['remote']) ?  $params['remote'] : '';

			$options = JHtml::getJSObject($opt);

			// Attach the modal to document
			JFactory::getDocument()->addScriptDeclaration(
				"(function($){
					$('#$selector').modal($options);
					})(jQuery);"
			);

			// Set static array
			static::$loaded[__METHOD__][$sig] = true;
		}

		return;
	}

	/**
	 * Method to render a Bootstrap modal
	 *
	 * @param   string  $selector  The ID selector for the modal.
	 * @param   array   $params    An array of options for the modal.
	 * @param   string  $footer    Optional markup for the modal footer
	 *
	 * @return  string  HTML markup for a modal
	 *
	 * @since   3.0
	 */
	public static function renderModal($selector = 'modal', $params = array(), $footer = '')
	{
		// Ensure the behavior is loaded
		static::modal($selector, $params);

		$html = "<div class=\"modal hide fade\" id=\"" . $selector . "\">\n";
		$html .= "<div class=\"modal-header\">\n";
		$html .= "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">×</button>\n";
		$html .= "<h3>" . $params['title'] . "</h3>\n";
		$html .= "</div>\n";
		$html .= "<div id=\"" . $selector . "-container\">\n";
		$html .= "</div>\n";
		$html .= "</div>\n";

		$html .= "<script>";
		$html .= "jQuery('#" . $selector . "').on('show', function () {\n";
		$html .= "document.getElementById('" . $selector . "-container').innerHTML = '<div class=\"modal-body\"><iframe class=\"iframe\" src=\""
			. $params['url'] . "\" height=\"" . $params['height'] . "\" width=\"" . $params['width'] . "\"></iframe></div>" . $footer . "';\n";
		$html .= "});\n";
		$html .= "</script>";

		return $html;
	}

	/**
	 * Add javascript support for Bootstrap popovers
	 *
	 * Use element's Title as popover content
	 *
	 * @param   string  $selector  Selector for the popover
	 * @param   array   $params    An array of options for the popover.
	 *                  Options for the popover can be:
	 *                      animation  boolean          apply a css fade transition to the popover
	 *                      html       boolean          Insert HTML into the popover. If false, jQuery's text method will be used to insert
	 *                                                  content into the dom.
	 *                      placement  string|function  how to position the popover - top | bottom | left | right
	 *                      selector   string           If a selector is provided, popover objects will be delegated to the specified targets.
	 *                      trigger    string           how popover is triggered - hover | focus | manual
	 *                      title      string|function  default title value if `title` tag isn't present
	 *                      content    string|function  default content value if `data-content` attribute isn't present
	 *                      delay      number|object    delay showing and hiding the popover (ms) - does not apply to manual trigger type
	 *                                                  If a number is supplied, delay is applied to both hide/show
	 *                                                  Object structure is: delay: { show: 500, hide: 100 }
	 *                      container  string|boolean   Appends the popover to a specific element: { container: 'body' }
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function popover($selector = '.hasPopover', $params = array())
	{
		// Only load once
		if (isset(static::$loaded[__METHOD__][$selector]))
		{
			return;
		}

		// Include Bootstrap framework
		static::framework();

		$opt['animation'] = isset($params['animation']) ? $params['animation'] : null;
		$opt['html']      = isset($params['html']) ? $params['html'] : true;
		$opt['placement'] = isset($params['placement']) ? $params['placement'] : null;
		$opt['selector']  = isset($params['selector']) ? $params['selector'] : null;
		$opt['title']     = isset($params['title']) ? $params['title'] : null;
		$opt['trigger']   = isset($params['trigger']) ? $params['trigger'] : 'hover focus';
		$opt['content']   = isset($params['content']) ? $params['content'] : null;
		$opt['delay']     = isset($params['delay']) ? $params['delay'] : null;
		$opt['container'] = isset($params['container']) ? $params['container'] : 'body';

		$options = JHtml::getJSObject($opt);

		// Attach the popover to the document
		JFactory::getDocument()->addScriptDeclaration(
			"jQuery(document).ready(function()
			{
				jQuery('" . $selector . "').popover(" . $options . ");
			});"
		);

		static::$loaded[__METHOD__][$selector] = true;

		return;
	}

	/**
	 * Add javascript support for Bootstrap ScrollSpy
	 *
	 * @param   string  $selector  The ID selector for the ScrollSpy element.
	 * @param   array   $params    An array of options for the ScrollSpy.
	 *                             Options for the modal can be:
	 *                             - offset  number  Pixels to offset from top when calculating position of scroll.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function scrollspy($selector = 'navbar', $params = array())
	{
		$sig = md5(serialize(array($selector, $params)));

		if (!isset(static::$loaded[__METHOD__][$sig]))
		{
			// Include Bootstrap framework
			static::framework();

			// Setup options object
			$opt['offset'] = isset($params['offset']) ? (int) $params['offset'] : 10;

			$options = JHtml::getJSObject($opt);

			// Attach ScrollSpy to document
			JFactory::getDocument()->addScriptDeclaration(
				"(function($){
					$('#$selector').scrollspy($options);
					})(jQuery);"
			);

			// Set static array
			static::$loaded[__METHOD__][$sig] = true;
		}

		return;
	}

	/**
	 * Add javascript support for Bootstrap tooltips
	 *
	 * Add a title attribute to any element in the form
	 * title="title::text"
	 *
	 * @param   string  $selector  The ID selector for the tooltip.
	 * @param   array   $params    An array of options for the tooltip.
	 *                             Options for the tooltip can be:
	 *                             - animation  boolean          Apply a CSS fade transition to the tooltip
	 *                             - html       boolean          Insert HTML into the tooltip. If false, jQuery's text method will be used to insert
	 *                                                           content into the dom.
	 *                             - placement  string|function  How to position the tooltip - top | bottom | left | right
	 *                             - selector   string           If a selector is provided, tooltip objects will be delegated to the specified targets.
	 *                             - title      string|function  Default title value if `title` tag isn't present
	 *                             - trigger    string           How tooltip is triggered - hover | focus | manual
	 *                             - delay      integer          Delay showing and hiding the tooltip (ms) - does not apply to manual trigger type
	 *                                                           If a number is supplied, delay is applied to both hide/show
	 *                                                           Object structure is: delay: { show: 500, hide: 100 }
	 *                             - container  string|boolean   Appends the popover to a specific element: { container: 'body' }
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function tooltip($selector = '.hasTooltip', $params = array())
	{
		if (!isset(static::$loaded[__METHOD__][$selector]))
		{
			// Include Bootstrap framework
			static::framework();

			// Setup options object
			$opt['animation'] = isset($params['animation']) ? (boolean) $params['animation'] : null;
			$opt['html']      = isset($params['html']) ? (boolean) $params['html'] : true;
			$opt['placement'] = isset($params['placement']) ? (string) $params['placement'] : null;
			$opt['selector']  = isset($params['selector']) ? (string) $params['selector'] : null;
			$opt['title']     = isset($params['title']) ? (string) $params['title'] : null;
			$opt['trigger']   = isset($params['trigger']) ? (string) $params['trigger'] : null;
			$opt['delay']     = isset($params['delay']) ? (int) $params['delay'] : null;
			$opt['container'] = isset($params['container']) ? $params['container'] : 'body';
			$opt['template']  = isset($params['template']) ? (string) $params['template'] : null;

			$options = JHtml::getJSObject($opt);

			// Attach tooltips to document
			JFactory::getDocument()->addScriptDeclaration(
				"jQuery(document).ready(function()
				{
					jQuery('" . $selector . "').tooltip(" . $options . ");
				});"
			);

			// Set static array
			static::$loaded[__METHOD__][$selector] = true;
		}

		return;
	}

	/**
	 * Add javascript support for Bootstrap typeahead
	 *
	 * @param   string  $selector  The selector for the typeahead element.
	 * @param   array   $params    An array of options for the typeahead element.
	 *                             Options for the tooltip can be:
	 *                             - source       array, function  The data source to query against. May be an array of strings or a function.
	 *                                                             The function is passed two arguments, the query value in the input field and the
	 *                                                             process callback. The function may be used synchronously by returning the data
	 *                                                             source directly or asynchronously via the process callback's single argument.
	 *                             - items        number           The max number of items to display in the dropdown.
	 *                             - minLength    number           The minimum character length needed before triggering autocomplete suggestions
	 *                             - matcher      function         The method used to determine if a query matches an item. Accepts a single argument,
	 *                                                             the item against which to test the query. Access the current query with this.query.
	 *                                                             Return a boolean true if query is a match.
	 *                             - sorter       function         Method used to sort autocomplete results. Accepts a single argument items and has
	 *                                                             the scope of the typeahead instance. Reference the current query with this.query.
	 *                             - updater      function         The method used to return selected item. Accepts a single argument, the item and
	 *                                                             has the scope of the typeahead instance.
	 *                             - highlighter  function         Method used to highlight autocomplete results. Accepts a single argument item and
	 *                                                             has the scope of the typeahead instance. Should return html.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function typeahead($selector = '.typeahead', $params = array())
	{
		if (!isset(static::$loaded[__METHOD__][$selector]))
		{
			// Include Bootstrap framework
			static::framework();

			// Setup options object
			$opt['source']      = isset($params['source']) ? $params['source'] : '[]';
			$opt['items']       = isset($params['items']) ? (int) $params['items'] : 8;
			$opt['minLength']   = isset($params['minLength']) ? (int) $params['minLength'] : 1;
			$opt['matcher']     = isset($params['matcher']) ? (string) $params['matcher'] : null;
			$opt['sorter']      = isset($params['sorter']) ? (string) $params['sorter'] : null;
			$opt['updater']     = isset($params['updater']) ? (string) $params['updater'] : null;
			$opt['highlighter'] = isset($params['highlighter']) ? (int) $params['highlighter'] : null;

			$options = JHtml::getJSObject($opt);

			// Attach tooltips to document
			JFactory::getDocument()->addScriptDeclaration(
				"jQuery(document).ready(function()
				{
					jQuery('" . $selector . "').typeahead(" . $options . ");
				});"
			);

			// Set static array
			static::$loaded[__METHOD__][$selector] = true;
		}

		return;
	}

	/**
	 * Add javascript support for Bootstrap accordians and insert the accordian
	 *
	 * @param   string  $selector  The ID selector for the tooltip.
	 * @param   array   $params    An array of options for the tooltip.
	 *                             Options for the tooltip can be:
	 *                             - parent  selector  If selector then all collapsible elements under the specified parent will be closed when this
	 *                                                 collapsible item is shown. (similar to traditional accordion behavior)
	 *                             - toggle  boolean   Toggles the collapsible element on invocation
	 *                             - active  string    Sets the active slide during load
	 *
	 * @return  string  HTML for the accordian
	 *
	 * @since   3.0
	 */
	public static function startAccordion($selector = 'myAccordian', $params = array())
	{
		$sig = md5(serialize(array($selector, $params)));

		if (!isset(static::$loaded[__METHOD__][$sig]))
		{
			// Include Bootstrap framework
			static::framework();

			// Setup options object
			$opt['parent'] = isset($params['parent']) ? (boolean) $params['parent'] : false;
			$opt['toggle'] = isset($params['toggle']) ? (boolean) $params['toggle'] : true;
			$opt['active'] = isset($params['active']) ? (string) $params['active'] : '';

			$options = JHtml::getJSObject($opt);

			// Attach accordion to document
			JFactory::getDocument()->addScriptDeclaration(
				"(function($){
					$('#$selector').collapse($options);
				})(jQuery);"
			);

			// Set static array
			static::$loaded[__METHOD__][$sig] = true;
			static::$loaded[__METHOD__]['active'] = $opt['active'];
		}

		return '<div id="' . $selector . '" class="accordion">';
	}

	/**
	 * Close the current accordion
	 *
	 * @return  string  HTML to close the accordian
	 *
	 * @since   3.0
	 */
	public static function endAccordion()
	{
		return '</div>';
	}

	/**
	 * Begins the display of a new accordion slide.
	 *
	 * @param   string  $selector  Identifier of the accordion group.
	 * @param   string  $text      Text to display.
	 * @param   string  $id        Identifier of the slide.
	 * @param   string  $class     Class of the accordion group.
	 *
	 * @return  string  HTML to add the slide
	 *
	 * @since   3.0
	 */
	public static function addSlide($selector, $text, $id, $class = '')
	{
		$in = (static::$loaded['JHtmlBootstrap::startAccordion']['active'] == $id) ? ' in' : '';
		$class = (!empty($class)) ? ' ' . $class : '';

		$html = '<div class="accordion-group' . $class . '">'
			. '<div class="accordion-heading">'
			. '<strong><a href="#' . $id . '" data-parent="#' . $selector . '" data-toggle="collapse" class="accordion-toggle">'
			. $text
			. '</a></strong>'
			. '</div>'
			. '<div class="accordion-body collapse' . $in . '" id="' . $id . '">'
			. '<div class="accordion-inner">';

		return $html;
	}

	/**
	 * Close the current slide
	 *
	 * @return  string  HTML to close the slide
	 *
	 * @since   3.0
	 */
	public static function endSlide()
	{
		return '</div></div></div>';
	}

	/**
	 * Creates a tab pane
	 *
	 * @param   string  $selector  The pane identifier.
	 * @param   array   $params    The parameters for the pane
	 *
	 * @return  string
	 *
	 * @since   3.1
	 */
	public static function startTabSet($selector = 'myTab', $params = array())
	{
		$sig = md5(serialize(array($selector, $params)));

		if (!isset(static::$loaded[__METHOD__][$sig]))
		{
			// Include Bootstrap framework
			static::framework();

			// Setup options object
			$opt['active'] = (isset($params['active']) && ($params['active'])) ? (string) $params['active'] : '';

			// Attach tabs to document
			JFactory::getDocument()
				->addScriptDeclaration(JLayoutHelper::render('libraries.cms.html.bootstrap.starttabsetscript', array('selector' => $selector)));

			// Set static array
			static::$loaded[__METHOD__][$sig] = true;
			static::$loaded[__METHOD__][$selector]['active'] = $opt['active'];
		}

		$html = JLayoutHelper::render('libraries.cms.html.bootstrap.starttabset', array('selector' => $selector));

		return $html;
	}

	/**
	 * Close the current tab pane
	 *
	 * @return  string  HTML to close the pane
	 *
	 * @since   3.1
	 */
	public static function endTabSet()
	{
		$html = JLayoutHelper::render('libraries.cms.html.bootstrap.endtabset');

		return $html;
	}

	/**
	 * Begins the display of a new tab content panel.
	 *
	 * @param   string  $selector  Identifier of the panel.
	 * @param   string  $id        The ID of the div element
	 * @param   string  $title     The title text for the new UL tab
	 *
	 * @return  string  HTML to start a new panel
	 *
	 * @since   3.1
	 */
	public static function addTab($selector, $id, $title)
	{
		static $tabScriptLayout = null;
		static $tabLayout = null;

		$tabScriptLayout = is_null($tabScriptLayout) ? new JLayoutFile('libraries.cms.html.bootstrap.addtabscript') : $tabScriptLayout;
		$tabLayout = is_null($tabLayout) ? new JLayoutFile('libraries.cms.html.bootstrap.addtab') : $tabLayout;

		$active = (static::$loaded['JHtmlBootstrap::startTabSet'][$selector]['active'] == $id) ? ' active' : '';

		// Inject tab into UL
		JFactory::getDocument()
		->addScriptDeclaration($tabScriptLayout->render(array('selector' => $selector,'id' => $id, 'active' => $active, 'title' => $title)));

		$html = $tabLayout->render(array('id' => $id, 'active' => $active));

		return $html;
	}

	/**
	 * Close the current tab content panel
	 *
	 * @return  string  HTML to close the pane
	 *
	 * @since   3.1
	 */
	public static function endTab()
	{
		$html = JLayoutHelper::render('libraries.cms.html.bootstrap.endtab');

		return $html;
	}

	/**
	 * Creates a tab pane
	 *
	 * @param   string  $selector  The pane identifier.
	 * @param   array   $params    The parameters for the pane
	 *
	 * @return  string
	 *
	 * @since   3.0
	 * @deprecated  4.0	Use JHtml::_('bootstrap.startTabSet') instead.
	 */
	public static function startPane($selector = 'myTab', $params = array())
	{
		$sig = md5(serialize(array($selector, $params)));

		if (!isset(static::$loaded['JHtmlBootstrap::startTabSet'][$sig]))
		{
			// Include Bootstrap framework
			static::framework();

			// Setup options object
			$opt['active'] = isset($params['active']) ? (string) $params['active'] : '';

			// Attach tooltips to document
			JFactory::getDocument()->addScriptDeclaration(
				"(function($){
					$('#$selector a').click(function (e) {
						e.preventDefault();
						$(this).tab('show');
					});
				})(jQuery);"
			);

			// Set static array
			static::$loaded['JHtmlBootstrap::startTabSet'][$sig] = true;
			static::$loaded['JHtmlBootstrap::startTabSet'][$selector]['active'] = $opt['active'];
		}

		return '<div class="tab-content" id="' . $selector . 'Content">';
	}

	/**
	 * Close the current tab pane
	 *
	 * @return  string  HTML to close the pane
	 *
	 * @since   3.0
	 * @deprecated  4.0	Use JHtml::_('bootstrap.endTabSet') instead.
	 */
	public static function endPane()
	{
		return '</div>';
	}

	/**
	 * Begins the display of a new tab content panel.
	 *
	 * @param   string  $selector  Identifier of the panel.
	 * @param   string  $id        The ID of the div element
	 *
	 * @return  string  HTML to start a new panel
	 *
	 * @since   3.0
	 * @deprecated  4.0 Use JHtml::_('bootstrap.addTab') instead.
	 */
	public static function addPanel($selector, $id)
	{
		$active = (static::$loaded['JHtmlBootstrap::startTabSet'][$selector]['active'] == $id) ? ' active' : '';

		return '<div id="' . $id . '" class="tab-pane' . $active . '">';
	}

	/**
	 * Close the current tab content panel
	 *
	 * @return  string  HTML to close the pane
	 *
	 * @since   3.0
	 * @deprecated  4.0 Use JHtml::_('bootstrap.endTab') instead.
	 */
	public static function endPanel()
	{
		return '</div>';
	}

	/**
	 * Loads CSS files needed by Bootstrap
	 *
	 * @param   boolean  $includeMainCss  If true, main bootstrap.css files are loaded
	 * @param   string   $direction       rtl or ltr direction. If empty, ltr is assumed
	 * @param   array    $attribs         Optional array of attributes to be passed to JHtml::_('stylesheet')
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function loadCss($includeMainCss = true, $direction = 'ltr', $attribs = array())
	{
		// Load Bootstrap main CSS
        $document = JFactory::getDocument();
        if($direction === 'ltr'){
            $document->addStyleSheet(JUri::root(true) .'/plugins/system/jvlibs/javascripts/jquery/bootstrap/css/bootstrap.min.css');
        }else{
            $document->addStyleSheet(JUri::root(true) .'/plugins/system/jvlibs/javascripts/jquery/bootstrap/css/bootstrap-rtl.min.css');
        }
            
		if ($includeMainCss)
		{
            $document->addStyleSheet(JUri::root(true) .'/plugins/system/jvlibs/javascripts/jquery/bootstrap/css/bootstrap-theme.min.css');
		}
	}
}
}
?>
