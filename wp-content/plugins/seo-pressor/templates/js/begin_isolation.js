/**
 * Created with JetBrains PhpStorm.
 * User: delmo
 * Date: 25/02/13
 * Time: 06:51 PM
 * To change this template use File | Settings | File Templates.
 */
is_$_jQueryAlias = false;
if (typeof jQuery != "undefined") {
    is_$_jQueryAlias = (typeof $ != "undefined") && ($ === jQuery);
    _temp34kjnhdf_jQuery = jQuery.noConflict(true);
}