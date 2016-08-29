function SEOPressor_internal_link($) {
    if (!SEOPressor_internal_link_triggered)
    {
        SEOPressor_internal_link_triggered = true;
        /*
         * Automatic Internal Link Page behaviour.
         */
        /*
         * Buttons.
         */
        $('.seopressor-grid-add-button').button({
            icons: {
                primary: 'ui-icon-plus'
            }
        }).click(function () {
                $('#seopressor-automatic-internal-link-grid').jqGrid('editGridRow', 'new', {
                    // Settings for ADD.
                    addCaption   : 'Add Internal Link',
                    addedrow     : 'last',
                    // Handler the response from server.
                    afterSubmit  : function (response, postdata) {
                        // Parse the XMLHttpRequest response.
                        var data = $.parseJSON(response.responseText);

                        // It is a notification.
                        if (data.type == 'notification') {
                            return [true, data.message]; 		// [success,message,new_id]
                        } else if (data.type == 'error') {
                            return [false, data.message]; 		// [success,message,new_id]
                        }
                    },
                    bSubmit      : 'Add',
                    closeAfterAdd: true,
                    closeOnEscape: true,
                    dataheight   : 250,
                    editData     : {
                        object: 'automatic_internal_links',
                        id    : '', // Replace the id added automaticaly by jqGrid.
                        action: 'seopressor_add'
                    },
                    modal        : false,
                    mtype        : 'POST',
                    recreateForm : true,
                    url          : ajaxurl,
                    width        : 425
                });
            });

        $('body').on('click', '.action_edit', function () {
            var selected_row = $('#seopressor-automatic-internal-link-grid').jqGrid('getGridParam', 'selrow');
            if (selected_row != null) {
                $('#seopressor-automatic-internal-link-grid').jqGrid('editGridRow', selected_row, {
                    // Settings for EDIT.
                    // Handler the response from server.
                    afterSubmit     : function (response, postdata) {
                        // Parse the XMLHttpRequest response.
                        var data = $.parseJSON(response.responseText);

                        // It is a notification.
                        if (data.type == 'notification') {
                            return [true, data.message]; 		// [success,message,new_id]
                        } else if (data.type == 'error') {
                            return [false, data.message]; 		// [success,message,new_id]
                        }
                    },
                    bSubmit         : 'Done',
                    checkOnSubmit   : false,
                    closeAfterEdit  : true,
                    closeOnEscape   : true,
                    dataheight      : 250,
                    editCaption     : 'Edit Internal Link',
                    editData        : {
                        object: 'automatic_internal_links', // The id is added automaticaly by jqGrid.
                        action: 'seopressor_add'
                    },
                    modal           : true,
                    mtype           : 'POST',
                    recreateForm    : true,
                    url             : ajaxurl,
                    viewPagerButtons: false,
                    width           : 425
                });
            }
            else {
                /*
                 * Show server message to user.
                 */
                $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Warning" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>Please, select first an <strong>Internal Link</strong>.</p></div>').appendTo('body');
                $('#seopressor-thickbox-dialog-link').trigger('click');
                $('#TB_window').css({
                    'height': 'auto',
                    'left'  : '60%',
                    'top'   : '35%',
                    'width' : '20%'
                });
                $('#TB_ajaxContent').css({
                    'width': '90%'
                });
                $('#TB_ajaxContent p').css({
                    'text-align': 'center'
                });
            }
        });

        $('body').on('click', '.action_delete', function () {
            var selected_row = $('#seopressor-automatic-internal-link-grid').jqGrid('getGridParam', 'selrow');
            if (selected_row != null) {
                $('#seopressor-automatic-internal-link-grid').jqGrid('delGridRow', selected_row, {
                    // Settings for DELETE.
                    addCaption : 'Delete Internal Link',
                    // Handler the response from server.
                    afterSubmit: function (response, postdata) {
                        // Parse the XMLHttpRequest response.
                        var data = $.parseJSON(response.responseText);

                        // It is a notification.
                        if (data.type == 'notification') {
                            return [true, data.message]; 		// [success,message,new_id]
                        } else if (data.type == 'error') {
                            return [false, data.message]; 		// [success,message,new_id]
                        }
                    },
                    bSubmit    : 'Delete',
                    modal      : false,
                    mtype      : 'POST',
                    delData    : {
                        object: 'automatic_internal_links', // The id is added automaticaly by jqGrid.
                        action: 'seopressor_del'
                    },
                    url        : ajaxurl
                });
            }
            else {
                /*
                 * Show server message to user.
                 */
                $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Warning" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>Please, select first an <strong>Internal Link</strong>.</p></div>').appendTo('body');
                $('#seopressor-thickbox-dialog-link').trigger('click');
                $('#TB_window').css({
                    'height': 'auto',
                    'left'  : '60%',
                    'top'   : '35%',
                    'width' : '20%'
                });
                $('#TB_ajaxContent').css({
                    'width': '90%'
                });
                $('#TB_ajaxContent p').css({
                    'text-align': 'center'
                });
            }
        });

        /*
         * Manage Automatic Internal Link Grid Definition.
         */
        var seopressor_automatic_internal_link_grid = $('#seopressor-automatic-internal-link-grid').jqGrid({
            altRows          : false,
            autowidth        : true,
            caption          : '',
            colModel         : [
                {
                    align   : 'center',
                    classes : 'actions_column',
                    index   : 'actions',
                    name    : 'actions',
                    search  : false,
                    sortable: false,
                    width   : 15
                },
                {
                    align         : 'left',
                    classes       : 'keywords_column',
                    editable      : true,
                    editrules     : {
                        required: true
                    },
                    edittype      : 'text',
                    firstsortorder: 'asc',
                    formoptions   : {
                        elmsuffix: ' (*) <br />&nbsp;<em>Separated comma values.</em>'
                    },
                    index         : 'keywords',
                    name          : 'keywords',
                    search        : true,
                    sortable      : true,
                    stype         : 'text',
                    width         : 40
                },
                {
                    align        : 'center',
                    classes      : 'post_id_column',
                    editable     : true,
                    editrules    : {
                        required: true
                    },
                    edittype     : 'select',
                    editoptions  : {
                        dataInit: function (element) {
                            var row_selected = $('#seopressor-automatic-internal-link-grid').jqGrid('getGridParam', 'selrow'),
                                posts = $('#seopressor-automatic-internal-link-grid').jqGrid('getCell', row_selected, 'post_id');

                            if (posts) {
                                for (posts_item in posts.split(', ')) {
                                    $('option:contains(' + posts.split(', ')[posts_item].split('</a>')[0].split('>')[1] + ')', element).attr('selected', 'selected');
                                }
                            }

                            $(element).chosen();
                        },
                        dataUrl : ajaxurl + '?action=seopressor_html_posts_select',
                        multiple: false
                    },
                    formoptions  : {
                        elmsuffix: ' (*)'
                    },
                    index        : 'post_id',
                    name         : 'post_id',
                    search       : 'true',
                    searchoptions: {
                        dataUrl: ajaxurl + '?action=seopressor_html_posts_select'
                    },
                    sortable     : true,
                    stype        : 'text',
                    width        : 60
                },
                {
                    align         : 'right',
                    classes       : 'times_to_link_column',
                    editable      : true,
                    editrules     : {
                        required: true
                    },
                    editoptions   : {
                        defaultValue: 2
                    },
                    edittype      : 'text',
                    firstsortorder: 'asc',
                    formoptions   : {
                        elmsuffix: '&nbsp;<span title="If your keyword appears more than 1 time, how many times should it be linked to the internal post/page?" class="seopressor-icon-info"></span>'
                    },
                    index         : 'times_to_link',
                    name          : 'times_to_link',
                    search        : true,
                    sortable      : true,
                    stype         : 'text',
                    width         : 40
                }
            ],
            colNames         : ['', '<strong>Keywords</strong>', '<strong>Post/Page Title</strong>', '<strong>How many times to link</strong>'],
            datatype         : 'json',
            deselectAfterSort: false,
            emptyrecords     : 'No <strong>Internal Links</strong> found!',
            forceFit         : true,
            gridview         : true, //  If set to true we can not use treeGrid, subGrid, or afterInsertRow event.
            height           : 'auto',
            hoverrows        : true,
            ignoreCase       : true,
            loadui           : 'block',
            mtype            : 'POST',
            pager            : '#seopressor-automatic-internal-link-grid-pager',
            postData         : {
                object: 'automatic_internal_links',
                action: 'seopressor_list'
            },
            prmNames         : {
                sort : 'orderby',
                order: 'orderdir'
            },
            rowList          : [10, 20, 30],
            rowNum           : 10,
            rownumbers       : true,
            sortname         : 'keywords',
            url              : ajaxurl,
            viewrecords      : true
        }).jqGrid('navGrid', '#seopressor-automatic-internal-link-grid-pager', {
                // General navigation parameters.
                edit         : false,
                edittext     : '<strong>Edit</strong>',
                add          : false,
                addtext      : '<strong>Add</strong>',
                del          : false,
                deltext      : '<strong>Delete</strong>',
                search       : false,
                refresh      : false,
                refreshtext  : '<strong>Refresh</strong>',
                view         : false,
                closeOnEscape: true,
                refreshstate : 'current'
            }, {
                // Settings for EDIT.
                // Handler the response from server.
                afterSubmit     : function (response, postdata) {
                    // Parse the XMLHttpRequest response.
                    var data = $.parseJSON(response.responseText);

                    // It is a notification.
                    if (data.type == 'notification') {
                        return [true, data.message]; 		// [success,message,new_id]
                    } else if (data.type == 'error') {
                        return [false, data.message]; 		// [success,message,new_id]
                    }
                },
                bSubmit         : 'Done',
                checkOnSubmit   : true,
                closeAfterEdit  : true,
                closeOnEscape   : true,
                dataheight      : 250,
                editCaption     : 'Edit Internal Link',
                editData        : {
                    object: 'automatic_internal_links', // The id is added automaticaly by jqGrid.
                    action: 'seopressor_add'
                },
                modal           : true,
                mtype           : 'POST',
                recreateForm    : true,
                url             : ajaxurl,
                viewPagerButtons: false,
                width           : 425
            }, {
                // Settings for ADD.
                addCaption   : 'Add Internal Link',
                addedrow     : 'last',
                // Handler the response from server.
                afterSubmit  : function (response, postdata) {
                    // Parse the XMLHttpRequest response.
                    var data = $.parseJSON(response.responseText);

                    // It is a notification.
                    if (data.type == 'notification') {
                        return [true, data.message]; 		// [success,message,new_id]
                    } else if (data.type == 'error') {
                        return [false, data.message]; 		// [success,message,new_id]
                    }
                },
                bSubmit      : 'Add',
                closeAfterAdd: true,
                closeOnEscape: true,
                dataheight   : 250,
                editData     : {
                    object: 'automatic_internal_links',
                    id    : '', // Replace the id added automaticaly by jqGrid.
                    action: 'seopressor_add'
                },
                modal        : false,
                mtype        : 'POST',
                recreateForm : true,
                url          : ajaxurl,
                width        : 425
            }, {
                // Settings for DELETE.
                addCaption : 'Delete Internal Link',
                // Handler the response from server.
                afterSubmit: function (response, postdata) {
                    // Parse the XMLHttpRequest response.
                    var data = $.parseJSON(response.responseText);

                    // It is a notification.
                    if (data.type == 'notification') {
                        return [true, data.message]; 		// [success,message,new_id]
                    } else if (data.type == 'error') {
                        return [false, data.message]; 		// [success,message,new_id]
                    }
                },
                bSubmit    : 'Delete',
                modal      : false,
                mtype      : 'POST',
                delData    : {
                    object: 'automatic_internal_links', // The id is added automaticaly by jqGrid.
                    action: 'seopressor_del'
                },
                url        : ajaxurl
            }, {
            }, {}, {});

        $('#seopressor-automatic-internal-link-grid').jqGrid('filterToolbar', {
            searchOnEnter: false
        });
    }
};

seop_jquery(SEOPressor_internal_link);

//To be sure that seopressor code will be executed even when other code generate an exception
SEOPressor_internal_link_triggered = false;

function OnErrorResponse(){
    if (document.readyState==="interactive" && !SEOPressor_internal_link_triggered) SEOPressor_internal_link(seop_jquery);
    //document.readyState==="interactive" means that DOM is ready to interact with it
    //This check is useful to exclude the errors fired before DOMContentLoaded event
}

if (window.addEventListener) window.addEventListener('error', OnErrorResponse);
else window.attachEvent('onerror', OnErrorResponse);