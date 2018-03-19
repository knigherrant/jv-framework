<?php
class JVTabs{
    private $tabs = array(),$params;
    private static $count = 0;
    private static $docID = 0;
    public $id;
    
    static function fillAssets($fn,$args = array()){
        $cacheDoc = JFactory::getDocument();
        $jslibLoaded = JVJSLib::$loaded;
        JVJSLib::$loaded = array();
        $doc = JDocument::getInstance('html', array(
            'type' => 'jvtabs',
            'id' =>  self::$docID ++
        ));
        JFactory::$document = $doc;
        $doc = JFactory::getDocument();
        $content = call_user_func_array($fn,$args);
        $assets = array(
            'scripts' => array(),
            'script' => array(),
            'styles' => array(),
            'content' => $content
        );
        
        foreach($doc->_scripts as $k => $v) $assets['scripts'][] = array('src' => $k, "cache" => true);
        foreach($doc->_script as $v) $assets['script'][] = $v;
        foreach($doc->_styleSheets as $k => $v) $assets['styles'][] = array('src' => $k, "cache" => true);
        foreach($doc->_style as $v) $assets['styles'][] = $v;
        JFactory::$document = $cacheDoc;
        JVJSLib::$loaded = $jslibLoaded;
        return $assets;
    }
    function __construct($params){
        $this->params = $params;
        $this->id = 'jvtab-'.self::$count;
        self::$count ++;
    }
    private function from_position($param){
        $modules = JModuleHelper::getModules((string)$param->position);
        $tabs = array();
        foreach($modules as $module){
            switch($this->params->config->get('load','all')){
                case 'all': $content = JModuleHelper::renderModule($module); break;
                case 'cache': $content = self::fillAssets(array('JModuleHelper','renderModule'),array($module)); break;
            }
            
            $tabs[] = array(
                'title' =>  $module->title,
                'id'    => 'module-'.$module->id,
                'content' => $content
            );
        }   
        return $tabs;
    }
    
    private function from_article($param,$load){
        require_once('article.php');
        return JVTabArticle::getArticle($param,$load);
    }
    private function from_queryarticle($param,$load = 'all'){
        require_once('article.php');
        return JVTabArticle::getArticles($param,$load);
    }
    private function from_k2item($param,$load = 'all'){
        require_once('k2.php');
        return JVTabK2::getK2Item($param,$load);
    }
    private function from_queryk2($param,$load = 'all'){
        require_once('k2.php');
        return JVTabK2::getK2Items($param,$load);
    }
    
    public function render(){
        JVJSLib::add('jquery.plugins.imagesloaded');
        JVJSLib::add('jquery.plugins.transform');
        
        
        foreach($this->params->tabs as $tab){
            $method = 'from_'.$tab->state('selected');
            if(!method_exists($this,$method)) continue;
            $tabs = $this->{$method}($tab,(string)$this->params->config->get('load','all'));
            if(!$tabs) continue;
            $this->tabs = array_merge($this->tabs,$tabs);
        }
        $tabHead = '<div class="JVTab-nav"><div class="nav-content"><ul>';
        $contents = '<div class="JVTab-content">';
        foreach($this->tabs as $tab){
            $tab['id'] = $this->id.'-'.$tab['id'];
            $tabHead .= '<li><a href="#'.$tab['id'].'"><span>'.$tab['title'].'</span></a></li>';
            $content = '';
            if(is_array($tab['content'])){
                $this->params->config['cache.'.$tab['id']] = $tab['content'];
            }else $content = $tab['content'];
            $contents .= '<div id="'.$tab['id'].'">'.$content.'</div>';
        }
        $contents .= '</div>';
        $tabHead .= '</ul></div></div>';
        
        $options = (string)$this->params->config;
        $doc = JFactory::getDocument();
        $doc->addScript(JUri::root(true).'/plugins/system/jvtabs/sources/jvtabs.sys.site.js');
        $doc->addStyleSheet(JUri::root(true).'/plugins/system/jvtabs/sources/jvtabs.sys.site.css');
        $doc->addScriptDeclaration("
            jQuery(function($){
                new JVTab('#{$this->id}',{$options});
            });
        ");
        return '<div id="'.$this->id.'" class="JVTab">'.$tabHead.$contents.'</div>';
    }
}
?>
