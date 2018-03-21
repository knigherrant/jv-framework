/**
 * For content shortcodes
 */
 jQuery(document).ready(function ($) {
	 // Add class when hover column in price table
	 $('.jvsc-pricetable .jvsc-pricecol ').mouseenter(function(){
		 $('.jvsc-pricetable .jvsc-pricecol ').removeClass('jvsc-pricecol-special');
		 $(this).addClass('jvsc-pricecol-special');
	 });

 });