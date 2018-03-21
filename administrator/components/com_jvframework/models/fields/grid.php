<?php
  jimport('joomla.form.formfield');
     class JFormFieldGrid extends JFormField{
         protected $type = 'Jvcustom';
         protected function getInput()
         {
             if(get_magic_quotes_gpc()){
                 $this->value = stripslashes($this->value);
             }
             JVJSLib::add('jquery.ui.interactions');
             $doc = JFactory::getDocument();
             $attrs = $this->element->attributes();
             $config = array(
                "totalGrid" => (int)$attrs->grids,
                "maxColumn" => (int)$attrs->column,
                "changeColumn" => (bool)(int)$attrs->change
             );
             
             $doc->addScript ( JURI::base () . "components/com_jvframework/assets/js/grid.js" );
             $doc->addScriptDeclaration("
                jQuery(function($){
                    JVCustomGrid($('#{$this->id}'),".json_encode($config).");
                });
             ");
			 
			 $label = (string) $attrs['label'];
			 
			 
             return "<label>$label</label><div class=\"jvfieldgrid\" id=\"{$this->id}\"><textarea name=\"{$this->name}\" class=\"hidden\" id=\"{$this->id}\">{$this->value}</textarea></div>";
         }
         function getParams(){
             return json_encode($this->getJSONField($this->element));
         }
         protected function getLabel() {}
     }
?>
