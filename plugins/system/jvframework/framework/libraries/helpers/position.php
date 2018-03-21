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
JVFrameworkLoader::import ( 'joomlib.application.module.helper' );
JVFrameworkLoader::import ( 'helpers.template' );

class JVFrameworkHelperPosition extends JVFrameworkHelperTemplate {
    protected $_name = 'position';
    protected $_extension = array ();
    protected static $modules = array ();
    protected static $_modules = array ();
    protected static $positions = array ();

    public function render($position,$p = array()) {   
        $options = array();
        if (strpos($position, '::')){
            list ( $position, $options ) = explode ( '::', $position );
            $options = json_decode($options, true);
        }

        if (strpos($position, '.')){
            list ( $position, $options['style'] ) = explode ( '.', $position );
        }

        // Merge Position Options
        foreach ($this['option']->get('position.'.$position, array()) as $key => $val){
            $options[$key] = $val;
        }

        $position = isset ( $this->_alias [$position] )   ? $this->_alias [$position]   : $position;

        if (isset ( $this->_unloads [$position] )) {
            return false;
        }

        $extensions = isset ( $this->_extension [$position] ) ? $this->_extension [$position] : array ();

        return $this ['template']->render ( 'position', compact ( 'position', 'options', 'extensions' ) );
    }

    public function load($position) {
        if (! isset ( self::$modules [$position] )) {
            $renderer = JFactory::getDocument ()->loadRenderer ( 'module' );
            self::$modules [$position] = $this->getModules ( $position );
            foreach ( self::$modules [$position] as $module ) {
                $module->parameter = new JRegistry ( $module->params );
                $params = $xparams =  json_decode($module->params);
                $params->style = 'none';
                $module->params = json_encode($params);
                $module->content   = $renderer->render ( $module, array('style' => 'none') );
                $this['event']->fireEvent('onRenderModule', array(&$module, &$module->parameter));
            }
        }

        return self::$modules [$position];
    }

    public function register($name, $position, $options = array()) {
        if (! $position) {
            trigger_error ( 'Please enter position name !' );
        }
        $this->_extension [$position] [$name] [] = $options;
    }

    /**
     *
     * @package Joomla.Platform
     * @subpackage Document
     *
     * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights
     *            reserved.
     * @license GNU General Public License version 2 or later; see LICENSE
     */
    /**
     * Count the modules based on the given condition
     *
     * @param string $condition
     *        	The condition to use
     *
     * @return integer Number of modules found
     *
     * @since 11.1
     */
    public function count($condition) {
        if(!class_exists('JDocumentHTML')){
            return false;
        }

        $operators = '(\+|\-|\*|\/|==|\!=|\<\>|\<|\>|\<=|\>=|and|or|xor)';
        $words = preg_split ( '# ' . $operators . ' #', $condition, null, PREG_SPLIT_DELIM_CAPTURE );
        for($i = 0, $n = count ( $words ); $i < $n; $i += 2) {
            // odd parts (modules)
            $name = strtolower ( $words [$i] );
            $name = isset ( $this->_alias [$name] ) ? $this->_alias [$name] : $name;

            $words [$i] = ((isset ( JDocumentHTML::$_buffer ['modules'] [$name] )) && (JDocumentHTML::$_buffer ['modules'] [$name] === false)) ? 0 : count ( $this->getModules ( $name ) );

            if (isset ( $this->_extension [$name] )) {
                $words [$i] = 1;
            }
        }

        $str = 'return ' . implode ( ' ', $words ) . ';';

        return eval ( $str );
    }

    public function getModules11($name){

        print_r(self::_load());die;
        if(!isset(self::$_modules[$name])){
            $modules = JModuleHelper::getModules ( $name );
            $this['event']->fireEvent('onGetModules', array(&$modules));
            self::$_modules[$name] = $modules; unset($modules);
        }
        return self::$_modules[$name];
    }

