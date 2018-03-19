<?php
require_once(JPATH_SITE.'/administrator/components/com_k2/models/model.php');
require_once(JPATH_SITE.'/components/com_k2/models/itemlist.php');
require_once(JPATH_SITE.'/components/com_k2/models/item.php');
require_once(JPATH_SITE.'/components/com_k2/helpers/utilities.php');
require_once(JPATH_SITE.'/components/com_k2/helpers/route.php');
require_once(JPATH_SITE.'/components/com_k2/helpers/permissions.php');
require_once(JPATH_SITE.'/administrator/components/com_k2/tables/k2category.php');

class JVTabK2 extends JViewLegacy{
    public static function getK2Item($config,$load){
        $query = "SELECT * FROM #__k2_items WHERE id={$config->id}";
        $db = JFactory::getDbo();
        $db->setQuery($query, 0, 1);
        $item = $db->loadObject();
        if(!$item) return;
        return array(array(
            'title' =>  $item->title,
            'id'    => 'article-'.$item->id,
            'content' => self::render($item,$config,$load)
        ));
    }
    public static function getK2Items($params,$load){
        $sql = "SELECT * FROM #__k2_items";
        $where = array();
        $author = implode(',',array_keys(JFactory::getUser()->getAuthorisedGroups()));
        $where[] = "published = 1";
        
        if(count($params->cate)){
            $params->cate = implode(',',$params->cate->restore());
            $where[] = " catid IN({$params->cate})";
        }
        $params->featured =  (string)$params->featured;
        if($params->featured == 'nofeatured') $where[] = " featured = 1";
        else if($params->featured == 'onlyfeatured') $where[] = " featured = 0";
        
        if(!empty($where)){
            $where = implode(" AND ",$where);
            $sql .= " WHERE {$where}";
        }
        if(count($params->order)){
            $order = array();
            $orders = array(
                'publish_asc'       => 'publish_up ASC',
                'ordering_asc'      => 'ordering ASC',
                'hits_asc'          => 'hits ASC',
                'publish_desc'       => 'publish_up DESC',
                'ordering_desc'      => 'ordering DESC',
                'hits_desc'          => 'hits DESC'
            );
            foreach($params->order as $o){
                $order[] = $orders[$o];
            }
            $order = implode(',',$order);
            $sql .= " ORDER BY {$order}";
        };
        $sql .= " LIMIT {$params->get('offset')},{$params->get('limit')}";
        $db = JFactory::getDbo();
        $db->setQuery($sql);
        $items = $db->loadObjectList();
        
        
        foreach($items as $item){
            $data[] = array(
                'title' =>  $item->title,
                'id'    => 'article-'.$item->id,
                'content' => self::render($item,$params,$load)
            );
        }
        
        return $data;
    }
    private static function render($item,$config,$load){
        if($config->get('render') == 'text'){
            $content = $item->fulltext?$item->fulltext:$item->introtext;
            switch($load){
                case 'all': return $content;
                    break;
                case 'cache': 
                    return array('scripts'=> array(),'content'=>$content);
                    break;
            }
        } 
        else return self::renderIntro($item,$config,$load);
        
    }
    private static function renderIntro($item,$config,$load){
        $view = new self($item);
        $template = JFactory::getApplication()->getTemplate(true)->template;
        $path = JPATH_THEMES.'/'.$template.'/html/com_k2/templates/default/category_item.php';
        if(!is_file($path)) $path = JPATH_BASE.'/components/com_k2/templates/default/category_item.php';
        if(!is_file($path))return;
        switch($load){
            case 'all': return $view->display($path);
                break;
            case 'cache': 
                return JVTabs::fillAssets(array($view,'display'),array($path));
                break;
        }
    }
    
    protected $_name = 'JVTabK2Item';
    
    function __construct($item){
        $this->item = $item;
    }
    
    function display($path = null){
        $item = $this->item;
        $item->image_caption = '';
        $item->itemGroup = 'leading';
        
        
        $mainframe = JFactory::getApplication();
        $params = K2HelperUtilities::getParams('com_k2');
        $document = JFactory::getDocument();
        $user = JFactory::getUser();
        $cache = JFactory::getCache('com_k2_extended');
        $model = new K2ModelItemlist();
        $itemModel = new K2ModelItem();
        $theme = $params->get('theme');
        
        $this->params = $params;
        $itemModel->prepareItem($item,'itemlist','');
        $itemModel->execPlugins($item,'itemlist','');
        
        
        
        ob_start();
        include($path);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
    public function loadTemplate($tpl = null){}
}  
?>
