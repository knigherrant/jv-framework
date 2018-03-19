<?php
/**
 * @version     1.0.0
 * @package     com_jvss
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PHPKungfu <info@phpkungfu.club> - http://www.joomalvi.com
 */

// No direct access
defined('_JEXEC') or die;

jimport( 'joomla.application.component.controllerform' );
jimport( 'joomla.filesystem.archive' );
jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );

/**
 * Item controller class.
 */
class JvssControllerItem extends JControllerForm
{

    function __construct() {
        $this->view_list = 'items';
        parent::__construct();
    }
    
    public function includeCss(){
        
        $styles = JFactory::getDbo()
        ->setQuery("SELECT handle, params FROM `#__jvss_css`;")
        ->loadObjectList();
        
        if( $styles && count($styles) ) {
            
            $str = "";
            foreach( $styles as $sitem ) {
                $str .= sprintf("%s { %s }\n", $sitem->handle, self::obj2Css( json_decode( $sitem->params ) ) );
            }  
            
            die( $str );  
        }
        
        return die();
    }
    
    public static function obj2Css( $arr = array() ){
        $str = ""; 
        foreach( $arr as $k => $v ) {
            $str .= "{$k}:{$v};";    
        }
        return $str;   
    }
    
    public function backUrl() {
        $this->setRedirect( JRoute::_( 'index.php?option=com_jvss' ) );
        $this->redirect();
    }
    
