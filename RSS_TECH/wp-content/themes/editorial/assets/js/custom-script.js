jQuery(document).ready(function() {
    "use strict";
    // Ticker
    jQuery('#mt-newsTicker').bxSlider({
        minSlides: 1,
        maxSlides: 1,
        speed: 3000,
        mode: 'vertical',
        auto: true,
        controls: true,
        prevText: '<i class="fa fa-backward"> </i>',
        nextText: '<i class="fa fa-forward"> </i>',
        pager: false
    });

    // Slider
    jQuery('.editorialSlider').bxSlider({
        pager: false,
        controls: true,
        prevText: '<i class="fa fa-chevron-left"> </i>',
        nextText: '<i class="fa fa-chevron-right"> </i>'
    });

    //Search toggle
    jQuery('.header-search-wrapper .search-main').click(function() {
        jQuery('.search-form-main').toggleClass('active-search');
    });

    //widget title wrap
    jQuery('.widget .widget-title,.related-articles-wrapper .related-title').wrap('<div class="widget-title-wrapper"></div>');

    //responsive menu toggle
    jQuery('.bottom-header-wrapper .menu-toggle').click(function(event) {
        jQuery('.bottom-header-wrapper #site-navigation').slideToggle('slow');
    });

    //responsive sub menu toggle
    jQuery('#site-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-angle-right"></i> </span>');

    jQuery('#site-navigation .sub-toggle').click(function() {
        jQuery(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        jQuery(this).children('.fa-angle-right').first().toggleClass('fa-angle-down');
    });

    // Scroll To Top
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > 700) {
            jQuery('#mt-scrollup').fadeIn('slow');
        } else {
            jQuery('#mt-scrollup').fadeOut('slow');
        }
    });

    jQuery('#mt-scrollup').click(function() {
        jQuery("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
});
