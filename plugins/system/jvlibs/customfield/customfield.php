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

$jvcts = JRequest::getVar('jvcts');
if(!empty($jvcts)){
    $file = JPATH_SITE.'/'.$jvcts;
    if(is_file($file)) require_once($file);
}
$customs = JRequest::getVar('__jvcustoms',array());
if(!empty($customs)){
    foreach($customs as $key){
        $root = &$_POST;
        foreach(explode('.',$key) as $key){
            if(isset($root[$key])) $root = &$root[$key];
            else break;
        }
        if (get_magic_quotes_gpc())  $root = stripslashes($root);
        $root = json_decode($root,true);
    }
    
    if (get_magic_quotes_gpc()){
        class plgJVCustomField extends JPlugin{
            function onExtensionBeforeSave($name,$tbl){
                $tbl->params = json_encode($_POST['jform']['params']);
                die();
            }
        }
        new plgJVCustomField(JDispatcher::getInstance());
    }
}


jimport('joomla.form.formfield');
class JFormFieldJVCustom extends JFormField{
     protected $type = 'Jvcustom';
     static $_addOne = false;
     function __construct($form = null){
         parent::__construct($form);
     }
     protected function getInput()
     {
         $params = $this->getParam();
         if(!$params) return '<script type="text/javascript" class="jv-custom-null"></script>';
         
         if(!self::$_addOne){
             self::addOne();
             self::$_addOne = true;
         }
         JFactory::getDocument()->addScriptDeclaration(";(function($){CustomField.init('{$this->id}',(function(a){return a})({$params}));})(jQuery);");
         
         if(empty($this->value)) $this->value = new stdClass();
         if(!is_string($this->value)) $this->value = json_encode($this->value);
        return '
            <div class="clr"></div>
            <div class="jvcustomfieldpanel">
                <input type="hidden" name="__jvcustoms[]" value="'.str_replace(']','',str_replace(array('][','['),'.',$this->name)).'"/>
                <textarea
                    style="display:none"
                    name="'.$this->name.'" 
                    id="'.$this->id.'">
                        '.$this->value.'
                </textarea>
            </div>
        ';
     }
     
     function getParam(){
         $doc = JFactory::getDocument();
         $filepath = (string)$this->element->attributes()->addfieldpath;
         $include = (string)$this->element->attributes()->include;
         $import = (string)$this->element->attributes()->import;
         if(!empty($filepath) && !empty($include)){
             switch($include){
                 case 'php':
                    ob_start();
                    include(JPATH_SITE.$filepath);
                    $content = ob_get_contents();
                    ob_end_clean();
                    return $content;
                 case 'javascript': $doc->addScript(JUri::root(true).$filepath); return $this->includeSource('javascript');
                 case 'css': $doc->addStyleSheet(JUri::root(true).$filepath); return $this->includeSource('css');
                 default: return;
             }
         } 
         self::import($import);
         
         if(!empty($filepath))$params = file_get_contents(JPATH_SITE.$filepath);
         else $params = (string) $this->element;
         if(!empty($include)){
             $this->includeSource($include,$params);
             return false;
         } 
         return self::parseParams($params);
     }
     
     private function includeSource($method,$source = null){
         if($source){
             try{
                $this->{$method}($source);
             }catch(Exception $e){
             }
         }
     }
     
     private function javascript($script){
         JFactory::getDocument()->addScriptDeclaration($script);
     }
     private function php($script){
             eval($script);
     }
     private function css($css){
         JFactory::getDocument()->addStyleDeclaration($css);
     }
     