    public function import(){
        $path_temp = JPATH_SITE . "/tmp/";
        $extractdir = $path_temp . time();
        $file = JRequest::getVar('pkg', array(), 'files', 'array');
        
        if( !count( $file ) ) {
            $this->setError('COM_JVSS_ERROR_NO_FILE');
            $this->backUrl();
            return false;
        }; 
        $fpath = $path_temp . $file[ 'name' ];
        JFile::upload( $file[ 'tmp_name' ], $fpath );
        JFolder::exists( $extractdir ) || JFolder::create( $extractdir );              
        if( !JArchive::extract( $fpath, $extractdir ) ) {
            
            $this->setError('COM_JVSS_ERROR_EXTRACT');
            $this->backUrl();
            return false;
        }
        
        // get data zip with type
        $t_jvss = "{$extractdir}/jvss.json";
        if( JFile::exists( $t_jvss ) )
        {
            if( ( $slider = file_get_contents( $t_jvss ) ) && $slider = json_decode( $slider, true ) )
            {
                JFolder::copy( "{$extractdir}/images", JPATH_SITE . '/images', '', true );
                
                $this->_importe_process( $slider, $extractdir, $fpath );
                
                return false;   
            }
             
            $this->backUrl();
            
            return false;   
        }                   
        
        // copy image
        $aimage     =  "{$extractdir}/images";
        if( JFolder::exists( $aimage ) ) {
            
            foreach( JFolder::listFolderTree( $aimage ) as $ifolder ) {
                $cf     = $ifolder[ "fullname" ];
                $dest   = end( explode( "images", $cf ));
                $dest   =  JPATH_SITE . "/images{$dest}";
                JFolder::exists( $dest ) || JFolder::create( $dest );
                foreach( JFolder::files( $cf ) as $i ) {
                    JFile::copy( "{$cf}/{$i}", "{$dest}/{$i}" );
                }
            }
        }
        
        // get animate custom
        $acustom = array();
        $acustom_export = "{$extractdir}/custom_animations.txt";
        if( JFile::exists( $acustom_export ) ) {
            
            $acustom    = unserialize( file_get_contents( $acustom_export ) );  
            $acustom    = JvssHelper::buildAnimationCustom( $acustom );   
        }
        
        
        // get data slider
        $slider_export = "{$extractdir}/slider_export.txt";
        $slider = array( 'customcss' => '' );
        if( JFile::exists( $slider_export ) ) {
            
            $slider_export          = unserialize( file_get_contents( $slider_export ) ); 
            
            // params of slider
            $params                 = JvssHelper::getArray( $slider_export, 'params', array() );
            $soparams 				= $params;
            $slider[ 'name' ]       = JvssHelper::getArray( $params, 'title', '' );
            $slider[ 'sconfig' ]    = JvssHelper::filterParams( $params );
            $slider[ 'state' ]      = 1;
            $slider[ 'customcss' ] .= stripslashes( JvssHelper::getArray( $params, 'custom_css', '' ) );
            
            // slides         
            $slides                 = array();
            $sindex                 = rand( 0, 1000 );
            foreach( JvssHelper::getArray( $slider_export, 'slides', array() ) as $k => $slide ) {
                
                // params of slide
                $oparams_slide              = JvssHelper::getArray( $slide, 'params', array() );
                $params_slide               = $oparams_slide;
                $bgsrc                      = JUri::root() . "images/" . JvssHelper::getArray( $params_slide, 'image', '' );   
                $params_slide[ 'state' ]    = JvssHelper::getState( JvssHelper::getArray( $params_slide, 'state', '' ) );  
                $params_slide               = JvssHelper::mapKey( $params_slide, 'slide' );
                $params_slide               = JvssHelper::getAttrBg( $oparams_slide, $params_slide );
                $params_slide[ 'bgsrc' ]    = $bgsrc;
                
                // item in slide
                $layers = array();
                $zIndex = 1;
                $lindex = rand( 0, 1000 );
                foreach( JvssHelper::getArray( $slide, 'layers', array() ) as $k => $item ) {
                   
                    // params of item
                    $item_type      = JvssHelper::getArray( $item, 'type', '' ); 
                    $params_item    = JvssHelper::mapKey( $item, 'layer' ); 
                    
                    // params of item - part loop
                    if( ( $loop_animation = JvssHelper::getArray( $item, 'loop_animation', 'none' ) ) && $loop_animation !== 'none' ) {
                        
                        JvssHelper::getLoop( $item, $params_item );

                    } 
                    
                    // params of item - part content
                    $params_item[ 'content' ]   = JvssHelper::getLayerType( $item );
                    
                    // params of item - part time
                    $params_item[ 'timeline' ]  = JvssHelper::getTimer( $item );

                    // params of item - zIndex part
                    $params_item[ 'zIndex' ] = $zIndex;
                    
                    // params of item - part position
                    $params_item[ 'pos' ]       = JvssHelper::getPosition( $item );
                    
                    // params of item - part animationcustomin | animationcustomout
                    $acustom_types               = JvssHelper::getAnimationCustomType( $item );
                    if( count( $acustom ) && count( $acustom_types ) ) {
                        
                        $params_item            = JvssHelper::getAnimationCustom( $acustom, $acustom_types, $params_item );
                        
                    }
                    
                    // params of item - part video
                    if( $item_type === 'video' && ( $vdata = JvssHelper::getArray( $item, 'video_data', false) ) ) {
                        
                        JvssHelper::getVideoData( $params_item,  $vdata );
                    }
                    
                    $layers[ ( $lindex + $zIndex ) ]  = $params_item;  

                    $zIndex ++;
                }
                
                $params_slide[ 'items' ]    = $layers;
                $slides[ ( $sindex ++ ) ]  = $params_slide;
            }
            $slider[ 'params' ] = $slides;   
        }
        
        // get css
        foreach( Jfolder::files( $extractdir, '\.css$' ) as $stylesshet ) {
            $sspath = "{$extractdir}/{$stylesshet}";
            if( !JFile::exists( $sspath ) ) { continue; }
            $slider[ 'customcss' ] .= file_get_contents( $sspath );    
        }

        if( isset( $soparams[ 'load_googlefont' ] ) 
        	&& $soparams[ 'load_googlefont' ] == 'true'
        	&& isset( $soparams[ 'google_font' ] ) ) {
            
            $fonts = "";
            foreach ( $soparams[ 'google_font' ] as $font ) {
            
                $font = stripslashes( $font );
            
                if( !preg_match( '/fonts\.[^(\'|")]+/', $font, $rs ) ) { continue; }
            
                $fonts .= "@import url('//{$rs[0]}');\n";

            }

            $slider[ 'customcss' ] = $fonts . $slider[ 'customcss' ];
        }
        
        $this->_importe_process( $slider, $extractdir, $fpath );
    }
    
    protected function _importe_process( $slider, $extractdir = '' , $fpath = '' )
    {
        $tbl = $this->getModel()->getTable();
        $id = JRequest::getInt( 'id', 0 );
        
        if( !$tbl->load( $id ) ) 
        {
            $this->setError('COM_JVSS_ERROR_EXTRACT');
            $this->backUrl();
            return false;    
        }
        
        if( !$tbl->bind( $slider ) ) {
            
            return JError::raiseWarning( 500, $tbl->getError() );
        }
        
        if( !$tbl->store() ) {
            
             JError::raiseWarning( 500, $tbl->getError() );    
        }
        
        // empty file upload
        !JFolder::exists( $extractdir ) || JFolder::delete( $extractdir );   
        !JFile::exists( $fpath ) || JFile::delete( $fpath );
        
        // callback to edit
        $this->setMessage( JText::_( 'COM_JVSS_MSG_IMPORT' ) );
        $this->setRedirect( JRoute::_( "index.php?option=com_jvss&task=item.edit&id={$tbl->id}", false ) );  
        $this->redirect();
        
    }
    
