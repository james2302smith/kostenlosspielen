/**
 * File custom.js.
 *
 * All script for theme be write in this file.
 *
 *
 */

( function( $ ) {
	// FAVORITE GAMES
	/*$('#favoriteSlider').slick({
		infinite: false,
		adaptiveHeight: true
	});*/
	// SHOW FULL MENU
	$("#primary-menu").on('click', '.show-more-menu', function(event) {
		/* Act on the event */
		$(this).parents('.nav-menu-top').toggleClass('open');
		$(this).parents('.nav-menu-top').find('.menu-full-menu-container').slideToggle('fast/400/fast');
	});
} )( jQuery );

var swiper = new Swiper('#favoriteSwiper', {
    pagination: '.swiper-pagination',
    slidesPerView: 5,
    slidesPerColumn: 2,
    paginationClickable: true,
    nextButton: '.fsw-next',
    prevButton: '.fsw-prev',
    spaceBetween: 10,
});

var myswiper = new Swiper('#myfavoriteSwiper', {
    pagination: '.swiper-pagination',
    slidesPerView: 6,
    paginationClickable: true,
    nextButton: '.mfsw-next',
    prevButton: '.mfsw-prev',
    spaceBetween: 10,
});

function openLogin(e){
	jQuery("#signinRegisterBox").slideToggle('fast/400/fast');
	jQuery("body").toggleClass('open-login-box');
    if (!jQuery("#signinRegisterBox .form-box.login-form").is(':visible')) {
        switchLogin(e);
    }
}
function switchRegister(e){
	jQuery("#signinRegisterBox .form-box.login-form").hide();
	jQuery("#signinRegisterBox .form-box.register-form").slideDown('fast/400/fast');
	jQuery("body").removeClass('open-login-box');
	jQuery("body").addClass('open-register-box');
}

function switchLogin(e) {
	jQuery("#signinRegisterBox .form-box.register-form").hide();
	jQuery("#signinRegisterBox .form-box.login-form").slideDown('fast/400/fast');
	jQuery("body").removeClass('open-register-box');
	jQuery("body").addClass('open-login-box');
}

function closeLogin(e) {
	jQuery("#login-toggle").click();
	if(jQuery('body').hasClass('open-login-box')) {
		jQuery('body').removeClass('open-login-box');
	}
	else if (jQuery('body').hasClass('open-register-box')) {
		jQuery('body').removeClass('open-register-box');
	}
}

function openFavoriteBox(e) {
	 jQuery('#favoritesBar').slideToggle('fast/400/fast', function(){
	 	jQuery('#favoritesBar').toggleClass('open');
	 });
}