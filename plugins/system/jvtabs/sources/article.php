<?php

class JVTabArticle extends JViewLegacy{
    
    public static function getArticle($config,$load){
        require_once(JPATH_SITE.'/components/com_content/models/article.php');
        $model = new ContentModelArticle();
        $item = $model->getItem((string)$config->id);
        if(!$item) return;
        return array(array(
            'title' =>  $item->title,
            'id'    => 'article-'.$item->id,
            'content' => self::render($item,$config,$load)
        ));
    }
    public static function getArticles($config,$load){
        require_once(JPATH_SITE.'/components/com_content/models/articles.php');
        $model = new ContentModelArticles();
        $state = $model->getState();
        $state->set('filter.category_id',(array)$config->get('cate'));
        $state->set('filter.category_id.include',$config->get('incate',true));
        $state->set('filter.author_id',(array)$config->get('author'));
        $state->set('filter.author_id.include',$config->get('inauthor',true));
        $state->set('filter.featured',(string)$config->get('featured','show'));
        $state->set('list.ordering','a.'.(string)$config->get('order'));
        $state->set('list.direction', (string)$config->get('dir','ASC'));
        
        $state->set('list.start',$config->get('offset',0));
        $state->set('list.limit',$config->get('limit',5));
        
        $items = $model->getItems();
        $data = array();
        
        foreach($items as $item){
            $data[] = array(
                'title' =>  $item->title,
                'id'    => 'article-'.$item->id,
                'content' => self::render($item,$config,$load)
            );
        }
        
        return $data;
    }
    private static function render($item,$config, $load){
        if($config->get('render') == 'text'){
            $content = $item->fulltext?$item->fulltext:$item->introtext;
            switch($load){
                case 'all': return $content;
                    break;
                case 'cache': return array('scripts' => array(),'content' => $content);
                    break;
            }
        } 
        if($config->get('render') == 'intro') return self::renderIntro($item,$config,$load);
        else return self::renderFull($item,$config,$load);        
    }
    private static function renderIntro($item,$config, $load){
        $view = new self($item);
        $template = JFactory::getApplication()->getTemplate(true)->template;
        $path = JPATH_THEMES.'/'.$template.'/html/com_content/featured/default_item.php';
        
        if(!is_file($path)) $path = JPATH_BASE.'/components/com_content/views/featured/tmpl/default_item.php';
        if(!is_file($path)) return false;
        switch($load){
            case 'all': return $view->display($path);
                break;
            case 'cache': 
                return JVTabs::fillAssets(array($view,'display'),array($path));
                break;
        }
    }
    private static function renderFull($item,$config,$load){
        $view = new self($item);
        $view->params = $item->params;
        $view->print = false;
        $view->pageclass_sfx = $item->params->get('pageclass_sfx');
        $template = JFactory::getApplication()->getTemplate(true)->template;
        $path = JPATH_THEMES.'/'.$template.'/html/com_content/article/article.php';
        if(!is_file($path)) $path = JPATH_BASE.'/components/com_content/views/article/tmpl/default.php';
        if(!is_file($path)) return false;
        switch($load){
            case 'all': return $view->display($path);
                break;
            case 'cache': return JVTabs::fillAssets(array($view,'display'),array($path));
                break;
        }
    }
    
    protected $_name = 'JVTabArticle';
    
    function __construct($item){
        $this->item = $item;
    }
    
    function display($path = null){
        $item = $this->item;
        
        $item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;
        $item->catslug = ($item->category_alias) ? ($item->catid . ':' . $item->category_alias) : $item->catid;
        $item->parent_slug = ($item->parent_alias) ? ($item->parent_id . ':' . $item->parent_alias) : $item->parent_id;
        $item->params->set('show_print_icon',false);
        $item->params->set('show_email_icon',false);
        $item->readmore = true;
        $item->alternative_readmore = $item->params->get('alternative_readmore');
        $item->language = '*';
        
        // No link for ROOT category
        if ($item->parent_alias == 'root')
        {
            $item->parent_slug = null;
        }

        $item->event = new stdClass;

        $dispatcher = JEventDispatcher::getInstance();

        // Old plugins: Ensure that text property is available
        if (!isset($item->text))
        {
            $item->text = $item->introtext;
        }
        JPluginHelper::importPlugin('content');
        $dispatcher->trigger('onContentPrepare', array ('com_content.featured', &$item, &$item->params, 0));

        // Old plugins: Use processed text as introtext
        $item->introtext = $item->text;

        $results = $dispatcher->trigger('onContentAfterTitle', array('com_content.featured', &$item, &$item->params, 0));
        $item->event->afterDisplayTitle = trim(implode("\n", $results));

        $results = $dispatcher->trigger('onContentBeforeDisplay', array('com_content.featured', &$item, &$item->params, 0));
        $item->event->beforeDisplayContent = trim(implode("\n", $results));

        $results = $dispatcher->trigger('onContentAfterDisplay', array('com_content.featured', &$item, &$item->params, 0));
        $item->event->afterDisplayContent = trim(implode("\n", $results));
        JHtml::addIncludePath(JPATH_SITE.'/components/com_content/helpers');
        
        
        
        ob_start();
        include($path);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
    public function loadTemplate($tpl = null){}
}  
?>
