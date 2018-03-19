<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * Script file of loadjvss plugin
 */
class PlgContentLoadjvssInstallerScript
{
    /**
     * Method to install the extension
     * $parent is the class calling this method
     *
     * @return void
     */
    function install($parent) 
    {
        $this->do_data();
    }
 
    /**
     * Method to update the extension
     * $parent is the class calling this method
     *
     * @return void
     */
    function update($parent) 
    {
        $this->do_data();
    }
    
    private function do_data()
    {
        JFactory::getDbo()
        ->setQuery( "UPDATE #__extensions SET enabled = 1 WHERE type = 'plugin' AND element = 'loadjvss';" )
        ->execute();
    }
}