     private static function addOne(){
         JVJSLib::add('jquery.plugins.customfield');
         JFactory::getDocument()->addScriptDeclaration("
            ;(function($){
                $(function(){
                    $('.jv-custom-null').parents('.control-group').remove()
                    var  _submit = Joomla.submitbutton;
                    Joomla.submitbutton = function(){
                        if(arguments[0].indexOf('cancel') > 0 || CustomField.apply()) _submit.apply(Joomla,arguments);
                    }
                    var _submitForm = Joomla.submitform;
                    Joomla.submitform = function(){
                        if(arguments[0].indexOf('cancel') > 0 || CustomField.apply()) _submitForm.apply(Joomla,arguments);
                    }
                });
            
                $.extend(CustomField,{
                    fields: [],
                    apply: function(){
                        var 
                            errors = 0,
                            msgs = []
                        ;
                        jQuery.each(CustomField.fields,function(){
                            var err = this.data().validate();
                            errors += err;
                            if(err > 0) {
                                msgs.push(this.data().config.label + ' has ' + err +' errors!');
                                return;
                            }
                            this.data()._customform.val(JSON.stringify(this.data().data()));
                        });
                        if(errors > 0){
                            var self = arguments.callee;
                            self.lastAlert && self.lastAlert.remove();
                            var alert = self.lastAlert = $('<div>',{'class':'alert alert-error'})
                            .appendTo('#system-message-container')
                            .append($('<button>',{type:'button', 'class':'close', 'data-dismiss':'alert', html: 'x'}))
                            .append((function(){
                                var ul = $('<ul>');
                                $.each(msgs,function(i,val){
                                    ul.append($('<li>').html(val));
                                });
                                return ul;
                            })())
                            .alert();
                            return false;
                        }
                        return true;
                    },
                    datas: CustomField.datas || {}
                });
                
                
                
                
                CustomField.init = function(id,params){
                     params = params || {};
                    $(function(){
                        var 
                            formData = $('#' + id),
                            custom = new CustomField(params),
                            data
                        ;
                        custom.data()._customform = formData;
                        custom.attr('id', formData.attr('id') + '_custom');
                        try{ data = JSON.parse(formData.val()) }catch(e){}
                        formData.after(custom);
                        
                        if(data && !$.isEmptyObject(data)){
                            custom.data().clear();
                            custom.data().data(data);
                        }
                        CustomField.fields[id] = custom;
                        CustomField.fields.push(custom);
                    });
                }
            })(jQuery);
        ");
          
        JFactory::getDocument()->addStyleDeclaration("
            #module-form div.width-60, #style-form div.width-60{width: 45%;}
            #module-form div.width-40, #style-form div.width-40{ width: 55%;}
        ");
     }
     
     protected function getLabel() {}
     

    private static function parseParams($params){
        preg_match_all('/{::([\w\.\d ]+?):}/',$params,$matches);
        foreach($matches[0] as $i => $match){
            $params = str_replace($match, JText::_($matches[1][$i]),$params);
        }
        return $params;
    }
    
    static $imported = array();
    static function import($args){
        JVJSLib::add('jquery.plugins.customfield');
        if(empty($args)) return;
        foreach(explode(' ',$args) as $arg){
            if(isset(self::$imported[$arg])) continue;
            self::$imported[$arg] = true;
            $arg = "import_{$arg}";
            $fn = array('JFormFieldJVCustom',$arg);
            if(is_callable($fn)) call_user_func_array($fn,array());
        }
    }
    
    private static function import_positions(){
       require_once JPATH_ADMINISTRATOR . '/components/com_modules/helpers/modules.php';
        require_once JPATH_ADMINISTRATOR . '/components/com_modules/models/positions.php';
        $model = new ModulesModelPositions( array("ignore_request" => 1, "state" => new JObject(
            array(
                "filter.search" => null,
                "filter.state"  => "",
                "filter.client_id"  => 0,
                "filter.template"   => "",
                "filter.type"   => "",
                "params"    => array(),
                "list.limit"    => null,
                "list.start"    => null,
                "list.ordering" => "value",
                "list.direction"    =>"asc"
            )
        )));
        $poss = $model->getItems();
        
        $groups = array();
        $lang        = JFactory::getLanguage();
        foreach($poss as $pos => $ops){
            if(empty($ops)) $ops = array( "Custom position" => "Custom position");
            
            foreach($ops as $temp => $name){
                if(!isset($groups[$temp])) $groups[$temp] = array(
                    "children" => array(),
                    "text" => JText::_($temp)
                );
                $group = &$groups[$temp];
                $group['children'][] = array(
                    "id" => $pos,
                    "text" => $lang->hasKey($name)? JText::_($name)." ({$pos})": JText::_($pos)
                );
            }
        }
        JFactory::getDocument()->addScriptDeclaration("CustomField.datas = CustomField.datas || {}; CustomField.datas.positions = ".json_encode(array_values($groups)));
    }
    
    private static function import_menus(){
        require_once JPATH_ADMINISTRATOR . '/components/com_menus/helpers/menus.php';
        $menuTypes = MenusHelper::getMenuLinks();
        $types = array();
        foreach($menuTypes as $type){
            $levels = array((object)array(
                'children' => array()
            ));
            foreach($type->links as $i => $menu){
                $item = new stdClass();
                if($menu->type != 'separator') $item->id = $menu->value;
                $item->text = $menu->text;
                $levels[$menu->level] = $item;
                $parent = $levels[$menu->level - 1];
                if(!isset($parent->children)) $parent->children = array();
                $parent->children[] = $item;
            }         
            
            $types[] = array(
                'text' => $type->title,
                'children' => $levels[0]->children
            );
        }
        
        JFactory::getDocument()->addScriptDeclaration("CustomField.datas = CustomField.datas || {}; CustomField.datas['menus'] = ".json_encode($types));
    }
    
    private static function import_assignment(){
        self::import_menus();
        JFactory::getDocument()->addScript(JVLIBS_URI.'customfield/fields/menuassignment.js');
    }
    
    static function checkMenuAssign($config){
        $selected = (string) $config->selected;
        if($selected == '0') return true;
        if($selected == '-') return false;
        $active = JFactory::getApplication()->getMenu()->getActive();
        if(empty($active)) $inarr = false;
        else $inarr = in_array($active->id,$config->checked->restore()) > 0;
        return $inarr === ($selected > 0);
    }
    
 }

class JVCustomParam extends JVDataObject{
    private $__state;
    private $__val;
    public function __construct($data = null){
        $this->__state = new JVDataObject();
        parent::__construct($data);
    }
    public function apply($data = null){
        if(isset($data->{'@state'})) return $this->apply($this->parse($data));
        return parent::apply($data);
    }
    public function state($key = null){
        if(empty($key)) return $this->__state;
        return $this->__state->$key;
    }
    private function parse($data){
        $state = $this->__state;
        $state->extend($data->{'@state'});
        
        unset($data->{'@state'});
        $method = 'parse_'.$state->field;
        if(method_exists($this,$method)) return $this->{$method}($data);
        return $data;
    }
    
    private function parse_multi($data){
        $data = $data->{'@data'};
        $newItems = array();
        $checks = $this->state('checks');
        if(isset($checks)){
            foreach($checks as $i => $check) if($check) $newItems[] = $data[$i];
        }else $newItems = $data;
        return $newItems;
    }
    private function parse_filter($data){
        return $data->{$this->__state->selected};
    }
    
    private function parse_select2($data){
        return $data->{'@data'};
    }
    
    static function parseParams($params){
        preg_match_all('/{::([\w\.\d ]+?):}/',$params,$matches);
        foreach($matches[0] as $i => $match){
            $params = str_replace($match, JText::_($matches[1][$i]),$params);
        }
        return $params;
    }
}