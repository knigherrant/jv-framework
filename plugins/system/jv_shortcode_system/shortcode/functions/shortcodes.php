<?php

// no direct access
defined ( '_JEXEC' ) or die ();
class Jv_Shortcodes {
	static $tabs = array ();
	static $tab_count = 0;
	static $images = array ();
	static $image_count = array ();
	static $bar_count = 0;
	static $bars = array ();
	static $panel_count = 0;
	static $panels = array ();
	static $pricecol_count = 0;
	static $pricecols = array ();
	static $user_count = 0;
	static $users = array ();
	static $counter_count = 0;
	static $counters = array();
	static $member_count = 0;
	static $members = array ();
	static $step_count = 0;
	static $steps = array ();
	static $imagebox_count = 0;
	static $imageboxes = array ();
	static $icon_count = 0;
	static $icons = array ();
	
	public static function heading($atts = null, $content = null) {
		// extend atts
		$atts = shortcode_atts ( array (
				'style' => 'default',
				'heading_text' => 'Heading Text',
				'heading_tag' => 'h3',
				'heading_size' => 0,
				'heading_class' => '',
				'sub_text' => '',
				'sub_text_size' => 0,
				'sub_text_class' => '',
				'align' => 'none',
				'desc' => '',
				'class' => '' 
		), $atts, 'heading' );

		if ($atts['style'] === "default") {
				$html = '<'.$atts['heading_tag'].' class="';
				if ($atts['align'] != 'none') {
					$html .= 'text-'.$atts['align'].' ';
				}
				$html .= $atts['class'].' '.$atts['heading_class'].'"';
				if ($atts['heading_size'] != 0) {
					$html .= ' style="font-size: '.$atts['heading_size'].'px"';
				}
				$html .= '>'.$atts['heading_text'];
				if (!empty($atts['sub_text'])) {
					$html .= ' <small class="'.$atts['sub_text_class'].' '.$atts['class'].'"';
					if ($atts['sub_text_size'] != 0) {
						$html .= ' style="font-size: '.$atts['sub_text_size'].'px"';
					}
					$html .= '>'.$atts['sub_text'].'</small>';
				}
				$html .= '</'.$atts['heading_tag'].'>';
				if ($atts['desc']) {
					$html .= '<p>'.$atts['desc'].'</p>';
				}
		} else {
			$heading_size = ($atts['heading_size']!=0)?' style="font-size:'.$atts['heading_size'].'px" ':'';
			$sub_text_size = ($atts['sub_text_size']!=0)?'style="font-size:'.$atts['sub_text_size'].'px" ':'';
			$sub_text = (!empty($atts['sub_text']))?'<span class="heading-sub '.$atts['sub_text_class'].'" '.$sub_text_size.'>'.$atts['sub_text'].'</span>':'';
			$style = $atts['style'];
			$align = ($atts['align']!="none")?'text-'.$atts['align']:'';
			$tag = $atts['heading_tag'];
			$heading_class = (!empty($atts['heading_class']))?' class="heading-cont '.$atts['heading_class'].'"':' class="heading-cont"';
			$data_text = !empty($atts['sub_text'])?' data-text="' . $atts['sub_text'][0] . '"':'';

			$html = '<div class="heading-'.$style.' '.$align.' '.$atts['class'].'">';
				$html .= '<'.$tag.''.$heading_class.''.$heading_size .$data_text.'>'.$atts['heading_text'];
						$html .= ' '.$sub_text;
				$html .= '</'.$tag.'>';
				if ($atts['desc']) {
					$html .= '<p class="heading-desc">'.$atts['desc'].'</p>';
				}
			$html .= '</div>';
		}
		return $html;
	}
	public static function tabs($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'active' => 1,
				'style' => 'default',
				'number' => 3,
				'fitwidth' => 'no',
				'title' => '',
				'cover' =>'',
				'cover_align' =>'',
				'color' => '',
				'class' => '' 
		), $atts, 'tabs' );
		do_shortcode ( $content );
		$return = '';
		$id ='tabs-'.rand(100,9999999);
		$cover = $cssStyles = $align = '';
		if (!empty($atts['cover'])) {
			$cover = '<img alt="tabs" class="tabs-cover" src="' . $atts['cover'] . '"/>';
		}
		$tabs = $panes = array ();
		if (is_array ( self::$tabs )) {
			if (self::$tab_count < $atts ['active'])
				$atts ['active'] = self::$tab_count;
				
			if(
					(
						$atts['style'] == 'default' || 
						$atts['style'] == 'tabs-2' 	||
						$atts['style'] == 'tabs-3' 	||
						$atts['style'] == 'tabs-4' 	||
						$atts['style'] == 'tabs-5' 	||
						$atts['style'] == 'tabs-6' 	||
						$atts['style'] == 'tabs-7' 	||
						$atts['style'] == 'tabs-8' 	||
						$atts['style'] == 'tabs-9'
					) 
					&& $atts['fitwidth'] == 'yes'
			){	
				$spanWidth = 'nav-justified';
			}else{
				$spanWidth = '';
			}


			
			foreach ( self::$tabs as $key => $tab ) {
				$icon = '';
				if($tab['icon']){
					if (strpos($tab ['icon'], 'icon:') !== false) {
						$tab['icon'] = str_replace('icon:', '', $tab['icon']);
						$icon = '<i class="fa fa-' . $tab ['icon'] . '"></i>';
					}else{
						$icon = '<img style="width: 1em;" alt="" src="' . $tab['icon'] . '"/>';
					}
				}
				$active = ($atts ['active'] == ($key+1))?'active':'';
				$tabs [] = '<li role="presentation" class="'.$active.'"><a href="#'.$id.'-'.($key + 1).'" aria-controls="'.$id.'-'.($key + 1).'" role="tab" data-toggle="tab">' . $icon . '<span>' .$tab ['title'] . '</span></a></li>';
				$panes [] = '<div role="tabpanel" class="tab-pane '.$active.'" id="'.$id.'-'.($key + 1).'">' . $tab ['content'] . '</div>';
			}
			$styleClass = $atts['style'];
			if($spanWidth){
				$styleClass .= ' tabs-fitwidth ';
			}
			$return = '<div id='.$id.' class="tabs ' . $styleClass . jv_ecssc ( $atts ) . '">';
			if( $atts['style'] == 'tabs-7'){
				if ($atts['color'] != '') {
					$color = $atts['color'];
					$cssStyles = '#'.$id.'.tabs-7 .nav-tabs > li.tab-title { background-color:'.$color.';} #'.$id.'.tabs-7 .nav-tabs > li.tab-title:before { border-color: transparent '.$color.';}#'.$id.'.tabs-7 .tab-content-wrap {border-top-color:'.$color.';}#'.$id.'.tabs-7 .nav-tabs > li.active > a, #'.$id.'.tabs-7 .nav-tabs > li > a:hover,#'.$id.'.tabs-7 .nav-tabs > li.active > a:hover, #'.$id.'.tabs-7 .nav-tabs > li.active > a:focus{color: '.$color.';} @media (max-width: 767px) { #'.$id.'.tabs-7 .nav-tabs > li.tab-title:before { border-color: '.$color.' transparent;} }';
				}
				$align = ($atts['cover_align'] != '')?" cover-".$atts['cover_align']:"";
				$return .= '<ul class="nav nav-tabs '.$spanWidth.'" role="tablist">';
				if ($atts['title'] != '') {
					$return .= '<li class="tab-title">'.$atts['title'].'</li>';
				}
				$return .= implode ( '', $tabs ) . '</ul>';
				$return .= '<div class="tab-content-wrap clearfix'.$align.'">';
				if ($cover != '') {
					$return .= '<div class="tab-cover-wrap">'.$cover.'</div>';
				}
				$return .= '<div class="tab-content">' . implode ( "\n", $panes ) . '</div></div>';	
				$document 	= JFactory::getDocument();
				$document->addStyleDeclaration($cssStyles);	
			} else {
				$return .= $cover;
				$return .= '<ul class="nav nav-tabs '.$spanWidth.'" role="tablist">' . implode ( '', $tabs ) . '</ul><div class="tab-content">' . implode ( "\n", $panes ) . '</div>';	
			}
			$return .= '</div>';
			
		}
		// Reset tabs
		self::$tabs = array ();
		self::$tab_count = 0;
		
		
		return $return;
	}
	public static function tab($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'title' => 'Tab title',
				'class' => '',
				'icon'	=> '' 
		), $atts, 'tab' );
		$x = self::$tab_count;
		self::$tabs [$x] = array (
				'title' => $atts ['title'],
				'content' => do_shortcode ( $content ),
				'class' => $atts ['class'],
				'icon' => $atts['icon'] 
		);
		self::$tab_count ++;
	}
	public static function gallery($atts = null, $content = null) {
		$mainframe = JFactory::getApplication ();
		$isAdmin = $mainframe->isAdmin ();
		$return = '';
		$atts = shortcode_atts ( array (
				'uid' 				=> '',
				'source' 			=> 'none',
				'style'				=> 'style-1',
				'carousel' 			=> 'no',
				'number'			=> '4',

				'crop' 				=> 'no',
				'thumbnail_width' => 800,
				'thumbnail_height' => 600,
				'quality' => 100,
				'crop_center' => true,
				'show_title' => 'no',

				'arrows' => 'no',
				'pagination' => 'no',
				'autoplay' => 3000,
				'speed' => 600,
				'class' => '' 
		), $atts, 'gallery' );
		
		do_shortcode ( $content );
		$gallery = self::$images;
		
		$return				= '';

		$id 				= 'gallery-' . $atts['uid'];
		$style 				= $atts['style'];

		$carousel 			= $atts['carousel'];
		$number 			= $atts['number'];

		$arrows 			= ($atts['arrows'] == 'yes')?'true':'false';
		$pagination 		= ($atts['pagination'] == 'yes')?'true':'false';;
		$autoplay 			= ($atts['autoplay'] == 0)?'false':$atts['autoplay'];
		$speed 				= $atts['speed'];

		$crop 				= $atts['crop'];
		$thumbnail_width	= $atts['thumbnail_width'];
		$thumbnail_height 	= $atts['thumbnail_height'];
		$quality 			= $atts['quality'];
		$crop_center 		= $atts['crop_center'];
		$show_title 		= $atts['show_title'];

		$class 				= $atts['class'];

		
		$classCarousel = $dataCarousel = '';
		if ($carousel == 'yes') {
			$classCarousel = 'carouselOwl';
			if ($number == '1') {
				$dataCarousel  = 'data-items="1" data-singleitem="true" data-slidespeed="'.$speed.'" data-autoplay="'.$autoplay.'" data-navigation="'.$arrows.'" data-pagination="'.$pagination.'" data-addactive="true"';
			} else {
				$itemsDesktopSmall = ((($number - 1) > 0)?($number-1):$number);
				$itemsTablet = ((($number - 2) > 0)?(((($number - 1) > 0)?($number-1):$number)):$number);
				$itemsTabletSmall = ($number>2)?'2':$number;
				$dataCarousel  = 'data-items="'.$number.'" data-itemsdesktop="'.$number.'" data-itemsdesktopsmall="'.$itemsDesktopSmall.'" data-itemstablet="'.$itemsTablet.'" data-itemstabletsmall="'.$itemsTabletSmall.'" data-itemsmobile="1" data-slidespeed="'.$speed.'" data-autoplay="'.$autoplay.'" data-navigation="'.$arrows.'" data-pagination="'.$pagination.'"';
			}
		} else {
			$classCarousel = 'row ';
			// $dataCarousel = ' data-uk-grid';
		}

		// Loop gallery
		$images = $thumbnail = array();

		if (count ( $gallery )) {				

			for($i = 0; $i < count ( $gallery ); $i ++) {
				$html = '';
				if ($carousel != 'yes') {
					if ($number == '1') {
						$html .='<div class="col-sm-12">';	
					} else {
						$cols_sm = ($number==3)?' col-sm-4':' col-sm-6';
						if ($i==0 && $style == 'style-3') {
							$html .='<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-6">';
						} else {
							$html .='<div class="col-xxs-12 col-xs-6'.$cols_sm.' col-md-'.number_format(12/$number,0).'">';	
						}						
					}
				}
				//Open ------------------------------
				$html .= '<div class="image '.$style.'"><div class="image-inner">';

				$link = $src = '';

				$url = parse_url ( $gallery [$i] ['src'] );
				if (! isset ( $url ['host'] )) {
					$link = $src = JURI::root () . $gallery [$i] ['src'];
				}
				// process to create image
				if($crop == 'yes' && $style != 'style-6' && $style != 'style-7' && $style != 'style-8' && $style != 'style-9' && $style != 'style-10' && $style != 'style-11'){
					$src = Jv_shortcodeHelper::createThumb ($id, $gallery [$i] ['src'], $atts ['thumbnail_width'], $atts ['thumbnail_height'], $atts ['crop_center'], $atts ['quality'] );
				}
				$title = ($show_title == 'yes')?'<h4 class="image-title"><span>'.$gallery [$i] ['title'].'</span></h4>':'';
				$html .= '<a href="' . $link . '" title="' . $gallery [$i] ['title'] . '"><i class="fa fa-search"></i><img src="' . $src . '" alt="' . $gallery [$i] ['title'] . '"></a>';
				$html .= $title;
				$html .= '</div></div>';
				//Close ------------------------------

				if ($carousel != 'yes') {
					$html .='</div>';
				}

				$images [] = $html;
				$thumbnail [] = '<a href="javascript:void(0);" data-slide-index="'.$i.'"><img src="' . Jv_shortcodeHelper::createThumb ($id, $gallery [$i] ['src'], $atts ['thumbnail_width'], $atts ['thumbnail_height'], $atts ['crop_center'], $atts ['quality'] ) . '" alt="' . $gallery [$i] ['title'] . '"></a>';
			}
			$thumbnail_slide = '';
			$document 	= JFactory::getDocument();
			if ($carousel != 'yes') {
				$document->addScriptDeclaration('
					(function($){
						$(function(){
							$("#'.$id.' .gallery-inner").imagesLoaded( function() {
								// $("#'.$id.' .gallery-inner").masonry({
								// 	columnWidth: \'.col-md-'.number_format(12/$number,0).'\',
								// 	itemSelector: \'.col-xxs-12\'
								// });
								var $grid = $("#'.$id.' .gallery-inner"),
									$sizer = $grid.find(".col-md-'.number_format(12/$number,0).'");

								  $grid.shuffle({
								    itemSelector: \'.col-xxs-12\',
								    sizer: $sizer
								  });
							});			
						});
					})(jQuery);	
				');		
			}
			$document->addScriptDeclaration('
				(function($){
					$(function(){
						$("#'.$id.' .gallery-inner").magnificPopup({
							delegate: \'a\',
							type: \'image\',
							tLoading: \'Loading image #%curr%...\',
							mainClass: \'my-mfp-zoom-in mfp-img-mobile\',
							gallery: {
								enabled: true,
								navigateByImgClick: true,
								preload: [0,1]
							},
							image: {
								tError: \'<a href="%url%">The image #%curr%</a> could not be loaded.\',
							}
						});		
					});
				})(jQuery);	
			');		
			if ($style == 'style-6' || $style == 'style-7' || $style == 'style-8' || $style == 'style-9' || $style == 'style-10' ) {
				if ($carousel == 'yes') {
					$classCarousel = ' gallery-hidden';
					$pag = 'false';
					$document 	= JFactory::getDocument();
					$items 				= $number;
					$itemsDesktop 		= ($number - 1)>0? ($number - 1):$number;
					$itemsDesktopSmall 	= ($itemsDesktop - 1)>0? ($itemsDesktop - 1):$itemsDesktop;
					$itemsTablet 		= ($itemsDesktopSmall - 1)>0? ($itemsDesktopSmall - 1):$itemsDesktopSmall;
					$itemsTabletSmall 	= ($itemsTablet - 1)>0? ($itemsTablet - 1):$itemsTablet;
					$itemsMobile 		= ($itemsTabletSmall - 1)>0? ($itemsTabletSmall - 1):$itemsTabletSmall;
					if ($style == 'style-8') {
						$itemsDesktop = $itemsDesktopSmall = $itemsTablet = $itemsTabletSmall = $itemsMobile = $items;
					}
					if ($style == 'style-9' && $pagination) {
						$pag = 'true';
					}
					$document->addScriptDeclaration('
						(function($){
							$(function(){
								var sync1 = $("#'.$id.' .gallery-inner");
								var sync2 = $("#'.$id.'-thumbnail");

								sync1.owlCarousel({
								    singleItem: true,
								    slideSpeed: '.$speed.',
								    navigation: '.$arrows.',
								    pagination: '.$pag.',
								    navigationText : ["<i class=\"fa fa-angle-left\"></i>","<i class=\"fa fa-angle-right\"></i>"],
								    afterAction: syncPosition,
								    responsiveRefreshRate: 200,
								    autoPlay: '.$autoplay.',
								    direction: $("body").hasClass("rtl") ? \'rtl\' : \'ltr\',
								    transitionStyle: "fade"
								});

								sync2.owlCarousel({
									direction: $("body").hasClass("rtl") ? \'rtl\' : \'ltr\',
								    items: '.$items.',
								    itemsDesktop: [1199, ' . $itemsDesktop. '],
								    itemsDesktopSmall: [979, '. $itemsDesktopSmall .'],
								    itemsTablet: [768, '. $itemsTablet .'],
								    itemsTabletSmall: [479, '. $itemsTabletSmall .'],
								    itemsMobile: [360, '. $itemsMobile .'],
								    pagination: false,
								    responsiveRefreshRate: 100,
								    afterInit: function(el) {
								        el.find(".owl-item").eq(0).addClass("active");
								    }
								});

								function syncPosition(el) {
								    var current = this.currentItem;
								    $("#'.$id.'-thumbnail")
								        .find(".owl-item")
								        .removeClass("active")
								        .eq(current)
								        .addClass("active")
								    if ($("#'.$id.'-thumbnail").data("owlCarousel") !== undefined) {
								        center(current)
								    }
								}

								$("#'.$id.'-thumbnail").on("click", ".owl-item", function(e) {
								    e.preventDefault();
								    var number = $(this).data("owlItem");
								    sync1.trigger("owl.goTo", number);
								});

								function center(number) {
								    var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
								    var num = number;
								    var found = false;
								    for (var i in sync2visible) {
								        if (num === sync2visible[i]) {
								            var found = true;
								        }
								    }

								    if (found === false) {
								        if (num > sync2visible[sync2visible.length - 1]) {
								            sync2.trigger("owl.goTo", num - sync2visible.length + 2)
								        } else {
								            if (num - 1 === -1) {
								                num = 0;
								            }
								            sync2.trigger("owl.goTo", num);
								        }
								    } else if (num === sync2visible[sync2visible.length - 1]) {
								        sync2.trigger("owl.goTo", sync2visible[1])
								    } else if (num === sync2visible[0]) {
								        sync2.trigger("owl.goTo", num - 1)
								    }

								}

							});
						})(jQuery);	
					');
					if ($pagination == 'true') {
						$thumbnail_slide = '<div class="gallery-thumbnails-wrapper"><div  id="'.$id.'-thumbnail" class="gallery-thumbnails gallery-hidden">'.implode ( '', $thumbnail ) .'</div></div>';		
					}							
				} else {
					$classCarousel = 'row';
				}				
			}
			$return = '<div id="'.$id.'" class="gallery ' . $style . ' ' . $class .'"><div class="gallery-inner '. $classCarousel. '" '.$dataCarousel.'>' . implode ( '', $images ) . '</div>'.$thumbnail_slide.'</div>';	
			

			// reset slider
			self::$images = array ();

			$mainframe = JFactory::getApplication ();
			if ($mainframe->isAdmin ()) {
				$asset  = jv_query_asset ( 'css', 'owl.carousel' );
				$asset .= jv_query_asset ( 'js', 'jquery' );
				$asset .= jv_query_asset ( 'js', 'owl.carousel.min' );
				$return .= $asset;
			}
		} 		// Slides not found
		else
			$return = '<p class="jvsc-error">Slider: images not found.</p>';
		
		return $return;
	}
	public static function postslider($atts = null, $content = null) {
		$mainframe = JFactory::getApplication ();
		$isAdmin = $mainframe->isAdmin ();
		$return = '';
		$atts = shortcode_atts ( array (
				'uid'		=> '',
				'source' 	=> 'none',
				'style'		=> 'style-1',
				'number'	=> '8',
				'title' 	=> '',
				'desc' 		=> '',
				'more' 		=> 'Learn more',
				'url' 		=> '',
				'class' => '' 
		), $atts, 'gallery' );
		
		do_shortcode ( $content );

		$gallery = self::$images;
		
		$return				= '';
		$id = 'postslider-' . $atts['uid'];
		$style 		= $atts['style'];
		$number 	= $atts['number'];
		$title 		= ($atts['title'])?'<h3 class="postslider-title mt-0 mb-30 text-semi-bold">'.$atts['title'].'</h3>':'';
		$desc 		= ($atts['desc'])?'<div class="postslider-desc">'.$atts['desc'].'</div>':'';
		$more 		= $atts['more'];
		$link 		= (!empty($atts['url']) || $atts['url'] == "#")?'#':$atts['url'];
		$class 		= $atts['class'];

		$button  	= (!empty($link) && !empty($more))?'<div class="postslider-more mt-30"><a class="btn btn-primary" href="'.$link.'" title="'.$more.'"><span class="text-normal">'.$more.'</span></a></div>':'';

		// Number Thumbnail Slide
		$items 				= $number;
		if ($style == "style-9") {
			$itemsDesktop  = $itemsDesktopSmall = $itemsTablet = $itemsTabletSmall = $itemsMobile = $items;
		} else {
			$itemsDesktop 		= ($number - 1)>0? ($number - 1):$number;
			$itemsDesktopSmall 	= ($itemsDesktop - 1)>0? ($itemsDesktop - 1):$itemsDesktop;
			$itemsTablet 		= ($itemsDesktopSmall - 1)>0? ($itemsDesktopSmall - 1):$itemsDesktopSmall;
			$itemsTabletSmall 	= ($itemsTablet - 1)>0? ($itemsTablet - 1):$itemsTablet;
			$itemsMobile 		= ($itemsTabletSmall - 1)>0? ($itemsTabletSmall - 1):$itemsTabletSmall;
		}
		

		// Pagination - Navigation
		$pagination = $navigation = 'false';
		$transition = 'data-transition="fade"';
		$dataCarousel = '';
		$document 	= JFactory::getDocument();

		if ($style == "style-1") {
			$dataCarousel = 'class="carouselOwl" data-items="'.$items.'" data-singleitem="true" data-pagination="true" '.$transition;
		} elseif ($style == "style-2" || $style == "style-3" || $style == "style-7") {
			$dataCarousel = 'class="carouselOwl" data-items="'.$items.'" data-singleitem="true" data-pagination="false" data-navigation="true" data-addactive="true" '.$transition;
		} elseif ( $style == "style-6" || $style == "style-8") {
			$dataCarousel = 'class="carouselOwl" data-items="'.$items.'" data-singleitem="true" data-pagination="true" data-addactive="true" '.$transition;
		}
		// Loop gallery
		$images = $thumbnail = array();

		if (count ( $gallery )) {				

			for($i = 0; $i < count ( $gallery ); $i ++) {
				$html = '';
				$src = '';
				$url = parse_url ( $gallery [$i] ['src'] );
				if (! isset ( $url ['host'] )) {
					$src = JURI::root () . $gallery [$i] ['src'];
				}
				$imageInfo = explode('|',$gallery [$i]['title']);
				$imageTitle = $imageInfo[0];

				$imageCat = $imageDate = "";
				if (isset($imageInfo[1])) {
				   $imageCat = $imageInfo[1];
				}
				if (isset($imageInfo[2])) {
				   $imageDate = $imageInfo[2];
				}
				$parallax = '';
				if ($style == "style-5") {
					$parallax = 'data-stellar-background-ratio="0.7"';
				}
				
				//Open ------------------------------
				$html .= '<div class="image"><div class="image-inner" style="background-image: url(' . $src . ');" '.$parallax.'>';
				$html .= '<img class="hidden" src="' . $src . '" alt="' . $gallery [$i] ['title'] . '">';
				if ($style == "style-2" || $style == "style-3" || $style == "style-5" || $style == "style-6" || $style == "style-8") {
					$html .= '<div class="image-info"><div class="image-info-table"><div class="image-info-tablecell">';
					if ($gallery [$i] ['link']) {
						$html .= '<a class="image-title" href="'.$gallery [$i] ['link'].'">'.$imageTitle.'</a>';
					} else {
						$html .= '<span class="image-title">'.$imageTitle.'</span>';
					}
					
					$html .= '<span class="image-info-item"><span>'.$imageCat.'</span><span>'.$imageDate.'</span></span></div></div></div>';
				}
				if ($style == "style-7") {
					$html .= '<div class="postslider-video"><div class="postslider-video-inner">';
					if (strpos($gallery [$i] ['link'], 'youtube')) {
						$iframe = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $gallery [$i] ['link'], $match ) ) ? $match[1] : false;
						$iframeID = uniqid ( 'video-' );
						if ( !$id ) {
							$html .= JText::_('Please enter correct url');
						} else {
							$html .= '<a href="javascript:void(0);" id="play-'.$iframeID.'" class="fa fa-play"></a>';
							$video= '<iframe id="'.$iframeID.'" src="http://www.youtube.com/embed/' . $iframe . '?autoplay=1"  allowfullscreen="true"></iframe>';
							$document->addScriptDeclaration('
								(function($){
									$(function(){
										$.getScript("http://www.youtube.com/player_api");
										$("#play-'.$iframeID.'").click(function(){
											$(this).parent().append(\''.$video.'\');	
										});											
									});
								})(jQuery);
							');
						}
					}
					$html .= '</div></div>';
				}
				$html .= '</div></div>';
				//Close ------------------------------

				$images [] = $html;
				$thumbnail [] = '<a href="javascript:void(0);" data-slide-index="'.$i.'"><img src="' . Jv_shortcodeHelper::createThumb ($id, $gallery [$i] ['src'], '200', '200', 'yes', '100' ) . '" alt="' . $gallery [$i] ['title'] . '"></a>';
			}
			$thumbnail_slide = '';
			

			if ($style == "style-4" || $style == "style-9" ||  $style == "style-10") {
				$thumbnail_slide = '<div class="postslider-thumbnails-wrapper"><div  id="'.$id.'-thumbnail" class="postslider-thumbnails gallery-hidden">'.implode ( '', $thumbnail ) .'</div></div>';
				$arrows = $pag = $pagThumb = "false";
				if ($style == "style-4" || $style == "style-9" ) {
					$arrows = "true";
				}
				if ($style == "style-10" ) {
					$pagThumb = "true";
				}
				$document->addScriptDeclaration('
				(function($){
					$(function(){
						var sync1 = $("#'.$id.'-slide");
						var sync2 = $("#'.$id.'-thumbnail");

						sync1.owlCarousel({
						    singleItem: true,
						    slideSpeed: 100,
						    navigation: '.$arrows.',
						    pagination: '.$pag.',
						    navigationText : ["<i class=\"fa fa-angle-left\"></i>","<i class=\"fa fa-angle-right\"></i>"],
						    afterAction: syncPosition,
						    responsiveRefreshRate: 200,
						    autoPlay: true,
						    direction: $("body").hasClass("rtl") ? \'rtl\' : \'ltr\',
						    transitionStyle: "fade"
						});

						sync2.owlCarousel({
							direction: $("body").hasClass("rtl") ? \'rtl\' : \'ltr\',
						    items: '.$items.',
						    itemsDesktop: [1199, ' . $itemsDesktop. '],
						    itemsDesktopSmall: [979, '. $itemsDesktopSmall .'],
						    itemsTablet: [768, '. $itemsTablet .'],
						    itemsTabletSmall: [479, '. $itemsTabletSmall .'],
						    itemsMobile: [360, '. $itemsMobile .'],
						    pagination: '.$pagThumb.',
						    responsiveRefreshRate: 100,
						    afterInit: function(el) {
						        el.find(".owl-item").eq(0).addClass("active");
						    }
						});

						function syncPosition(el) {
						    var current = this.currentItem;
						    $("#'.$id.'-thumbnail")
						        .find(".owl-item")
						        .removeClass("active")
						        .eq(current)
						        .addClass("active")
						    if ($("#'.$id.'-thumbnail").data("owlCarousel") !== undefined) {
						        center(current)
						    }
						}

						$("#'.$id.'-thumbnail").on("click", ".owl-item", function(e) {
						    e.preventDefault();
						    var number = $(this).data("owlItem");
						    sync1.trigger("owl.goTo", number);
						});

						function center(number) {
						    var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
						    var num = number;
						    var found = false;
						    for (var i in sync2visible) {
						        if (num === sync2visible[i]) {
						            var found = true;
						        }
						    }

						    if (found === false) {
						        if (num > sync2visible[sync2visible.length - 1]) {
						            sync2.trigger("owl.goTo", num - sync2visible.length + 2)
						        } else {
						            if (num - 1 === -1) {
						                num = 0;
						            }
						            sync2.trigger("owl.goTo", num);
						        }
						    } else if (num === sync2visible[sync2visible.length - 1]) {
						        sync2.trigger("owl.goTo", sync2visible[1])
						    } else if (num === sync2visible[0]) {
						        sync2.trigger("owl.goTo", num - 1)
						    }

						}

					});
				})(jQuery);	
			');
			}
			
			$return  = '<div id="'.$id.'" class="postslider ' . $style . ' ' . $class .'">';
				$return .= '<div class="postslider-inner ">';
					$return .= '<div class="row">';
						$return .= '<div class="col-md-8"><div id="'.$id.'-slide" '.$dataCarousel.'>' . implode ( '', $images ) . '</div>'.$thumbnail_slide.'</div>';
						$return .= '<div class="col-md-4">'.$title.$desc.$button.'</div>';
					$return .= '</div> <!-- End Row-->';
				$return .= '</div><!-- End Inner-->';
			$return .= '</div><!-- End Postslider-->';	
			

			// reset slider
			self::$images = array ();

			$mainframe = JFactory::getApplication ();
			if ($mainframe->isAdmin ()) {
				$asset  = jv_query_asset ( 'css', 'owl.carousel' );
				$asset .= jv_query_asset ( 'js', 'jquery' );
				$asset .= jv_query_asset ( 'js', 'owl.carousel.min' );
				$return .= $asset;
			}
		} 		// Slides not found
		else
			$return = '<p class="jvsc-error">Slider: images not found.</p>';
		
		return $return;
	}
	public static function image($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'src' => '',
				'title' => 'Image title',
				'link' => '' 
		), $atts, 'image' );
		
		self::$images [] = array (
				'src' => $atts ['src'],
				'title' => $atts ['title'],
				'link' => $atts ['link'] 
		);		
		return;
	}
	public static function lightbox($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'src' => false,
				'type' => 'iframe',
                'style' => 'default',
                'background' => '#2D89EF',
                'color' => '#FFFFFF',
                'border' => 'none',
                'size' => 13,
                'radius' => 'auto',
                'icon' => false,
                'icon_color' => '#FFFFFF',
                'box_shadow' => 'none',
                'text_shadow' => 'none',
				'class' => '' 
		), $atts, 'lightbox' );
		if (! $atts ['src'])
			return '<p class="jv-error">Lightbox: ' . JText::_ ( 'SOURCE_INCORECT' ) . '</p>';
        $button = '[' . Jv_shortcodeHelper::getPrefix() . 'button';
        $button .= ' style="' . $atts['style'] . '" background="' . $atts['background'] . '" color="' . $atts['color'] . '"';
        $button .= ' border="' . $atts['border']. '" size="' . $atts['size'] . '"';
        $button .= ' radius="' . $atts['radius'] . '" icon="' . $atts['icon'] . '"';
        $button .= ' icon_color="' . $atts['icon_color'] . '" box_shadow="' . $atts['box_shadow'] . '" text_shadow="' . $atts['text_shadow'] .'"';
        $button .= ']' . $content . '[/' . Jv_shortcodeHelper::getPrefix() . 'button]';
		jv_query_asset ( 'css', 'magnific-popup' );
		jv_query_asset ( 'js', 'jquery' );
		jv_query_asset ( 'js', 'jquery.magnific-popup.min' );
		jv_query_asset ( 'js', 'galleries-shortcodes' );
		return '<span class="jv-lightbox ' . jv_ecssc ( $atts ) . '" data-mfp-src="' . $atts ['src'] . '" data-mfp-type="' . $atts ['type'] . '">' . do_shortcode ( $button ) . '</span>';
	}
	public static function button($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
			'style' 	=> 'default',
			'size' 		=> 'default',
			'color' 	=> 'primary',
			'center'	=> 'no',
			'radius' 	=> 'no',
			'block' 	=> 'no',
			'icon' => false,
			'icon_show' => 'none',
			'url' => JURI::root (),
            'target' => '_self',
            'onclick' => '',
			'class' => '' 
		), $atts, 'button' );
		
		// Prepare Style
		$style 	= ($atts ['style'] != 'default')?' btn-' . $atts ['style']:'';

		// Prepare Size
		$size 	= ($atts ['size'] != 'default')?' btn-' . $atts ['size']:'';

		// Prepare Color
		$color 	= ' btn-' . $atts ['color'];

		// Center
		$before = $after = '';
		if ($atts ['center'] === 'yes') {
			$before = '<div class="text-center">';
			$after = '</div>';
		}

		// Prepare Radius
		$radius 	= ($atts ['radius'] == 'yes')?' btn-radius':'';

		// Prepare Radius
		$block 	= ($atts ['block'] == 'yes')?' btn-block':'';

		
		// Prepare button class
		$class = 'btn' . $style . $size . $color . $radius . $block . ' ' . $atts['class'];

		// Prepare icon
		$icon = '';
		if (strpos($atts ['icon'], 'icon:') !== false) {
			$atts['icon'] = str_replace('icon:', '', $atts['icon']);
			$icon = '<i class="fa fa-' . $atts ['icon'] . '"></i>';
		}else{
			$icon = '<img alt="" src="' . $atts['icon'] . '"/>';
		}

		$text = do_shortcode ( $content );

		if ($atts ['icon_show'] != 'none') {
			if ($atts ['icon_show'] === 'before') {
				$text = $icon . '&nbsp;&nbsp;&nbsp;' . $text;
			} else {
				$text = $text . '&nbsp;&nbsp;&nbsp;' . $icon;
			}
		}
		
		// prepare target
		$targetAction = '';
		if ($atts ['target'] === 'popup') {
			$atts ['target'] = '';
			$targetAction = "window.open(this.href,'Popup','height=600,width=800,resizable=1,scrollbars=1'); return false;";
		}

		// Prepare onClick function
		if ($atts ['onclick'] || $targetAction) {
			$atts ['onclick'] = $atts ['onclick'] . ' ' . $targetAction . '"';
		}
		
		return $before . '<a href="' . $atts ['url'] . '" class="' . $class . '" onClick="' . $atts ['onclick'] . '" target="' . $atts ['target'] . '" title="' .K2HelperUtilities::cleanHtml(do_shortcode ( $content )). '">' . $text . '</a>' . $after;
	}
	public static function iconbox($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' 	=> 'iconbox-1',
				'number'		=> '4',
				'class' => ''
		), $atts, 'iconbox' );
		$uid 		= rand(100,999999);
		do_shortcode ( $content );

		$return 	= '';

		$style 		= $atts ['style'];
		$number 	= $atts ['number'];
		$class 		= $atts ['class'];
		$cssStyles  = '';
		$iconboxes = array ();
		if (is_array ( self::$icons )) {

			foreach ( self::$icons as $key => $item ) {
				$title 			= $item ['title'];
				$sub_title 		= $item ['content'];
				$icon 			= $item ['icon'];
				$link			= $item ['link'];
				$color			= $item ['color'];
				$background		= $item ['background'];
				$classItem 		= $item ['class'];

				

				$cols = '';
				if($number == 1) {
					$cols = 'col-xs-12';
				} else {
					$col_xs = "col-xs-6 col-sm-6";
					if (self::$icon_count == 3) {
						$col_xs = "col-xs-12 col-sm-12";
					}
					$cols = 'col-xxs-12 '.$col_xs.' col-md-'.number_format(12/$number, 0).'';
				}

				$link_bf = $link_at = '';
				if ($link != '') {
					$link_bf = '<a class="iconbox-link" href="'.$link.'" title="'.$title.'" data-title="'.$title.'">';
					$link_at = '</a>';
				}

				

				if (!empty($icon)) {
					if (strpos($icon, 'icon:') !== false) {
						$icon = str_replace('icon:', '', $icon);
						$icon = '<i class="fa fa-' . $icon . '"></i>';
						if ($style == 'iconbox-2') {
							// $icon .= $icon;
						}
					} else {
						$icon = '<span class="iconbox-image"><img alt="' . $title .'" src="' . JURI::root () . '/'  . $icon . '"/></span>';
					}
					$icon = '<span class="iconbox-icon iconbox-icon-'.$key.'"><span class="iconbox-icon-inner">'.$icon.'</span></span>';
				}
				if ($title != '' && $title != 'Title') {
					if ($link != '') {
						$title = '<a class="iconbox-title" href="'.$link.'" title="'.$title.'" data-title="'.$title.'">'.$title.'</a>';
					} else {
						$title = '<span class="iconbox-title" data-title="'.$title.'">'.$title.'</span>';
					}
				} else {
					$title ='';
				}

				$sub_title = ($sub_title != '')?'<div class="iconbox-sub-title">'.$sub_title.'</div>':'';

				$html = '<div class="'.$cols.'"><div class="iconbox '. $classItem.'">';
				// if ($style == 'iconbox-3') {
				// 	$html .= '<div class="iconbox-content">'.$title.$sub_title.'</div>'.$icon;
				// } else {
					$html .= $icon.'<div class="iconbox-content">'.$title.$sub_title.'</div>';
				// }
				$html .= '</div></div>';

				$iconboxes [] = $html;
			}
			$document 	= JFactory::getDocument();
			$document->addStyleDeclaration($cssStyles);	
			$return = '<div class="iconboxes '.$atts ['style'].' '.$atts['class'].'" id="iconboxes-'.$uid.'"><div class="row">'. implode ( '', $iconboxes ) . '</div></div>';
		}
		// reset bars
		self::$icons = array ();
		self::$icon_count = 0;
		return $return;
	}
	public static function icon($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'title' => 'Title',
				'icon' => '',
				'color' => '',
				'background' => '',
				'link' => '',
				'class' => ''  
		), $atts );

		$x = self::$icon_count;
		self::$icons [$x] = array (
				'title' 	=> $atts ['title'],
				'content' 	=> do_shortcode ( $content ),
				'icon' 		=> $atts ['icon'],
				'color' 	=> $atts ['color'],
				'background'=> $atts ['background'],
				'link' 		=> $atts ['link'],
				'class' 	=> $atts ['class']
		);
		self::$icon_count ++;
	}
	public static function messagebox($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style'			=> 'basic',
				'contexts'		=> 'general',
				'font_size' 	=> 13,
				'icon' 			=> 'envelope-o',
				'head_text' 	=> '',
				'head_tag' 		=> 'h3',
				'close' 		=> 'yes',
				'class' 		=> '' 
		), $atts, 'messagebox' );
		$style = 		$atts ['style'];
		$contexts = 	$atts ['contexts'];
		$head_text = 	$atts ['head_text'];
		$head_tag = 	$atts ['head_tag'];
		if (!empty($head_text)) {
			if ($style == 'basic') {
				$head_text = '<strong>'.$head_text.'</strong> ';
			} else {
				$head_text = '<'.$head_tag.' class="alert-head">'.$head_text.'</'. $head_tag.'>';
			}
		}
		// Prepare icon
		$font_size = ($style == "style-3")?($atts ['font_size'] + 17):($atts ['font_size'] + 7);
		$icon_style = array (
			'font-size:' . $font_size . 'px',
			'line-height:' . ($atts ['font_size'] + 7) . 'px' 
		);
		$icon = '';
		if ($atts ['icon']) {
			if (strpos ( $atts ['icon'], 'icon:' ) !== false) {
				$icon = '<span class="alert-icon"><i class="fa fa-' . trim ( str_replace ( 'icon:', '', $atts ['icon'] ) ) . '" style="' . implode ( ';', $icon_style ) . '"></i></span>';
			} else {
				$icon = '<span class="alert-icon img"><img alt="" src="' . JURI::root () . '/' . $atts ['icon'] . '" style="' . implode ( ';', $icon_style ) . '"/></span>';
			}
		}
		$close ="";
		if ($atts ['close'] == "yes") {
			$close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
		}
		$box_style ='font-size:' . $atts ['font_size'] . 'px';
		$return = '<div class="alert alert-' . $style . ' alert-' . $contexts . ' alert-dismissible fade in ' . $atts ['class'] . '" role="alert" style="' . $box_style . '">' 
			. $close 
			. $icon 
			. $head_text
			. do_shortcode ( $content ) . '
	    </div>';
		
		return $return;
	}
	public static function clients($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				// Base
				'uid' 				=> '',
				'style'				=> 'client-1',
				'display'			=> 'carousel',
				'show_title' 		=> 'yes',
				'dark' 				=> 'no',
				'class' 			=> '',
				// Image
				'source' 			=> 'none',
				'gallery'			=> null,
				'target' 			=> '_self',
				'create_thumb'		=> 'no',
				'thumbnail_width' 	=> 180,
				'thumbnail_height' 	=> 120,
				'quality' 			=> 100,
				'crop_center' 		=> true,
				// Grid
				'grid_style'		=> 'grid1',
				'item_row'			=> 4,
				// Carousel
				'carousel_style'	=> 'carousel1',
				'items' 			=> 5,
				'items_desktop' 	=> 4,
				'items_tablet' 		=> 3,
				'items_mobile' 		=> 2,
				'single_item'		=> 'no',
				'scroll' 			=> 'page',
				'arrows' 			=> 'yes',
				'pagination' 		=> 'no',
				'autoplay' 			=> 3000,
				'speed' 			=> 600
		), $atts, 'clients' );
		
		do_shortcode ( $content );
		$slides = self::$images;
		$mainframe = JFactory::getApplication ();
		$isAdmin = $mainframe->isAdmin ();

		// not live preview
		if($isAdmin) return 'Preview this shortcode not apply. You can see it in font-end';

		$return = '';

		// Var
		$id 				= 'clients-' . $atts['uid'];
		$style 				= $atts['style'];
		$display 			= $atts['display'];
		$show_title 		= $atts['show_title'];
		$dark 				= ($atts['dark'] == 'yes')?' clients-dark':'';
		// ------------------------------------------------
		$source 			= $atts['source'];
		$target 			= $atts['target'];
		$create_thumb 		= $atts['create_thumb'];
		$thumbnail_width	= $atts['thumbnail_width'];
		$thumbnail_height	= $atts['thumbnail_height'];
		$quality 			= $atts['quality'];
		$crop_center 		= $atts['crop_center'];
		// ------------------------------------------------
		$grid_style 		= $atts['grid_style'];
		$item_row 			= number_format(12/$atts['item_row'], 0);
		// ------------------------------------------------
		$carousel_style 	= ' clients-'.$atts['carousel_style'];
		$items 				= $atts['items'];
		$items_desktop 		= $atts['items_desktop'];
		$items_tablet 		= $atts['items_tablet'];
		$items_mobile 		= $atts['items_mobile'];
		$single_item 		= ($atts['single_item'] == 'yes')?'true':'false';
		$scroll 			= $atts['scroll'];
		$arrows 			= ($atts['arrows'] == 'yes')?'true':'false';
		$pagination 		= $atts['pagination'];
		$autoplay 			= $atts['autoplay'];
		$speed 				= $atts['speed'];
		$nopag 				= '';

		// set up data attributes
		$data  = '';
		$data .= ' data-items="' 				. $items . '"';
		$data .= ' data-itemsdesktop="' 		. $items_desktop . '"';
		$data .= ' data-itemsdesktopsmall="' 	. $items_desktop . '"';
		$data .= ' data-itemstablet="' 			. $items_tablet . '"';
		$data .= ' data-itemstabletsmall="' 	. $items_tablet . '"';
		$data .= ' data-itemsmobile="' 			. $items_mobile . '"';
		$data .= ' data-singleitem="' 			. $single_item . '"';
		$data .= ' data-scrollperpage="' 		. $scroll . '"';
		$data .= ' data-navigation="' 			. $arrows . '"';
		$data .= ' data-navprevtext="<span class=\'hidden\'>' 		. JText::_('TPL_PREVIOUS') . '</span>"';
		$data .= ' data-navnexttext="<span class=\'hidden\'>' 		. JText::_('TPL_NEXT') . '</span>"';
		if ($pagination  == 'none') {
			$data .= ' data-pagination="false"';
		} 
		if ($pagination == 'number') {
			$data .= ' data-paginationNumbers="true"';
		}		
		$data .= ' data-autoplay="' 			. $autoplay . '"';
		$data .= ' data-slidespeed="' 			. $speed . '"';

		$noarrow = ($atts['arrows'] != 'yes')?' carousel-noarrow':'';
		// Links target
		if ($isAdmin) {
			$target = 'popup';
		}
		if ($target === '_blank') {
			$targetlink = ' target="_blank"';
		} elseif ($target === 'popup') {
			$targetlink = "onclick='window.open(this.href,\"Popup\",\"height=600,width=800,resizable=1,scrollbars=1\"); return false;'";
		} else {
			$targetlink = '';
		}

		// Loop slides
		if (count ( $slides )) {
			$count_slide = 0;
			if ($display === "grid") {
				$cols 	 = 'col-sm-6 col-md-'.$item_row;
				$return  = '<div class="clients '.$style.' clearfix row '.$grid_style. ' '.$dark.' '.$atts['class'].'">';

				for($i = 0; $i < count ( $slides ); $i ++) {
					// set url image
					$url = parse_url ( $slides [$i] ['src'] );
					if (! isset ( $url ['host'] )) {
						$slides [$i] ['src'] = JURI::root () . $slides [$i] ['src'];
					}
					
					if ($create_thumb == "yes") {
						// process to create image
						$slides [$i] ['src'] = Jv_shortcodeHelper::createThumb ( $id, $slides [$i] ['src'], $atts ['thumbnail_width'], $atts ['thumbnail_height'], $atts ['crop_center'], $atts ['quality'] );
					}
					$clear   = '';
					$return .=  $clear. '<div class="'.$cols.' client ">';
					$return .= 		'<div class="client-img">';
										if ($slides [$i] ['link']) {
											$return .= '<a href="' . $slides [$i] ['link'] . '" ' . $targetlink . '><img src="' . $slides [$i] ['src'] . '" alt=""></a>';
										} else {
											$return .= '<img src="' . $slides [$i] ['src'] . '" alt="">';
										}
					$return .= 		'</div>';
									if($slides[$i]['title'] && $atts['show_title'] == 'yes'){
										$return .= '<h4 class="client-title">';
											if($slides[$i]['link']){
												$return .= '<a href="' . $slides [$i] ['link'] . '" ' . $target . '>' . $slides[$i]['title'] . '</a>';
											}else{
												$return .= $slides[$i]['title'];
											}
										$return .='</h4>';
									}
					$return .= '</div>';	
				}
				// Close Grid
				$return .= '</div>';
			} elseif ($display === "carousel") {
				// Prepare width and height
				// Open slider			
				$return = '<div id="' . $id . '" class="clients '.$style.' carouselOwl'. $carousel_style . $dark . $noarrow .' '.$atts['class'].'" style="" ' . $data . '>';
				for($i = 0; $i < count ( $slides ); $i ++) {
					// set url image
					$url = parse_url ( $slides [$i] ['src'] );
					if (! isset ( $url ['host'] )) {
						$slides [$i] ['src'] = JURI::root () . $slides [$i] ['src'];
					}
					
					if ($create_thumb == "yes") {
						// process to create image
						$slides [$i] ['src'] = Jv_shortcodeHelper::createThumb ( $id, $slides [$i] ['src'], $atts ['thumbnail_width'], $atts ['thumbnail_height'], $atts ['crop_center'], $atts ['quality'] );
					}			
					
					// open item
					$return .= '<div class="client">';
						$return .= '<div class="client-img">';
						if ($slides [$i] ['link']) {
							$return .= '<a href="' . $slides [$i] ['link'] . '" ' . $targetlink . ' title="'. $slides[$i]['title'] .'"><img src="' . $slides [$i] ['src'] . '" alt=""></a>';
						} else {
							$return .= '<img src="' . $slides [$i] ['src'] . '" alt="'. $slides[$i]['title'] .'">';
						}
						
						if($slides[$i]['title'] && $atts['show_title'] == 'yes'){
							$return .= '<h4 class="client-title">';
								if($slides[$i]['link']){
									$return .= '<a href="' . $slides [$i] ['link'] . '" ' . $target . '>' . $slides[$i]['title'] . '</a>';
								}else{
									$return .= $slides[$i]['title'];
								}
							$return .='</h4>';
						}
						
						// close item
						$return .= '</div>';
					$return .= '</div>';
				}
				// Close slides
				$return .= '</div>';	
			}
			// reset carousel
			self::$images = array ();	
		} 	// Slides not found
		else
			$return = '<p class="jvsc-error">Slider: images not found.</p>';
		return $return;
	}
	public static function taglinebox($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' => 'top',
				'width' => 500,
				'font_size' => 14,
				'text_color' => '#5b5b5b',
				'title' => '',
				'title_color' => '#259b9a',
				'align_center' => 'no',
				'bgr_color' => '#f6f6f6',
				'class' => '' 
		), $atts, 'taglinebox' );
		
		$return = '';
		// Title
		if ($atts ['title']) {
			// Style title
			$title_style = array (
					'font-size:' . ($atts ['font_size'] + 4) . 'px',
					'color:' . $atts ['title_color'] 
			);
			$title = '<span class="jvsc-taglinebox-title" style="' . implode ( ';', $title_style ) . '">' . $atts ['title'] . '</span>';
		}
		// Border style
		$border_style = array ();
		if ($atts ['style'] === 'top') {
			$border_style = array (
					'border-top:3px solid ' . $atts ['title_color'] . '!important' 
			);
		} elseif ($atts ['style'] === 'full') {
			$border_style = array (
					'border: 3px solid ' . $atts ['title_color'] . '!important' 
			);
		}
		// Box style
		$box_style = array (
				'background-color:' . $atts ['bgr_color'],
				'width:' . $atts ['width'] . 'px',
				'text-align:' . ($atts ['align_center'] === 'yes' ? 'center' : 'left') 
		);
		$box_style = array_merge ( $border_style, $box_style );
		// open wrap
		$return = '<div class="jvsc-tagline-box-wrap ' . $atts ['class'] . '" style="' . implode ( ';', $box_style ) . '">';
		$return .= $title;
		// Prepare content style
		$content_style = array (
				'font-size:' . $atts ['font_size'],
				'color:' . $atts ['text_color'] 
		);
		$return .= '<div class="jvsc-tagline-box-content" style="' . implode ( ';', $content_style ) . '">' . do_shortcode ( $content ) . '</div>';
		// close wrap
		$return .= '</div>';
		// Load style
		$css = jv_query_asset ( 'css', 'content-shortcodes' );
		return $css . $return;
	}
	public static function testimonials($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' => 'testimonial-1',
				'carousel' => 'yes',
				'number' => 'single',
				'arrows' => 'no',
				'pagination' => 'no',
				'autoplay' => '5000',
				'speed' => '600',
				'class' => '' 
		), $atts, 'testimonials' );
		do_shortcode ( $content );
		$return 	= '';
		$style 		= $atts['style'];
		$carousel 	= $atts['carousel'];
		$number 	= $atts['number'];
		$arrows 	= ($atts['arrows'] == 'yes')?'true':'false';
		$pagination = ($atts['pagination'] == 'yes')?'true':'false';;
		$autoplay 	= ($atts['autoplay'] == 0)?'false':$atts['autoplay'];
		$speed 		= $atts['speed'];
		$class 		= $atts['class'];

		$classCarousel = $dataCarousel = '';
		if ($carousel == 'yes') {
			$classCarousel = 'carouselOwl';
			if ($number == 'single') {
				$dataCarousel  = 'data-singleitem="true" data-slidespeed="'.$speed.'" data-autoplay="'.$autoplay.'" data-navigation="'.$arrows.'" data-pagination="'.$pagination.'" data-addactive="true" data-transition="fade"';
			} else {
				$dataCarousel  = 'data-items="2" data-itemsdesktop="2" data-itemsdesktopsmall="2" data-itemstablet="1" data-itemstabletsmall="1" data-itemsmobile="1" data-slidespeed="'.$speed.'" data-autoplay="'.$autoplay.'" data-navigation="'.$arrows.'" data-pagination="'.$pagination.'" data-transition="fade"';
			}
		} else {
			$classCarousel = 'row';
		}

		$users = array ();
		$thumbnail = array();
		if (is_array ( self::$users )) {
			foreach ( self::$users as $key => $user ) {
				$user_name 			= 								'<h4 class="testimonial-name">'.$user['name'].'</h4>';
				$user_avatar 		= ($user['avatar'] != '')?		'<div class="testimonial-avatar"><img alt="' . $user['name'] . '" src="' . JURI::root () . '/' . $user['avatar'] . '"/></div>':'';
				$user_avatar_bg 	= ($user['avatar'] != '')?		'<div class="testimonial-avatar background" style="background-image: url(' . JURI::root () . '/' . $user['avatar'] . ');"></div>':'';
				$user_position 		= ($user['position'] != '')?	'<span class="testimonial-position">' . $user['position'] . '</span>':'';
				$user_company 		= ($user['company'] != '')?		'<span class="testimonial-company">' . $user['company'] . '</span>':'';
				$user_date 			= ($user['date'] != '')?		'<span class="testimonial-date">' . $user['date'] . '</span>':'';
				$user_rating 		= ($user['rating'] != 0)?		'<span class="testimonial-rating"><span class="rating rating-' . $user['rating'] . '"></span></span>':'';
				$user_recommended	= ($user['recommended'] != 0)?	'<span class="testimonial-recommended">' . $user['recommended'] . '% Recommended</span>':'';
				$user_content 		= ($user['content'] != '')?		'<div class="testimonial-content">' . $user['content'] . '</div>':'';
				$user_class 		= $user['class'];

				// Header/Footer Open
				$head_o = '<div class="testimonial-head">';
				$footer_o = '<div class="testimonial-footer">';
				//Header/Footer Close
				$head_c = $footer_c = '</div>';
				$html = '';
				if ($carousel != 'yes') {
					if ($number == 'single') {
						$html .='<div class="col-sm-12">';	
					} else {						
						$clearfix = (($key%2) == 0)?'clearfix':'';
						$html .='<div class="col-sm-12 col-md-6 '.$clearfix.'">';
					}
					
				}
				$html .= '<div class="testimonial '.$style. $user_class .'"><div class="testimonial-inner">';
				$html .= $user_content.$head_o.$user_avatar.$user_name.$user_position.$user_company.$user_date.$user_rating.$user_recommended.$head_c;
				$html .= '</div></div>';

				if ($carousel != 'yes') {
					$html .='</div>';
				}

				$users [] = $html;
				$thumb_avatar 		= ($user['avatar'] != '')?		'<img alt="' . $user['name'] . '" src="' . JURI::root () . '/' . $user['avatar'] . '"/>':'';
				$thumbnail [] = '<a href="javascript:void(0);" data-slide-index="'.$key.'">'.$thumb_avatar.'</a>';	
			}
			$id ='testimonials-'.rand(100,9999999);
			if ($style == 'testimonial-3') {
				if ($carousel == 'yes') {
					$classCarousel = ' testimonial-hidden';
					$pag = 'false';
					$singleItem = ($number == "single" || $number == "1")?'true':'false';
					$items = ($number != "single")?$number:'12';
					$itemsDesktop = ($items > 1)?($items - 1):'1';
					$itemsDesktopSmall = ($itemsDesktop > 1)?($itemsDesktop - 1):'1';
					$itemsTablet = ($itemsDesktopSmall > 1)?($itemsDesktopSmall - 1):'1';
					$itemsMobile = ($itemsTablet > 1)?($itemsTablet - 1):'1';
					$document 	= JFactory::getDocument();
					$document->addScriptDeclaration('
						(function($){
							$(function(){
								var $sync1 = $("#'.$id.' .testimonials-inner");
								var $sync2 = $("#'.$id.'-thumbnail");
								flag = false,
						        duration = 300;
						 
						    $sync1
						        .owlCarousel2({
						        	rtl: $("body").hasClass("rtl") ? true : false,
						            items: 1,
						            margin: 10,
						            nav: '.$arrows.',
						            navText: ["<i class=\"fa fa-angle-left\"></i>","<i class=\"fa fa-angle-right\"></i>"],
						            dots: false
						        })
						        .on(\'changed.owl.carousel\', function (e) {
						            if (!flag) {
						                flag = true;
						                $sync2.trigger(\'to.owl.carousel\', [e.item.index, duration, true]);
						                $sync2.find(".owl-item").removeClass("abc").eq(e.item.index).addClass("abc");
						                flag = false;
						            }
						        });
						 
						    $sync2
						        .owlCarousel2({
						        	rtl: $("body").hasClass("rtl") ? true : false,
						            margin: 20,
						            items: '.$items.',
						            nav: false,
						            center: true,
						            dots: false
						        })
						        .on(\'click\', \'.owl-item\', function () {
						            $sync1.trigger(\'to.owl.carousel\', [$(this).index(), duration, true]);
						 
						        })
						        .on(\'changed.owl.carousel\', function (e) {
						            if (!flag) {
						                flag = true;        
						                $sync1.trigger(\'to.owl.carousel\', [e.item.index, duration, true]);
						                flag = false;
						            }
						        });
								

							});
						})(jQuery);	
					');
					if ($pagination == 'true') {
						$thumbnail_slide = '<div  id="'.$id.'-thumbnail" class="testimonial-thumbnails testimonial-hidden">'.implode ( '', $thumbnail ) .'</div>';		
					}							
				} else {
					$classCarousel = 'row';
				}				
			}
			if ($style == 'testimonial-3') {
				$return = '<div id="'.$id.'" class="testimonials ' . $style . ' ' . $class .'"><div class="testimonials-inner '. $classCarousel. '">' . implode ( '', $users ) . '</div>'.$thumbnail_slide.'</div>';
			}else {
				$return = '<div class="testimonials ' . $style . ' ' . $class .'"><div class="testimonials-inner '. $classCarousel. '" '.$dataCarousel.'>' . implode ( '', $users ) . '</div></div>';			
			}
		}
		// reset user
		self::$users = array ();
		self::$user_count = 0;	

		return  $return;
	}
	public static function user($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
			'name'			=> '',
			'avatar'		=> '',
			'position'		=> '',
			'company'		=> '',
			'date'			=> '',
			'rating'		=> 0,
			'recommended'	=> '',
			'class'	 		=> '' 
		), $atts, 'user' );		
		$x = self::$user_count;
		self::$users [$x] = array (
			'name'			=> $atts['name'],
			'avatar'		=> $atts['avatar'],
			'position'		=> $atts['position'],
			'company'		=> $atts['company'],
			'date'			=> $atts['date'],
			'rating'		=> $atts['rating'],
			'recommended'	=> $atts['recommended'],
			'content' 		=> do_shortcode ( $content ),
			'class'	 		=> $atts['class']
		);
		self::$user_count ++;
	}
	public static function teams($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' => 'style-1',
				'carousel' => 'no',
				'number' => '4',
				'arrows' => 'no',
				'pagination' => 'no',
				'autoplay' => '5000',
				'speed' => '600',
				'class' => '' 
		), $atts, 'teams' );
		do_shortcode ( $content );
		$return 	= '';
		$style 		= $atts['style'];
		$carousel 	= $atts['carousel'];
		$number 	= $atts['number'];
		$arrows 	= ($atts['arrows'] == 'yes')?'true':'false';
		$pagination = ($atts['pagination'] == 'yes')?'true':'false';;
		$autoplay 	= ($atts['autoplay'] == 0)?'false':$atts['autoplay'];
		$speed 		= $atts['speed'];
		$class 		= $atts['class'];

		$classCarousel = $dataCarousel = '';
		if ($carousel == 'yes') {
			$classCarousel = 'carouselOwl';
			if ($number == '1') {
				$dataCarousel  = 'data-singleitem="true" data-slidespeed="'.$speed.'" data-autoplay="'.$autoplay.'" data-navigation="'.$arrows.'" data-pagination="'.$pagination.'" data-addactive="true"';
			} else {
				$itemsDesktopSmall = ((($number - 1) > 0)?($number-1):$number);
				$itemsTablet = ((($number - 2) > 0)?(((($number - 1) > 0)?($number-1):$number)):$number);
				$itemsTabletSmall = ($number>2)?'2':$number;
				$dataCarousel  = 'data-items="'.$number.'" data-itemsdesktop="'.$number.'" data-itemsdesktopsmall="'.$itemsDesktopSmall.'" data-itemstablet="'.$itemsTablet.'" data-itemstabletsmall="'.$itemsTabletSmall.'" data-itemsmobile="1" data-slidespeed="'.$speed.'" data-autoplay="'.$autoplay.'" data-navigation="'.$arrows.'" data-pagination="'.$pagination.'"';
			}
		} else {
			$classCarousel = 'row';
		}

		$team = array ();
		$thumbnail = array();
		if (is_array ( self::$members )) {
			foreach ( self::$members as $key => $member ) {
				$member_name 		= '<h4 class="member-name">'.$member['name'].'</h4>';
				$member_image		= ($member['image'] != '')?		'<div class="member-image"><img alt="' . $member['name'] . '" src="' . JURI::root () . '' . $member['image'] . '"/></div>':'';
				$member_position 	= ($member['position'] != '')?	'<span class="member-position">' . $member['position'] . '</span>':'';

				$member_social = $member_website = $member_facebook = $member_google = $member_linkedin = $member_twitter = $member_github = $member_tumblr = $member_pinterest = $member_instagram = $member_mail = "";

				if ($member['website'] != '' || 
					$member['facebook'] || 
					$member['google'] || 
					$member['linkedin'] || 
					$member['twitter'] || 
					$member['github'] || 
					$member['tumblr'] || 
					$member['pinterest'] || 
					$member['instagram'] || 
					$member['mail'] 
				) {
					if ($style == "style-2") {
						$member_social  = '<div class="member-social carouselOwl" data-items="4" data-itemsdesktop="3" data-itemsdesktopsmall="5" data-itemstablet="4" data-itemstabletsmall="3" data-itemsmobile="4" data-autoplay="false" data-navigation="false" data-pagination="false">';
					} else {
						$member_social  = '<div class="member-social carouselOwl" data-items="5" data-itemsdesktop="4" data-itemsdesktopsmall="6" data-itemstablet="5" data-itemstabletsmall="4" data-itemsmobile="5" data-autoplay="false" data-navigation="false" data-pagination="false">';
					}
					$member_social .= ($member['website'] != '')?	'<a href="' . $member['website'] . '" target="_blank" class="member-social-website"><i class="fa fa-globe"></i></a>':'';
					$member_social .= ($member['facebook'] != '')?	'<a href="' . $member['facebook'] . '" target="_blank" class="member-social-facebook"><i class="fa fa-facebook"></i></a>':'';
					$member_social .= ($member['google'] != '')?	'<a href="' . $member['google'] . '" target="_blank" class="member-social-google"><i class="fa fa-google-plus"></i></a>':'';
					$member_social .= ($member['linkedin'] != '')?	'<a href="' . $member['linkedin'] . '" target="_blank" class="member-social-linkedin"><i class="fa fa-linkedin"></i></a>':'';
					$member_social .= ($member['twitter'] != '')?	'<a href="' . $member['twitter'] . '" target="_blank" class="member-social-twitter"><i class="fa fa-twitter"></i></a>':'';
					$member_social .= ($member['github'] != '')?	'<a href="' . $member['github'] . '" target="_blank" class="member-social-github"><i class="fa fa-github"></i></a>':'';
					$member_social .= ($member['tumblr'] != '')?	'<a href="' . $member['tumblr'] . '" target="_blank" class="member-social-tumblr"><i class="fa fa-tumblr"></i></a>':'';
					$member_social .= ($member['pinterest'] != '')?	'<a href="' . $member['pinterest'] . '" target="_blank" class="member-social-pinterest"><i class="fa fa-pinterest"></i></a>':'';
					$member_social .= ($member['instagram'] != '')?	'<a href="' . $member['instagram'] . '" target="_blank" class="member-social-instagram"><i class="fa fa-instagram"></i></a>':'';
					$member_social .= ($member['mail'] != '')?		'<a href="mailto:' . $member['mail'] . '" class="member-social-website"><i class="fa fa-envelope"></i></a>':'';
					$member_social .= '</div>';
				}

				$member_excerpt		= ($member['excerpt'] != '')?	'<div class="member-excerpt">' . $member['excerpt'] . '</div>':'';
				$member_content 	= ($member['content'] != '')?	'<div class="member-content">' . $member['content'] . '</div>':'';

				// Header/Footer Open
				$head_o = '<div class="member-head">';
				$footer_o = '<div class="member-footer">';
				//Header/Footer Close
				$head_c = $footer_c = '</div>';
				$html = '';
				if ($carousel != 'yes') {
					if ($number == '1') {
						$html .='<div class="col-sm-12">';	
					} else {
						$cols_sm = ($number==3)?'col-xxs-offset-0 col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-0':'col-xs-6 col-sm-6';
						$cols_sm = ($style == 'style-19')?'col-xs-12 col-sm-12':$cols_sm;
						$html .='<div class="col-xxs-12 '.$cols_sm.' col-md-'.number_format(12/$number,0).'">';
					}
				}
				$html  .= '<div class="member '.$style.'"><div class="member-inner">';
				$html .= $member_image.$head_o.$member_name.$member_position.$member_excerpt.$head_c.$member_social.$member_content;
				if ($carousel != 'yes') {
					$html .='</div>';
				}

				$html .= '</div></div>';

				$team [] = $html;				
			}

				$return = '<div class="teams ' . $style . ' ' . $class .'"><div class="teams-inner '. $classCarousel. '" '.$dataCarousel.'>' . implode ( '', $team ) . '</div></div>';			
		}
		// reset user
		self::$members = array ();
		self::$member_count = 0;	

		return  $return;
	}
	public static function member($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
			'name'			=> '',
			'image'			=> '',
			'position'		=> '',
			'website'		=> '',
			'facebook'			=> '',
			'google'			=> '',
			'linkedin'			=> '',
			'twitter'			=> '',
			'github'			=> '',
			'tumblr'			=> '',
			'pinterest'			=> '',
			'instagram'			=> '',
			'mail'			=> '',
			'excerpt'	=> ''
		), $atts, 'member' );		
		$x = self::$member_count;
		self::$members [$x] = array (
			'name'			=> $atts['name'],
			'image'			=> $atts['image'],
			'position'		=> $atts['position'],
			'website'		=> $atts['website'],
			'facebook'		=> $atts['facebook'],
			'google'		=> $atts['google'],
			'linkedin'		=> $atts['linkedin'],
			'twitter'		=> $atts['twitter'],
			'github'		=> $atts['github'],
			'tumblr'		=> $atts['tumblr'],
			'pinterest'		=> $atts['pinterest'],
			'instagram'		=> $atts['instagram'],
			'mail'			=> $atts['mail'],
			'excerpt' 		=> $atts['excerpt'],
			'content' 		=> do_shortcode ( $content )
		);
		self::$member_count ++;
	}
	public static function skillbars($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' => 'default',
				'show_percent' => 'yes',
				'show_striped' => 'no',
				'class' => '' 
		), $atts );
		do_shortcode ( $content );
		$return = '';
		$bars = array ();

		$striped = ($atts ['show_striped'] == 'yes')?' progress-bar-striped':'';
		$skillbarsStyle = $atts ['style'];
		$showPercent = $atts ['show_percent'];

		if (is_array ( self::$bars )) {
			foreach ( self::$bars as $bar ) {
				$style 		= $bar ['style'];
				$icon 		= $bar ['icon'];
				$percent	= $bar ['achievement_percent'];
				$title 		= $bar ['title'];

				if (strpos($icon, 'icon:') !== false) {
					$icon = str_replace('icon:', '',$icon);
					$icon = '<i class="jv-list-icon fa fa-' . $icon . '"></i> ';
				}

				$title 	  = $icon.$title;

				$html = '<div class="progress-wrapper">';
				if ( $skillbarsStyle == 'progress-1' && ($showPercent == 'yes')) {
					$html .='<div class="progress-value"><span class="counting">'.$percent.'</span>%</div>';
				}
				$html .='<div class="progress-title">'.$title.'</div>';
				
				$html .= '<div class="progress progress-'.$style.'">';
				$html .= '<div class="progress-bar progress-bar-'.$style.$striped.'" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%">';
				if (( 	$skillbarsStyle == 'progress-2') && ($showPercent == 'yes')){
					$html .='<div class="progress-value"><span class="counting">'.$percent.'</span>%</div>';
				}

				$html .=  '  <span class="sr-only">'.$percent.'% Complete (success)</span>
						  </div></div>';
				$html .= '
					</div>';

				$bars [] = $html;
			}
			$return = '<div class="jv-progress jv-' . $atts ['style'] . ' ' . $atts ['class'] . '">' . implode ( '', $bars ) . '</div>';
		}
		// reset bars
		self::$bars = array ();
		self::$bar_count = 0;		
		return  $return;
	}
	public static function skillbar($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'title' => '',
				'icon' => '',
				'style' => '',
				'achievement_percent' => 0,
				'class' => '' 
		), $atts );
		$x = self::$bar_count;
		self::$bars [$x] = array (
				'title' => $atts ['title'],
				'icon' => $atts ['icon'],
				'style' => $atts ['style'],
				'achievement_percent' => $atts ['achievement_percent'],
				'class' => $atts ['class'] 
		);
		self::$bar_count ++;
	}
	public static function piechart($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' 		=> 'default',
				'value' 		=> '50',
				'value' 		=> '50',
				'value_size' 	=> '30',
				'value_class' 	=> '',
				'counter' 		=> '0',
				'icon' 			=> '',
				'icon_size' 	=> '30',
				'icon_show' 	=> 'no',
				'barcolor'		=> '#31aae2',
				'trackcolor'	=> '#eee',
				'linewidth'		=> '10',
				'size' => '160',
				'title' => '',
				'sub_text' => '' ,
				'class' => '' 
		), $atts );
		do_shortcode ( $content );
		$html = '';
		$mainframe = JFactory::getApplication();
		$isAdmin = $mainframe->isAdmin();		
		// not live preview
		if($isAdmin) return 'Preview this shortcode not apply. You can see it in font-end';

		// --------------
		$style 			= $atts['style'];

		$trackcolor 	= $atts['trackcolor']; 
		$barcolor  		= $atts['barcolor'];
		$to 			= $atts['value'];

		$title 			= (!empty($atts['title']))?'<h3 class="piechart-head">'.$atts['title'].'</h3>':'';
		$sub_text 		= (!empty($atts['sub_text']))?'<p>'.$atts['sub_text'].'</p>':'';

		$linewidth 		=  $atts['linewidth'];
		$size 			=  $atts['size'];

		// Icon
		$icon_size 		= ' style="font-size:'.$atts['icon_size'].'px; color:'.$barcolor.';"';
		if ($atts['style']== 'piechart-3') {
			$icon_size		= ' style="font-size:'.$atts['icon_size'].'px; text-shadow: -4px -4px 0 '.$barcolor .', -4px -3px 0 '.$barcolor .', -4px -2px 0 '.$barcolor .', -4px -1px 0 '.$barcolor .', -4px 0px 0 '.$barcolor .', -4px 1px 0 '.$barcolor .', -4px 2px 0 '.$barcolor .', -4px 3px 0 '.$barcolor .', -4px 4px 0 '.$barcolor .', -3px -4px 0 '.$barcolor .', -3px -3px 0 '.$barcolor .', -3px -2px 0 '.$barcolor .', -3px -1px 0 '.$barcolor .', -3px 0px 0 '.$barcolor .', -3px 1px 0 '.$barcolor .', -3px 2px 0 '.$barcolor .', -3px 3px 0 '.$barcolor .', -3px 4px 0 '.$barcolor .', -2px -4px 0 '.$barcolor .', -2px -3px 0 '.$barcolor .', -2px -2px 0 '.$barcolor .', -2px -1px 0 '.$barcolor .', -2px 0px 0 '.$barcolor .', -2px 1px 0 '.$barcolor .', -2px 2px 0 '.$barcolor .', -2px 3px 0 '.$barcolor .', -2px 4px 0 '.$barcolor .', -1px -4px 0 '.$barcolor .', -1px -3px 0 '.$barcolor .', -1px -2px 0 '.$barcolor .', -1px -1px 0 '.$barcolor .', -1px 0px 0 '.$barcolor .', -1px 1px 0 '.$barcolor .', -1px 2px 0 '.$barcolor .', -1px 3px 0 '.$barcolor .', -1px 4px 0 '.$barcolor .', 0px -4px 0 '.$barcolor .', 0px -3px 0 '.$barcolor .', 0px -2px 0 '.$barcolor .', 0px -1px 0 '.$barcolor .', 0px 0px 0 '.$barcolor .', 0px 1px 0 '.$barcolor .', 0px 2px 0 '.$barcolor .', 0px 3px 0 '.$barcolor .', 0px 4px 0 '.$barcolor .', 1px -4px 0 '.$barcolor .', 1px -3px 0 '.$barcolor .', 1px -2px 0 '.$barcolor .', 1px -1px 0 '.$barcolor .', 1px 0px 0 '.$barcolor .', 1px 1px 0 '.$barcolor .', 1px 2px 0 '.$barcolor .', 1px 3px 0 '.$barcolor .', 1px 4px 0 '.$barcolor .', 2px -4px 0 '.$barcolor .', 2px -3px 0 '.$barcolor .', 2px -2px 0 '.$barcolor .', 2px -1px 0 '.$barcolor .', 2px 0px 0 '.$barcolor .', 2px 1px 0 '.$barcolor .', 2px 2px 0 '.$barcolor .', 2px 3px 0 '.$barcolor .', 2px 4px 0 '.$barcolor .', 3px -4px 0 '.$barcolor .', 3px -3px 0 '.$barcolor .', 3px -2px 0 '.$barcolor .', 3px -1px 0 '.$barcolor .', 3px 0px 0 '.$barcolor .', 3px 1px 0 '.$barcolor .', 3px 2px 0 '.$barcolor .', 3px 3px 0 '.$barcolor .', 3px 4px 0 '.$barcolor .', 4px -4px 0 '.$barcolor .', 4px -3px 0 '.$barcolor .', 4px -2px 0 '.$barcolor .', 4px -1px 0 '.$barcolor .', 4px 0px 0 '.$barcolor .', 4px 1px 0 '.$barcolor .', 4px 2px 0 '.$barcolor .', 4px 3px 0 '.$barcolor .', 4px 4px 0 '.$barcolor .';"';
		}
		$icon ='';
		if (strpos($atts ['icon'], 'icon:') !== false) {
			$atts['icon'] = str_replace('icon:', '', $atts['icon']);
			$icon = '<span class="piechart-icon"><i class="fa fa-' . $atts ['icon'] . '" '.$icon_size.'></i></span>';
		}elseif ($atts['icon'] != ''){
			$icon_size 		= ' style="width:'.$atts['icon_size'].'px;"';
			$icon = '<span class="piechart-icon"><img alt="' . $content .'" src="' . $counter['icon'] . '" '.$icon_size.'/><span>';
		}

		// Value
		$value_size		= ' style="font-size:'.$atts['value_size'].'px;"';
		if ($atts['style']== 'piechart-3') {
			$value_size		= ' style="font-size:'.$atts['value_size'].'px; text-shadow: -4px -4px 0 '.$barcolor .', -4px -3px 0 '.$barcolor .', -4px -2px 0 '.$barcolor .', -4px -1px 0 '.$barcolor .', -4px 0px 0 '.$barcolor .', -4px 1px 0 '.$barcolor .', -4px 2px 0 '.$barcolor .', -4px 3px 0 '.$barcolor .', -4px 4px 0 '.$barcolor .', -3px -4px 0 '.$barcolor .', -3px -3px 0 '.$barcolor .', -3px -2px 0 '.$barcolor .', -3px -1px 0 '.$barcolor .', -3px 0px 0 '.$barcolor .', -3px 1px 0 '.$barcolor .', -3px 2px 0 '.$barcolor .', -3px 3px 0 '.$barcolor .', -3px 4px 0 '.$barcolor .', -2px -4px 0 '.$barcolor .', -2px -3px 0 '.$barcolor .', -2px -2px 0 '.$barcolor .', -2px -1px 0 '.$barcolor .', -2px 0px 0 '.$barcolor .', -2px 1px 0 '.$barcolor .', -2px 2px 0 '.$barcolor .', -2px 3px 0 '.$barcolor .', -2px 4px 0 '.$barcolor .', -1px -4px 0 '.$barcolor .', -1px -3px 0 '.$barcolor .', -1px -2px 0 '.$barcolor .', -1px -1px 0 '.$barcolor .', -1px 0px 0 '.$barcolor .', -1px 1px 0 '.$barcolor .', -1px 2px 0 '.$barcolor .', -1px 3px 0 '.$barcolor .', -1px 4px 0 '.$barcolor .', 0px -4px 0 '.$barcolor .', 0px -3px 0 '.$barcolor .', 0px -2px 0 '.$barcolor .', 0px -1px 0 '.$barcolor .', 0px 0px 0 '.$barcolor .', 0px 1px 0 '.$barcolor .', 0px 2px 0 '.$barcolor .', 0px 3px 0 '.$barcolor .', 0px 4px 0 '.$barcolor .', 1px -4px 0 '.$barcolor .', 1px -3px 0 '.$barcolor .', 1px -2px 0 '.$barcolor .', 1px -1px 0 '.$barcolor .', 1px 0px 0 '.$barcolor .', 1px 1px 0 '.$barcolor .', 1px 2px 0 '.$barcolor .', 1px 3px 0 '.$barcolor .', 1px 4px 0 '.$barcolor .', 2px -4px 0 '.$barcolor .', 2px -3px 0 '.$barcolor .', 2px -2px 0 '.$barcolor .', 2px -1px 0 '.$barcolor .', 2px 0px 0 '.$barcolor .', 2px 1px 0 '.$barcolor .', 2px 2px 0 '.$barcolor .', 2px 3px 0 '.$barcolor .', 2px 4px 0 '.$barcolor .', 3px -4px 0 '.$barcolor .', 3px -3px 0 '.$barcolor .', 3px -2px 0 '.$barcolor .', 3px -1px 0 '.$barcolor .', 3px 0px 0 '.$barcolor .', 3px 1px 0 '.$barcolor .', 3px 2px 0 '.$barcolor .', 3px 3px 0 '.$barcolor .', 3px 4px 0 '.$barcolor .', 4px -4px 0 '.$barcolor .', 4px -3px 0 '.$barcolor .', 4px -2px 0 '.$barcolor .', 4px -1px 0 '.$barcolor .', 4px 0px 0 '.$barcolor .', 4px 1px 0 '.$barcolor .', 4px 2px 0 '.$barcolor .', 4px 3px 0 '.$barcolor .', 4px 4px 0 '.$barcolor .';"';
		}
		$value_class	= $atts['value_class'];
		$value = ($atts['icon_show'] == 'yes' && $icon != '')?$icon:'<span class="piechart-value '.$value_class.'" '.$value_size.'>' . $to . '<sup>%</sup></span>';

		// Counter
		$counter = ($atts['counter'] != '0')?'<div class="piechart-counter"><span class="counting">'.$atts['counter'].'</span></div>':'';
		if ($atts['style']== 'piechart-2') {
			$atts['style'] .= '" style="background-color:' . $barcolor . '; ';
			$barcolor = '#ffffff';
		}
		if ($atts['style']== 'piechart-4') {
			$value .= '<span class="bg-color" style="background-color:'. $barcolor .'; width:'.($size/2).'px; height:'.($size/2).'px; margin-top:-'.($size/4).'px; margin-left:-'.($size/4).'px"></span>';
		}
		if ($atts['style']== 'piechart-5' && $atts['counter']) {
			$value = $counter;
			$counter = "";
		}
		$html .='
		<div class="piechart-wrap '.$atts['style'].' '.$atts['class'].'">
			<div class="divpiechart" 
				data-from="0" 
				data-to="' . $to . '" 
				data-barcolor="' . $barcolor . '" 
				data-trackcolor="' . $trackcolor . '" 
				data-linecap="square" 
				data-linewidth="'. $linewidth .'" 
				data-size="'. $size .'"
			>
				<div class="piechart-inner" style="height:'.$size.'px;">' . $value . '</div>
			</div>
			'. $counter .'
			'. $title .'
			'. $sub_text .'
		</div>';
		return $html;
	}
	public static function counters($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' => 'counters-3',
				'icon_size' => '0',
				'digit_size' => '0',
				'carousel' => 'no',
				'number' => '4',
				'arrows' => 'no',
				'pagination' => 'no',
				'autoplay' => '5000',
				'speed' => '600',
				'class' => '' 
		), $atts, 'counters' );
		do_shortcode ( $content );

		$return 	= '';
		$style 		= $atts['style'];
		$carousel 	= $atts['carousel'];
		$number 	= $atts['number'];
		$arrows 	= ($atts['arrows'] == 'yes')?'true':'false';
		$pagination = ($atts['pagination'] == 'yes')?'true':'false';;
		$autoplay 	= $atts['autoplay'];
		$speed 		= $atts['speed'];
		$class 		= $atts['class'];

		$classCarousel = $dataCarousel = '';
		if ($carousel == 'yes') {
			$classCarousel = 'carouselOwl';
			if ($number == '1') {
				$dataCarousel  = 'data-singleitem="true" data-slidespeed="'.$speed.'" data-autoplay="'.$autoplay.'" data-navigation="'.$arrows.'" data-pagination="'.$pagination.'"';
			} else {
				$itemsdesktopsmall = ($number > 1)?($number-1):$number;
				$dataCarousel  = 'data-items="'.$number.'" data-itemsdesktop="'.$number.'" data-itemsdesktopsmall="'.$itemsdesktopsmall.'" data-itemstablet="3" data-itemstabletsmall="2" data-itemsmobile="1" data-slidespeed="'.$speed.'" data-autoplay="'.$autoplay.'" data-navigation="'.$arrows.'" data-pagination="'.$pagination.'"';
			}
		} else {
			$classCarousel = 'row cols-'.$number;
		}

		$counters = array ();
		if (is_array ( self::$counters )) {
			foreach ( self::$counters as $key => $counter ) {
				$counter_icon_color = ($counter['icon_color'] !='none')?' text-'.$counter['icon_color']:'';
				$counter_icon_background = ($counter['icon_background'] !='none')?' bg-'.$counter['icon_background']:'';
				$counter_icon_size  = ($atts['icon_size'] !='0')?' style="font-size:'.$atts['icon_size'].'px;"':'';
				$counter_icon 		= '';
				if (strpos($counter ['icon'], 'icon:') !== false) {
					$counter['icon'] = str_replace('icon:', '', $counter['icon']);
					$counter_icon = ' <div class="counter-icon '. $counter_icon_color. $counter_icon_background.'">'.'<i class="fa fa-' . $counter ['icon'] . '" '.$counter_icon_size.'></i> '.'</div>';
				}elseif ($counter['icon'] != ''){
					$counter_icon = ' <div class="counter-icon '. $counter_icon_color. $counter_icon_background.'">'.'<span class="img"><img alt="' . $content .'" src="' . $counter['icon'] . '"/><span>'.'</div>';
				}
				$counter_digit 	= $counter['digit'];
				$counter_digit_size 	= ($atts['digit_size'] !='0')?' style="font-size:'.$atts['digit_size'].'px;"':'';
				$counter_prefix = $counter['prefix'];
				$counter_suffix = $counter['suffix'];
				$counter_title 	= (!empty($counter['title']))?'<h3 class="counter-head">'.$counter['title'].'</h3>':'';
				$counter_class 	= $counter['class'];


				$html = '';
				if ($carousel != 'yes') {
					$html .='<div class="col-xs-12 col-sm-6 col-md-'.number_format(12/$number, 0).' pt-md-30 pb-md-30">';
				}

				$html .='
				<div class="counter counter-'.$atts['style'].' '.$counter_class.'">
					<div class="counter-wrap">';
				if ($style == 'counters-4') {	$html .= '<div class="counter-body">';	}
				$html .=$counter_icon;
				if ($style == 'counters-2') {
					$html .=	$counter_title;
				}
				$html .= '	<div class="counter-content" '.$counter_digit_size.'>'.$counter_prefix.'<span class="counting">'.$counter_digit.'</span>'.$counter_suffix.'</div>';
				if ($style == 'counters-4') {	$html .= '<span class="counter-background '.$counter_icon_background.'"></span></div>';	}
				if ($style != 'counters-2') {
					$html .=	$counter_title;
				}
				$html .= '</div>
				</div>';

				if ($carousel != 'yes') {
					$html .='</div>';
				}

				$counters [] = $html;
			}
			$return = '<div class="counters ' . $style . ' ' . $class .'"><div class="counters-inner '. $classCarousel. '" '.$dataCarousel.'>' . implode ( '', $counters ) . '</div></div>';
		}
		// reset user
		self::$counters = array ();
		self::$counter_count = 0;	

		return  $return;
	}
	public static function counter($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' => 'default',
				'icon' => false,
				'icon_color' => 'none',
				'icon_background' => 'none',
				'digit' => '9999',
				'prefix' => '',
				'suffix' => '',
				'title' => '',
				'class' => ''
		), $atts );
		$x = self::$counter_count;
		self::$counters [$x] = array (
			'style'			=> $atts['style'],
			'icon'			=> $atts['icon'],
			'icon_color'	=> $atts['icon_color'],
			'icon_background'	=> $atts['icon_background'],
			'digit'			=> $atts['digit'],
			'prefix'		=> $atts['prefix'],
			'suffix'		=> $atts['suffix'],
			'title'			=> $atts['title'],
			'class'	 		=> $atts['class']
		);
		self::$counter_count ++;
	}
	public static function table($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'width' => 0,
				'border' => '1px solid #dfdfdf',
				'font_size_heading' => 16,
				'heading_color' => '#ffffff',
				'bgr_heading_color' => '#259b9a',
				'font_size' => 14,
				'text_color' => '#aeb9bf',
				'bgr_even_row' => 'none',
				'bgr_odd_row' => 'none',
				'class' => '' 
		), $atts );
		$id = uniqid ( 'jvsc-table-' );
		// prepare table style
		$declare_css = array (
				'type' => 'css',
				'val' => '' 
		);
		$style = '#' . $id . ' table {
					width:' . ($atts ['width'] == 0 ? '100%' : $atts['width'] . 'px') . '; 
					border:' . $atts ['border'] . ';
				}';
		$style .= '#' . $id . ' table tr:nth-child(odd) td{
					background-color:' . $atts ['bgr_odd_row'] . ';
		}';
		$style .= '#' . $id . ' table tr:nth-child(even) td{
					background-color:' . $atts ['bgr_even_row'] . ';
		}';
		$style .= '#' . $id . ' table th{
					font-size:' . $atts ['font_size_heading'] . 'px;
					color:' . $atts ['heading_color'] . ';
					background-color:' . $atts ['bgr_heading_color'] . ';
					border:' . $atts ['border'] . ';
					text-align: center;
				}';
		$style .= '#' . $id . ' table td{
					font-size:' . $atts ['font_size'] . 'px;
					color:' . $atts ['text_color'] . ';
					border:' . $atts ['border'] . ';
					}';
		$declare_css ['val'] = $style;
		// load style
		$declare_style = jv_query_asset ( 'inline', '', $declare_css );
		$link_style = jv_query_asset ( 'css', 'content-shortcodes' );
		$return = '<div id="' . $id . '" class="jvsc-table ' . $atts ['class'] . '">' . do_shortcode ( $content ) . '</div>';
		return $link_style . $declare_style . $return;
	}
	public static function pricetable($atts = null, $content = null) {
		$atts= shortcode_atts(array(
			'style' => 'pricetable-1',
			'currency'=>'$',
			'duration'=> '',
			'popular'=> '',
			'popular_text'=> '',
			'purchase_text'=>'PURCHASE',
			'cover'=>'',
			'class'=>''
		), $atts, 'pricetable');
		$mainframe = JFactory::getApplication();
		$isAdmin = $mainframe->isAdmin();
		
		// not live preview
		if($isAdmin) return 'Preview this shortcode not apply. You can see it in font-end';
		
		// do shortcode content
		do_shortcode($content);
		$style = $atts['style'];
		$class = ($atts['class'] != '')?' ' . $atts['class']:'';
		
		// generator html code
		$pricecols = array();
		$index = 1;
		foreach(self::$pricecols as $key => $col){
			// generator detail col
			$col_detail = array();
			foreach($col['detail'] as $detail){
				if(strpos($detail, 'icon:')===0){
					$feature = explode('|', $detail);
					$col_detail[]='<div class="pricetable-col-feature-detail"><i class="fa fa-'.str_replace('icon:','', $feature[0]).'"></i>'.$feature[1].'</div>';
				}else{
					$col_detail[]='<div class="pricetable-col-feature-detail">'.$detail.'</div>';
				}
			}

			$popular = ($atts['popular'] == $index)?' pricetable-popular':'';
			// gennerator cols

			$title 			= '<h2 class="pricetable-col-title"><span>'.$col['title'].'</span></h2>';
			$sub_title 		= ($col['sub_title'] != '')?'<p class="pricetable-col-sub-title">'.$col['sub_title'].'</p>':'';
			if (strpos($col['sub_title'], 'icon:') !== false) {
				$sub_title 	= str_replace('icon:', '',$col['sub_title']);
				$sub_title 	= '<div class="pricetable-col-sub-title"><i class="fa fa-' . $sub_title . '"></i></div>';
			}
			$price 			= ($col['price'] !=0)?'<div class="pricetable-col-price"><span class="currency">'.$atts['currency'].'</span><span class="price">'.$col['price'].'</span><span class="duration"><span>/</span> '.$atts['duration'].'</span></div>':'<div class="pricetable-col-price"><span class="price">Free</span><span class="duration">Forever</span></div>';
		 	$feature 		= '<div class="pricetable-col-feature">'.implode('', $col_detail).'</div>';
		 	$purchase 		= $col['purchase_link']===''?'':'<div class="pricetable-col-purchase" ><a href="'.$col['purchase_link'].'" class="btn ">'.$atts['purchase_text'].'</a></div>';
		 	$popular_text 	= ($atts['popular_text'] !='' && $atts['popular'] != '' && $atts['popular'] == $index)?'<div class="pricetable-col-popular-text"><span>'.$atts['popular_text'].'</span></div>':'';

		 	$html = '';
		 	$html .= '<div class="pricetable-col pricetable-col-' . ($index++) . ' ' .$col['class']. $popular.' col-md-'.number_format(12/self::$pricecol_count, 0).' col-xs-12 col-sm-6">';
		 	$html .= '	<div class="pricetable-col-inner">';

		 		$html .= $popular_text . '<div class="pricetable-col-head">'. $price . $sub_title . $title  . '</div>'. $feature . $purchase;

		 	$html .= '  </div>';
		 	$html .= '</div>';
		 	$pricecols[] = $html;
		}
		if (!empty($atts['cover'])) {
			$cssStyles = '';
			if ($style == "pricetable-3") {
		 		$cssStyles = '.pricetable-3 .pricetable-col-head {background-image: url("'.JURI::root () . '/'.$atts['cover'].'"); background-size: cover; background-position: center;}';
		 	} elseif ($style == "pricetable-2") {
		 		$cssStyles = '.pricetable-2 .pricetable-col-title {background-image: url("'.JURI::root () . '/'.$atts['cover'].'");}';
		 	} else {
		 		$cssStyles = '.pricetable-1 .pricetable-col-inner {background-image: url("'.JURI::root () . '/'.$atts['cover'].'"); background-size: cover; background-position: center;}';
		 	}
			$document 	= JFactory::getDocument();
			$document->addStyleDeclaration($cssStyles);	
		}
		
		// create id 
		$id = uniqid('pricetable-');
		$return ='<div id="'.$id.'" class="pricetable '.$style.$class.' cols-'.self::$pricecol_count.'"><div class="row">
		 			'.implode('',$pricecols).'
		 		  </div></div>';
		
		
		// reset count cols & array cols
		self::$pricecols = array();
		self::$pricecol_count = 0;
		return $return;
	}
	public static function pricecol($atts=null,$content=null){
		$atts= shortcode_atts(array(
			'title'=>'',
			'sub_title'=>'',
			'price'=>'',
			'detail'=>'',
			'purchase_link'=>'',
			'image' => '',
			'class'=>''
		), $atts);
		$detail = explode(';', $atts['detail']);
		$x= self::$pricecol_count;
		self::$pricecols[$x] = array(
			'title'=>$atts['title'],
			'sub_title'=>$atts['sub_title'],
			'price'=>$atts['price'],
			'detail'=>$detail,
			'image' => $atts['image'],
			'purchase_link'=>$atts['purchase_link'],
			'class'=>$atts['class']
		);
		self::$pricecol_count++;
	}
	public static function accordion($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' 	=> 'accordion-1',
				'color'		=> 'default',
				'width' => 0,
				'active_first' => 'yes',
				'icon' => 'none',
				'cover' => '',
				'class' => '' 
		), $atts );
		$uid = rand(100,999999);
		do_shortcode ( $content );
		$return = '';

		$icon_head = '';
		if ($atts ['icon'] == 'plus') {
			$icon_head = '<span></span><span></span>';
		} elseif ($atts ['icon'] == 'arrow') {
			$icon_head = '<i class="fa fa-angle-down"></i>';
		}

		$cover = '';
		if (!empty($atts['cover'])) {
			$cover = '<img alt="accordion" class="accordion-cover" src="' . $atts['cover'] . '"/>';
		}

		$panel = array ();

		if (is_array ( self::$panels )) {
			foreach ( self::$panels as $key => $item ) {
				$title 		= $item ['title'];
				$icon 		= $item ['icon'];
				$content	= $item ['content'];
				$class 		= $item ['class'];

				if (strpos($icon, 'icon:') !== false) {
					$icon 	= str_replace('icon:', '',$icon);
					$icon 	= '<i class="fa fa-' . $icon . '"></i> ';
				}
				$title 	  	= $icon.$title;
				$active   	= ( ($atts ['active_first'] == 'yes') && ($key == 0) )?' in':'';
				$activeHead = ( ($atts ['active_first'] == 'yes') && ($key == 0) )?' active':'';
				$html = '<div class="panel '.$class.' panel-'.$atts ['color'].' '.$activeHead.'">
						    <div class="panel-heading" id="heading-'.$uid.'-'.$key.'" data-text="'.$title[0].'">
						      <h4 class="panel-title">
						        <a role="button" data-toggle="collapse" data-parent="#accordion-'.$uid.'" href="#collapse-'.$uid.'-'.$key.'">
						          '.$title.'
						        </a>
						      </h4>';
						        		if ($atts ['icon'] != 'none') {
											$html .= '<a class="accordion-icon accordion-icon'.$atts ['icon'].' " data-toggle="collapse" data-parent="#accordion-'.$uid.'" href="#collapse-'.$uid.'-'.$key.'">
						          '.$icon_head.'
						        </a>';
										}

						        		$html .='
						    </div>
						    <div id="collapse-'.$uid.'-'.$key.'" class="panel-collapse collapse'.$active.'">
						      <div class="panel-body">
						        '.$content.'
						      </div>
						    </div>
						  </div>';

				$panel [] = $html;
			}
			$return = '<div class="panel-group accordion '.$atts ['style'].' accordion-'.$atts ['color'].'" id="accordion-'.$uid.'">'. $cover . implode ( '', $panel ) . '</div>';
		}
		// reset bars
		self::$panels = array ();
		self::$panel_count = 0;
		return $return;
	}
	public static function panel($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'title' => 'Title',
				'icon' => '',
				'class' => ''  
		), $atts );

		$x = self::$panel_count;
		self::$panels [$x] = array (
				'title' => $atts ['title'],
				'content' => do_shortcode ( $content ),
				'class' => $atts ['class'],
				'icon' => $atts['icon'] 
		);
		self::$panel_count ++;
	}
	public static function process($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' 	=> 'process-1',
				'color'		=> 'primary',
				'active'	=> '1',
				'class' => '' 
		), $atts );
		$uid = rand(100,999999);
		do_shortcode ( $content );
		$return = '';
		$style = $atts ['style'];
		$class = $atts ['class'];

		$process = array ();
		if (is_array ( self::$steps )) {
			$atts ['class'] = ($atts ['class'] > count(self::$steps ))?count(self::$steps ):$atts ['class'];
			foreach ( self::$steps as $key => $item ) {
				$title 		= $item ['title'];
				$icon 		= $item ['icon'];
				$content	= $item ['content'];
				$classItem 		= $item ['class'];
				$active = ($atts ['active'] == ($key+1) && $atts ['active'] !='no')?' active':'';
				$cols = '';
				if(count(self::$steps ) == 1) {
					$cols = 'col-xs-12';
				} else {
					$cols = 'col-xs-12 col-sm-6 col-md-'.number_format(12/count(self::$steps ), 0).' pt-md-20 pb-md-20';
					if ($style == "process-5") {
						$cols = 'col-xs-12 col-sm-'.number_format(12/count(self::$steps ), 0).' col-md-'.number_format(12/count(self::$steps ), 0).' pt-md-20 pb-md-20';
					}
				}
				if ($style != "process-2") {
					if (strpos($icon , 'icon:') !== false) {
						$icon = str_replace('icon:', '', $icon);
						$icon = '<span class="step-icon" data-step="' . ($key+1) . '"><i class="fa fa-' . $icon . '"></i></span>';
					}elseif ($icon != ''){
						$icon = '<span class="step-icon" data-step="' . ($key+1) . '"><span class="img"><img alt="' . $title .'" src="' . JURI::root () . '/'  . $icon . '"/></span></span>';
					} else {
						$icon = '<span class="step-icon" data-step="' . ($key+1) . '"><span class="number">' . ($key+1) . '</span></span>';
					}
					$title = ($title != '')?'<h4 class="step-title" data-step="' . ($key+1) . '">'.$title.'</h4>':'';
					$content = ($content !='')?'<div class="step-content">'.$content.'</div>':'';

					$html = '<div class="'.$cols.'"><div class="step'. $active. $classItem.'">';
					$html .= $icon;
					$html .= $title;
					$html .= $content;
					$html .= '</div></div>';
				}

				if ($style == "process-2") {
					$background = "";
					if (strpos($icon , 'icon:') !== false) {
						$icon = str_replace('icon:', '', $icon);
						$icon = '<span class="step-icon" data-step="' . ($key+1) . '"><i class="fa fa-' . $icon . '"></i></span>';
					}elseif ($icon != ''){
						$background = ' style="background-image: url('.JURI::root () . '/'  . $icon.');"';
						$icon = '<span class="step-icon" data-step="' . ($key+1) . '"><span class="number">' . ($key+1) . '</span></span>';						
					} else {
						$icon = '<span class="step-icon" data-step="' . ($key+1) . '"><span class="number">' . ($key+1) . '</span></span>';
					}
					$title = ($title != '')?'<h4 class="step-title" data-step="' . ($key+1) . '">'.$title.'</h4>':'';
					$content = ($content !='')?'<div class="step-content">'.$content.'</div>':'';

					$html = '<div class="'.$cols.'"><div class="step'. $active. $classItem.'"'.$background.'>';
					$html .= '<div class="step-head">';
					$html .= $title;
					$html .= $content;
					$html .= '</div>';
					$html .= $icon;
					$html .= '</div></div>';
				}	

				$process [] = $html;
			}
			$return = '<div class="process '.$atts ['style'].' cols-'.self::$step_count.' process-'.$atts ['color'].'" id="process-'.$uid.'"><div class="row">'. implode ( '', $process ) . '</div></div>';
		}
		// reset bars
		self::$steps = array ();
		self::$step_count = 0;
		return $return;
	}
	public static function step($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'title' => 'Title',
				'icon' => '',
				'class' => ''  
		), $atts );

		$x = self::$step_count;
		self::$steps [$x] = array (
				'title' => $atts ['title'],
				'content' => do_shortcode ( $content ),
				'class' => $atts ['class'],
				'icon' => $atts['icon'] 
		);
		self::$step_count ++;
	}
	public static function quote($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' => 'default',
				'width' => 0,
				'author' => '',
				'author_url' => '',
				'class' => '' 
		), $atts );
		$style = $atts ['width'] ? ' style="width: ' . $atts ['width'] . 'px;" ' : '';
		$html = '<div class="jv-quote jv-quote-' . $atts ['style'] . ' ' . $atts ['class'] . '" ' . $style . '>';
		$html .= '<blockquote>';
		if($atts['style'] == 'box1' || $atts['style'] == 'box2' || $atts['style'] == 'box3' || $atts['style'] == 'box4' || $atts['style'] == 'box5' || $atts['style'] == 'box6' || $atts['style'] == 'box7'){
			$html .='<i class="fa fa-quote-left jv-quote-box-icon"></i>';
		}
		$html .='<p>' . $content . '</p>';
		if ($atts ['author']) {
			$html .='<footer><cite title="Source Title">';
			if ($atts ['author_url']) {
				$html .= '<a class="jv-quote-author" href="' . $atts ['author_url'] . '">' . $atts ['author'] . '</a>';
			} else {
				$html .= '<span class="jv-quote-author">' . $atts ['author'] . '</span>';
			}
			$html .='</cite></footer>';
		}
		$html .= '</blockquote></div>';
		return $html;
	}
	public static function dropcap( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style' => 'default',
				'size'  => 1.5,
				'text_color' => '#ffffff',
				'background_color' => '#000000',
				'class' => ''
		), $atts, 'dropcap' );
		
		// Calculate font-size
		$em = $atts['size'] . 'em';
		$style = 'font-size:' . $em . '; color: ' . $atts['text_color'] .'; background-color: ' . (($atts['style'] != 'default' && $atts['style'] != 'nowrapper') ? $atts['background_color'] : 'transparent') . ';';
		return '<span class="jv-dropcap jv-dropcap-' . $atts['style'] . ' ' . $atts['class'] .'" style="' . $style . '">' . do_shortcode( $content ) . '</span>';
	}	
	public static function orderlist($atts = null, $content = null){
		
		$atts = shortcode_atts(array(
				'list_style' => 'o-circle',
				'icon' => 'star',
				'icon_color' => '#959595',
				'background_color' => 'transparent',
				'class' => ''
		), $atts, 'list');
		$list = do_shortcode($content);
		$count = substr_count($list, '%s');
		$arr = array();
		$color = 'color:'.$atts['icon_color'];
		$background = 'background-color:'.$atts['background_color'];
		$style = $color . '; ';
		$return = '<ul class="jv-list '. $atts['class'] .' jv-list-' . $atts['list_style']. '">';
		if($atts['list_style'] == 'o-circle'){
			
			$icon = '<i class="jv-list-icon fa fa-circle" style="'.$style.'"></i>';
			for($i = 0; $i< $count; $i++){
				$arr[] = $icon;
			}			
			$return .= vsprintf($list, $arr);			
		}else if($atts['list_style'] == 'o-square'){
			
			$icon = '<i class="jv-list-icon fa fa-stop" style="'.$style.'"></i>';
			for($i = 0; $i< $count; $i++){
				$arr[] = $icon;
			}			
			$return .= vsprintf($list, $arr);			
		}else if(($atts['list_style'] == 'o-decimal') || ($atts['list_style'] == 'o-decimal-leading-zero')){
			$leading = ($atts['list_style'] == 'o-decimal-leading-zero')?'0':'';
			for($i = 0; $i< $count; $i++){
				$arr[] = '<span class="jv-list-icon" style="' . $style . '">' . $leading .($i + 1) . '</span>';
			}
			$return .= vsprintf($list, $arr);			
		}else if(($atts['list_style'] == 'o-alphabet') || ($atts['list_style'] == 'o-alphabet-upper')){
			$upper = ($atts['list_style'] == 'o-alphabet')?'text-lowercase':'';
			for($i = 0; $i< $count; $i++){
				$arr[] = '<span class="jv-list-icon ' .$upper. '" style="' . $style . '">' . chr($i + 65) . '.</span>';
			}
			$return .= vsprintf($list, $arr);			
		}else if($atts['list_style'] == 'icon'){
			if (strpos($atts ['icon'], 'icon:') !== false) {
				$atts['icon'] = str_replace('icon:', '', $atts['icon']);
				$icon = '<i class="jv-list-icon fa fa-' . $atts ['icon'] . '" style="'.$style.'"></i>';
			}else{
				$icon = '<img class="jv-list-img" alt="" src="' . $atts['icon'] . '"/>';
			}			
			for($i = 0; $i< $count; $i++){
				$arr[] = $icon;
			}			
			$return .= vsprintf($list, $arr);			
		}else if(($atts['list_style'] == 'm-decimal') || ($atts['list_style'] == 'm-decimal-leading-zero')){
			$style .= $background;
			$leading = ($atts['list_style'] == 'm-decimal-leading-zero')?'0':'';
			for($i = 0; $i< $count; $i++){
				$arr[] = '<span class="jv-list-icon jv-list-icon-circle" style="' . $style . '">' . $leading .($i + 1) . '</span>';
			}
			$return .= vsprintf($list, $arr);				
		}else if(($atts['list_style'] == 'm-alphabet') || ($atts['list_style'] == 'm-alphabet-upper')){
			$style .= $background;
			$upper = ($atts['list_style'] == 'm-alphabet')?'text-lowercase':'';
			for($i = 0; $i< $count; $i++){
				$arr[] = '<span class="jv-list-icon jv-list-icon-circle ' .$upper. '" style="' . $style . '">' . chr($i + 65) . '</span>';
			}
			$return .= vsprintf($list, $arr);	
		} else if($atts['list_style'] == 'icon-circle-border' || $atts['list_style'] == 'icon-circle-background' || $atts['list_style'] == 'icon-square-border' || $atts['list_style'] == 'icon-square-background'){
			if ($atts['list_style'] == 'icon-circle-border' || $atts['list_style'] == 'icon-square-border') {
				$style .= ' border-color:'.$atts['icon_color'];
			}
			if ($atts['list_style'] == 'icon-circle-background' || $atts['list_style'] == 'icon-square-background') {
				$style .= $background;
			}
			if (strpos($atts ['icon'], 'icon:') !== false) {
				$atts['icon'] = str_replace('icon:', '', $atts['icon']);
				$icon = '<i class="jv-list-icon fa fa-' . $atts ['icon'] . '" style="'.$style.'"></i>';
			}else{
				$icon = '<img class="jv-list-img" alt="" src="' . $atts['icon'] . '"/>';
			}			
			for($i = 0; $i< $count; $i++){
				$arr[] = $icon;
			}			
			$return .= vsprintf($list, $arr);			
		}else{
			for($i = 0; $i< $count; $i++){
				$arr[] = '';
			}
			$return .= vsprintf($list, $arr);
			
		}
		$return .='</ul>';
		return $return;
	}
	public static function li($atts, $content){
		$atts = shortcode_atts(array(
				'class' => ''
		), $atts, 'li');
		
		return '<li ' . ($atts['class'] ? ' class="' . $atts['class'] . '"' : '') . '>' . '%s' . do_shortcode($content) . '</li>';
	}
	public static function columns($atts = null, $content = null){
		$atts = shortcode_atts(array(
			'class' => ''
		), $atts, 'columns');
		
		return '<div class="jv-columns ' . $atts['class']. '"><div class="row">' . do_shortcode($content) . '</div></div>';
	}	
	public static function column($atts = null, $content = null){
		$atts = shortcode_atts(array(
				'class' => ''
		), $atts, 'column');
		
		return '<div class="' . $atts['class'] . '">' . do_shortcode($content) . '</div>';
	}
	public static function label($atts = null, $content = null){
		$atts = shortcode_atts(array(
				'background_color' => '#09c',
				'font_size'		=> 14,
				'text_color'	=> '#ffffff',
				'border_radius'	=> 0,
				'class'			=> ''
		), $atts, 'label');
		return '<span class="jv-label ' . $atts['class'] . '" style="padding: 0 8px; display: inline-block; border-radius: ' . $atts['border_radius'] . 'px; background: ' . $atts['background_color'] . '; font-size: ' . $atts['font_size'] . 'px; color: ' . $atts['text_color'] . ';">' 
				. do_shortcode($content) . '</span>';
	}	
	public static function tooltip($atts = null, $content = null){
		$atts = shortcode_atts(array(
				'tooltip_text' 		=> 'Tooltip Text',
				'placement'			=> 'top',
				'font_size'			=> '12',
				'border_radius'		=> '4',
				'background_color'  => '#111111',
				'tooltip_class'		=> '',
				'text_color'		=> '#959595',
				'class'				=> ''				
		), $atts, 'tooltip');

		$border_color = ($atts['placement']=='top')?' border-top-color:' . $atts['background_color']:(($atts['placement']=='bottom')?' border-bottom-color:' . $atts['background_color']:(($atts['placement']=='left')?' border-left-color:' . $atts['background_color']:' border-right-color:' . $atts['background_color']));

		$data  = 'data-toggle="tooltip" data-html="true" ';
		$data .= 'data-placement="' . $atts['placement'] . '" ';
		$data .= 'data-title="' . $atts['tooltip_text'] . '" ';
		$data .= 'data-template="<div class=\'tooltip\' role=\'tooltip\'><div class=\'tooltip-arrow\' style=\'' . $border_color . '\'></div><div class=\'tooltip-inner\' style=\'background-color:' .  $atts['background_color'] . '; border-radius:' . $atts['border_radius'] . 'px; font-size:' . $atts['font_size'] . 'px; \'></div></div>" ';
		
		$class = 'jv-tooltip ' . $atts['class'];
		 
		$return = '<span style="color: ' . $atts['text_color'] . '" class="' . $class . '" ' . $data . '>' . do_shortcode($content) . '</span>';
		
		return $return;
	}	
	public static function actionbox($atts = null, $content = null){
		$atts = shortcode_atts(array(
			'background_color'		=> '',
			'background_image'		=> '',
			'background_position'	=> 'center',
			'background_size'		=> 'cover',
			'overlay'				=> 'no',
			'overlay_color'			=> '#000',
			'overlay_opacity'		=> '0',

			'parallax'				=> 'no',
			'parallax_speed'		=> '0.15',
			'parallax_vertical_offset'		=> '0',

			'box'					=> 'yes',
			'class'					=> '',
			// heading
			'heading_text'  		=> '',
			'heading_tag'			=> 'h3',
			'heading_size'			=> '0',
			'heading_class'			=> '',

			// sub text
			'sub_text'				=> '',
			'sub_text_size'			=> '0',
			'sub_text_class'		=> '',
			// Icon
			'icon'					=> '',
			'icon_size'				=> '30',
			// Button
			'button_text'			=> '',
			'button_style'			=> 'default',
			'button_color'			=> 'primary',
			'button_link' 			=> '#',
			'button_target' 		=> '_blank',
			// Button Second
			'button_second_text'	=> '',
			'button_second_style'	=> 'outline',
			'button_second_color'	=> 'darker',
			'button_second_link' 	=> '#',
			'button_second_target' 	=> '_blank'
		), $atts, 'actionbox');

		$heading = $sub_text = $icon = $button = $button_second = '';

		// Unstyle 
		$unstyle = ($atts['box'] != 'yes')?' actionbox-unstyled ':'';

		// Background
		$css_style		= "";
		$bg_color 		= $atts['background_color'];
		$bg_image 		= $atts['background_image'];
		$bg_position 	= $atts['background_position'];
		$bg_size		= $atts['background_size'];

		if ($bg_color || $bg_image) {
			$css_style 	= ' style="';
			if ($bg_color) {
				$css_style 	.= ' background-color:' . $bg_color . ';';
			}
			if ($bg_image) {
				$css_style 	.= ' background-image: url(' . $bg_image . '); background-position: ' . $bg_position . '; background-size:' . $bg_size ;
			}
			$css_style 	.= '"';
		}

		// Overlay
		$over_html 		= '';
		$over 			= $atts['overlay'];
		$over_color 	= $atts['overlay_color'];
		$over_opacity	= $atts['overlay_opacity'];

		if ($over == 'yes') {
			$over_html = '<div class="overlay" style="background-color: ' . $over_color . '; opacity: ' . $over_opacity . '; filter: alpha(opacity=' . $over_opacity * 100 . ');"></div>';
		}

		// Parallax
		$par 			= $atts['parallax'];
		$par_speed		= $atts['parallax_speed'];
		$par_ver_of		= $atts['parallax_vertical_offset'];

		$class = $atts['class'];
		$par_data = '';
		if ($par == "yes") {
			$class .= ' parallax';
			$par_data = ' data-stellar-background-ratio="' . $par_speed . '" data-stellar-vertical-offset="' . $par_ver_of . '"';
		}

		$html = '<div class="actionbox ' . $class . $unstyle . '" ' . $css_style . $par_data .'>';
			// Heading
			if (!empty($atts['heading_text'])) {
				$h_style = ($atts['heading_size'] != '0')?'font-size: '.$atts['heading_size'].'px;':'';
				$h_class = (!empty($atts['heading_class']))?' class="'.$atts['heading_class'].'"':'';
				$h_line_height = (empty($atts['sub_text']))?'line-height: 44px;':'';
				$heading = '<'.$atts['heading_tag'].' '.$h_class.' style="'.$h_style. $h_line_height.'">'.$atts['heading_text'].'</'.$atts['heading_tag'].'>';
			}

			// Sub text
			if (!empty($atts['sub_text'])) {
				$s_style = ($atts['sub_text_size'] != '0')?' style="font-size: '.$atts['sub_text_size'].'px;"':'';
				$s_class = (!empty($atts['sub_text_class']))?' class="'.$atts['sub_text_class'].'"':'';
				$sub_text = '<p '.$s_style.$s_class.'>'.$atts['sub_text'].'</p>';
			}

			// Icon
			if (!empty($atts['icon'])) {
				if (strpos($atts ['icon'], 'icon:') !== false) {
					$atts['icon'] = str_replace('icon:', '', $atts['icon']);
					$icon = '<i class="fa fa-' . $atts ['icon'] . '" style="font-size: '.$atts ['icon_size'].'px;"></i>';
				}else{
					$icon = '<img alt="" src="' . $atts['icon'] . '"/>';
				}
				$icon = '<span class="actionbox-icon-box">'.$icon.'</span>';
			}			

			// Button 
			if (!empty($atts['button_text'])) {
				$outline = ($atts ['button_style'] != 'default')?' btn-' . $atts ['button_style']:'';
				$button = '<div class="actionbox-button">';		
					$button .= '<a href="' . $atts ['button_link'] . '" target="' . $atts ['button_target'] . '" class="btn '.$outline.' btn-'.$atts['button_color'].'">' . $atts['button_text'] . '</a>';
				$button .= '</div>';
			}

			// Button Second
			if (!empty($atts['button_second_text'])) {
				$outline = ($atts ['button_second_style'] != 'default')?' btn-' . $atts ['button_second_style']:'';
				$button_second = '<div class="actionbox-button-second">';		
					$button_second .= '<a href="' . $atts ['button_second_link'] . '" target="' . $atts ['button_second_target'] . '" class="btn '.$outline.' btn-'.$atts['button_second_color'].'">' . $atts['button_second_text'] . '</a>';
				$button_second .= '</div>';
			}



			$text = '<div class="actionbox-content">';
			$text .= 	$heading . $sub_text;
			$text .= '</div>';

			$html .=  $icon. $text.$button . $button_second;
		$html .= $over_html. '</div>';
	
		return $html; 
	}
	public static function imageboxes($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' 	=> 'imagebox-1',
				'link_text'		=> '',
				'number'		=> '1',
				'class' => ''
		), $atts, 'imageboxes' );
		$uid 		= rand(100,999999);
		do_shortcode ( $content );
		$return 	= '';
		$style 		= $atts ['style'];
		$link_text 	= $atts ['link_text'];
		$number 	= $atts ['number'];
		$class 		= $atts ['class'];

		$imageboxes = $imageSlide = array ();
		if (is_array ( self::$imageboxes )) {

			foreach ( self::$imageboxes as $key => $item ) {

				$title 			= $item ['title'];
				$sub_title 		= $item ['sub_title'];
				$image 			= $item ['image'];
				$icon 			= $item ['icon'];
				$link			= $item ['link'];
				$classItem 		= $item ['class'];


				$cols = $html = $img = $button = '';
				if($number == 1) {
					$cols = 'col-xs-12';
				} else {
					$col_xs = "col-xs-6 col-sm-6";
					if (self::$imagebox_count == 3) {
						$col_xs = "col-xs-".number_format(12/$number, 0);
					}
					$cols = 'imagebox-item col-xxs-12 '.$col_xs.' col-md-'.number_format(12/$number, 0).'';
					if ( $style == "imagebox-4" || $style == "imagebox-3" || $style == "imagebox-5") {
						$cols = 'imagebox-item col-xs-6 col-md-'.number_format(12/$number, 0).'';
					}
				}
				if (!empty($icon)) {
					if (strpos($icon, 'icon:') !== false) {
						$icon = str_replace('icon:', '', $icon);
						$icon = '<i class="fa fa-' . $icon . '"></i>';
					}
					$icon = '<span class="imagebox-icon">'.$icon.'</span>';
				}
				if ($style == "imagebox-1" || $style == "imagebox-7" || $style == "imagebox-8") {
					$titlehtml = "";
					if($title != ''){
						$titlehtml = '<span class="imagebox-title">'.$title.'</span>';
					}
					$sub_title = ($sub_title != '')?'<div class="imagebox-sub-title">'.$sub_title.'</div>':'';
					$inner = "";
					if ($link != '' || $item ['title'] != '' || strpos($icon, 'icon:') !== false) {
						if($link != ''){
							$inner = '<a class="inner" href="'.$link.'" title="' . $item ['title'] .'" ><div class="divtable"><div class="divtablecell">'.$icon.$titlehtml.'</div></div></a>';
						} else {
							$inner = '<div class="inner"><div class="divtable"><div class="divtablecell">'.$icon.$titlehtml.'</div></div></div>';
						}
					}
					$imagehtml = "";
					if ($image != ''){
						$imagehtml = '<div class="imagebox-image" style="background-image: url(' . JURI::root () . '/'  . $image . ');"><div class="wrap">'.$inner.'</div><img class="hidden" alt="'.$title.'" src="' . JURI::root () . '/'  . $image . '"/></div>';
					} else {
						$imagehtml = '<div class="imagebox-image"><div class="wrap">'.$inner.'</div></div>';
					}
					$html = '<div class="'.$cols.'"><div class="imagebox '. $classItem.'">'.$imagehtml.$sub_title.'</div></div>';
				} else if ($style == "imagebox-2" || $style == "imagebox-4") {
					if ($image != ''){
						$image = '<div class="imagebox-image" style="background-image: url(' . JURI::root () . '/'  . $image . ');"><img class="hidden" alt="' . $title .'" src="' . JURI::root () . '/'  . $image . '"/></div>';
					}
					if($title != ''){
						$title = ($link != '')?'<a class="imagebox-title" href="'.$link.'" title="' . $item ['title'] .'" >'.$title.'</a>':'<span class="imagebox-title" href="'.$link.'" title="' . $item ['title'] .'" >'.$title.'</span>';
					} else {
						$title = ($link != '')?'<a class="imagebox-title" href="'.$link.'" title=""><i class="sfr-link"></i></a>':'';
					}
					$sub_title = ($sub_title != '')?'<div class="imagebox-sub-title">'.$sub_title.'</div>':'';
					if ($link != "") {
						$button = '<a class="btn btn-white btn-radius btn-outline-thin" href="'.$link.'" title="' . $link_text .'" >'.$link_text.'</a>';
					}
					$html = '<div class="imagebox-item"><div class="imagebox '. $classItem.'">';
					$html .= $image;
					$html .= '<div class="wrap"><div class="divtable"><div class="divtablecell"><div class="inner">' . $icon . $title . $sub_title . $button . '</div></div></div></div>';
					$html .= '</div></div>';
				} else if ($style == "imagebox-3") {
					if ($image != ''){
						$img = '<div class="imagebox-image" style="background-image: url(' . JURI::root () . '/'  . $image . ');"><img class="hidden" alt="' . $title .'" src="' . JURI::root () . '/'  . $image . '"/></div>';
					}
					if($title != ''){
						$title = ($link != '')?'<a class="imagebox-title" href="'.$link.'" title="' . $item ['title'] .'" >'.$title.'</a>':'<span class="imagebox-title">'.$title.'</span>';
					}
					$sub_title = ($sub_title != '')?'<div class="imagebox-sub-title">'.$sub_title.'</div>':'';
					$html = '<div class="'.$cols.'"><div class="imagebox '. $classItem.'">';
					$html .= $img.'<div class="imagebox-content"><div class="divtable"><div class="divtablecell">'.$sub_title.$title.$icon.'</div></div></div>';
					$html .= '</div></div>';
				} else if ($style == "imagebox-6") {
					if ($image != ''){
						$img = '<div class="imagebox-image" style="background-image: url(' . JURI::root () . '/'  . $image . ');"><img class="hidden" alt="' . $title .'" src="' . JURI::root () . '/'  . $image . '"/></div>';
					}
					if($title != ''){
						$title = ($link != '')?'<a class="imagebox-title" href="'.$link.'" title="' . $item ['title'] .'" >'.$title.'</a>':'<span class="imagebox-title">'.$title.'</span>';
					}
					$sub_title = ($sub_title != '')?'<div class="imagebox-sub-title">'.$sub_title.'</div>':'';
					$html = '<div class="'.$cols.'"><div class="imagebox '. $classItem.'">';
					$html .= $img.'<div class="imagebox-content">'.$icon.$title.$sub_title.'</div>';
					$html .= '</div></div>';
				} else if ($style == "imagebox-5") {
					if ($image != ''){
						$img = ' style="background-image: url(' . JURI::root () . '/'  . $image . ');"';
					}
					if($title != ''){
						$title = '<span class="imagebox-title">'.$title.'</span>';
					}
					$sub_title = ($sub_title != '')?'<span class="imagebox-sub-title">'.$sub_title.'</span>':'';
					$html = '<div class="'.$cols.'"><div class="imagebox image-hover '. $classItem.'">';
					if ($link != "") {
						$html .= '<a class="imagebox-content" href="'.$link.'" title="' . $link_text .'"'.$img.'><div class="imagebox-inner">'.$icon.$title.$sub_title.'</div></a>';
					} else {
						$html .= '<div class="imagebox-content"'.$img.'><div class="imagebox-inner">'.$icon.$title.$sub_title.'</div></div>';
					}
					$html .= '</div></div>';
				} else {
					if ($image != ''){
						$image = '<div class="imagebox-image mb-10"><img alt="' . $title .'" src="' . JURI::root () . '/'  . $image . '"/></div>';
					}
					$title = ($title != '')?'<h4 class="imagebox-title">'.$title.'</h4>':'';
					$sub_title = ($sub_title != '')?'<div class="imagebox-sub-title">'.$sub_title.'</div>':'';
					$link = ($link != '')?'<a class="mt-20 btn btn-default btn-outline btn-sm imagebox-link" href="'.$link.'" title="' . $item ['title'] .'" >'.$link_text.'</a>':'';

					$content = ($content !='')?'<div class="imagebox-content">'.$title.$sub_title.$link.'</div>':'';

					$html = '<div class="'.$cols.'"><div class="imagebox '. $classItem.'">';
					$html .= $image.$content;
					$html .= '</div></div>';
				}

				$imageboxes [] = $html;
				$imageSlide [] = $img;
			}
			if ($style == "imagebox-2" || $style == "imagebox-4") {
				$return = '<div class="imageboxes '.$atts ['style'].' '.$atts ['class'].' carouselOwl" data-items="'.$number.'" data-itemsdesktop="'.($number - 1).'" 
				data-itemsdesktopsmall="'.($number - 1).'" 
				data-itemstablet="3"  
				data-itemstabletsmall = "2" 
				data-itemsmobile = "1" 
				data-pagination="true" 
				data-navigation="true" id="imagebox-'.$uid.'">'. implode ( '', $imageboxes ) . '</div>';	
			} else if($style == "imagebox-3") {
				$document 	= JFactory::getDocument();
					$document->addScriptDeclaration('
						(function($){
							$(function(){
								$("#imagebox-'.$uid.' .row").show().imagesLoaded( function() {
									var $grid =$("#imagebox-'.$uid.' .row"),
										$sizer = $grid.find(".col-md-'.number_format(12/$number,0).':nth-child(2)");
									  $grid.shuffle({
									    itemSelector: \'.imagebox-item\',
									    sizer: $sizer
									  });
								});		
							});
						})(jQuery);	
					');
				$return = '<div class="imageboxes '.$atts ['style'].' itemrow-'.$number.' '.$atts ['class'].'" id="imagebox-'.$uid.'"><div class="row">'. implode ( '', $imageboxes ) . '</div></div>';
			} else if($style == "imagebox-5" || $style == "imagebox-6") {
				$document 	= JFactory::getDocument();
					$document->addScriptDeclaration('
						(function($){
							$(function(){
								$("#imagebox-'.$uid.' .row").show().imagesLoaded( function() {
									var $grid =$("#imagebox-'.$uid.' .row"),
										$sizer = $grid.find(".imagebox-size");
									  $grid.shuffle({
									    itemSelector: \'.imagebox-item\',
									    sizer: $sizer
									  });
								});		
							});
						})(jQuery);	
					');
				$return = '<div class="imageboxes '.$atts ['style'].' itemrow-'.$number.' '.$atts ['class'].'" id="imagebox-'.$uid.'"><div class="row">'. implode ( '', $imageboxes ) . '<div class="imagebox-size col-xs-6 col-md-1"></div></div></div>';
			} else {
				$return = '<div class="imageboxes '.$atts ['style'].' itemrow-'.$number.' '.$atts ['class'].'" id="imagebox-'.$uid.'"><div class="row">'. implode ( '', $imageboxes ) . '</div></div>';
			}
		}
		// reset bars
		self::$imageboxes = array ();
		self::$imagebox_count = 0;
		return $return;
	}
	public static function imagebox($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'title' => '',
				'sub_title' => '',
				'image' => '',
				'icon' => '',
				'link' => '',
				'class' => ''  
		), $atts );

		$x = self::$imagebox_count;
		self::$imageboxes [$x] = array (
				'title' => $atts ['title'],
				'sub_title' => do_shortcode ( $atts ['sub_title'] ),
				'image' => $atts ['image'],
				'icon' => $atts ['icon'],
				'link' => $atts ['link'],
				'class' => $atts ['class']
		);
		self::$imagebox_count ++;
	}
	public static function googlemap($atts, $content){
		$atts = shortcode_atts(array(
			'width' => 0,
			'height' => 400,
			'address' => 'New York',
			'coordinate' => '40.7127840,-74.0059410',
			'infowindow' => '',
			'border' => '1px solid #cccccc',
			'zoom' => 13,
			'zoom_control' => 'yes',
			'pan_control' => 'yes',
			'streetview_control' => 'yes',
			'maptype_control' => 'yes',
			'scale_control' => 'yes',
			'overview_control' => 'yes',
			'icon' => '',
			'icon_show' => 'no',
			'style' => 'default',
			'api' => '',
			'class' => ''
			), $atts, 'googlemap');
		$mainframe = JFactory::getApplication ();
		$isAdmin = $mainframe->isAdmin ();

		// not live preview
		if($isAdmin) return 'Preview this shortcode not apply. You can see it in font-end';
		
		$id = uniqid('jvsc-googlemap-');
		$style = ' style="width:' . ($atts['width'] ? $atts['width'] . 'px' : 'auto') . '; height: ' . $atts['height'] . 'px; border: ' . $atts['border']. '"'; 
		
		if ($atts['api']) {
			$html =  '<div class="jvsc-googlemap ' . $atts['class']. '"  id="' . $id . '" ' . $style . '></div>';
		} else {
			$html =  '<div class="jvsc-googlemap text-center ' . $atts['class']. '" ' . $style . '>Enter Google Maps API</div>';
		}

		$icon =  JURI::root ().$atts['icon'];
		$icon_show =  $atts['icon_show'];
		if ($icon_show == "no") {
			$icon = " ";
		}

		$color_style = '';
		if ($atts['style'] == 'gray-light') {
			$color_style = '[{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#d3d3d3"}]},{"featureType":"transit","stylers":[{"color":"#808080"},{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#b3b3b3"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"weight":1.8}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"color":"#d7d7d7"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#ebebeb"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"color":"#a7a7a7"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#efefef"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#696969"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"color":"#737373"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#d6d6d6"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#dadada"}]}]';
		} elseif ($atts['style'] == 'minimal-dark-theme') {
			$color_style = '[{"featureType":"all","elementType":"all","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":-30}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"color":"#353535"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#656565"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#505050"}]},{"featureType":"poi","elementType":"geometry.stroke","stylers":[{"color":"#808080"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#454545"}]},{"featureType":"transit","elementType":"labels","stylers":[{"hue":"#000000"},{"saturation":100},{"lightness":-40},{"invert_lightness":true},{"gamma":1.5}]}]';
		} elseif ($atts['style'] == 'ultra-light-with-labels') {
			$color_style = '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]';
		} elseif ($atts['style'] == 'shades-of-grey') {
			$color_style = '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]';
		} elseif ($atts['style'] == 'mute-green') {
			$color_style = '[{"featureType":"all","elementType":"all","stylers":[{"hue":"#00ffbc"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-70}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"simplified"},{"saturation":-60}]}]';
		} elseif ($atts['style'] == 'red-darkness') {
			$color_style = '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#ff1c00"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#ec523f"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#ec523f"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"lightness":20},{"color":"#383838"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ec523f"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"lightness":19},{"color":"#404040"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]';
		} else {
			$color_style ='[]';
		}
		
		$markerScript = '';
		if($atts['address'] || $atts['coordinate']){
			if($atts['coordinate']){				
				$markerScript .= '
				var pos = new google.maps.LatLng(' . $atts['coordinate'] . ');	
				var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});	
				mapOptions.center = pos;
				var map = new google.maps.Map(document.getElementById("' . $id . '"), mapOptions);
				var marker = new google.maps.Marker({map: map, position: pos, icon: \''.$icon.'\', title: "' . $atts['infowindow'] . '"});
				map.mapTypes.set(\'map_style\', styledMap);
  				map.setMapTypeId(\'map_style\');
				';

			}else{
				$markerScript .= '
				 var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});
				var geocoder = new google.maps.Geocoder();
				var pos;
				geocoder.geocode({ "address": " ' . $atts['address'] . '"}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						pos = results[0].geometry.location;	
						mapOptions.center = pos;
						var map = new google.maps.Map(document.getElementById("' . $id . '"), mapOptions);
						var marker = new google.maps.Marker({map: map, position: pos, title: "' . $atts['infowindow'] . '"});
						map.mapTypes.set(\'map_style\', styledMap);
  						map.setMapTypeId(\'map_style\');
					}else{
						alert("Geocode was not successful for the following reason: " + status + "! Map address: ' . $atts['address'] . '");
					}
				});
				
				';
				
			}
		}
		$script = 
		'<script type="text/javascript">
			jQuery(document).ready(function($){
				var mapOptions = {
					zoom					: ' . $atts['zoom'] . ',
					zoomControl				: ' . ($atts['zoom_control'] == 'yes' ? 'true' : 'false') . ',
					scaleControl			: ' . ($atts['scale_control'] == 'yes' ? 'true' : 'false') . ',
					mapTypeControl			: ' . ($atts['maptype_control'] == 'yes' ? 'true' : 'false') . ',
					panControl				: ' . ($atts['pan_control'] == 'yes' ? 'true' : 'false') . ',
					streetViewControl		: ' . ($atts['streetview_control'] == 'yes' ? 'true' : 'false') . ',
					overviewMapControl		: ' . ($atts['overview_control'] == 'yes' ? 'true' : 'false') . ',
					mapTypeControlOptions: {
				      mapTypeIds: [google.maps.MapTypeId.ROADMAP, \'map_style\']
				    }
				}

				// Create an array of styles.
				var styles = '.$color_style.';

				'
				. $markerScript . '
				
				
			})
		</script>';
		$document = JFactory::getDocument();
		$language = JFactory::getLanguage();
		$mapApi= '//maps.google.com/maps/api/js?key='.$atts['api'].'&language='.$language->getTag();
		$document->addScript($mapApi);
		
		return $html . $script;
	}
	public static function socialicons($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'style' 	=> 'social-1',
				'number'		=> '4',
				'class' => ''
		), $atts, 'socialicons' );
		$uid 		= rand(100,999999);
		do_shortcode ( $content );

		$return 	= '';

		$style 		= $atts ['style'];
		$number 	= $atts ['number'];
		$class 		= $atts ['class'];

		$socialicons = array ();
		$cssStyles ='';
		if (is_array ( self::$icons )) {

			foreach ( self::$icons as $key => $item ) {
				$title 			= $item ['title'];
				$sub_title 		= $item ['content'];
				$icon 			= $item ['icon'];
				$color 			= ($item ['color'] != "")?$item ['color']:'';
				$link			= $item ['link'];
				$classItem 		= ($item ['class'] != "")?' '.$item ['class']:'';


				$row = $cols = '';
				if ($style == 'social-5' || $style == 'social-6' || $style == 'social-7' || $style == 'social-13') {
					$row = 'row';
					if(count($number) > 1) {
						$cols = 'col-xs-12';
					} else {
						$cols = 'col-xxs-12 col-xs-6 col-sm-6 col-md-'.number_format(12/$number, 0).'';
						if ($style == 'social-5' || $style == 'social-6') {
							$cols = 'col-xs-'.number_format(12/$number, 0).'';
						}
					}	
				}

				if ($style == "social-1" && $color != "") {
					$cssStyles .= '#socialicons-'.$uid.' .item-'.$key.' a:not(:hover) { background-color: '.$color.'; border-color: '.$color.'; color: #fff;} ';
				}

				
				
				if (!empty($icon)) {
					if (strpos($icon, 'icon:') !== false) {
						$icon = str_replace('icon:', '', $icon);
						$icon = '<i class="fa fa-' . $icon . '"></i>';
					} else {
						$icon = '<span class="social-image"><img alt="' . $title .'" src="' . JURI::root () . '/'  . $icon . '"/></span>';
					}
					$icon = '<a class="social-icon" href="'.$link.'" title="'.$title.'" data-title="'.$title.'"><span class="social-icon-inner">'.$icon.'</span></a>';
				}

				if ($title != '') {
					$title = '<span class="social-title" data-title="'.$title.'">'.$title.'</span>';
					if ($style == "social-15") {
						$title = '<a class="social-title" href="'.$link.'" title="'.$item ['title'].'">'.$item ['title'].'</a>';
					}
				}

				$sub_title = ($sub_title != '')?'<div class="social-sub-title">'.$sub_title.'</div>':'';

				$html = '<div class="social-cols '.$cols.'"><div class="social item-'.$key. $classItem.'">';
				if ($style == "social-1" ||
					$style == "social-2" ||
					$style == "social-3" ||
					$style == "social-4" ||
					$style == "social-8" ||
					$style == "social-9" ||
					$style == "social-10" ||
					$style == "social-11" ||
					$style == "social-12" ||
					$style == "social-14"
					) {
					$html .= $icon;
				} elseif ($style == "social-5" ||
					$style == "social-6" ||
					$style == "social-7"
					) {
					$html .= $icon.$title;
				} else {
					$html .= $icon.'<div class="social-content">'.$title.$sub_title.'</div>';
				}
				$html .= '</div></div>';

				$socialicons [] = $html;
			}
			$document 	= JFactory::getDocument();
			$document->addStyleDeclaration($cssStyles);		
			$return = '<div class="socialicons '.$atts ['style'].' '.$class.'" id="socialicons-'.$uid.'"><div class="socialicons-inner '.$row.'">'. implode ( '', $socialicons ) . '</div></div>';
		}
		// reset bars
		self::$icons = array ();
		self::$icon_count = 0;
		return $return;
	}
	public static function flickr($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'id' => '95572727@N00',	
				'style' => 'default',
				'size' => 's',
				'limit'    => '8',
				'cols'    => '4',
	            'lightbox' => 'no',
	            'radius'   => '0',
	            'more' => 'no',
	            'more_text' => 'View more',			
				'class' => '' 
		), $atts, 'flickr' );
		$return = '';
		$js ='';
		$unique_id = uniqid("flickr_");
		$size = ($atts['size'] !="md") ? '_'.$atts['size']: '';
		$cols = $atts['cols'];
		$class = ($atts['class']) ? $atts['class'].' ':'';

		$rounded = ($atts['radius']) ? 'border-radius: ' . $atts['radius'] . 'px;' : '';
		$styleCSS = 'style="' . $rounded . '"';

		$image = ($atts['lightbox'] == 'yes') ? '<a class="flickr-modal" href="{{image_b}}" title="{{title}}"> ' : '';
		$image .= '<img ' . $styleCSS . ' src="{{image'.$size.'}}" alt="{{title}}" />';
		$image .= ($atts['lightbox'] == 'yes') ? '</a> ' : '';

		

		
		if ($atts['style'] == 'slide') {
			$return .= "<div id='".$unique_id."' class='flickrfeed-".$class.$atts['style']."'></div> <div class='clearfix'></div>";
			$document 	= JFactory::getDocument();
			$document->addScriptDeclaration('
				(function($){
					$(function(){
						$("#'.$unique_id.'").jflickrfeed({  
	                        limit: '. $atts['limit'] .', 
	                        qstrings: { 
	                          id: "' . $atts['id'] . '"
	                      	}, 
	                        itemTemplate: "<div class=\"flickrItem\">' . addslashes($image) . '</div>",
	                        itemCallback: function() {
	                        	$("#'.$unique_id.'").each(function(){
									var el = $(this);
										el.magnificPopup({
											delegate: "a",
											type: "image",
											mainClass: "my-mfp-zoom-in mfp-img-mobile",
											gallery: {
												enabled: true,
												navigateByImgClick: true,
												preload: [0,1]
											}
										});
								});
	                        }
	                    }, function (){
	                    	$("#'.$unique_id.'").owlCarousel({
									direction: $("body").hasClass("rtl") ? \'rtl\' : \'ltr\',
									items: 1,
							        singleItem : true,
							        navigation : true,
							        navigationText: ["<i class=\"fa fa-angle-left\"></i> '.JText::_("TPL_PREVIOUS").'","'.JText::_("TPL_NEXT").' <i class=\"fa fa-angle-right\"></i>"],			
							        autoHeight : true,
							        pagination: false,
    								transitionStyle:"fade"
								});
	                    });					
					});
				})(jQuery);	
			');
		} else {
			$return .= "<div id='".$unique_id."' class='flickrfeed row ".$class.$atts['style']."'></div> <div class='clearfix'></div>";
			$document 	= JFactory::getDocument();
			$document->addScriptDeclaration('
				(function($){
					$(function(){
						$("#'.$unique_id.'").jflickrfeed({  
	                        limit: '. $atts['limit'] .', 
	                        qstrings: { 
	                          id: "' . $atts['id'] . '"
	                      	}, 
	                        itemTemplate: "<div class=\"col-xs-'.number_format(12/$cols, 0).'\">' . addslashes($image) . '</div>",
	                        itemCallback: function() {
	                        	$("#'.$unique_id.'").each(function(){
									var el = $(this);
										el.magnificPopup({
											delegate: "a",
											type: "image",
											mainClass: "my-mfp-zoom-in mfp-img-mobile",
											gallery: {
												enabled: true,
												navigateByImgClick: true,
												preload: [0,1]
											}
										});
								});
	                        }
	                    });					
					});
				})(jQuery);	
			');
		};
		$return .= ($atts['more'] == 'yes')?'<div class="flickrfeed-more"><a target="_blank" href="https://www.flickr.com/photos/'.$atts['id'].'" title="'.$atts['more_text'].'">'.$atts['more_text'].' <i class="fa fa-angle-double-right text-primary"></i></a></div>':'';
		$link_js = jv_query_asset ( 'js', 'flickr' );


		
		$mainframe = JFactory::getApplication ();
		if ($mainframe->isAdmin ()) {
			$js .= "<script type='text/javascript'> 
              jQuery(document).ready(function() {
                      jQuery('#".$unique_id."').jflickrfeed({ 
                        limit: '". $atts['limit'] ."', 
	                        qstrings: { 
	                          id: '" . $atts['id'] . "'
	                      	}, 
	                        itemTemplate: '<div class=\"col-xs-".number_format(12/$cols, 0)." \"> " . addslashes($image) . "</div>'
                      });
                    });
              </script> ";
		}
		return $link_js.$js.$return;
	}
	public static function youtube($atts, $content){
		$atts = shortcode_atts(
				array(
					'url' 		=> '',
					'width'		=> 600,
					'height'	=> 400,
					'responsive'	=> 'yes',
					'autoplay'	=> 'no',
					'class'		=> ''	
				),
				$atts, 'youtube');
		
		if ( !$atts['url'] ) return JText::_('Please insert an URL');

		$id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $atts['url'], $match ) ) ? $match[1] : false;
		// Check that url is specified
		if ( !$id ) return JText::_('Please enter correct url');
		// Prepare autoplay
		$autoplay = ( $atts['autoplay'] == 'yes' ) ? '?autoplay=1' : '';
		// Create player
		$return= '<div class="jv-youtube ' . ($atts['responsive'] == 'yes' ? 'jv-media-responsive ' : '')  .$atts['class'] . '">';
		$return.= '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://www.youtube.com/embed/' . $id . $autoplay . '" frameborder="0" allowfullscreen="true"></iframe>';
		$return.= '</div>';
		$return= jv_query_asset('css', 'media-shortcodes') . $return;
		return $return;
	}	
	public static function vimeo($atts, $content){
		$atts = shortcode_atts(
				array(
					'url' 		=> '',
					'width'		=> 600,
					'height'	=> 400,
					'responsive'	=> 'yes',
					'autoplay'	=> 'no',
					'class'		=> ''	
				),
				$atts, 'vimeo');
		
		if ( !$atts['url'] ) return JText::_('Please insert an URL');

		$id = ( preg_match( '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $atts['url'], $match ) ) ? $match[count($match) - 1] : false;

		// Check that url is specified
		if ( !$id ) return JText::_('Please enter correct url');
		// Prepare autoplay
		$autoplay = ( $atts['autoplay'] == 'yes' ) ? '&autoplay=1' : '';
		// Create player
		$return= '<div class="jv-vimeo ' . ($atts['responsive'] == 'yes' ? 'jv-media-responsive ' : '')  .$atts['class'] . '">';
		$return.= '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://player.vimeo.com/video/' . $id . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff' . $autoplay . '" frameborder="0" allowfullscreen="true"></iframe>';
		$return.= '</div>';
		$return = jv_query_asset('css', 'media-shortcodes') . $return;
		return $return;
	}
	public static function video($atts, $content){
		$atts = shortcode_atts(
				array(
					'url' 			=> '',
					'poster'		=> '',
					'width'			=> 600,
					'height'		=> 400,
					'responsive'	=> 'yes',
					'autoplay'		=> 'no',
					'control'		=> 'yes',
					'loop'			=> 'no',
					'class'			=> ''	
				),
				$atts, 'video');
		if ( !$atts['url'] ) return JText::_('Please insert absolute video URI');
		$ext = substr($atts['url'], strrpos($atts['url'], '.') + 1);
		if(!in_array($ext, array('mp4', 'webm', 'ogg', 'MP4', 'WEBM', 'OGG'))){
			return JText::_('Your video\'s format isn\'t supported. Please use video in these formats: MP4, WEBM and OGG.');
		}
		$return = '<div class="jv-video ' . ($atts['responsive'] == 'yes' ? 'jv-video-responsive ' : '') . $atts['class'] . '">';
		$return .= '<video width="' . $atts['width'] . '" height="' . $atts['height'] . '" poster="' . JURI::root() . '/' . $atts['poster']. '" ';
		if($atts['control'] == 'yes'){
			$return .= 'controls="controls" ';
		}
		if($atts['loop'] == 'yes'){
			$return .= 'loop="loop"';
		}
		if($atts['autoplay'] == 'yes'){
			$return .= 'autoplay="autoplay"';
		}
		$return .= '><source src="' . $atts['url'] .'" type="video/' . $ext . '">Your browser does not support the video tag</video></div>';
		$inline_style = array('type'=>'css','val'=>'');
		$inline_style['val'] ='';
		$inline_style['val'].='.jv-video-responsive video{width: 100%; height: auto;}';
		$inline_css = jv_query_asset('inline', '' ,$inline_style);
		$return = $inline_css.$return;
		return $return;
	}
	public static function countdown($atts = null, $content = null) {
		$atts = shortcode_atts ( array (
				'day' => 01,
				'month' => 01,
                'year' => 2020,
                'second_label' 	=> 'Seconds',
                'minute_label' 	=> 'Minutes',
                'hour_label' 	=> 'Hours',
                'day_label' 	=> 'Days',
                'week_label' 	=> 'Weeks',
                'month_label'	=> 'Months',
                'year_label' 	=> 'Years',
                'expiry_text' 	=> 'Countdown is complete!',
				'class' => '' 
		), $atts, 'countdown' );
		$id = uniqid('jvcountdown-');
		$day 	= $atts ['day'];
		$month 	= $atts ['month'];
		$year 	= $atts ['year'];
		$second_label 	= $atts ['second_label'];
		$minute_label 	= $atts ['minute_label'];
		$hour_label 	= $atts ['hour_label'];
		$day_label 		= $atts ['day_label'];
		$week_label 	= $atts ['week_label'];
		$month_label 	= $atts ['month_label'];
		$year_label 	= $atts ['year_label'];
		$expiry_text 	= $atts ['expiry_text'];
		$class 			= ($atts ['class'])?' '.$atts ['class']:'';

		jv_query_asset ( 'js', 'jquery.plugin.min' );
		jv_query_asset ( 'js', 'jquery.countdown.min' );
		$document 	= JFactory::getDocument();
		$document->addScriptDeclaration('
			(function($){
				$(function(){
				   	var austDay = new Date();
					austDay = new Date("'.$month.', '.$day.', '.$year.'");
					$("#'.$id.'").countdown({
						until: austDay,
						labels: [\''.$year_label.'\', \''.$month_label.'\', \''.$week_label.'\', \''.$day_label.'\', \''.$hour_label.'\', \''.$minute_label.'\', \''.$second_label.'\'],
						labels1: [\''.$year_label.'\', \''.$month_label.'\', \''.$week_label.'\', \''.$day_label.'\', \''.$hour_label.'\', \''.$minute_label.'\', \''.$second_label.'\'],
						padZeroes: true,
						expiryText : "'.$expiry_text.'"
					});
				});
			})(jQuery);
		');
		return '<div class="jvcountdown'.$class.'" id="'.$id.'"></div>';
	}
}
