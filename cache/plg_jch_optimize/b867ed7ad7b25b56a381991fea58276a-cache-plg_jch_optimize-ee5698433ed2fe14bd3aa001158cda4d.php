<?php die("Access Denied"); ?>#x#a:2:{s:6:"output";s:0:"";s:6:"result";s:12874:"@import url(/jv-framework/media/system/css/system.css);
/**
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/* Import project-level system CSS */
@import url(/jv-framework/media/system/css/system.css);

/* Unpublished */
.system-unpublished, tr.system-unpublished {
	background: #e8edf1;
	border-top: 4px solid #c4d3df;
	border-bottom: 4px solid #c4d3df;
}

span.highlight {
	background-color:#FFFFCC;
	font-weight:bold;
	padding:1px 4px;
}

.img-fulltext-float-right {
	float: right;
	margin-left: 10px;
	margin-bottom: 10px;
}

.img-fulltext-float-left {
	float: left;
	margin-right: 10px;
	margin-bottom: 10px;
}

.img-fulltext-float-none {
}

.img-intro-float-right {
	float: right;
	margin-left: 5px;
	margin-bottom: 5px;
}

.img-intro-float-left {
	float: left;
	margin-right: 5px;
	margin-bottom: 5px;
}

.img-intro-float-none {
}
/**
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/* Form validation */
.invalid { border-color: #ff0000; }
label.invalid { color: #ff0000; }

/* Buttons */
#editor-xtd-buttons {
	padding: 5px;
}

.button2-left,
.button2-right,
.button2-left div,
.button2-right div {
	float: left;
}

.button2-left a,
.button2-right a,
.button2-left span,
.button2-right span {
	display: block;
	height: 22px;
	float: left;
	line-height: 22px;
	font-size: 11px;
	color: #666;
	cursor: pointer;
}

.button2-left span,
.button2-right span {
	cursor: default;
	color: #999;
}

.button2-left .page a,
.button2-right .page a,
.button2-left .page span,
.button2-right .page span {
	padding: 0 6px;
}

.page span {
	color: #000;
	font-weight: bold;
}

.button2-left a:hover,
.button2-right a:hover {
	text-decoration: none;
	color: #0B55C4;
}

.button2-left a,
.button2-left span {
	padding: 0 24px 0 6px;
}

.button2-right a,
.button2-right span {
	padding: 0 6px 0 24px;
}

.button2-left {
	background: url(/jv-framework/templates/system/images/j_button2_left.png) no-repeat;
	float: left;
	margin-left: 5px;
}

.button2-right {
	background: url(/jv-framework/templates/system/images/j_button2_right.png) 100% 0 no-repeat;
	float: left;
	margin-left: 5px;
}

.button2-left .image {
	background: url(/jv-framework/templates/system/images/j_button2_image.png) 100% 0 no-repeat;
}

.button2-left .readmore,
.button2-left .article {
	background: url(/jv-framework/templates/system/images/j_button2_readmore.png) 100% 0 no-repeat;
}

.button2-left .pagebreak {
	background: url(/jv-framework/templates/system/images/j_button2_pagebreak.png) 100% 0 no-repeat;
}

.button2-left .blank {
	background: url(/jv-framework/templates/system/images/j_button2_blank.png) 100% 0 no-repeat;
}

/* Tooltips */
div.tooltip {
	float: left;
	background: #ffc;
	border: 1px solid #D4D5AA;
	padding: 5px;
	max-width: 200px;
	z-index:13000;
}

div.tooltip h4 {
	padding: 0;
	margin: 0;
	font-size: 95%;
	font-weight: bold;
	margin-top: -15px;
	padding-top: 15px;
	padding-bottom: 5px;
	background: url(/jv-framework/templates/system/images/selector-arrow.png) no-repeat;
}

div.tooltip p {
	font-size: 90%;
	margin: 0;
}

/* Caption fixes */
/* Caption fixes */
.img_caption .left {
        float: left;
        margin-right: 1em;
}

.img_caption .right {
        float: right;
        margin-left: 1em;
}

.img_caption .left p {
        clear: left;
        text-align: center;
}

.img_caption .right p {
        clear: right;
        text-align: center;
}

.img_caption  {
	text-align: center!important;
}

.img_caption.none {
	margin-left:auto;
	margin-right:auto;
}


/* Calendar */
a img.calendar {
	width: 16px;
	height: 16px;
	margin-left: 3px;
	background: url(/jv-framework/templates/system/images/calendar.png) no-repeat;
	cursor: pointer;
	vertical-align: middle;
}

a, .fxmenu  .level1 , .fxmenu   .levelsub , .fx-subitem .iconsubmenu 
{-webkit-transition: all 0.2s ease-out; -moz-transition: all 0.2s ease-out; -o-transition: all 0.2s ease-out; -ms-transition: all 0.2s ease-out;}

button, .button
{    -webkit-border-radius:  3px;    -moz-border-radius:     3px;    border-radius:          3px;}

.box-sizing, input
{		-moz-box-sizing:border-box;	-webkit-box-sizing:border-box;	box-sizing:border-box;	}
	/* Item level 1 */
	ul.fxmenu li .level1 { line-height:50px; display:block; padding:0 20px; font-size:18px; color:#fff;}

	ul.fxmenu li > .iconImage { padding-left:50px; position:relative;}
	ul.fxmenu li > .iconImage img.icon  { position:absolute; top:7px; left:5px; max-width:40px; max-height:36px;		 }
	ul.fxmenu li > .fx-desc { line-height:18px; padding-top:7px; padding-bottom:7px;}
	ul.fxmenu li > .fx-desc .fx-desc { font-size:13px; font-weight:normal;}
	
	/* Item level sub */
	ul.fxmenu .fx-subitem  ul li{ margin-top:2px;    box-shadow:0 -1px 0 0 #DDDDDD, 0 -2px 0 0 #FFFFFF; 		-webkit-box-shadow: 0 -1px 0 0 #DDDDDD, 0 -2px 0 0 #FFFFFF;		-moz-box-shadow: 0 -1px 0 0 #DDDDDD, 0 -2px 0 0 #FFFFFF;}
	ul.fxmenu .fx-subitem  ul li:first-child   {    box-shadow: none; 		-webkit-box-shadow: none;		-moz-box-shadow: none; margin-top:0}
	
	ul.fxmenu .fx-subitem .levelsub { color:#fff; padding:10px 0; display:block;    color: #000;    text-decoration: none;    text-shadow: 0 1px 0 #FFFFFF;}
	ul.fxmenu .fx-subitem li.hasChild > .iconsubmenu { }
	ul.fxmenu .fx-subitem li.hasChild:hover > .iconsubmenu {}
	ul.fxmenu .fx-subitem li.fxcolumn > .iconsubmenu  { display:none !important}
	ul.fxmenu .fx-subitem li:first-child > .levelsub { border:none;  box-shadow:none;} /* First-child */
	ul.fxmenu .fx-subitem li:hover > .levelsub, ul.fxmenu .fx-subitem li.active > .levelsub { background:#e9e7e7; padding-left:10px;} /* Hover and active */
	
	/* Item Group */
	ul.fxmenu .fx-subitem .group-title, .fx-subitem h3.title-module {border-top:none;   font-size:150%; line-height:normal; background:none !important; padding:10px 0 !important;
	box-shadow:0 1px 0 0 #DDDDDD, 0 2px 0 0 #FFFFFF !important; 		-webkit-box-shadow: 0 1px 0 0 #DDDDDD, 0 2px 0 0 #FFFFFF !important;		-moz-box-shadow: 0 1px 0 0 #DDDDDD, 0 2px 0 0 #FFFFFF !important;} 
	
	/* Sub Module */
	ul.fxmenu .fx-subitem .jv-module { background:none; color:#000;}
	ul.fxmenu .fx-subitem h3.title-module { color:#000; margin-bottom:10px;}
	ul.fxmenu .fx-subitem .jv-module .contentmod  { padding:0}
	.flexMenuToggle{display:none;}



body { background:#eee;}

/*--CLASS PUBLIC
-------------------------------------------------------------------*/
button, .button { color:#fff; }


.container {     background: none repeat scroll 0 0 #FFFFFF;    padding: 10px;}

.helvetica_neueitalic       			                {    font-family: 'helvetica_neueitalic';}
h2, h3, ul.fxmenu ,  .helvetica_neue_lightregular       		{    font-family: 'helvetica_neue_lightregular';}
.helvetica_neue_lightitalic       		                {    font-family: 'helvetica_neue_lightitalic';}
.helvetica_neue_thinregular       		                {    font-family: 'helvetica_neue_thinregular';}
.helvetica_neue_thinitalic       		                {    font-family: 'helvetica_neue_thinitalic';}
.helvetica_neue_mediumregular       	            {    font-family: 'helvetica_neue_mediumregular';}
.helvetica_neue_mediumitalic       		                {    font-family: 'helvetica_neue_mediumitalic';}
h1, .helvetica_neue_condensed_heRg       	            {    font-family: 'helvetica_neue_condensed_heRg';}

/*--HEADER
-------------------------------------------------------------------*/

#block-header .container { padding:0; min-height:100px; background:none }
#logo { float:left; margin-top: 28px;}
.position-search { position:absolute; top:10px; right:0}

/*Font size*/
#block-header .timer {    bottom: 10px;    font-size: 14px;    position: absolute;    right: 100px;}
#block-header .font-size { position:absolute; right:0; bottom:10px}

.font-size a { width:25px; height:20px; display:block; float:left; text-indent:-999em;  margin-left:3px; font-size:0; background-image:url(/jv-framework/templates/jv-melody-iii/images/default/button.png)}
.font-size a.smaller { background-position:0 0}
.font-size a.bigger { background-position:0 -20px}
.font-size a.reset { background-position:0 -40px}
	
/*--MENU
-------------------------------------------------------------------*/

#block-mainnav { margin:0}
#block-mainnav .container { padding:0; }
#block-mainnav ul.fxmenu {margin:0 -10px;}




/*--MODULE
-------------------------------------------------------------------*/
.jv-module { background:#ddd;}
.contentmod  { padding:10px;}

h3.title-module, .page-header h1 { font-size:20px; padding:7px 10px; color:#fff; line-height:26px; margin:0; }
.page-header h1 { margin-bottom:20px;}

 #fx-item498_  > .fx-subitem { display:block !important; opacity:1 !important}


.follow-us {    margin: 0;    padding: 0;}
.follow-us li {    list-style-type: none;     margin-top: 10px;    padding-top: 10px;   box-shadow: 0 -1px 0 0 #fff, 0 -2px 0 0 #bcbcbc; -webkit-box-shadow: 0 -1px 0 0 #fff, 0 -2px 0 0 #bcbcbc; -moz-box-shadow: 0 -1px 0 0 #fff, 0 -2px 0 0 #bcbcbc;}
.follow-us li:first-child { margin-top:0; padding:0; box-shadow: none; -webkit-box-shadow: none; -moz-box-shadow: none}
.follow-us li a {	background: url(/jv-framework/templates/jv-melody-iii/images/default/follow-us.png) no-repeat;	    display: block;    line-height: 16px;    padding: 8px 0 8px 40px;}
.follow-us .facebook a { background-position:0 0;}
.follow-us .twitter a { background-position:0 -50px;}
.follow-us .rss a { background-position:0 -100px;}
.follow-us .people a { background-position:0 -150px;}

.accordion-group { background:#fff; border-color:#BCBCBC;}
.accordion-inner { border-color:#BCBCBC;}
.tab-content {    background:  #FFFFFF;    padding: 10px;	border:1px solid #aaa;	border-top:none;}


.jcarousel-container .jcarousel-clip li {    height: 150px;}

#block-bottomb .accordion { margin:0}

.block.equal-column > [class*="span"]:after { background:#ddd;}



/*--CONTAINER
-------------------------------------------------------------------*/
#block-slide img { width:100%;}

[class*="blog"] .items-row { border-bottom:1px dashed #ddd; padding-bottom:20px;}
div.pagination p.counter  { margin:6px 0 0}
p.readmore { margin:0}

#myTab { border-color:#aaa; margin:0; padding:0 10px;}
.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus { border-color:#BCBCBC #BCBCBC transparent}



/*--FOOTER
-------------------------------------------------------------------*/

#block-footer {    background: none repeat scroll 0 0 #666666;
    padding: 10px 0; } 
div.copyright { padding:0}
 


@media (min-width: 1600px) {  /* HD */
}

@media (max-width: 1199px) {  /* Tablet and Mobile */
}

 @media (min-width: 730px) and (max-width: 1199px) {  /* Tablet */
}

 @media (min-width: 980px) and (max-width: 1199px) {  /* Tablet larger */
}

 @media (min-width: 768px) and (max-width: 979px) {  /* Tablet small */
}

@media (max-width: 767px) { /* Mobile */


}

@media (min-width: 401px) and (max-width: 767px) { /* Mobile  larger */
}

@media (max-width: 400px) { /* Mobile small */

}

a, ul.vertical li:hover a, ul.vertical li.active a { color:#0088CC;}
a:hover { color:#000;}

ul.vertical ul a:hover, ul.vertical ul li.active > a { color:#0088CC !important;}

ul.fxmenu li:hover .level1, ul.fxmenu li.active .level1 { background:#545454}

.gradient,  h3.title-module, button, .button, ul.fxmenu, .page-header h1
{  background-color: #545454;
  background-repeat: repeat-x;
  background-image: -khtml-gradient(linear, left top, left bottom, from(#545454), to(#333));
  background-image: -moz-linear-gradient(top, #545454, #333);
  background-image: -ms-linear-gradient(top, #545454, #333);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #545454), color-stop(100%, #333));
  background-image: -webkit-linear-gradient(top, #545454, #333);
  background-image: -o-linear-gradient(top, #545454, #333);
  background-image: linear-gradient(top, #545454, #333);
}
button:hover, .button:hover
{  background-color: #333;
  background-repeat: repeat-x;
  background-image: -khtml-gradient(linear, left top, left bottom, from(#333), to(#545454));
  background-image: -moz-linear-gradient(top, #333, #545454);
  background-image: -ms-linear-gradient(top, #333, #545454);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #333), color-stop(100%, #545454));
  background-image: -webkit-linear-gradient(top, #333, #545454);
  background-image: -o-linear-gradient(top, #333, #545454);
  background-image: linear-gradient(top, #333, #545454);
}

";}