jQuery(document).ready(function(){jQuery("li.nav-1.level0.parent, .menu-promo").hover(function(){jQuery("li.nav-1.level0.parent").addClass("menu-active"),jQuery("#nav").addClass("show-promo")},function(){jQuery("li.nav-1.level0.parent").removeClass("menu-active"),jQuery("#nav").removeClass("show-promo")}),jQuery(".nav-primary li.level0 ul.level0").hover(function(){jQuery(".menu-promo").addClass("active")},function(){jQuery(".menu-promo").removeClass("active")}),jQuery("#nav li.level1 a").on("click touchend",function(){var e=jQuery(this),r=e.attr("href");window.location=r}),jQuery("ul.messages").click(function(){jQuery(this).fadeOut(400)}),jQuery(window).load(function(){var e=0;jQuery(".gemstone-list-container .gemstone-list-item").each(function(){e=Math.max(e,jQuery(this).height())}).height(e)}),jQuery(".gemstone-featured-item .stone-info-wrapper").scrollTop(1).scrollTop(0),jQuery("ul.sidr-class-level0").hide(),jQuery("li.sidr-class-level0.sidr-class-parent > a").click(function(e){e.preventDefault(),jQuery(this).next("ul.sidr-class-level0").is(":hidden")?jQuery(this).addClass("active").next("ul.sidr-class-level0").slideDown("normal"):jQuery(this).removeClass("active").next("ul.sidr-class-level0").slideUp("normal")}),jQuery(".img.popup").each(function(){var e=jQuery(this).children("img").attr("src"),r=e.replace("/thumbnails","");jQuery(this).attr("href",r),jQuery(this).magnificPopup({type:"image",mainClass:"mfp-fade",closeOnContentClick:"true"})})});