/**
 * File custom.js.
 *
 * All script for theme be write in this file.
 *
 *
 */

( function( $ ) {
	$("#primary-menu").on('click', '.show-more-menu', function(event) {
		/* Act on the event */
		$(this).parents('.nav-menu-top').toggleClass('open');
		$(this).parents('.nav-menu-top').find('.menu-full-menu-container').slideToggle('fast/400/fast');
	});
} )( jQuery );
