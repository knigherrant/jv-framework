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
jimport ( 'joomla.application.component.modeladmin' );

class JVFrameworkManagerModelStyle extends JModelAdmin {
	protected $option = 'com_jvframework';
        public $tmpl = null;


        public function __construct($config = array()){
		parent::__construct($config);
		
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_templates/models');
		JForm::addFieldPath(JPATH_ADMINISTRATOR.'/components/com_templates/models/fields');
		JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_templates/tables');
		
		$lang = JFactory::getLanguage();
		$lang->load('com_templates');
		
		$this->model = JModelLegacy::getInstance('Style', 'TemplatesModel');		
	}
	
	public function getTable($type = 'Style', $prefix = 'TemplatesTable', $config = array())
	{
		JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_templates/tables');
		return JTable::getInstance($type, $prefix, $config);
	}
	
	
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 *
	 * @return	mixed	A JVFrameworkForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_jvframework.style', 'style', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}	
	
	/**
	 * Method to preprocess the form
	 *
	 * @param   JForm   $form   A form object.
	 * @param   mixed   $data   The data expected for the form.
	 * @param   string  $group  The name of the plugin group to import (defaults to "content").
	 *
	 * @return  void
	 *
	 * @since   1.6
	 * @throws  Exception if there is an error loading the form.
	 */
	protected function preprocessForm(JForm $form, $data, $group = 'content')
	{	
		$feature  = JV::helper('extension');
		$features = $feature->getExtensionList();
		
		if(is_array($features)){
			foreach ($features as $key => $feature) {
				$form->loadFile($feature, true, '//config');				
			}	
		}	
		
		// Trigger the default form events.
		parent::preprocessForm($form, $data, $group);
	}
	
	public function delete(&$pks)
	{		
		return $this->model->delete($pks);
		
	}
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_jvframework.edit.style.data', array());
	
		if (empty($data)) {
			$data = $this->getItem();
		}
	
		return $data;
	}
	
	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed    Object on success, false on failure.
	 *
	 * @since   11.1
	 */
	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);
		if(!$item->params){			
			// Support backend template
			if($item->client_id){
				$path = JPATH_ADMINISTRATOR.'/templates';
			}else{
				$path = JPATH_SITE.'/templates';
			}
			$registry = new JRegistry;
			$registry->loadFile($path.'/'.$item->template.'/params.json');
			$item->params = $registry->toArray();
		}
                $item->version = $this->getVersion($item->template);
		return $item;
	}
	
	function getVersion($template){
            $template = JURI::root() . '/templates/'.$template.'/templateDetails.xml';
            $this->tmpl = $details = JApplicationHelper::parseXMLInstallFile($template);
            return $details['version'];
        }
        
        function getDesc(){
            return $this->tmpl['description'];
        }
        
        
	function duplicate($pks = array()) {
		return $this->model->duplicate($pks);
	}
	
	public function save($data) {
		if (JFactory::getApplication()->input->get ( 'task' ) == 'reset') {
			$data ['params'] = '{}'; 
		}else{
                    if( (int) $data ['params']['menu']['responsive'] < 768) $data ['params']['menu']['responsive'] = 768;
                    
                }
       
        if(is_array($data ['params'])){
            if (get_magic_quotes_gpc()) {
                $process = array(&$data ['params']);
                while (list($key, $val) = each($process)) {
                    foreach ($val as $k => $v) {
                        unset($process[$key][$k]);
                        if (is_array($v)) {
                            $process[$key][stripslashes($k)] = $v;
                            $process[] = &$process[$key][stripslashes($k)];
                        } else {
                            $process[$key][stripslashes($k)] = stripslashes($v);
                        }
                    }
                }
                unset($process);
            }
        }
		$return = $this->model->save ( $data );		
		$this->setState($this->getName() . '.id', $this->model->getState($this->getName() . '.id'));
		
		return $return;
	}
	
        
	/**
	 * Method to set template to default.
	 *
	 * @return	bool.
	 * @since	1.6
	 */
	public function setDefaultTemplate() {
		$this->unsetDefaultTemplate ();
		$db = $this->getDbo ();
		$query = $db->getQuery(true);
		$query->update ( '#__template_styles' );
		$query->set ( '`home` = 1' );
		$query->where ( 'client_id = 0' );
		$query->where ( 'template = ' . $db->quote ( 'jv-framework' ) );
		$db->setQuery ( ( string ) $query . " LIMIT 1" );
		$db->query ();
		
		return true;
	}
	
	/**
	 * Method to unset default template.
	 *
	 * @return	bool.
	 * @since	1.6
	 */
	public function unsetDefaultTemplate() {
		$db = $this->getDbo ();
		$query = $db->getQuery(true);
		$query->update ( '#__template_styles' );
		$query->set ( '`home` = 0' );
		$query->where ( 'client_id = 0' );
		$query->where ( '`home` = 1' );
		$db->setQuery ( ( string ) $query );
		$db->query ();
		
		return true;
	}

}