    /**
     * Get modules by position
     *
     * @param   string  $position  The position of the module
     *
     * @return  array  An array of module objects
     *
     * @since   11.1
     */
    public function &getModules($position)
    {
        $position = strtolower($position);
        $result = array();

        $modules =& self::_load();

        $total = count($modules);
        for ($i = 0; $i < $total; $i++)
        {
            if ($modules[$i]->position == $position)
            {
                $result[] = &$modules[$i];
            }
        }

        if (count($result) == 0)
        {
            if (JFactory::getApplication()->input->getBool('tp',false) && JComponentHelper::getParams('com_templates')->get('template_positions_display'))
            {
                $result[0] = JModuleHelper::getModule('mod_' . $position);
                $result[0]->title = $position;
                $result[0]->content = $position;
                $result[0]->position = $position;
            }
        }

        // Event to check module assignment
        $this['event']->fireEvent('onGetModules', array(&$result));

        return $result;
    }

    /**
     * Load all modules.
     *
     * @return  array
     *
     * @since   11.1
     */
    protected static function &_load()
    {
        static $clean;

        if (isset($clean))
        {
            return $clean;
        }

        $app = JFactory::getApplication();
        $Itemid = $app->input->get('Itemid', 0, 'int');
        $user = JFactory::getUser();
        $groups = implode(',', $user->getAuthorisedViewLevels());
        $lang = JFactory::getLanguage()->getTag();
        $clientId = (int) $app->getClientId();

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params, mm.menuid');
        $query->from('#__modules AS m');
        $query->join('LEFT', '#__modules_menu AS mm ON mm.moduleid = m.id');
        $query->where('m.published = 1');

        $query->join('LEFT', '#__extensions AS e ON e.element = m.module AND e.client_id = m.client_id');
        $query->where('e.enabled = 1');

        $date = JFactory::getDate();
        $now = $date->toSql();
        $nullDate = $db->getNullDate();
        $query->where('(m.publish_up = ' . $db->Quote($nullDate) . ' OR m.publish_up <= ' . $db->Quote($now) . ')');
        $query->where('(m.publish_down = ' . $db->Quote($nullDate) . ' OR m.publish_down >= ' . $db->Quote($now) . ')');

        $query->where('m.access IN (' . $groups . ')');
        $query->where('m.client_id = ' . $clientId);
        // Filter by menu item
        //$query->where('(mm.menuid = ' . (int) $Itemid . ' OR mm.menuid <= 0)');

        // Filter by language
        if ($app->isSite() && $app->getLanguageFilter())
        {
            $query->where('m.language IN (' . $db->Quote($lang) . ',' . $db->Quote('*') . ')');
        }

        $query->order('m.position, m.ordering');

        // Set the query
        $db->setQuery($query);
        $clean = array();

        try
        {
            $modules = $db->loadObjectList();
        }
        catch (RuntimeException $e)
        {
            JLog::add(JText::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $e->getMessage()), JLog::WARNING, 'jerror');
            return $clean;
        }

        // Apply negative selections and eliminate duplicates
        $negId = $Itemid ? -(int) $Itemid : false;
        $dupes = array();
        for ($i = 0, $n = count($modules); $i < $n; $i++)
        {
            $module = &$modules[$i];

            // The module is excluded if there is an explicit prohibition
            $negHit = ($negId === (int) $module->menuid);

            if (isset($dupes[$module->id]))
            {
                // If this item has been excluded, keep the duplicate flag set,
                // but remove any item from the cleaned array.
                if ($negHit)
                {
                    unset($clean[$module->id]);
                }
                continue;
            }

            $dupes[$module->id] = true;

            // Only accept modules without explicit exclusions.
            if (!$negHit)
            {
                $module->name = substr($module->module, 4);
                $module->style = null;
                $module->position = strtolower($module->position);
                $clean[$module->id] = $module;
            }
        }

        unset($dupes);

        // Return to simple indexing that matches the query order.
        $clean = array_values($clean);
        $app = JFactory::getApplication();
        $app->triggerEvent('onPrepareModuleList', array(&$clean));
        
        return $clean;
    }

}
?>