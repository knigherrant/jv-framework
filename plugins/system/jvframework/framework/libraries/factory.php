<?php

/**
  # com_jvframwork - JV Framework
  # @version		1.5.x
  # ------------------------------------------------------------------------
  # author    PHPKungfu Solutions Co
  # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
  # Websites: http://www.phpkungfu.club
  # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
// No direct access
defined ( 'JPATH_BASE' ) or die ();

abstract class JVFactory {
	/**
	 * Reads a XML file.
	 *
	 * @param   string   $data    Full path and file name.
	 * @param   boolean  $isFile  true to load a file or false to load a string.
	 *
	 * @return  mixed    JXMLElement on success or false on error.
	 *
	 * @see     JXMLElement
	 * @since   11.1
	 * @todo    This may go in a separate class - error reporting may be improved.
	 */
	public static function getXML($data, $isFile = true)
	{
		JVFrameworkLoader::import('joomlib.utilities.xmlelement');
	
		// Disable libxml errors and allow to fetch error information as needed
		libxml_use_internal_errors(true);
	
		if ($isFile)
		{
			// Try to load the XML file
			$xml = simplexml_load_file($data, 'JVFrameworkXMLElement');
		}
		else
		{
			// Try to load the XML string
			$xml = simplexml_load_string($data, 'JVFrameworkXMLElement');
		}		
	
		if (empty($xml))
		{
			// There was an error
            JFactory::getApplication()->enqueueMessage(JText::_('JLIB_UTIL_ERROR_XML_LOAD'), 'warning');
	
			if ($isFile)
			{
                JFactory::getApplication()->enqueueMessage($data, 'warning');
			}
	
			foreach (libxml_get_errors() as $error)
			{
                JFactory::getApplication()->enqueueMessage('XML: ' . $error->message, 'warning');
			}
		}
	
		return $xml;
	}

}