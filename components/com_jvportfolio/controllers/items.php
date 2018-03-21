<?php
/**
 * @version     1.0.0
 * @package     com_jvportfolio
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      phpkungfu <info@phpkungfu.club> - http://www.phpkungfu.club
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';
require_once JPATH_COMPONENT.'/helpers/jvportfolio.php';

/**
 * Items list controller class.
 */
class JvportfolioControllerItems extends JvportfolioController
{
	
    public function toggleVote() {
        $db = JFactory::getDbo();
        $u = JvportfolioFrontendHelper::getUid();
        $pfid = JRequest::getInt('pfid', 0);
        if(!$pfid) {
            return null;
        }
        $rs = $db
        ->setQuery("SELECT id 
                    FROM #__jvportfolio_liked 
                    WHERE u = '{$u}' AND pfid={$pfid}")
        ->loadColumn(); 
        $rs = trim(implode(',',$rs), ',');
        if(empty($rs)) {
            $db
            ->setQuery("INSERT INTO #__jvportfolio_liked(pfid, u) 
                        VALUES ({$pfid}, '{$u}')")
            ->execute();
        }
        else {
            $db
            ->setQuery("DELETE FROM #__jvportfolio_liked 
                        WHERE id in ({$rs})")
            ->execute();
        }
        header('Content-Type: application/json');
    die(json_encode(array(
        'data'=>intval($db
        ->setQuery("SELECT count(*) as c 
                    FROM #__jvportfolio_liked 
                    WHERE pfid={$pfid}")
        ->loadObject()->c)
        )));
    }
    
    public function buildCss(){
        header('Content-Type: text/css'); 
        $app = JFactory::getApplication();
	    $skins = array('pfo.css');
        if($eskin = JRequest::getVar('skinextend', 0)){
            $skins[] = $eskin;
        }
        foreach($skins as $item) {
            require_once(JPATH_COMPONENT."/assets/css/{$item}");      
        }
        
        $app->close();
    }
    
    public function buildJs(){
        header('Content-Type: text/javascript');
        $app = JFactory::getApplication();
        
		$pfoid = JRequest::getVar('pfoid', 0);
		if(!$pfoid) {$app->close();return false;}
		
		
        $lib = array(
            "modernizr.custom.min.js",   
            "jquery.shuffle.js", 
            "jquery.infinitescroll.js", 
            "fresco.js", 
            "frontend.jvportfolio.js"
        );
        $mid = JRequest::getInt('mid', 0);
        $pageTotal = JRequest::getInt('pageTotal', 0);
        $limit = JRequest::getInt('limit', 0);
		
		$menu = $app->getMenu()->getItem($mid);
		
		$format = 'hfetch';
		if(preg_match('/mod-frm-portfolio/', $pfoid)) {
			$format = "html";
			$idMod = intval(preg_replace('/mod-frm-portfolio-/', '', $pfoid));
			$mparams = JvportfolioFrontendHelper::getModule($idMod);
			
			if(!$mparams) {$app->close();return false;}
		}else {
			$mparams = $menu->params; 
		}
		
        $jstext = "";
        
        $mfetch = $mparams->get('mfetch', 'scroll');
        $jstext .= "window.JV = jQuery.extend(window.JV, {mfetch: '{$mfetch}'});";
        
        // sort and filter
        if(intval($mparams->get('filter'))) {
            $lib[] = "extend.filter.portfolio.js";
            $jstext .= "window.JV = jQuery.extend(window.JV, {cfilter: 1});";
        }
        if($mparams->get('sort', 0)) {
            $jstext .= "window.JV = jQuery.extend(window.JV, {csort: 1});";
        }
        
        // Layout device
        if( ( $use_layoutdevice = $mparams->get('use_layoutdevice', 0) ) && intval( $use_layoutdevice ) ) {
            $lib[] = "extend.sizer.portfolio.js";
            $layoutdevice = $mparams->get( 'layoutdevice', '' );
            $jstext .= "window.JV = jQuery.extend(window.JV, {bp: ( function( p ) { return p || 0; } )( {$layoutdevice} ) });"; 
        }
        
        // Effect loading
        if($effect = $mparams->get('effect', '')) {
            $lib[] = "extend.effect.portfolio.js";
            $jstext .= "window.JV = jQuery.extend(window.JV, {pfoEffect: 'animated {$effect}'});";
        }
        
        // method fetch
        switch($mfetch){
            case 'button':
            $lib[] = "extend.scrf.js";
            break;
            case 'nav':
            $lib[] = "jquery.simplePagination.js";
            $lib[] = "extend.scrf.js";      
            break;    
        }
        
        // setup
        $citems = "#{$pfoid} .box-portfolio .pfo-item"; 
        $link = JUri::root().$menu->link;
        $jstext .= "
            jQuery(function($){
                var pf = $('#{$pfoid} .box-portfolio'),
                    ppf = pf.closest('#{$pfoid}'),
                    msg = ppf.find('.pf-load'),
                    sequentialFadeDelay = 150
                ;
                pf.infinitescroll({
                    itemSelector : '{$citems}',
                    loading: {msg: msg},
                    maxPage: (function(mp){return mp})({$pageTotal}),
                    path: function(p){
                        var 
                        limit = {$limit},
                        url = '{$link}&Itemid={$menu->id}&limit={$limit}&limitstart=0&format={$format}'
                        ; 
                        return url.replace(/limitstart=\d+/, ['limitstart',(p-1)*limit].join('='));   
                    }
                }, function(items){
                    var items = $(items);
                    items.imagesLoaded(function(){
                        !$.fn.pfoEffect || items.pfoEffect('after-imagesLoaded', JV.pfoEffect, sequentialFadeDelay);
                        pf.shuffle('appended', items); 
                    });                
                });
                if(window.JV.cfilter) {
                    ppf.extendFilterScrf({pf : pf});
                }
                if(window.JV.mfetch == 'button'){
                    pf.extendScrfBtn({
                        doc: $(document), 
                        mark: ppf.find('.load-more'),
                        maxPage: (function(mp){return mp})({$pageTotal})
                    });
                }
                if(window.JV.mfetch == 'nav'){
                    pf.extendScrfNav({    
                        mark: ppf.find('[data-nav]'),
                        pagination: {
                            pages: (function(mp){return mp})({$pageTotal}),
                            itemsOnPage: (function(mp){return mp})({$limit})
                        }
                    });
                }  
                !window.JV.csort || ppf.find('#csort').asort({pf: pf});  
                pf.imagesLoaded(function(){
                    pf.trigger( 'shuffle_before_init' );
					
					var oshuffle = pf.data( 'shuffle-option' );
					oshuffle = oshuffle || {};
					
					pf.shuffle( $.extend( {}, {
						itemSelector: '{$citems}'
						,sequentialFadeDelay: sequentialFadeDelay
						,sizer: pf.children( '.sizer' )
					}, oshuffle || {} ) )
					.trigger( 'shuffle_after_init' );
                    msg.hide(0);
                });        
                var doc = $(document);
                
                doc
                .pfQuickView({pf: pf})
                .pfVote()
                ;           
                
                !window.JV.bp || doc.trigger( 'sizer-element', [ pf, '{$citems}' ] );
            });
        ";
        
        // output
        foreach($lib as $item) {
            require_once(JPATH_COMPONENT."/assets/js/{$item}");    
        }
        echo $jstext;
        
        $app->close();
    }
}