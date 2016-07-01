/*
 * Bug fix: "TypeError: this.element.propAttr is not a function".
 */
seop_jquery.fn.extend({
	propAttr: seop_jquery.fn.prop || seop_jquery.fn.attr
});

function SEOPressor_global($) {
    if (!SEOPressor_global_triggered)
    {
        SEOPressor_global_triggered = true;
        /*
         * Global behavior.
         */
        /*
         * Make Support Menu link to open in another tab.
         */
        $('#toplevel_page_seo-pressor a[href="admin.php?page=seopressor-support"]').attr('target', '_blank');

        /*
         * Actions menu.
         */
        $('body').on('click', '.actions-menu-button', function () {
            $(this).next().show();
        });
    }
};

seop_jquery(SEOPressor_global);

//To be sure that seopressor code will be executed even when other code generate an exception
SEOPressor_global_triggered = false;

function OnErrorResponse(){
    if (document.readyState==="interactive" && !SEOPressor_global_triggered) SEOPressor_global(seop_jquery);
    //document.readyState==="interactive" means that DOM is ready to interact with it
    //This check is useful to exclude the errors fired before DOMContentLoaded event
}

if (window.addEventListener) window.addEventListener('error', OnErrorResponse);
else window.attachEvent('onerror', OnErrorResponse);