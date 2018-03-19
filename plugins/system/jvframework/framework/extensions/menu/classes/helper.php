<?php
/**
 # com_jvframework - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class FlexMenuHelper {
	protected static $modules = array ();
	protected static $moduleitems = array ();
	protected static $modulepositions = array ();
	
	public static function loadPosition($position, $style = 'none') {
		if (! isset ( self::$modulepositions [$position] )) {					
			self::$modulepositions [$position] = JV::_('position.render', $position.'.'.$style);
		}
		return self::$modulepositions [$position];
	}
	
	public static function loadModule($moduleid, $style = 'none') {
		if (! count ( self::$modules )) {
			self::$modules = self::_load ();
		}
		
		if (! isset ( self::$moduleitems [$moduleid] )) {
            $renderer = JFactory::getDocument ()->loadRenderer ( 'module' );
			$module = '';
			$total = count ( self::$modules );
			for($i = 0; $i < $total; $i ++) {
				// Match the name of the module
				if (self::$modules [$i]->id == $moduleid) {
					$module = self::$modules [$i];
                    $module->content   = $renderer->render ( $module, array('style' => 'none') );
				}
			}
			
			if (! $module)
				return;
			
			self::$moduleitems [$moduleid] = JV::_('module.render', $module, array ('style' => $style ) );
		}
		
		return self::$moduleitems [$moduleid];
	}

    /**
     * Load published modules.
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
        $query->where('(mm.menuid = ' . (int) $Itemid . ' OR mm.menuid <= 0)');

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

        return $clean;
    }
}