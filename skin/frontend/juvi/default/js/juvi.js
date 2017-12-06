// General js
jQuery(document).ready(function(){
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
	// Magnific popup
	jQuery('.img.popup').each(function(){
	    var imgsrc = jQuery(this).children('img').attr("src");
	    var newsrc = imgsrc.replace( '/thumbnails', '');
		jQuery(this).attr("href",newsrc);
		jQuery(this).magnificPopup({type:'image',mainClass: 'mfp-fade',closeOnContentClick: 'true'});
	});
	// FB chat
	jQuery('#fb-chat-btn span').on('click',function(){
		jQuery('.fb-page.fb_iframe_widget, #fb-close').addClass("slide-out");
	});
	jQuery('#fb-close').on('click',function(){
		jQuery('.fb-page.fb_iframe_widget, #fb-close').removeClass("slide-out");
	});
});
