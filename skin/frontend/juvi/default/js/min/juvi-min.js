jQuery(document).ready(function(){jQuery("li.nav-1.level0.parent, .menu-promo").hover(function(){jQuery("li.nav-1.level0.parent").addClass("menu-active"),jQuery("#nav").addClass("show-promo")},function(){jQuery("li.nav-1.level0.parent").removeClass("menu-active"),jQuery("#nav").removeClass("show-promo")}),jQuery(".nav-primary li.level0 ul.level0").hover(function(){jQuery(".menu-promo").addClass("active")},function(){jQuery(".menu-promo").removeClass("active")}),jQuery("#nav li.level1 a").on("click touchend",function(){var e=jQuery(this),n=e.attr("href");window.location=n}),jQuery("#nav li.level0.parent").on("touchend",function(){jQuery("#nav").addClass("show-promo")})});