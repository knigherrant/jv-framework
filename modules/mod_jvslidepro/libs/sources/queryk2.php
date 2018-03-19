<?php
class JVJSlideProSourceQueryK2{
    private $params;
    function __construct($params){
        $this->params = $params;
    }
    private function query($params){
        $sql = "SELECT id,title,introtext,access,alias,catid FROM #__k2_items";
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
        return $sql;
    }
    function data(){
        require_once(JPATH_BASE.'/components/com_k2/helpers/route.php');
        $component = JComponentHelper::getComponent('com_k2');
            $params = class_exists('JParameter') ? new JParameter($component->params) : new JRegistry($component->params);
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
            $obj = array(
                'title' => $item->title,
                'content' => $item->introtext,
                'type'  => 'k2'
            );
            if($this->params->introtext){
                JPluginHelper::importPlugin('k2');
                $item->text = $item->introtext;
                JDispatcher::getInstance()->trigger('onContentPrepare', array ('com_k2.item', &$item, &$item->params, 0));
                $obj['content'] = $item->text;
            } 
            if($this->params->readmore){
                if($access || in_array($item->access, $authorised)){
                    $link = K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid);
                    $obj['link'] = urldecode(JRoute::_($link));
                }else{
                    $obj['link'] = JRoute::_('index.php?option=com_users&view=login');
                }
                $obj['readmore'] = $this->params->readmore;
            }
            if($this->params->path !== 'none'){
                if($this->params->path == 'full' && JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image".$item->id).'_XL.jpg')){
                    
                     $obj['path'] = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_XL.jpg';
                    if($params->get('imageTimestamp')){
                        $obj['path'] = $item->images->image_fulltext;
                    }
                }else if(JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg')){
                    $obj['path'] = JURI::root(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg';
                    if ($params->get('imageTimestamp'))
                    {
                        $obj['path'] .= $timestamp;
                    }                  
                }
            }
            $items[] = $obj;
        }
        
        return $items;
    }
}  
?>
