// General js
jQuery(document).ready(function(){
	// Animate menu dropdown
	jQuery('li.nav-1.level0.parent, .menu-promo').hover(
		function() {
			jQuery('li.nav-1.level0.parent').addClass("menu-active");
			jQuery('#nav').addClass("show-promo");
		}, function() {
			jQuery('li.nav-1.level0.parent').removeClass("menu-active");
			jQuery('#nav').removeClass("show-promo");
		}
	);
	jQuery('.nav-primary li.level0 ul.level0').hover(
		function() {
			jQuery('.menu-promo').addClass("active");
		}, function() {
			jQuery('.menu-promo').removeClass("active");
		}
	);
	// Fix for tablet hover (to override stuff in app.js)
	jQuery('#nav li.level1 a').on('click touchend', function() {
		var el = jQuery(this);
		var link = el.attr('href');
		window.location = link;
	});
	// Hide messages if clicked
	jQuery("ul.messages").click(function(){
		jQuery(this).fadeOut(400);
	});
		// Equalise heights on list page
	jQuery(window).load(function(){
		var maxHeight = 0;
		jQuery('.gemstone-list-container .gemstone-list-item').each(function() { 
			maxHeight = Math.max(maxHeight, jQuery(this).height()); 
		}).height(maxHeight);
	});
	// Scroll Gemstones prompt
	jQuery('.gemstone-featured-item .stone-info-wrapper').scrollTop(1).scrollTop(0);
});
