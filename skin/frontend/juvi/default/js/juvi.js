// General js
jQuery(document).ready(function(){

	// Animate menu dropdown
	jQuery('li.level0.parent, .menu-promo').hover(
		function() {
			jQuery(this,'li.level0.parent').addClass("menu-active");
			jQuery('#nav').addClass("show-promo");
		}, function() {
			jQuery(this,'li.level0.parent').removeClass("menu-active");
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
	jQuery('#nav li.level0.parent').on('touchend', function() {
		jQuery('#nav').addClass("show-promo");
	});
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
