/**
 * File custom.js.
 *
 * All script for theme be write in this file.
 *
 *
 */

( function( $ ) {
	// FAVORITE GAMES
	$('#favoriteSlider').slick({
		infinite: false,
		adaptiveHeight: true
	});
	// SHOW FULL MENU
	$("#primary-menu").on('click', '.show-more-menu', function(event) {
		/* Act on the event */
		$(this).parents('.nav-menu-top').toggleClass('open');
		$(this).parents('.nav-menu-top').find('.menu-full-menu-container').slideToggle('fast/400/fast');
	});
} )( jQuery );


function openLogin(e){
	jQuery("#signinRegisterBox").slideToggle('slow/400/fast');
	jQuery("body").toggleClass('open-login-box');
	console.log('End clicked');
}

function closeLogin(e) {
	jQuery("#login-toggle").click();
}