jQuery(document).ready(function ($) {

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

function checkPermalinks(){
    var currentHash = window.location.hash;
    if(typeof currentHash == 'undefined' || currentHash.length < 5)
        return;
    if(currentHash.substring(0,6) !== '#view-')
        return;

    var projectSlug = currentHash.substring(6);
    var projectLinkItem = jQuery('.captionWrapper [data-slug="'+projectSlug+'"]');
    var holder = projectLinkItem.closest('.portfolio-holder');
    if(projectLinkItem.length != 0 && holder.length != 0){
        jQuery('html, body').animate({scrollTop: holder.offset().top});
        projectLinkItem.trigger('click');
    }
}

var portfolios = {};


    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* Isotope */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    if(typeof fastwp != 'undefined' && typeof fastwp.portfolio != 'undefined'){

        for(var index in fastwp['portfolio']){
            var _portfolioConfig    = fastwp['portfolio'][index];
            var _defaultFilterValue = _portfolioConfig.default_cat;
            var _pID                = _portfolioConfig.id;
            portfolios[_pID]        = $('.js-isotope', '#' + _pID).imagesLoaded( function() {
                portfolios[_pID].isotope({
                    filter: _defaultFilterValue
                });
            });

            $('.js-filters','#' + _pID)
                .off('click')
                .on('click', 'button', function() {
                    var nume = $(this).attr('title');
                    if( $(this).attr('data-filter') == '.f--all' ) {
                        nume = 'All';
                    }
                    $(".activeFilter h3 span").text(nume);
                    var filterValue = $(this).attr('data-filter');
                    var _ID = jQuery(this).closest('.portfolio-holder').attr('id');
                    jQuery(this).closest('.js-filters').find('[data-filter]').not(this).removeClass('active');
                    jQuery(this).addClass('active');
                    portfolios[_ID].isotope({ filter: filterValue });
            })
            .find('[data-filter="'+_defaultFilterValue+'"]').addClass('active');

            portfolios[_pID].isotope({
                filter: _defaultFilterValue
            });
        }
    }

    //    masonry 3 columns
    $( function() {
        var $container2 = $('.blogPostsWrapper');
        // initialize Masonry after all images have loaded
        $container2.imagesLoaded(function () {
            $container2.isotope({
                itemSelector: '.blogPost',
                masonry: {
                    columnWidth: '.grid-sizer-blog-3'
                }
            });
        });
    });

    // $( function() {
    //     var $container2 = $('.gallery');
    //     // initialize Masonry after all images have loaded
    //     $container2.imagesLoaded(function () {
    //         $container2.isotope({
    //             itemSelector: '.griditem',
    //             masonry: {
    //                 columnWidth: '.grid-sizer-blog-3'
    //             }

    //         });
    //     });
    // });


    //    masonry 2 columns
    $( function() {
        var $container3 = $('.blogPostsWrapper2');
        // initialize Masonry after all images have loaded
        $container3.imagesLoaded(function () {
            $container3.isotope({
                itemSelector: '.blogPost2',
                masonry: {
                    columnWidth: '.grid-sizer-blog-2'
                }
            });
        });
    });



function getCurrentScriptsFromPage(){
    var myScripts = [];
    jQuery('script').each(function(){
        var tmpscript = jQuery(this).attr('src');
        if(typeof tmpscript == 'string' && tmpscript.length > 4){
            if(!(tmpscript in myScripts))
                myScripts.push(tmpscript);
        }
    });
    return myScripts;
}






    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* overlay portfolio */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    $("a.overlay-ajax").click(function(){
        var url = $(this).attr("href");
        $(".overlay-section #transmitter").html('');
        $(".js-project-overlay").addClass('is-loading');
        $(".js-loading-msg").show();
        $(".overlay-section").load(url + ' #transmitter', function(a, b){
            var myScripts = $(a).find('script');
            var currentScriptsOnPage = getCurrentScriptsFromPage();
            myScripts.each(function(){
                var scriptSrc = $(this).attr('src');
                var scriptId = $(this).attr('id');
                if((typeof scriptSrc != 'undefined' && $('[src="' + scriptSrc + '"]').length == 0) || (typeof scriptId != 'undefined' && $('[id="' + scriptId + '"]').length == 0)){
                    $('body').append($(this));
                }
            });

            $(".fwp-owl-carousel").owlCarousel({
                singleItem: true,
                autoPlay:   true,
                navigation: true,
                navigationText: [
                    "<i class='fa fa-angle-left fa-2x itemNav'></i>",
                    "<i class='fa fa-angle-right fa-2x itemNav'></i>"
                ]
            });

            $(".js-project-overlay").removeClass('is-loading');
            $(".js-loading-msg").hide();
        });
        $('.overlay-close img').tooltip();
        return false;
    });


    // no scroll on body when overlay is up
    $(function () {

        $('a.overlay-ajax').click(function(){
            $( "body" ).addClass( "noscroll" );
        });

        $('a.overlay-close').click(function(){
            $( "body" ).removeClass( "noscroll" );
            setTimeout(function(){
                $('#transmitter').empty();
            },250);
        });

    });

    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* smoothscroll */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    smoothScroll.init({
        speed: 1000,
        offset: 60
    });



    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* Intro Height  */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

    function introHeight() {
        var wh = $(window).height();
        $('.intro').css({height: wh});
    }

    introHeight();
    $(window).bind('resize',function () {
        //Update slider height on resize
        introHeight();
    });

    function adminbarHeight() {
        if( $('#wpadminbar').length > 0 ) {
            $('.navbar').css({ marginTop: $('#wpadminbar').height() });
        }
    }

    adminbarHeight();

    if(typeof $('body').matchHeight == 'function' && $(".heightItem").length > 0){
        jQuery(".row").each(function() {
                jQuery(this).children(".heightItem").matchHeight();
            });
    }


   $("#owl-team").owlCarousel({
        singleItem: true,
        autoPlay:   true,
        navigation: true,
        navigationText: [
            "<i class='fa fa-angle-left fa-4x'></i>",
            "<i class='fa fa-angle-right fa-4x'></i>"
        ]
    });

    $(".owl-carousel").owlCarousel({
        singleItem:	true,
        navigation: true,
        navigationText: [
            "<i class='fa fa-angle-left fa-2x blogNav'></i>",
            "<i class='fa fa-angle-right fa-2x blogNav'></i>"
        ]
    });

     $("#owl-testimonials").owlCarousel({
        singleItem:	true,
        autoPlay:	true
    });

    $("#owl-featured").owlCarousel({
        items:3,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [980,2],
        itemsTablet: [768,2],
        itemsMobile : [479,1],
        navigation: true,
        navigationText: [
            "<i class='fa fa-angle-left fa-2x blogNav'></i>",
            "<i class='fa fa-angle-right fa-2x blogNav'></i>"
        ]
    });

    $("#owl-clients").owlCarousel({
        items:3,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [980,2],
        itemsTablet: [768,2],
        itemsMobile : [479,1],
        navigation: true,
        navigationText: [
            "<i class='fa fa-angle-left fa-4x'></i>",
            "<i class='fa fa-angle-right fa-4x'></i>"
        ]
    });

    $('.timer-item').waypoint(function() {
        "use strict";
        var settings = eval('(' + $(this).attr('data-settings') + ')');
        if(typeof settings.max != 'undefined'){
            $('.timer', this).countTo({
                from: settings.start,
                to: settings.max,
                speed: settings.speed,
                refreshInterval: settings.interval
            });
        }
    },
    {
        offset: '750',
        triggerOnce: true
    });

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $(function() {
            $('.captionWrapper.valign').css({
                top: '120px'
            });

            $('.parallaxIcon').css({
                display: 'none'
            });
        });


    }
    else{
        $(window).stellar({
            responsive: true,
            horizontalOffset: 0,
            horizontalScrolling:false
        });
    }

    if( $('.tabs').length ) {

    if( $('.tabs li.tab-current:last').length ) {
    var content = $('.tabs li.tab-current:last');
    content.each(function(){
        var tabs = $(this).parents('.tabs');
        var content = tabs.find('.content-wrap p');
        tabs.find('li.tab-current').removeClass('tab-current');
        $(this).addClass('tab-current');
        content.html( $(this).find('p').html() );
    });
    }

    $('.tabs li').on('click', function(e){
        e.preventDefault();
        var tabs = $(this).parents('.tabs');
        var content = tabs.find('.content-wrap p');
        tabs.find('li.tab-current').removeClass('tab-current');
        $(this).addClass('tab-current');
        content.html( $(this).find('p').html() );
    });

    }

    if ( (typeof $.fn.countdown !== 'undefined') ) {
        $('#countdown').countdown({until: new Date( fastwp.countdown_date )});
    }

    if( !isMobile.any() && $(window).width() > 768 && typeof $.fn.hcSticky !== 'undefined' ) {
        $('.sidebarFixedWrapper').hcSticky({
            top: 100,
            bottomEnd: 0,
            wrapperClassName: 'sidebar-sticky'
        });
    }

    window.scrollReveal = new scrollReveal();

});