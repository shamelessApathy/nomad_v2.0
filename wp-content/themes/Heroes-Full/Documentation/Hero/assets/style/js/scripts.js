
/*-----------------------------------------------------------------------------------*/
/*	PRETTIFY
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function () {
    window.prettyPrint && prettyPrint()
});
/*-----------------------------------------------------------------------------------*/
/*	DATA REL
/*-----------------------------------------------------------------------------------*/
$('a[data-rel]').each(function () {
    $(this).attr('rel', $(this).data('rel'));
});
/*-----------------------------------------------------------------------------------*/
/*	STICKY NAVIGATION
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {

    var menu = $('.navbar'),
        pos = menu.offset();

    $(window).scroll(function () {
        if ($(this).scrollTop() > pos.top + menu.height() && menu.hasClass('default') && $(this).scrollTop() > 150) {
            menu.fadeOut('fast', function () {
                $(this).removeClass('default').addClass('fixed').fadeIn('fast');
            });
        } else if ($(this).scrollTop() <= pos.top + 150 && menu.hasClass('fixed')) {
            menu.fadeOut(0, function () {
                $(this).removeClass('fixed').addClass('default').fadeIn(0);
            });
        }
    });

});
$(document).ready(function() {
	$('.offset').css('padding-top', $('.navbar').height() + 'px');
       
}); 
$(window).resize(function() {
	$('.offset').css('padding-top', $('.navbar').height() + 'px');        
}); 