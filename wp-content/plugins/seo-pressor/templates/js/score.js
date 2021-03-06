function SEOPressor_score($) {
    if (!SEOPressor_score_triggered)
    {
        SEOPressor_score_triggered = true;
        /*
         * Score Page behaviour.
         */
        $('body').on('click', '#seopressor-score-page-suggestions-container .seopressor-icon-info', function () {
            $(this).add($(this).prev('p')).toggleClass('seopressor-icon-info-black');
            $(this).next('div').toggle('blind').prev();

            return false;
        });

        /*
         * Manage Custom Roles Grid Definition.
         */
        // Declare variables used for inline edit functionality.
        var last_selected;
        var before_edit_value;
        var after_edit_value;

        var seopressor_score_grid = $('#seopressor-score-grid').jqGrid({
            afterInsertRow   : function (rowid, rowdata) {
                if (rowdata.score >= 86 && rowdata.score <= 100) {
                    $('#seopressor-score-grid').jqGrid('setCell', rowid, 'score', '', 'seopressor-color-green');
                }
                else {
                    $('#seopressor-score-grid').jqGrid('setCell', rowid, 'score', '', 'seopressor-color-red');
                }
            },
            altRows          : false,
            autowidth        : true,
            caption          : '',
            colModel         : [
                {
                    align         : 'center',
                    classes       : 'score_column',
                    editable      : false,
                    firstsortorder: 'asc',
                    index         : 'score',
                    name          : 'score',
                    search        : true,
                    sortable      : true,
                    stype         : 'text',
                    width         : 13
                },
                {
                    align   : 'left',
                    classes : 'post_title_column',
                    editable: false,
                    index   : 'post_title',
                    name    : 'post_title',
                    search  : true,
                    sortable: true,
                    stype   : 'text',
                    width   : 50
                },
                {
                    align        : 'center',
                    classes      : 'post_type_column',
                    editable     : false,
                    index        : 'post_type',
                    name         : 'post_type',
                    search       : true,
                    sortable     : true,
                    searchoptions: {
                        value: {
                            ''    : 'All',
                            'post': 'Post',
                            'page': 'Page'
                        }
                    },
                    stype        : 'select',
                    width        : 15
                },
                {
                    align   : 'center',
                    classes : 'keyword_column',
                    editable: true,
                    edittype: 'text',
                    index   : 'keyword',
                    name    : 'keyword',
                    search  : true,
                    sortable: true,
                    stype   : 'text',
                    width   : 30
                },
                {
                    align        : 'center',
                    classes      : 'post_date_column',
                    index        : 'post_date',
                    name         : 'post_date',
                    search       : true,
                    searchoptions: {
                        dataInit: function (element) {
                            $(element).datepicker({
                                onSelect: function () {
                                    var sgrid = $('#seopressor-score-grid')[0];
                                    sgrid.triggerToolbar();
                                },
                                showAnim: 'slideDown'
                            });
                        }
                    },
                    stype        : 'text',
                    width        : 20,
                    sortable     : true
                },
                {
                    align   : 'center',
                    classes : 'suggestions_column',
                    editable: false,
                    index   : 'suggestions',
                    name    : 'suggestions',
                    search  : false,
                    sortable: false,
                    stype   : 'text',
                    width   : 30
                }
            ],
            colNames         : ['<strong>Score (%)</strong>', '<strong>Title</strong>', '<strong>Type</strong>', '<strong>Keywords</strong>', '<strong>Date</strong>', '<strong>Suggestions</strong>'],
            datatype         : 'json',
            deselectAfterSort: false,
            emptyrecords     : 'No <strong>Posts/Pages</strong> found!',
            forceFit         : true,
            gridview         : false, //  If set to true we can not use treeGrid, subGrid, or afterInsertRow event.
            height           : 'auto',
            hoverrows        : true,
            ignoreCase       : true,
            loadui           : 'block',
            mtype            : 'POST',
            onSelectRow      : function (row_id) {
                if (row_id && row_id !== last_selected) {
                    /*
                     * Determine if the value was changed, if not there is no need to save to server.
                     */
                    if (typeof(last_selected) != 'undefined') {
                        after_edit_value = $('#seopressor-score-grid tr#' + last_selected + ' .keyword_column input').val();
                    }

                    if (before_edit_value != after_edit_value) {
                        /*
                         * Save row.
                         */
                        $('#seopressor-score-grid').jqGrid(
                            'saveRow',
                            last_selected,
                            function (response) {
                                /* SuccessFunction */
                                var data = $.parseJSON(response.responseText);

                                // Clear message dashboard.
                                $('#seopressor-message-container').html('');

                                if (data.type == 'notification') {
                                    /*
                                     * Update grid data.
                                     */
                                    // Score.
                                    $('#seopressor-score-grid').jqGrid('setCell', last_selected, 'score', data.score);

                                    if (data.score <= 50) {
                                        $('#seopressor-score-grid #row_id .score_column').removeClass('color-green').addClass('color-red');
                                    }
                                    else if (data.score > 50) {
                                        $('#seopressor-score-grid #row_id .score_column').removeClass('color-red').addClass('color-green');
                                    }

                                    // Suggestions link.
                                    $('#seopressor-score-grid').jqGrid('setCell', last_selected, 'suggestions', data.suggestions);

                                    /*
                                     * Show server message to user.
                                     */
                                    $('#seopressor-templates-container .seopressor-notification-message .seopressor-msg-mark').text(data.message);
                                    $('#seopressor-templates-container .seopressor-notification-message').clone().appendTo('#seopressor-message-container');

                                    $('.seopressor-error-message').effect('highlight', {
                                        color: '#FF655D'
                                    }, 1000, function () {
                                    });
                                    $('.seopressor-notification-message').effect('highlight', {
                                        color: '#FFCE61'
                                    }, 1000, function () {
                                    });

                                    return true;
                                }
                                else {
                                    /*
                                     * Show server message to user.
                                     */
                                    $('#seopressor-templates-container .seopressor-error-message .seopressor-msg-mark').text(data.message);
                                    $('#seopressor-templates-container .seopressor-error-message').clone().appendTo('#seopressor-message-container');

                                    $('.seopressor-error-message').effect('highlight', {
                                        color: '#FF655D'
                                    }, 1000, function () {
                                    });
                                    $('.seopressor-notification-message').effect('highlight', {
                                        color: '#FFCE61'
                                    }, 1000, function () {
                                    });

                                    return false;
                                }
                            },
                            ajaxurl,
                            {
                                object: 'posts',
                                action: 'seopressor_add'
                            });
                    }
                    else {
                        /*
                         * Restore the row.
                         */
                        $('#seopressor-score-grid').jqGrid('restoreRow', last_selected);
                    }

                    before_edit_value = $('#seopressor-score-grid').jqGrid('getCell', row_id, 'keyword');
                }

                last_selected = row_id;

                /*
                 * Edit row.
                 */
                $('#seopressor-score-grid').jqGrid(
                    'editRow',
                    row_id,
                    true,
                    function () {/* OnEditFunction */
                    },
                    function (response) {
                        /* SuccessFunction */
                        var data = $.parseJSON(response.responseText);

                        // Clear message dashboard.
                        $('#seopressor-message-container').html('');

                        if (data.type == 'notification') {
                            /*
                             * Update grid data.
                             */
                            // Score.
                            $('#seopressor-score-grid').jqGrid('setCell', row_id, 'score', data.score);

                            if (data.score <= 50) {
                                $('#seopressor-score-grid #row_id .score_column').removeClass('color-green').addClass('color-red');
                            }
                            else if (data.score > 50) {
                                $('#seopressor-score-grid #row_id .score_column').removeClass('color-red').addClass('color-green');
                            }

                            // Suggestions link.
                            $('#seopressor-score-grid').jqGrid('setCell', row_id, 'suggestions', data.suggestions);

                            /*
                             * Show server message to user.
                             */
                            $('#seopressor-templates-container .seopressor-notification-message .seopressor-msg-mark').text(data.message);
                            $('#seopressor-templates-container .seopressor-notification-message').clone().appendTo('#seopressor-message-container');

                            $('.seopressor-error-message').effect('highlight', {
                                color: '#FF655D'
                            }, 1000, function () {
                            });
                            $('.seopressor-notification-message').effect('highlight', {
                                color: '#FFCE61'
                            }, 1000, function () {
                            });

                            return true;
                        }
                        else {
                            /*
                             * Show server message to user.
                             */
                            $('#seopressor-templates-container .seopressor-error-message .seopressor-msg-mark').text(data.message);
                            $('#seopressor-templates-container .seopressor-error-message').clone().appendTo('#seopressor-message-container');

                            $('.seopressor-error-message').effect('highlight', {
                                color: '#FF655D'
                            }, 1000, function () {
                            });
                            $('.seopressor-notification-message').effect('highlight', {
                                color: '#FFCE61'
                            }, 1000, function () {
                            });

                            return false;
                        }
                    },
                    ajaxurl,
                    {
                        object: 'posts',
                        action: 'seopressor_add'
                    });
            },
            pager            : '#seopressor-score-grid-pager',
            postData         : {
                object: 'posts',
                action: 'seopressor_list'
            },
            prmNames         : {
                sort : 'orderby',
                order: 'orderdir'
            },
            rowList          : [50, 100, 300, 500, 1000],
            rowNum           : 20,
            rownumbers       : true,
            sortname         : 'score',
            url              : ajaxurl,
            viewrecords      : true,
            width            : 'auto'
        }).jqGrid('navGrid', '#seopressor-score-grid-pager', {
                // General navigation parameters.
                edit         : false,
                add          : false,
                del          : false,
                search       : false,
                refresh      : false,
                refreshtext  : '<strong>Refresh Data</strong>',
                view         : false,
                closeOnEscape: true,
                refreshstate : 'current'
            }, {}, {}, {}, {}, {}, {});

        $('#seopressor-score-grid').jqGrid('filterToolbar', {
            searchOnEnter: false
        });
    }
};

seop_jquery(SEOPressor_score);

//To be sure that seopressor code will be executed even when other code generate an exception
SEOPressor_score_triggered = false;

function OnErrorResponse(){
    if (document.readyState==="interactive" && !SEOPressor_score_triggered) SEOPressor_score(seop_jquery);
    //document.readyState==="interactive" means that DOM is ready to interact with it
    //This check is useful to exclude the errors fired before DOMContentLoaded event
}

if (window.addEventListener) window.addEventListener('error', OnErrorResponse);
else window.attachEvent('onerror', OnErrorResponse);