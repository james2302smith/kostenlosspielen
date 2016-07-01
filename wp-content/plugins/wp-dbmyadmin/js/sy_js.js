/*
	Custom JS
	Author : Syed Amir Hussain
*/
var jq = jQuery.noConflict();
var loader_html = '<div class="sy_bg loader">&nbsp;</div><div class="sy_loader loader">Please wait...</div>';
jq(document).ready(function(){
	jq('.table').click(function(){
		passToSyAjax( jq(this).attr('data'), 'show_record' );
	});
	
	jq('.sy_database').click(function(){
		passToSyAjax( '', 'back' );
	});
	
	jq('.sy_paginate').click(function(){
  		jq('.sy_paginate').remove();
		jq('.sy-main-content').append( loader_html );
		var ajaxobject = {
			action: 'syAjax',
			data: { act : 'show_record', cond : 'more', tab: jq(this).attr('data') }
		};
		jq.post(ajaxurl, ajaxobject, function(response) {
			jq.getScript( plugin_url );
			response = JSON.parse( response );
			jq('.sy-database-container .row:last-child').after( response.data );
			jq('.sy-database-container').after( response.paging );
			jq('.loader').remove();
		});
		return false;
	});
});

var passToSyAjax = function( table, __do ){
	jq('.sy-main-content').append( loader_html );
	var ajaxobject = {
		action: 'syAjax',
		data: { tab : table, act : __do }
	};
	jq.post(ajaxurl, ajaxobject, function(response) {
		jq.getScript( plugin_url );
		jq('#wpbody-content').html( response );
	});
    return false;
}