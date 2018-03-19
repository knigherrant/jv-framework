<?php
  jimport('joomla.form.formfield');
     class JFormFieldClearcache extends JFormField{
         protected $type = 'clearcache';
         protected function getInput()
         {
             
            $doc = JFactory::getDocument();
            $attrs = $this->element->attributes();
            $label = (string) $attrs['label'];
            $label = JText::_($label);	 
            return '<button class="btn btn-success btn-clearcache">Clear Cache</button>';
         }
        
     }
?>