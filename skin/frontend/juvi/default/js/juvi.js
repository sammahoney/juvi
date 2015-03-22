// General js
jQuery(document).ready(function(){

	// Animate menu dropdown
	jQuery('li.level0.parent, .menu-promo').hover(
		function() {
			jQuery('li.level0.parent').addClass("menu-active");
			jQuery('#nav').addClass("show-promo");
		}, function() {
			jQuery('li.level0.parent').removeClass("menu-active");
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

	/*
	// Sidr menu
	jQuery('#left-menu').sidr({
		side: 'left',
		source: '.nav-container'
	});
	// Add Sidr menu accordions
	jQuery("ul.sidr-class-level0").hide();
	jQuery("li.sidr-class-level0.sidr-class-parent > a").click(function(e) {
		e.preventDefault();
		if (jQuery(this).next("ul.sidr-class-level0").is(":hidden")) {
			jQuery(this).addClass("active").next("ul.sidr-class-level0").slideDown("normal");
		} else {
			jQuery(this).removeClass("active").next("ul.sidr-class-level0").slideUp("normal");
		}
	});
	*/
});
