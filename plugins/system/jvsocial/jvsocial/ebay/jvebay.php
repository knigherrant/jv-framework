<?php
class JVEbay {
    public $params;
    function __construct($params){
        $this->params = $params;
    }

    public function getLatestHTML(){
        $callUrl = "http://edeetion.com/ebayproxy/index.js.php?";

        $resp = array(
            'requestType'                     => 'EBayStore',
            'storeName'                       => urlencode($this->params->get('storeName', '')),
            'keywords'                        => $this->params->get('keywords', ''),
            'paginationInput.entriesPerPage'  => $this->params->get('maxEntries', '3'),
            'sortOrder'                       => $this->params->get('sortOrder', 'BestMatch'),
            'openlink'                        => $this->params->get('openlink' , '_blank'),
            'GLOBAL-ID'                       => $this->params->get('global_id', 'EBAY-US'),
            'proxy_display_language'          => $this->params->get('proxy_display_language'),
        );
        if(!$resp['storeName']) return JText::_('Please enter you store Name');
        /**
         * 'searchResult.item.globalId'      => $this->params->get('global_id', 'EBAY-US'),

        searchResult.item.country
        searchResult.item.globalId
         */
        $category_id = $this->params->get('categoryId', '');
        if(trim($category_id) !== "")
            $resp['categoryId'] = $category_id;

        $first = true;
        //add the user params to they request url
        foreach ($resp as $key=>$param){
            if($first){
                $callUrl .= $key . '=' . $param;
                $first = false;
            } else {
                $callUrl .= '&' . $key . '=' . $param;
            }
        }
        return '<script type="text/javascript" src="'.$callUrl.'"></script><div class="clearEbay"></div>';
    }
}