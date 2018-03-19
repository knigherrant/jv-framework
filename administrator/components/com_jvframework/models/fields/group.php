<?php
  jimport('joomla.form.formfield');
     class JFormFieldGroup extends JFormField{
         protected $type = 'group';
         protected function getInput()
         {
             if(get_magic_quotes_gpc()){
                 $this->value = stripslashes($this->value);
             }
             JHtml::_('jquery.ui');
             $doc = JFactory::getDocument();
             $attrs = $this->element->attributes();
            $label = (string) $attrs['label'];
            $label = JText::_($label);	 
            $class = (string) $attrs['class'];
            if($class) $class = "class='$class'";
            return "<div $class>$label";
         }
         function getParams(){
             return json_encode($this->getJSONField($this->element));
         }
         protected function getLabel() {}
     }
?>