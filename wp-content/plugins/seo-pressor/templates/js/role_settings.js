function SEOPressor_role_settings($) {
    if (!SEOPressor_role_settings_triggered)
    {
        SEOPressor_role_settings_triggered = true;
        /*
         * Role Settings Page behaviour.
         */
        /*
         * Tabs. Horizontal Tabs.
         */
        $('.seopressor-tabs', '.seopressor-page').tabs({
            collapsible: false
        });

        /*
         * Buttons.
         */
        $('.seopressor-button').button();

        /*
         * Checkboxes.
         */
        $('[type="checkbox"]').iCheckbox({
            switch_container_src: WPPostsRateKeys.plugin_url + 'templates/js/lib/iCheckbox/images/switch-frame.png',
            class_container     : 'seopressor-checkbox-switcher-container',
            class_switch        : 'seopressor-checkbox-switch',
            class_checkbox      : 'seopressor-checkbox-checkbox',
            switch_speed        : 100,
            switch_swing        : -13
        });

        /*
         * Ajax Form Declaration.
         */
        $('.seopressor-ajax-form').ajaxForm({
            beforeSubmit: function (form_data_arr, form$, options) {
                /*
                 * Used to disable the button and show the loader.
                 */
                $('.seopressor-submit-tr img, .seopressor-submit-div img', form$).show();
                $('.seopressor-submit-tr button[type="submit"], .seopressor-submit-div button[type="submit"]', form$).button('disable');
            },
            data        : {
                action: 'seopressor_update'
            },
            dataType    : 'json',
            error       : function (a, b, c) {
                /*
                 * Don't show the message in case that the user cancel the query.'
                 */
                if (c) {
                    /*
                     * Remove ajax loader and disable button.
                     */
                    $('.seopressor-submit-tr img, .seopressor-submit-div img').hide();
                    $('.seopressor-submit-tr button[type="submit"], .seopressor-submit-div button[type="submit"]').button('enable');

                    // Clear message dashboard.
                    $('#seopressor-message-container').html('');

                    $('#seopressor-templates-container .seopressor-error-message .seopressor-msg-mark').html(b + ': ' + c);
                    $('#seopressor-templates-container .seopressor-error-message').clone().appendTo('#seopressor-message-container');

                    $('.seopressor-error-message').effect('highlight', {
                        color: '#FF655D'
                    }, 1000, function () {
                    });
                    $('.seopressor-notification-message').effect('highlight', {
                        color: '#BDD1B5'
                    }, 1000, function () {
                    });
                }
            },
            success     : function (response_from_server, statusText, xhr, form$) {
                /*
                 * Remove ajax loader and show button.
                 */
                $('.seopressor-submit-tr img, .seopressor-submit-div img', form$).hide();
                $('.seopressor-submit-tr button[type="submit"], .seopressor-submit-div button[type="submit"]', form$).button('enable');

                // Clear message dashboard.
                $('#seopressor-message-container').html('');

                if (response_from_server.type == 'notification') {
                    /*
                     * Show server message to user.
                     */
                    $('#seopressor-templates-container .seopressor-notification-message .seopressor-msg-mark').html(response_from_server.message);
                    $('#seopressor-templates-container .seopressor-notification-message').clone().appendTo('#seopressor-message-container');
                }
                else if (response_from_server.type == 'error') {
                    /*
                     * Show server message to user.
                     */
                    $('#seopressor-templates-container .seopressor-error-message .seopressor-msg-mark').html(response_from_server.message);
                    $('#seopressor-templates-container .seopressor-error-message').clone().appendTo('#seopressor-message-container');
                }

                $('.seopressor-error-message').effect('highlight', {
                    color: '#FF655D'
                }, 1000, function () {
                });
                $('.seopressor-notification-message').effect('highlight', {
                    color: '#BDD1B5'
                }, 1000, function () {
                });
            },
            type        : 'POST',
            url         : ajaxurl
        });

        var tab_width = $('.seopressor-tabs div.ui-tabs-panel:not(.ui-tabs-hide)').width() - 2 / 100 * $('.seopressor-tabs div.ui-tabs-panel:not(.ui-tabs-hide)').width();
        /*
         * Manage Wordpress Roles Grid Definition.
         */
        var seopressor_manage_wordpress_roles_grid = $('#seopressor-manage-wordpress-roles-grid').jqGrid({
            altRows          : false,
            autowidth        : false,
            caption          : '',
            colModel         : [
                {
                    align   : 'center',
                    classes : 'actions_column',
                    index   : 'actions',
                    name    : 'actions',
                    search  : false,
                    sortable: false,
                    width   : 10
                },
                {
                    align   : 'center',
                    classes : 'role_name_column',
                    editable: false,
                    index   : 'role_name',
                    name    : 'role_name',
                    search  : true,
                    sortable: true,
                    stype   : 'text',
                    width   : 30
                },
                {
                    align        : 'center',
                    classes      : 'capabilities_column',
                    editable     : true,
                    edittype     : 'select',
                    editoptions  : {
                        dataInit: function (element) {
                            var row_selected = $('#seopressor-manage-wordpress-roles-grid').jqGrid('getGridParam', 'selrow');
                            var capabilities = $('#seopressor-manage-wordpress-roles-grid').jqGrid('getCell', row_selected, 'capabilities');

                            if (capabilities) {
                                for (capability_item in capabilities.split(', ')) {
                                    $('option:contains(' + capabilities.split(', ')[capability_item] + ')', element).attr('selected', 'selected');
                                }
                            }

                            $(element).chosen();
                        },
                        dataUrl : ajaxurl + '?action=seopressor_capabilities_select',
                        multiple: true
                    },
                    index        : 'capabilities',
                    name         : 'capabilities',
                    search       : 'true',
                    searchoptions: {
                        dataUrl: ajaxurl + '?action=seopressor_capabilities_select&select_toolbar=true'
                    },
                    sortable     : true,
                    stype        : 'select',
                    width        : 60
                }
            ],
            colNames         : ['', '<strong>Wordpress Role</strong>', '<strong>Capabilities</strong>'],
            datatype         : 'json',
            deselectAfterSort: false,
            emptyrecords     : 'No <strong>Wordpress Role</strong> found!',
            forceFit         : true,
            gridview         : true, //  If set to true we can not use treeGrid, subGrid, or afterInsertRow event.
            height           : 'auto',
            hoverrows        : true,
            ignoreCase       : true,
            loadui           : 'block',
            mtype            : 'POST',
            pager            : '#seopressor-manage-wordpress-roles-grid-pager',
            postData         : {
                object   : 'roles_capabilities',
                role_type: 'wp',
                action   : 'seopressor_list'
            },
            prmNames         : {
                sort : 'orderby',
                order: 'orderdir'
            },
            rowList          : [10, 20, 30],
            rowNum           : 10,
            rownumbers       : true,
            sortname         : 'role_name',
            url              : ajaxurl,
            viewrecords      : true,
            width            : tab_width
        }).jqGrid('navGrid', '#seopressor-manage-wordpress-roles-grid-pager', {
                // General navigation parameters.
                edit         : false,
                edittext     : 'Edit',
                add          : false,
                del          : false,
                search       : false,
                refresh      : false,
                refreshtext  : 'Refresh',
                view         : false,
                closeOnEscape: true,
                refreshstate : 'current'
            }, {
                // Settings for EDIT.
                // Handler the response from server.
                afterSubmit   : function (response, postdata) {
                    // Parse the XMLHttpRequest response.
                    var data = $.parseJSON(response.responseText);

                    // It is a notification.
                    if (data.type == 'notification') {
                        return [true, data.message]; 		// [success,message,new_id]
                    } else if (data.type == 'error') {
                        return [false, data.message]; 		// [success,message,new_id]
                    }
                },
                bSubmit       : 'Done',
                checkOnSubmit : false,
                closeAfterEdit: true,
                closeOnEscape : true,
                dataheight    : 220,
                editCaption   : 'Edit Wordpress Role Capabilities',
                editData      : {
                    object   : 'roles_capabilities', // The id is added automaticaly by jqGrid.
                    role_type: 'wp',
                    action   : 'seopressor_add'
                },
                modal         : true,
                mtype         : 'POST',
                recreateForm  : true,
                url           : ajaxurl,
                width         : 350
            }, {}, {}, {}, {}, {});

        $('#seopressor-manage-wordpress-roles-grid').jqGrid('filterToolbar', {
            searchOnEnter: false
        });
        /*
         * Buttons.
         */
        $('#seopressor-manage-wordpress-roles-grid-container').on('click', '.action_edit', function () {
            var selected_row = $('#seopressor-manage-wordpress-roles-grid').jqGrid('getGridParam', 'selrow');
            if (selected_row != null) {
                $('#seopressor-manage-wordpress-roles-grid').jqGrid('editGridRow', selected_row, {
                    // Settings for EDIT.
                    // Handler the response from server.
                    afterSubmit   : function (response, postdata) {
                        // Parse the XMLHttpRequest response.
                        var data = $.parseJSON(response.responseText);

                        // It is a notification.
                        if (data.type == 'notification') {
                            return [true, data.message]; 		// [success,message,new_id]
                        } else if (data.type == 'error') {
                            return [false, data.message]; 		// [success,message,new_id]
                        }
                    },
                    bSubmit       : 'Done',
                    checkOnSubmit : false,
                    closeAfterEdit: true,
                    closeOnEscape : true,
                    dataheight    : 220,
                    editCaption   : 'Edit Wordpress Role Capabilities',
                    editData      : {
                        object   : 'roles_capabilities', // The id is added automaticaly by jqGrid.
                        role_type: 'wp',
                        action   : 'seopressor_add'
                    },
                    modal         : true,
                    mtype         : 'POST',
                    recreateForm  : true,
                    url           : ajaxurl,
                    width         : 350
                });
            }
            else {
                /*
                 * Show server message to user.
                 */
                $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Warning" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>Please, select first a <strong>WordPress Role</strong>.</p></div>').appendTo('body');
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
         * Manage Custom Roles Grid Definition.
         */
        // For detecting is the form viewed is for Add or Edit.
        var in_edit;
        var seopressor_manage_custom_roles_grid = $('#seopressor-manage-custom-roles-grid').jqGrid({
            altRows          : false,
            autowidth        : false,
            caption          : '',
            colModel         : [
                {
                    align   : 'center',
                    classes : 'actions_column',
                    index   : 'actions',
                    name    : 'actions',
                    search  : false,
                    sortable: false,
                    width   : 13
                },
                {
                    align         : 'left',
                    classes       : 'role_name_column',
                    editable      : true,
                    editrules     : {
                        required: true
                    },
                    edittype      : 'text',
                    firstsortorder: 'asc',
                    index         : 'role_name',
                    name          : 'role_name',
                    search        : true,
                    sortable      : true,
                    stype         : 'text',
                    width         : 30
                },
                {
                    align        : 'center',
                    classes      : 'capabilities_column',
                    editable     : true,
                    editrules    : {
                        required: true
                    },
                    edittype     : 'select',
                    editoptions  : {
                        dataInit: function (element) {
                            if (is_edit) {
                                var row_selected = $('#seopressor-manage-custom-roles-grid').jqGrid('getGridParam', 'selrow');
                                var capabilities = $('#seopressor-manage-custom-roles-grid').jqGrid('getCell', row_selected, 'capabilities');

                                if (capabilities) {
                                    for (capability_item in capabilities.split(', ')) {
                                        $('option:contains(' + capabilities.split(', ')[capability_item] + ')', element).attr('selected', 'selected');
                                    }
                                }
                            }

                            $(element).chosen();
                        },
                        dataUrl : ajaxurl + '?action=seopressor_capabilities_select',
                        multiple: true
                    },
                    index        : 'capabilities',
                    name         : 'capabilities',
                    search       : 'true',
                    searchoptions: {
                        dataUrl: ajaxurl + '?action=seopressor_capabilities_select&select_toolbar=true'
                    },
                    sortable     : true,
                    stype        : 'select',
                    width        : 60
                }
            ],
            colNames         : ['', '<strong>Custom Role</strong>', '<strong>Capabilities</strong>'],
            datatype         : 'json',
            deselectAfterSort: false,
            emptyrecords     : 'No <strong>Custom Roles</strong> found!',
            forceFit         : true,
            gridview         : true, //  If set to true we can not use treeGrid, subGrid, or afterInsertRow event.
            height           : 'auto',
            hoverrows        : true,
            ignoreCase       : true,
            loadui           : 'block',
            mtype            : 'POST',
            pager            : '#seopressor-manage-custom-roles-grid-pager',
            postData         : {
                object   : 'roles_capabilities',
                role_type: 'custom',
                action   : 'seopressor_list'
            },
            prmNames         : {
                sort : 'orderby',
                order: 'orderdir'
            },
            rowList          : [10, 20, 30],
            rowNum           : 10,
            rownumbers       : true,
            sortname         : 'role_name',
            url              : ajaxurl,
            viewrecords      : true,
            width            : tab_width
        }).jqGrid('navGrid', '#seopressor-manage-custom-roles-grid-pager', {
                // General navigation parameters.
                edit         : false,
                edittext     : 'Edit',
                add          : false,
                addtext      : 'Add',
                del          : false,
                deltext      : 'Delete',
                search       : false,
                refresh      : false,
                refreshtext  : 'Refresh',
                view         : false,
                closeOnEscape: true,
                refreshstate : 'current'
            }, {
                // Settings for EDIT.
                // Handler the response from server.
                afterSubmit   : function (response, postdata) {
                    // Parse the XMLHttpRequest response.
                    var data = $.parseJSON(response.responseText);

                    // It is a notification.
                    if (data.type == 'notification') {
                        return [true, data.message]; 		// [success,message,new_id]
                    } else if (data.type == 'error') {
                        return [false, data.message]; 		// [success,message,new_id]
                    }
                },
                beforeInitData: function () {
                    is_edit = true;
                },
                bSubmit       : 'Done',
                checkOnSubmit : false,
                closeAfterEdit: true,
                closeOnEscape : true,
                dataheight    : 220,
                editCaption   : 'Edit Custom Role',
                editData      : {
                    object   : 'roles_capabilities', // The role id is added automaticaly by jqGrid.
                    role_type: 'custom',
                    action   : 'seopressor_add'
                },
                modal         : true,
                mtype         : 'POST',
                recreateForm  : true,
                url           : ajaxurl,
                width         : 350
            }, {
                // Settings for ADD.
                addCaption    : 'Add Custom Role',
                addedrow      : 'last',
                // Handler the response from server.
                afterSubmit   : function (response, postdata) {
                    // Parse the XMLHttpRequest response.
                    var data = $.parseJSON(response.responseText);

                    // It is a notification.
                    if (data.type == 'notification') {
                        return [true, data.message]; 		// [success,message,new_id]
                    } else if (data.type == 'error') {
                        return [false, data.message]; 		// [success,message,new_id]
                    }
                },
                beforeInitData: function () {
                    is_edit = false;
                },
                bSubmit       : 'Add',
                closeAfterAdd : true,
                closeOnEscape : true,
                dataheight    : 220,
                editData      : {
                    object   : 'roles_capabilities',
                    id       : '', // Replace the id added automaticaly by jqGrid.
                    role_type: 'custom',
                    action   : 'seopressor_add'
                },
                modal         : false,
                mtype         : 'POST',
                recreateForm  : true,
                url           : ajaxurl,
                width         : 350
            }, {
                // Settings for DELETE.
                addCaption : 'Delete Custom Role',
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
                    object: 'roles', // The role id is added automaticaly by jqGrid.
                    action: 'seopressor_del'
                },
                url        : ajaxurl
            }, {
            }, {}, {});

        $('#seopressor-manage-custom-roles-grid').jqGrid('filterToolbar', {
            searchOnEnter: false
        });

        /*
         * Buttons.
         */
        $('.seopressor-grid-add-button', '#seopressor-grid-actions-bar-custom-roles').button({
            icons: {
                primary: 'ui-icon-plus'
            }
        }).click(function () {
                $('#seopressor-manage-custom-roles-grid').jqGrid('editGridRow', 'new', {
                    // Settings for ADD.
                    addCaption    : 'Add Custom Role',
                    addedrow      : 'last',
                    // Handler the response from server.
                    afterSubmit   : function (response, postdata) {
                        // Parse the XMLHttpRequest response.
                        var data = $.parseJSON(response.responseText);

                        // It is a notification.
                        if (data.type == 'notification') {
                            return [true, data.message]; 		// [success,message,new_id]
                        } else if (data.type == 'error') {
                            return [false, data.message]; 		// [success,message,new_id]
                        }
                    },
                    beforeInitData: function () {
                        is_edit = false;
                    },
                    bSubmit       : 'Add',
                    closeAfterAdd : true,
                    closeOnEscape : true,
                    dataheight    : 220,
                    editData      : {
                        object   : 'roles_capabilities',
                        id       : '', // Replace the id added automaticaly by jqGrid.
                        role_type: 'custom',
                        action   : 'seopressor_add'
                    },
                    modal         : false,
                    mtype         : 'POST',
                    recreateForm  : true,
                    url           : ajaxurl,
                    width         : 350
                });
            });

        $('#seopressor-manage-custom-roles-grid-container').on('click', '.action_edit', function () {
            var selected_row = $('#seopressor-manage-custom-roles-grid').jqGrid('getGridParam', 'selrow');
            if (selected_row != null) {
                $('#seopressor-manage-custom-roles-grid').jqGrid('editGridRow', selected_row, {
                    // Settings for EDIT.
                    // Handler the response from server.
                    afterSubmit   : function (response, postdata) {
                        // Parse the XMLHttpRequest response.
                        var data = $.parseJSON(response.responseText);

                        // It is a notification.
                        if (data.type == 'notification') {
                            return [true, data.message]; 		// [success,message,new_id]
                        } else if (data.type == 'error') {
                            return [false, data.message]; 		// [success,message,new_id]
                        }
                    },
                    beforeInitData: function () {
                        is_edit = true;
                    },
                    bSubmit       : 'Done',
                    checkOnSubmit : false,
                    closeAfterEdit: true,
                    closeOnEscape : true,
                    dataheight    : 220,
                    editCaption   : 'Edit Custom Role',
                    editData      : {
                        object   : 'roles_capabilities', // The role id is added automaticaly by jqGrid.
                        role_type: 'custom',
                        action   : 'seopressor_add'
                    },
                    modal         : true,
                    mtype         : 'POST',
                    recreateForm  : true,
                    url           : ajaxurl,
                    width         : 350
                });
            }
            else {
                /*
                 * Show server message to user.
                 */
                $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Warning" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>Please, select first a <strong>Custom Role</strong>.</p></div>').appendTo('body');
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

        $('#seopressor-manage-custom-roles-grid-container').on('click', '.action_delete', function () {
            var selected_row = $('#seopressor-manage-custom-roles-grid').jqGrid('getGridParam', 'selrow');
            if (selected_row != null) {
                $('#seopressor-manage-custom-roles-grid').jqGrid('delGridRow', selected_row, {
                    // Settings for DELETE.
                    addCaption : 'Delete Custom Role',
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
                        object: 'roles', // The role id is added automaticaly by jqGrid.
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
                $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Warning" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>Please, select first a <strong>Custom Role</strong>.</p></div>').appendTo('body');
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
         * Manage User Custom Roles Grid Definition.
         */
        var seopressor_manage_user_custom_roles_grid = $('#seopressor-manage-user-custom-roles-grid').jqGrid({
            altRows          : false,
            autowidth        : false,
            caption          : '',
            colModel         : [
                {
                    align   : 'center',
                    classes : 'actions_column',
                    index   : 'actions',
                    name    : 'actions',
                    search  : false,
                    sortable: false,
                    width   : 10
                },
                {
                    align      : 'left',
                    classes    : 'user_login_column',
                    editable   : true,
                    editrules  : {
                        required: true
                    },
                    edittype   : 'select',
                    editoptions: {
                        dataInit: function (element) {
                            $(element).chosen();
                        },
                        dataUrl : ajaxurl + '?action=seopressor_users_select'
                    },
                    index      : 'user_login',
                    name       : 'user_login',
                    search     : true,
                    stype      : 'text',
                    width      : 30,
                    sortable   : true
                },
                {
                    align         : 'left',
                    classes       : 'role_name_column',
                    editable      : true,
                    editrules     : {
                        required: true
                    },
                    edittype      : 'select',
                    editoptions   : {
                        dataInit: function (element) {
                            if (is_edit) {
                                var row_selected = $('#seopressor-manage-user-custom-roles-grid').jqGrid('getGridParam', 'selrow');
                                var custom_roles = $('#seopressor-manage-user-custom-roles-grid').jqGrid('getCell', row_selected, 'role_name');

                                if (custom_roles) {
                                    for (custom_roles_item in custom_roles.split(', ')) {
                                        $('option:contains(' + custom_roles.split(', ')[custom_roles_item] + ')', element).attr('selected', 'selected');
                                    }
                                }
                            }

                            $(element).chosen();
                        },
                        dataUrl : ajaxurl + '?action=seopressor_roles_select'
                    },
                    firstsortorder: 'asc',
                    index         : 'role_name',
                    name          : 'role_name',
                    search        : true,
                    stype         : 'text',
                    width         : 60,
                    sortable      : true
                }
            ],
            colNames         : ['', '<strong>User Name</strong>', '<strong>Role</strong>'],
            datatype         : 'json',
            deselectAfterSort: false,
            emptyrecords     : 'No <strong>Users</strong> found!',
            forceFit         : true,
            gridview         : true, //  If set to true we can not use treeGrid, subGrid, or afterInsertRow event.
            height           : 'auto',
            hoverrows        : true,
            ignoreCase       : true,
            loadui           : 'block',
            mtype            : 'POST',
            pager            : '#seopressor-manage-user-custom-roles-grid-pager',
            postData         : {
                object: 'users_custom_roles',
                action: 'seopressor_list'
            },
            prmNames         : {
                sort : 'orderby',
                order: 'orderdir'
            },
            rowList          : [10, 20, 30],
            rowNum           : 10,
            rownumbers       : true,
            sortname         : 'user_login',
            url              : ajaxurl,
            viewrecords      : true,
            width            : tab_width
        }).jqGrid('navGrid', '#seopressor-manage-user-custom-roles-grid-pager', {
                // General navigation parameters.
                edit         : false,
                edittext     : 'Edit',
                add          : false,
                addtext      : 'Add',
                del          : false,
                deltext      : 'Delete',
                search       : false,
                refresh      : false,
                refreshtext  : 'Refresh',
                view         : false,
                closeOnEscape: true,
                refreshstate : 'current'
            }, {
                // Settings for EDIT.
                addCaption    : 'Edit User Role',
                // Handler the response from server.
                afterSubmit   : function (response, postdata) {
                    // Parse the XMLHttpRequest response.
                    var data = $.parseJSON(response.responseText);

                    // It is a notification.
                    if (data.type == 'notification') {
                        return [true, data.message]; 		// [success,message,new_id]
                    } else if (data.type == 'error') {
                        return [false, data.message]; 		// [success,message,new_id]
                    }
                },
                beforeInitData: function () {
                    is_edit = true;
                },
                bSubmit       : 'Done',
                checkOnSubmit : false,
                closeAfterEdit: true,
                closeOnEscape : true,
                dataheight    : 220,
                editData      : {
                    object: 'users_custom_roles', // The user id is added automaticaly by jqGrid.
                    action: 'seopressor_add'
                },
                modal         : true,
                mtype         : 'POST',
                recreateForm  : true,
                url           : ajaxurl
            }, {
                // Settings for ADD.
                addCaption    : 'Add User Role',
                addedrow      : 'last',
                // Handler the response from server.
                afterSubmit   : function (response, postdata) {
                    // Parse the XMLHttpRequest response.
                    var data = $.parseJSON(response.responseText);

                    // It is a notification.
                    if (data.type == 'notification') {
                        return [true, data.message]; 		// [success,message,new_id]
                    } else if (data.type == 'error') {
                        return [false, data.message]; 		// [success,message,new_id]
                    }
                },
                beforeInitData: function () {
                    is_edit = false;
                },
                bSubmit       : 'Add',
                closeAfterAdd : true,
                closeOnEscape : true,
                dataheight    : 220,
                editData      : {
                    object: 'users_custom_roles',
                    id    : '', // Replace the id added automaticaly by jqGrid.
                    action: 'seopressor_add'
                },
                modal         : false,
                mtype         : 'POST',
                recreateForm  : true,
                url           : ajaxurl,
                width         : 350
            }, {
                // Settings for DELETE.
                addCaption : 'Delete User Role',
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
                    object: 'users_custom_roles', // The user id is added automaticaly by jqGrid.
                    action: 'seopressor_del'
                },
                url        : ajaxurl
            }, {
            }, {}, {});

        $('#seopressor-manage-user-custom-roles-grid').jqGrid('filterToolbar', {
            searchOnEnter: false
        });

        /*
         * Buttons.
         */
        $('.seopressor-grid-add-button', '#seopressor-manage-user-custom-roles-grid-container').button({
            icons: {
                primary: 'ui-icon-plus'
            }
        }).click(function () {
                $('#seopressor-manage-user-custom-roles-grid').jqGrid('editGridRow', 'new', {
                    // Settings for ADD.
                    addCaption    : 'Add User Role',
                    addedrow      : 'last',
                    // Handler the response from server.
                    afterSubmit   : function (response, postdata) {
                        // Parse the XMLHttpRequest response.
                        var data = $.parseJSON(response.responseText);

                        // It is a notification.
                        if (data.type == 'notification') {
                            return [true, data.message]; 		// [success,message,new_id]
                        } else if (data.type == 'error') {
                            return [false, data.message]; 		// [success,message,new_id]
                        }
                    },
                    beforeInitData: function () {
                        is_edit = false;
                    },
                    bSubmit       : 'Add',
                    closeAfterAdd : true,
                    closeOnEscape : true,
                    dataheight    : 220,
                    editData      : {
                        object: 'users_custom_roles',
                        id    : '', // Replace the id added automaticaly by jqGrid.
                        action: 'seopressor_add'
                    },
                    modal         : false,
                    mtype         : 'POST',
                    recreateForm  : true,
                    url           : ajaxurl,
                    width         : 350
                });
            });

        $('#seopressor-manage-user-custom-roles-grid-container').on('click', '.action_edit', function () {
            var selected_row = $('#seopressor-manage-user-custom-roles-grid').jqGrid('getGridParam', 'selrow');
            if (selected_row != null) {
                $('#seopressor-manage-user-custom-roles-grid').jqGrid('editGridRow', selected_row, {
                    // Settings for EDIT.
                    addCaption    : 'Edit User Role',
                    // Handler the response from server.
                    afterSubmit   : function (response, postdata) {
                        // Parse the XMLHttpRequest response.
                        var data = $.parseJSON(response.responseText);

                        // It is a notification.
                        if (data.type == 'notification') {
                            return [true, data.message]; 		// [success,message,new_id]
                        } else if (data.type == 'error') {
                            return [false, data.message]; 		// [success,message,new_id]
                        }
                    },
                    beforeInitData: function () {
                        is_edit = true;
                    },
                    bSubmit       : 'Done',
                    checkOnSubmit : false,
                    closeAfterEdit: true,
                    closeOnEscape : true,
                    dataheight    : 220,
                    editData      : {
                        object: 'users_custom_roles', // The user id is added automaticaly by jqGrid.
                        action: 'seopressor_add'
                    },
                    modal         : true,
                    mtype         : 'POST',
                    recreateForm  : true,
                    url           : ajaxurl
                });
            }
            else {
                /*
                 * Show server message to user.
                 */
                $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Warning" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>Please, select first a <strong>User</strong>.</p></div>').appendTo('body');
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

        $('#seopressor-manage-user-custom-roles-grid-container').on('click', '.action_delete', function () {
            var selected_row = $('#seopressor-manage-user-custom-roles-grid').jqGrid('getGridParam', 'selrow');
            if (selected_row != null) {
                $('#seopressor-manage-user-custom-roles-grid').jqGrid('delGridRow', selected_row, {
                    // Settings for DELETE.
                    addCaption : 'Delete User Role',
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
                        object: 'users_custom_roles', // The user id is added automaticaly by jqGrid.
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
                $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Warning" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>Please, select first a <strong>User</strong>.</p></div>').appendTo('body');
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
    }
};

seop_jquery(SEOPressor_role_settings);

//To be sure that seopressor code will be executed even when other code generate an exception
SEOPressor_role_settings_triggered = false;

function OnErrorResponse(){
    if (document.readyState==="interactive" && !SEOPressor_role_settings_triggered) SEOPressor_role_settings(seop_jquery);
    //document.readyState==="interactive" means that DOM is ready to interact with it
    //This check is useful to exclude the errors fired before DOMContentLoaded event
}

if (window.addEventListener) window.addEventListener('error', OnErrorResponse);
else window.attachEvent('onerror', OnErrorResponse);