function SEOPressor_log($) {
    if (!SEOPressor_log_triggered)
    {
        SEOPressor_log_triggered = true;
        /*
         * Log Page behavior.
         */
        var WPPostsRateKeys = {
            plugin_url: $('#plugin_url').val()
        };

        /*
         * Logs Grid Definition.
         */
        var logs_grid = $('#seopressor-logs-grid').jqGrid({
            url         : ajaxurl,
            postData    : {
                object: 'log',
                action: 'seopressor_list'
            },
            datatype    : 'json',
            mtype       : 'POST',
            caption     : 'Logs',
            colNames    : ['Date', 'Type', 'Code', 'Message'],
            colModel    : [
                {
                    align        : 'center',
                    classes      : 'dt_column',
                    index        : 'dt',
                    name         : 'dt',
                    search       : true,
                    searchoptions: {
                        dataInit: function (element) {
                            $(element).datepicker({
                                dateFormat: 'yy-mm-dd',
                                onSelect  : function () {
                                    var sgrid = $("#seopressor-logs-grid")[0];
                                    sgrid.triggerToolbar();
                                },
                                showAnim  : 'slideDown'
                            });
                        }
                    },
                    stype        : 'text',
                    width        : 5,
                    sortable     : true
                },
                {
                    align  : 'center',
                    classes: 'type_column',
                    index  : 'type',
                    name   : 'type',
                    stype  : 'text',
                    width  : 5
                },
                {
                    align  : 'center',
                    classes: 'msg_code_column',
                    index  : 'msg_code',
                    name   : 'msg_code',
                    stype  : 'text',
                    width  : 5
                },
                {
                    align  : 'left',
                    classes: 'message_column',
                    index  : 'message',
                    name   : 'message',
                    stype  : 'text',
                    width  : 40
                }
            ],
            sortname    : 'dt',
            sortorder   : 'desc',
            pager       : '#seopressor-logs-grid-pager',
            rowList     : [50, 100, 300, 500, 1000],
            autowidth   : true,
            rownumbers  : true,
            viewrecords : true,
            emptyrecords: 'No <strong>log entry</strong> found!',
            forceFit    : true,
            height      : 'auto',
            headertitles: true,
            hoverrows   : true,
            ignoreCase  : true,
            loadui      : 'block',
            prmNames    : {
                sort : 'orderby',
                order: 'orderdir'
            }
        }).jqGrid('navGrid', '#seopressor-logs-grid-pager', {
                // General navigation parameters.
                edit         : false,
                add          : false,
                del          : false,
                search       : false,
                refresh      : true,
                refreshtext  : 'Refresh Data',
                view         : false,
                closeOnEscape: true,
                refreshstate : 'current'
            }, {}, {}, {}, {}, {}, {});

        jQuery('#seopressor-logs-grid').jqGrid('filterToolbar', {
            searchOnEnter: false
        });
    }
};

jQuery(SEOPressor_log);

//To be sure that seopressor code will be executed even when other code generate an exception
SEOPressor_log_triggered = false;

function OnErrorResponse(){
    if (document.readyState==="interactive" && !SEOPressor_settings_triggered) SEOPressor_log(seop_jquery);
    //document.readyState==="interactive" means that DOM is ready to interact with it
    //This check is useful to exclude the errors fired before DOMContentLoaded event
}

if (window.addEventListener) window.addEventListener('error', OnErrorResponse);
else window.attachEvent('onerror', OnErrorResponse);