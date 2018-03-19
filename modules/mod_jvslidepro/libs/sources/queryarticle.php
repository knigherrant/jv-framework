<?php
class JVJSlideProSourceQueryArticle{
    private $params;
    function __construct($params){
        $this->params = $params;
    }
    private function query($params){
        $sql = "SELECT id,title,introtext,images,access,alias,catid FROM #__content";
        $where = array();
        $author = implode(',',array_keys(JFactory::getUser()->getAuthorisedGroups()));
        $where[] = "state = 1";
        
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
        $sql .= " LIMIT {$params->get('offset',0)},{$params->get('limit',5)}";
        return $sql;
    }
    function data(){
        $items = array();
        if($this->params->readmore){
                require_once JPATH_SITE . '/components/com_content/helpers/route.php'; 
                $access = !JComponentHelper::getParams('com_content')->get('show_noauth');
                $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
        }
        $this->params->path = (string)$this->params->path;
        
        $db = JFactory::getDbo();
        $db->setQuery($this->query($this->params));
        foreach($db->loadObjectList() as $item){
            JPluginHelper::importPlugin('content');
            $item->text = $item->introtext;
            JDispatcher::getInstance()->trigger('onContentPrepare', array ('com_content.article', &$item, &$item->params, 0));
            $obj = array(
                'title' => $item->title,
                'content' => $item->text,
                'type'  => 'article'
            );
            if($this->params->readmore){
                if($access || in_array($item->access, $authorised)){
                    $obj['link'] = JRoute::_(ContentHelperRoute::getArticleRoute($item->id.':'.$item->alias, $item->catid));
                }else{
                    $obj['link'] = JRoute::_('index.php?option=com_users&view=login');
                }
                $obj['readmore'] = $this->params->readmore;
            }
            $item->images = json_decode($item->images);
            if($this->params->path != 'none'){
                if($this->params->path == 'full' && !empty($item->images->image_fulltext)){
                    $obj['path'] = $item->images->image_fulltext;
                }else if(!empty($item->images->image_intro)){
                    $obj['path'] = $item->images->image_intro;
                }
            }
            if($this->params->thumb){
                $obj['thumb'] = $item->images->image_intro;
            }
            
            $items[] = $obj;
        }
        
        return $items;
    }
}  
?>