    public function sexport()
    {
        $id = JRequest::getVar( 'id', 0 );
        
        if( !$id ) { die(); }
        
        $model = $this->getModel()->getTable();
        
        if( !$model->load( $id ) ) { die(); }
        
        if( !class_exists( 'ZipArchive' ) ) { die(); }
        
        $fn = JPATH_CACHE . '/' . md5( $model->id ) . '.zip';
        
        if( !function_exists( 'str_get_html' ) )
        {
            require_once( JPATH_ADMINISTRATOR . '/components/com_jvss/helpers/simple_html_dom.php' );
        }                                     
         
        $zip = new ZipArchive();
        if( !$zip->open( $fn, ZIPARCHIVE::CREATE | ZipArchive::OVERWRITE ) ) { die(); }
        $d = array_fill_keys( array( 'name', 'params', 'state', 'customcss', 'sconfig' ), '' ); 
        foreach( $d as $k => $v ) { $d[ $k ] = $model->{ $k }; }
        // CREATE INFO
        $zip->addFromString( 'jvss.json', json_encode( $d ) );
        // CREATE IMAGE     
        if( ( $params = json_decode( $model->params ) ) )        
        {
            foreach( $params as $slide )
            {
                // MAIN IMAGE
                if( property_exists( $slide, 'bgsrc' ) && $slide->bgsrc )
                {
                    $this->_zip_add_file_image( $zip, $slide->bgsrc );                                                                
                }   
                
                // LAYER IMAGE
                if( property_exists( $slide, 'items' ) )                
                {
                    foreach( $slide->items as $layer )
                    {
                        // SEARCH IN CONTENT
                        if( property_exists( $layer, 'content' ) && $layer->content )
                        {
                            if( ( $layer_imgs = JvssHelper::get_the_image_src( $layer->content ) ) && count( $layer_imgs ) )
                            {
                                foreach( $layer_imgs as $layer_img )
                                {
                                    $this->_zip_add_file_image( $zip, $layer_img );
                                }
                            }
                        }                                                                        
                        
                        // SEARCH IN COVER VIDEO
                        if( property_exists( $layer, 'urlPoster' ) && $layer->urlPoster )
                        {
                            $this->_zip_add_file_image( $zip, $layer->urlPoster );                                                                 
                        }
                    }
                }
            }
        }
        $zip->close();                                                                                      
        
        header( 'Content-Type: application/zip' );
        header( 'Content-Disposition: attachment; filename="' . basename( $fn ) . '"' );
        readfile( $fn );           
        @unlink( $fn );
        die();       
    }
    
    protected function _zip_add_file_image( $zip, $path = '' )
    {
        if( $path = JvssHelper::get_the_image_path( $path ) )
        {
            $zip->addFile( $path, ltrim( str_replace( JPATH_SITE, '', $path ), '/' ) ); 
            
        }
    }
    
    function syt()
    {
        header( 'Content-Type: application/json' );
        
        $rs = array();
        
        if ( ( $q = JRequest::getVar( 'q', false ) ) && ( $maxResults = JRequest::getVar( 'maxResults', false ) ) ) 
        {
          // Call set_include_path() as needed to point to your client library.
          $helper_p = implode( '/', array( JPATH_ADMINISTRATOR, "components", "com_jvss", "helpers" ) );
          require_once ( $helper_p.'/google-api-php-client/src/Google_Client.php' );
          require_once ( $helper_p.'/google-api-php-client/src/contrib/Google_YouTubeService.php' );
          
          $DEVELOPER_KEY = JComponentHelper::getParams( 'com_jvss' )->get( 'yt_key', 'AIzaSyDOkg-u9jnhP-WnzX5WPJyV1sc5QQrtuyc' );

          $client = new Google_Client();
          $client->setDeveloperKey($DEVELOPER_KEY);

          $youtube = new Google_YoutubeService($client);

          try {
            $searchResponse = $youtube->search->listSearch('id,snippet', array(
              'q' => $q,
              'maxResults' => $maxResults,
            ));

            $videos = '';
            $channels = '';

            foreach ($searchResponse['items'] as $searchResult) {
              switch ($searchResult['id']['kind']) {
                case 'youtube#video':
                    array_push( $rs, array( 'title' => $searchResult['snippet']['title'], 'videoId' => $searchResult['id']['videoId'] ) );
                break;
               }
            }

           } catch (Google_ServiceException $e) 
           {
          
            } catch (Google_Exception $e) {
            
          }
  
        }
        
        die( json_encode( array( 'feed' => array( 'entry' => $rs ) ) ) );
    }

}