/*
 * Utility function.
 */
seop_jquery.fn.extend({
	insertAtCaret: function (myValue) {
		return this.each(function (i) {
			if (document.selection) {
				//For browsers like Internet Explorer
				this.focus();
				sel = document.selection.createRange();
				sel.text = myValue;
				this.focus();
			}
			else if (this.selectionStart || this.selectionStart == '0') {
				//For browsers like Firefox and Webkit based
				var startPos = this.selectionStart;
				var endPos = this.selectionEnd;
				var scrollTop = this.scrollTop;
				this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
				this.focus();
				this.selectionStart = startPos + myValue.length;
				this.selectionEnd = startPos + myValue.length;
				this.scrollTop = scrollTop;
			}
			else {
				this.value += myValue;
				is.focus();
			}
		});
	}
});

function SEOPressor_postbox($) {
    if (!SEOPressor_postbox_triggered)
    {
        SEOPressor_postbox_triggered = true;
        /*
         * SEOPressor PostBox.
         */
        /*
         * Tabs.
         */
        $('.seopressor-tabs, .seopressor-tabs-second-lvl', '#seopressor_postbox').add('.seopressor-tabs,.seopressor-tabs-second-lvl', '#seopressor_postbox_below').tabs({
            collapsible: false
        });

        /*
         * In-field labels.
         */
        $('.seopressor-keyword-field-item label', '#seopressor_postbox').inFieldLabels();

        /*
         * Uniform fields.
         */
        $('[type="radio"]', '.seopressor-page').uniform();

        /*
         * Checkboxes.
         */
        $('[type="checkbox"]', '#seopressor_postbox_below').iCheckbox({
            switch_container_src: WPPostsRateKeys.plugin_url + 'templates/js/lib/iCheckbox/images/switch-frame.png',
            class_container     : 'seopressor-checkbox-switcher-container',
            class_switch        : 'seopressor-checkbox-switch',
            class_checkbox      : 'seopressor-checkbox-checkbox',
            switch_speed        : 100,
            switch_swing        : -13
        });

        /*
         * Dropdowns.
         */
        $('#seopressor-suggestions-filter', '#seopressor_postbox').chosen();
        $('#seopressor-rating', '#seopressor_postbox_below').chosen();

        /*
         * Keywords: Add Keyword handler.
         */
        $('#seopressor_postbox').on('click', '.seopressor-icon-add', function () {
            if ($(this).closest('li').find('[type="text"]').val() != '') {
                if ($(this).closest('ul').find('li').length != 3) {
                    $(this).toggleClass('seopressor-icon-add seopressor-icon-remove');

                    var keyword_item$ = $('.seopressor-keyword-field li', '#seopressor-templates-container').clone();

                    keyword_item$.addClass('seopressor-keyword-field-item');

                    if ($(this).closest('ul').find('li').length == 2) {
                        keyword_item$.find('.seopressor-control').addClass('seopressor-icon-remove');
                    }
                    else {
                        keyword_item$.find('.seopressor-control').addClass('seopressor-icon-add');
                    }

                    var keyword_unique_identifier = (new Date()).getTime();
                    keyword_item$.find('input').attr('id', 'seopressor-keyword-field-item-input-' + keyword_unique_identifier);
                    keyword_item$.find('label').attr('for', 'seopressor-keyword-field-item-input-' + keyword_unique_identifier);

                    keyword_item$.appendTo('#seopressor-keyword-list ul', '#seopressor_postbox');

                    $('#seopressor-keyword-list ul li input', '#seopressor_postbox').removeAttr('disabled');

                    $('#seopressor-keyword-list ul li:last-child label', '#seopressor_postbox').inFieldLabels();

                    $('#seopressor-keyword-list ul li:last-child input', '#seopressor_postbox').focus();
                }
            }
            else {
                // Enter a keyword first.
                $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Warning" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>You must enter a keyword first.</p></div>').appendTo('body');
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
         * Keywords: Remove Keyword handler.
         */
        $('#seopressor_postbox').on('click', '.seopressor-icon-remove', function () {
            if ($('#seopressor-keyword-list ul li').length > 1) {
                $(this).closest('li').remove();
                $('#seopressor-keyword-list ul li:last-child .seopressor-control', '#seopressor_postbox').addClass('seopressor-icon-add').removeClass('seopressor-icon-remove');
            }
            else {
                $('#seopressor-keyword-list ul li:last-child .seopressor-control', '#seopressor_postbox').toggleClass('seopressor-icon-add seopressor-icon-remove');
            }
        });

        /*
         * Select: seopressor_suggestions_filter.
         */
        $('#seopressor-suggestions-filter', '#seopressor_postbox').change(function () {
            var selected_option_value = $('#seopressor-suggestions-filter option:selected', '#seopressor_postbox').val();
            var general_suggestions$ = $('.seopressor-suggestion-container-general');

            if (selected_option_value == 'all') {
                $('.seopressor-suggestion-container', '#seopressor_postbox').not(general_suggestions$).show();
            }
            else {
                $('.seopressor-suggestion-container', '#seopressor_postbox').not(general_suggestions$).hide();
                $('#seopressor-suggestions-' + selected_option_value, '#seopressor_postbox').not(general_suggestions$).show();
            }
        });

        /*
         * Select: seopressor_suggestions_filter. Initial selection.
         */
        var selected_option_value = $('#seopressor-suggestions-filter option:selected', '#seopressor_postbox').val();
        var general_suggestions$ = $('.seopressor-suggestion-container-general');

        if (selected_option_value == 'all') {
            $('.seopressor-suggestion-container', '#seopressor_postbox').not(general_suggestions$).show();
        }
        else {
            $('.seopressor-suggestion-container', '#seopressor_postbox').not(general_suggestions$).hide();
            $('#seopressor-suggestions-' + selected_option_value, '#seopressor_postbox').not(general_suggestions$).show();
        }

        /*
         * Buttons.
         */
        $('.seopressor-button').button();

        /*
         * Date and Time Picker.
         */
        $('#seopressor-rich-snippets-events-startdate').datetimepicker();

        /*
         * Suggestions help icons behaviour.
         */
        $('#seopressor_postbox').on('click', '#seopressor-suggestions .seopressor-icon-info', function () {
            $(this).add($(this).prev('p')).toggleClass('seopressor-icon-info-black');
            $(this).next('div').toggle('blind').prev();

            return false;
        });

        /*
         * User typing detection for data update.
         */
        var first_query = true;

        function update_postbox() {
            var data_options = {
                /* General needed data */
                first_query         : first_query,
                action              : 'seopressor_box',
                object              : 'box',
                post_id             : $('#seopressor-post-id').text(),
                content             : $('#content').val(),
                post_title          : $('#title').val(),
                post_name           : $('#editable-post-name-full').text(),

                /* Settings tab */
                allow_meta_keyword  : ($('#seopressor-allow-meta-keyword').attr('checked')) ? '1' : '',
                use_for_meta_keyword: $('[name=use_for_meta_keyword]:checked').val(),

                allow_meta_title: ($('#seopressor-allow-meta-title').attr('checked')) ? '1' : '',
                meta_title      : $('#seopressor-meta-title').val(),

                allow_meta_description: ($('#seopressor-allow-meta-description').attr('checked')) ? '1' : '',
                meta_description      : $('#seopressor-meta-description').val(),

                allow_keyword_overriding_in_sentences     : ($('#seopressor-override-keyword-in-sentences').attr('checked')) ? '1' : '',
                key_in_first_sentence                     : ($('#key-in-first-sentence').attr('checked')) ? '1' : '',
                key_in_last_sentence                      : ($('#key-in-last-sentence').attr('checked')) ? '1' : '',

                /* Rich Snippets tab */
                seopressor_google_rich_snippet_rating     : $('#seopressor-rating option:selected').val(),
                seopressor_google_rich_snippet_author     : $('#seopressor-author').val(),
                seopressor_google_rich_snippet_summary    : $('#seopressor-short-summary').val(),
                seopressor_google_rich_snippet_description: $('#seopressor-medium-summary').val(),

                seop_grs_event_url                             : $('#seopressor-rich-snippets-events-url').val(),
                seop_grs_event_name                            : $('#seopressor-rich-snippets-events-name').val(),
                seop_grs_event_startdate                       : $('#seopressor-rich-snippets-events-startdate').val(),
                seop_grs_event_location_name                   : $('#seopressor-rich-snippets-events-location-name').val(),
                seop_grs_event_location_address_streetaddress  : $('#seopressor-rich-snippets-events-location-address-streetaddress').val(),
                seop_grs_event_location_address_addresslocality: $('#seopressor-rich-snippets-events-address-addresslocality').val(),
                seop_grs_event_location_address_addressregion  : $('#seopressor-rich-snippets-events-location-address-addressregion').val(),

                seop_grs_people_name_given_name : $('#seopressor-rich-snippets-people-given-name').val(),
                seop_grs_people_name_family_name: $('#seopressor-rich-snippets-people-family-name').val(),
                seop_grs_people_locality        : $('#seopressor-rich-snippets-people-locality').val(),
                seop_grs_people_region          : $('#seopressor-rich-snippets-people-region').val(),
                seop_grs_people_title           : $('#seopressor-rich-snippets-people-title').val(),
                seop_grs_people_home_url        : $('#seopressor-rich-snippets-people-home-url').val(),
                seop_grs_people_photo           : $('#seopressor-rich-snippets-people-photo').val(),

                seop_grs_product_name       : $('#seopressor-rich-snippets-product-name').val(),
                seop_grs_product_image      : $('#seopressor-rich-snippets-product-image').val(),
                seop_grs_product_description: $('#seopressor-rich-snippets-product-description').val(),
                seop_grs_product_offers     : $('#seopressor-rich-snippets-product-offers').val(),

                seop_grs_recipe_name                 : $('#seopressor-rich-snippets-recipe-name').val(),
                seop_grs_recipe_yield                : $('#seopressor-rich-snippets-recipe-yield').val(),
                seop_grs_recipe_author               : $('#seopressor-rich-snippets-recipe-author').val(),
                seop_grs_recipe_photo                : $('#seopressor-rich-snippets-recipe-photo').val(),
                seop_grs_recipe_ingredient           : $('#seopressor-rich-snippets-recipe-ingredient').val(),
                seop_grs_recipe_nutrition_calories   : $('#seopressor-rich-snippets-recipe-nutrition-calories').val(),
                seop_grs_recipe_nutrition_sodium     : $('#seopressor-rich-snippets-recipe-nutrition-sodium').val(),
                seop_grs_recipe_nutrition_fat        : $('#seopressor-rich-snippets-recipe-nutrition-fat').val(),
                seop_grs_recipe_nutrition_protein    : $('#seopressor-rich-snippets-recipe-nutrition-protein').val(),
                seop_grs_recipe_nutrition_cholesterol: $('#seopressor-rich-snippets-recipe-nutrition-cholesterol').val(),
                seop_grs_recipe_total_time_minutes   : $('#seopressor-rich-snippets-recipe-total-time-minutes').val(),
                seop_grs_recipe_cook_time_minutes    : $('#seopressor-rich-snippets-recipe-cook-time-minutes').val(),
                seop_grs_recipe_prep_time_minutes    : $('#seopressor-rich-snippets-recipe-prep-time-minutes').val(),

                /* Social SEO tab */
                og_image_use    					 : ($('#seopressor-og-image-use').attr('checked')) ? '1' : '',
                og_image                             : ($('#seopressor-og-image').val()) ? ($('#seopressor-og-image').val()).replace(/x/g, '-wxw-') : '',

                // New fields
                seopressor_og_author   				: $('#seopressor-og-author').val(),
                seopressor_og_publisher    			: $('#seopressor-og-publisher').val(),
                seopressor_og_title    				: $('#seopressor-og-title').val(),
                seopressor_og_description    		: $('#seopressor-og-description').val(),
                seopressor_twitter_title    		: $('#seopressor-twitter-title').val(),
                seopressor_twitter_description    	: $('#seopressor-twitter-description').val(),
                seopressor_dc_title    				: $('#seopressor-dc-title').val(),
                seopressor_dc_description    		: $('#seopressor-dc-description').val(),
					
                /* Enable/Disable settings */
				seop_publish_rich_snippets       	 : ($('#publish-rich-snippets').attr('checked')) ? '1' : '',
				seop_enable_rich_snippets       	 : ($('#enable-rich-snippets').attr('checked')) ? '1' : '',
				seop_enable_socialseo_facebook       : ($('#enable-socialseo-facebook').attr('checked')) ? '1' : '',
				seop_enable_socialseo_twitter        : ($('#enable-socialseo-twitter').attr('checked')) ? '1' : '',
				seop_enable_dublincore               : ($('#enable-dublincore').attr('checked')) ? '1' : ''

            };

            /*
             * Gather keywords and send them to server..
             */
            data_options.seopressor_keywords = [];
            for (var keyword = 0; keyword < $('#seopressor-keyword-list ul li').length; keyword++) {
                data_options.seopressor_keywords.push($('#seopressor-keyword-list ul li').eq(keyword).find('input').val());
            }

            /*
             * Update data when user wants to refresh analysis.
             */
            $.ajax({
                async     : true,
                cache     : false,
                beforeSend: function (xhr) {
                    $('.seopressor-overlay-container', '#seopressor_postbox').add('.seopressor-overlay-container', '#seopressor_postbox_below').css('display', 'block');
                },
                cache     : false,
                data      : data_options,
                dataType  : 'json',
                error     : function (a, b, c) {
                    /*
                     * Don't show the message in case that the user cancel the query.'
                     */
                    if (c) {
                        /*
                         * Remove ajax loader for feedback user.
                         */
                        $('.seopressor-overlay-container', '#seopressor_postbox').add('.seopressor-overlay-container', '#seopressor_postbox_below').css('display', 'none');

                        /*
                         * Show server message to user.
                         */
                        $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                        $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="SEOPressor Error" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p><strong style="text-transform:capitalize;">' + b + ':</strong> ' + c + '</p></div>').appendTo('body');
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
                },
                success   : function (response_from_server) {
                    /*
                     * Remove ajax loader for feedback user.
                     */
                    $('.seopressor-overlay-container', '#seopressor_postbox').add('.seopressor-overlay-container', '#seopressor_postbox_below').css('display', 'none');

                    // It is a notification.
                    if (response_from_server.type == 'notification') {
                        /*
                         * Keywords update.
                         */
                        // Do this processing only if was the first query.
                        if (first_query) {
                            // Empty keywords container.
                            $('#seopressor-keyword-list ul', '#seopressor_postbox').html('');
                            var keyword_unique_identifier = (new Date()).getTime();

                            if (response_from_server.seopressor_keywords.length > 0) {
                                for (var keyword = 0; keyword < response_from_server.seopressor_keywords.length; keyword++) {
                                    var keyword_item$ = $('.seopressor-keyword-field li', '#seopressor-templates-container').clone();

                                    keyword_item$.addClass('seopressor-keyword-field-item');
                                    keyword_item$.find('label').attr('for', 'seopressor-keyword-field-item-input-' + keyword_unique_identifier);
                                    keyword_item$.find('input').val(response_from_server.seopressor_keywords[keyword]).removeAttr('disabled').attr('id', 'seopressor-keyword-field-item-input-' + keyword_unique_identifier);

                                    // If is the last item
                                    if (keyword == response_from_server.seopressor_keywords.length - 1 && keyword != 2) {
                                        keyword_item$.find('.seopressor-control').addClass('seopressor-icon-add');
                                    }
                                    else {
                                        keyword_item$.find('.seopressor-control').addClass('seopressor-icon-remove');
                                    }

                                    keyword_item$.appendTo('#seopressor-keyword-list ul', '#seopressor_postbox');

                                    keyword_unique_identifier++;
                                }
                            }
                            else {
                                // Only build one keyword container.
                                var keyword_item$ = $('.seopressor-keyword-field li', '#seopressor-templates-container').clone();

                                keyword_item$.addClass('seopressor-keyword-field-item');
                                keyword_item$.find('label').attr('for', 'seopressor-keyword-field-item-input-0');
                                keyword_item$.find('input').val(response_from_server.seopressor_keywords[keyword]).attr('id', 'seopressor-keyword-field-item-input-0');
                                keyword_item$.find('.seopressor-control').addClass('seopressor-icon-add').removeAttr('disabled');
                                keyword_item$.appendTo('#seopressor-keyword-list ul', '#seopressor_postbox');
                            }

                            $('.seopressor-keyword-field-item label', '#seopressor_postbox').inFieldLabels();
                        }

                        // If there is no keywords then don't show the bottom block content (Suggestions/LSI tabs)
                        if ($('#seopressor-keyword-list ul li:first input', '#seopressor_postbox').val() == '') {
                            $('.seopressor-bottom-content-container', '#seopressor_postbox').hide();
                        }
                        else {
                            $('.seopressor-bottom-content-container', '#seopressor_postbox').show();
                        }

                        /*
                         * Score update.
                         */
                        $('#seopressor-main .seopressor-score-box-block-score .seopressor-score-text').text(response_from_server['score'].value);

                        if (response_from_server['score'].type == 'positive') {
                            $('#seopressor-main .seopressor-score-box-block-score  .seopressor-score-box').addClass('seopressor-positive').removeClass('seopressor-negative');
                        }
                        else {
                            $('#seopressor-main .seopressor-score-box-block-score  .seopressor-score-box').addClass('seopressor-negative').removeClass('seopressor-positive');
                        }

                        /*
                         * Keyword density update.
                         */
                        $('#seopressor-main .seopressor-score-box-block-keyword-density .seopressor-score-text').html(response_from_server['keyword_density'].value + '<span class="seopressor-percent">&nbsp;%</span>');

                        if (response_from_server['keyword_density'].type == 'positive') {
                            $('#seopressor-main .seopressor-score-box-block-keyword-density  .seopressor-score-box').addClass('seopressor-positive').removeClass('seopressor-negative');
                        }
                        else {
                            $('#seopressor-main .seopressor-score-box-block-keyword-density  .seopressor-score-box').addClass('seopressor-negative').removeClass('seopressor-positive');
                        }

                        /*
                         * Suggestions update.
                         */
                        if (response_from_server['suggestions'].score_less_than_100.length > 0) {
                            var suggestions_wrapper = '<ul>';

                            for (var Index=0; Index < response_from_server['suggestions'].score_less_than_100.length; Index++) {
                                suggestions_wrapper += '<li><p>' + response_from_server['suggestions'].score_less_than_100[Index] + '</p>' + '</li>';
                            }

                            suggestions_wrapper += '</ul>';

                            $('#seopressor-main' + ' #seopressor-suggestions-score-less-than-100').html(suggestions_wrapper).show().prev('.seopressor-suggestion-heading').show();
                        }
                        else {
                            $('#seopressor-main' + ' #seopressor-suggestions-score-less-than-100').hide().prev('.seopressor-suggestion-heading').hide();
                        }

                        if (response_from_server['suggestions'].score_more_than_100.length > 0) {
                            var suggestions_wrapper = '<ul>';

                            for (var Index=0; Index < response_from_server['suggestions'].score_more_than_100.length; Index++) {
                                suggestions_wrapper += '<li><p>' + response_from_server['suggestions'].score_more_than_100[Index] + '</p>' + '</li>';
                            }

                            suggestions_wrapper += '</ul>';

                            $('#seopressor-main' + ' #seopressor-suggestions-score-more-than-100').html(suggestions_wrapper).show().prev('.seopressor-suggestion-heading').show();
                        }
                        else {
                            $('#seopressor-main' + ' #seopressor-suggestions-score-more-than-100').hide().prev('.seopressor-suggestion-heading').hide();
                        }

                        if (response_from_server['suggestions'].score_over_optimization && response_from_server['suggestions'].score_over_optimization.list && response_from_server['suggestions'].score_over_optimization.list && response_from_server['suggestions'].score_over_optimization.list.length > 0) {
                            var suggestions_wrapper = '<ul>';

                            for (var Index=0; Index < response_from_server['suggestions'].score_over_optimization.list.length; Index++) {
                                suggestions_wrapper += '<li><p>' + response_from_server['suggestions'].score_over_optimization.list[Index] + '</p>' + '</li>';
                            }

                            suggestions_wrapper += '</ul>';

                            $('#seopressor-main' + ' #seopressor-suggestions-score-over-optimization').html(suggestions_wrapper).show().prev('.seopressor-suggestion-heading').show();

                            if (response_from_server['suggestions'].score_over_optimization.type == 'positive') {
                                $('#seopressor-main' + ' #seopressor-suggestions-score-over-optimization').prev('.seopressor-suggestion-heading').addClass('seopressor-positive').removeClass('seopressor-negative');
                            }
                            else if (response_from_server['suggestions'].score_over_optimization.type == 'negative') {
                                $('#seopressor-main' + ' #seopressor-suggestions-score-over-optimization').prev('.seopressor-suggestion-heading').addClass('seopressor-negative').removeClass('seopressor-positive');
                            }
                        }
                        else {
                            $('#seopressor-main' + ' #seopressor-suggestions-score-over-optimization').hide().prev('.seopressor-suggestion-heading').hide();
                        }

                        if (response_from_server['suggestions'].decoration.length > 0) {
                            var suggestions_wrapper = '<ul>';

                            for (var Index=0; Index < response_from_server['suggestions'].decoration.length; Index++) {
                                suggestions_wrapper += '<li class="' + ((response_from_server['suggestions'].decoration[Index][0] == 1) ? 'seopressor-positive' : 'seopressor-negative') + '"><span class="seopressor-icon-suggestion-type"></span><p>' + response_from_server['suggestions'].decoration[Index][1] + '</p>' + ((response_from_server['suggestions'].decoration[Index][2]) ? '<a class="seopressor-icon-info" title="Click to show the help"></a><div class="ui-helper-hidden seopressor-hidden-help"><p>' + response_from_server['suggestions'].decoration[Index][2] + '</p></div>' : '') + '</li>';
                            }

                            suggestions_wrapper += '</ul>';

                            $('#seopressor-main' + ' #seopressor-suggestions-keyword-decoration').html(suggestions_wrapper);
                        }

                        if (response_from_server['suggestions'].url.length > 0) {
                            var suggestions_wrapper = '<ul>';

                            for (var Index=0; Index < response_from_server['suggestions'].url.length; Index++) {
                                suggestions_wrapper += '<li class="' + ((response_from_server['suggestions'].url[Index][0] == 1) ? 'seopressor-positive' : 'seopressor-negative') + '"><span class="seopressor-icon-suggestion-type"></span><p>' + response_from_server['suggestions'].url[Index][1] + '</p>' + ((response_from_server['suggestions'].url[Index][2]) ? '<a class="seopressor-icon-info" title="Click to show the help"></a><div class="ui-helper-hidden seopressor-hidden-help"><p>' + response_from_server['suggestions'].url[Index][2] + '</p></div>' : '') + '</li>';
                            }

                            suggestions_wrapper += '</ul>';

                            $('#seopressor-main' + ' #seopressor-suggestions-url').html(suggestions_wrapper);
                        }

                        if (response_from_server['suggestions'].content.length > 0) {
                            var suggestions_wrapper = '<ul>';

                            for (var Index=0; Index < response_from_server['suggestions'].content.length; Index++) {
                                suggestions_wrapper += '<li class="' + ((response_from_server['suggestions'].content[Index][0] == 1) ? 'seopressor-positive' : 'seopressor-negative') + '"><span class="seopressor-icon-suggestion-type"></span><p>' + response_from_server['suggestions'].content[Index][1] + '</p>' + ((response_from_server['suggestions'].content[Index][2]) ? '<a class="seopressor-icon-info" title="Click to show the help"></a><div class="ui-helper-hidden seopressor-hidden-help"><p>' + response_from_server['suggestions'].content[Index][2] + '</p></div>' : '') + '</li>';
                            }

                            suggestions_wrapper += '</ul>';

                            $('#seopressor-main' + ' #seopressor-suggestions-content').html(suggestions_wrapper);
                        }

                        /*
                         * LSI update.
                         */
                        showLSI(response_from_server);
                    } else if (response_from_server.type == 'error') {
                        /*
                         * Show server message to user.
                         */
                        $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                        $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Error" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>' + response_from_server.message + '</p></div>').appendTo('body');
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

                    first_query = false;
                },
                type      : 'POST',
                url       : ajaxurl
            });
        }

        // Start the countdown.
        $('#refresh-postbox', '#seopressor_postbox').add('.seopressor-submit-button', '#seopressor_postbox_below').click(function () {
            update_postbox();
        });

        /*
         * Parse LSI.
         */
        function showLSI(response_from_server) {
            /*
             * Clear old LSI and options in select filter.
             */
            $('#seopressor-lsi-filter').html('');
            $('.seopressor-lsi-wrapper').remove();

            if (response_from_server.lsi.message === "") {
                for (keyword in response_from_server.lsi.list) {
                    var lsi_wrapper = '<ul>';

                    if (!response_from_server.lsi.list[keyword].message != '') {
                        for (var item = 0; item < response_from_server.lsi.list[keyword].list.length; item++) {
                            // Detecting presence in post content.
                            var lsi_is_present = ((new String($('#content').val()).toLowerCase()).indexOf(response_from_server.lsi.list[keyword].list[item].lsi.toLowerCase()) != '-1') ? true : false;

                            lsi_wrapper += '<li class="seopressor-lsi-item seopressor-' + ((lsi_is_present) ? 'positive' : 'negative');
                            lsi_wrapper += '"><span class="seopressor-icon-suggestion-type" title="The LSI ' + ((lsi_is_present) ? 'is' : 'is not') + ' in the post content"></span>';

                            lsi_wrapper += '<span class="seopressor-lsi-item-actions">';
                            lsi_wrapper += '<img class="seopressor-insert-text" src="' + WPPostsRateKeys.plugin_url + 'templates/images/icons/settings/text.png" title="Insert LSI into content at caret position" />';
                            lsi_wrapper += '</span>';

                            lsi_wrapper += '<p><span class="seopressor-lsi-item-text">' + response_from_server.lsi.list[keyword].list[item].lsi + '</span>';
                            lsi_wrapper += '</p><span class="seopressor-lsi-item-search-engines-wrapper"><a target="_blank" title="Search with Bing" class="seopressor-search-engines-link seopressor-bing-search" href="'
                                + response_from_server.lsi.list[keyword].list[item].BingUrl + '"></a>';
                            lsi_wrapper += '<a target="_blank" title="Search with Google" class="seopressor-search-engines-link seopressor-google-search" href="'
                                + (response_from_server.lsi.list[keyword].list[item].BingUrl).replace('www.bing.com', 'www.google.com') + '"></a></span>';
                            lsi_wrapper += '</li>';
                        }
                    }
                    else {
                        // There are no lsi.
                        lsi_wrapper += '<li class="seopressor-negative seopressor-message"><p>' + response_from_server.lsi.list[keyword].message + '</p></li>';
                    }

                    lsi_wrapper += '</ul>';

                    // Adding option to select filter.
                    $('#seopressor-lsi-filter').append('<option value="' + keyword.replace(/[^a-zA-Z\w:.-]/g, '') + '">' + keyword + '</option>');

                    // Add LSI container box.
                    $('#seopressor_lsi_filter_mark').after('<div id="seopressor-keyword-lsi-' + keyword.replace(/[^a-zA-Z\w:.-]/g, '') + '" class="seopressor-lsi-wrapper">' + lsi_wrapper + '</div>');
                }

                // Initial selection.
                $('#seopressor-keyword-lsi-' + $('#seopressor-lsi-filter option:selected').val()).first().css('display', 'block');

                /*
                 * Select: seopressor_lsi_filter.
                 */
                $('#seopressor-lsi-filter').change(function () {
                    var value = $('#seopressor-lsi-filter option:selected').val();

                    $('.seopressor-lsi-wrapper', '#seopressor_postbox').hide();
                    $('#seopressor-keyword-lsi-' + value, '#seopressor_postbox').show();
                });

                $('#seopressor_lsi_filter_chzn').css('display', 'block');

                if (!$('#seopressor-lsi-filter').hasClass('chzn-done')) {
                    // First time is loaded. Convert the dropdown.
                    $('#seopressor-lsi-filter', '#seopressor_postbox').chosen();
                }
                else {
                    // Update the dropdown options.
                    $('#seopressor-lsi-filter').trigger('liszt:updated');
                }
            }
            else {
                // Show message to user.
                $('#seopressor_lsi_filter_chzn,.seopressor-lsi-heading').css('display', 'none')

                lsi_wrapper = '<ul><li><p>' + response_from_server.lsi.message + '</p></li></ul>';

                // Add LSI container box.
                $('#seopressor_lsi_filter_mark').after('<div class="seopressor-negative seopressor-message seopressor-lsi-wrapper">' + lsi_wrapper + '</div>');
                $('#seopressor-content-lsi .seopressor-lsi-wrapper').css({
                    'display'   : 'block',
                    'margin-top': '0'
                });
            }
        }

        /*
         * Initial update of postbox data.
         */
        if (!$('body').hasClass('post-new-php')) {
            update_postbox();
        }
        else {
            // Is the Add New page so first_query == false;
            first_query = false;
        }

        /*
         * Parse videos and shows them to user.
         */
        function showVideos(response_from_server) {
            /*
             * Clear old Videos and options in select filter.
             */
            $('#seopressor-videos-filter').html('');
            $('.seopressor-videos-wrapper').remove();

            if ($.isEmptyObject(response_from_server.videos.message)) {
                for (keyword in response_from_server.videos.list) {
                    var videos_wrapper = '<ul>';

                    if (!response_from_server.videos.list[keyword].message != '') {
                        for (var item = 0; item < response_from_server.videos.list[keyword].list.length; item++) {
                            videos_wrapper += '<li class="seopressor-videos-item"><div class="seopressor-videos-item-thumbnail-container">';
                            videos_wrapper += '<img width="120" src="' + response_from_server.videos.list[keyword].list[item].thumbnail + '" />';
                            videos_wrapper += '<div class="seopressor-videos-item-duration">' + response_from_server.videos.list[keyword].list[item].duration + '</div>';
                            videos_wrapper += '<div class="seopressor-videos-item-actions">';
                            videos_wrapper += '<img class="seopressor-insert-image-small" src="' + WPPostsRateKeys.plugin_url + 'templates/images/icons/settings/image-small.png" title="Embed SMALL video into content at caret position" />';
                            videos_wrapper += '<img class="seopressor-insert-image-medium" src="' + WPPostsRateKeys.plugin_url + 'templates/images/icons/settings/image-medium.png" title="Embed MEDIUM video into content at caret position" />';
                            videos_wrapper += '<img class="seopressor-insert-image-large" src="' + WPPostsRateKeys.plugin_url + 'templates/images/icons/settings/image-large.png" title="Embed LARGE video into content at caret position" />';
                            videos_wrapper += '<a class="seopressor-prettyPhoto" href="' + response_from_server.videos.list[keyword].list[item].url + '" title="' + response_from_server.videos.list[keyword].list[item].title + '"><img class="seopressor-insert-video-play" src="' + WPPostsRateKeys.plugin_url + 'templates/images/icons/settings/video-play.png" title="Play video" /></a>';
                            videos_wrapper += '</div></div>';
                            videos_wrapper += '<div class="seopressor-videos-item-title"><a href="' + response_from_server.videos.list[keyword].list[item].url + '" target="_blank" title="' + response_from_server.videos.list[keyword].list[item].title + '">' + response_from_server.videos.list[keyword].list[item].title + '</a></div>';
                            videos_wrapper += '<div class="seopressor-videos-item-author">by ' + response_from_server.videos.list[keyword].list[item].author + '</div>';
                            videos_wrapper += '<div class="seopressor-videos-item-views">' + response_from_server.videos.list[keyword].list[item].views + ' views</div>';
                            videos_wrapper += '<br class="clearfloat" /></li>';
                        }
                    }
                    else {
                        // There are no videos.
                        videos_wrapper += '<li class="seopressor-negative seopressor-message"><p>' + response_from_server.videos.list[keyword].message + '</p></li>';
                    }

                    videos_wrapper += '</ul>';

                    // Adding option to select filter.
                    $('#seopressor-videos-filter').append('<option value="' + keyword.replace(/\s/g, '') + '">' + keyword + '</option>');

                    // Add Videos container box.
                    $('#seopressor_videos_filter_mark').after('<div id="seopressor-keyword-videos-' + keyword.replace(/\s/g, '') + '" class="seopressor-videos-wrapper">' + videos_wrapper + '</div>');
                }

                // Initial selection.
                $('#seopressor-keyword-videos-' + $('#seopressor-videos-filter option:selected').val()).first().css('display', 'block');

                /*
                 * Select: seopressor_videos_filter.
                 */
                $('#seopressor-videos-filter').change(function () {
                    var value = $('#seopressor-videos-filter option:selected').val();

                    $('.seopressor-videos-wrapper', '#seopressor_postbox').hide();
                    $('#seopressor-keyword-videos-' + value, '#seopressor_postbox').show();
                });

                $('#seopressor_videos_filter_chzn').css('display', 'block');

                if (!$('#seopressor-videos-filter').hasClass('chzn-done')) {
                    // First time is loaded. Convert the dropdown.
                    $('#seopressor-videos-filter', '#seopressor_postbox').chosen();
                }
                else {
                    // Update the dropdown options.
                    $('#seopressor-videos-filter').trigger('liszt:updated');
                }

                $('.seopressor-prettyPhoto').prettyPhoto({
                    social_tools: false
                });
            }
            else {
                // Show message to user.
                $('#seopressor_videos_filter_chzn,.seopressor-videos-heading').css('display', 'none')

                videos_wrapper = '<ul><li><p>' + response_from_server.videos.message + '</p></li></ul>';

                // Add Videos container box.
                $('#seopressor_videos_filter_mark').after('<div class="seopressor-negative seopressor-message seopressor-videos-wrapper">' + videos_wrapper + '</div>');
                $('#seopressor-content-videos .seopressor-videos-wrapper').css({
                    'display'   : 'block',
                    'margin-top': '0'
                });
            }
        }

        /*
         * Search For Related Videos button behaviour.
         */
        $('#seopressor-get-videos-button', '#seopressor_postbox').click(function () {
            var button$ = $(this);

            $.ajax({
                async     : true,
                cache     : false,
                beforeSend: function (xhr) {
                    $('#seopressor-content .seopressor-content-videos-tab .seopressor-ajax-loader', '#seopressor_postbox').css('display', 'block');
                    button$.button('disable');
                },
                data      : {
                    object : 'youtube_videos',
                    post_id: $('#seopressor-post-id').text(),
                    action : 'seopressor_list'
                },
                dataType  : 'json',
                error     : function (a, b, c) {
                    /*
                     * Don't show the message in case that the user cancel the query.'
                     */
                    if (c) {
                        /*
                         * Remove ajax loader for feedback user.
                         */
                        $('#seopressor-content .seopressor-content-videos-tab .seopressor-ajax-loader', '#seopressor_postbox').css('display', 'none');
                        button$.button('enable');

                        /*
                         * Show server message to user.
                         */
                        $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                        $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="SEOPressor Error" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p><strong style="text-transform:capitalize;">' + b + ':</strong> ' + c + '</p></div>').appendTo('body');
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
                },
                success   : function (response_from_server) {
                    /*
                     * Remove ajax loader for feedback user.
                     */
                    $('#seopressor-content .seopressor-content-videos-tab .seopressor-ajax-loader', '#seopressor_postbox').css('display', 'none');
                    button$.button('enable');

                    // It is a notification.
                    if (response_from_server.type == 'notification') {
                        showVideos(response_from_server);
                    }
                    else if (response_from_server.type == 'error') {
                        /*
                         * Show message to user.
                         */
                        $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                        $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Error" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>' + response_from_server.message + '</p></div>').appendTo('body');
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
                },
                type      : 'POST',
                url       : ajaxurl
            });
        });

        /*
         * LSI actions behaviour.
         */
        // Displaying behaviour.
        $('#seopressor_postbox').on('mouseenter', '.seopressor-lsi-item', function () {
            $(this).find('.seopressor-lsi-item-actions').show();
        });

        $('#seopressor_postbox').on('mouseleave', '.seopressor-lsi-item', function () {
            $(this).find('.seopressor-lsi-item-actions').hide();
        });

        /*
         * Embed LSI on WordPress.
         */
        function insert_lsi(lsi) {
            // It is fine executing this two lines without an if-else statement because they complement each other.
            // Update RTE if is active the Visual tab.
            tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, lsi);
            // Update the textarea is is active the HTML tab.
            $('#content').insertAtCaret(lsi);
        };

        // Inserting video in Rich Text Editor at caret position.
        $('#seopressor_postbox').on('click', '.seopressor-insert-text', function () {
            insert_lsi($(this).closest('li').find('.seopressor-lsi-item-text').text());
        });

        /*
         * Video actions behaviour.
         */
        // Displaying behaviour.
        $('#seopressor_postbox').on('mouseenter', '.seopressor-videos-item', function () {
            $(this).find('.seopressor-videos-item-actions').show();
        });

        $('#seopressor_postbox').on('mouseleave', '.seopressor-videos-item', function () {
            $(this).find('.seopressor-videos-item-actions').hide();
        });

        /*
         * Embed video on WordPress using oEmbed.
         */
        function embed_video(url, width) {
            var content_to_insert = '[embed width="' + width + '"]' + url + '[/embed]';

            // It is fine executing this two lines without an if-else statement because they complement each other.
            // Update RTE if is active the Visual tab.
            tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, content_to_insert);
            // Update the textarea is is active the HTML tab.
            $('#content').insertAtCaret(content_to_insert);
        };

        // Inserting video in Rich Text Editor at caret position.
        $('#seopressor_postbox').on('click', '.seopressor-insert-image-small,.seopressor-insert-image-medium,.seopressor-insert-image-large', function () {
            var width = '';

            if ($(this).hasClass('seopressor-insert-image-small')) {
                width = '320';
            }
            else if ($(this).hasClass('seopressor-insert-image-medium')) {
                width = '480';
            }
            else if ($(this).hasClass('seopressor-insert-image-large')) {
                width = '640';
            }

            embed_video($(this).closest('li').find('.seopressor-videos-item-title a').attr('href'), width);
        });

        /*
         * Postbox Below Image Control behaviour.
         */
        $('.seopressor-button-next').button({
            text : false,
            icons: {
                primary: 'ui-icon-seek-next'
            }
        }).click(function () {
                if (($('#seopressor-gallery img:visible').data('position') != $('#seopressor-gallery img:last').data('position') - 1) || $('#seopressor-gallery img:visible').data('position') == 1) {
                    $('#seopressor-image-control .seopressor-button-prev').button('enable');
                }
                else {
                    // If is the last image in gallery disable button.
                    $(this).button('disable');
                }

                $('#seopressor-gallery img:visible').hide().next('img').show();
                $('#seopressor-og-image').val($('#seopressor-gallery img:visible').attr('src'));
                $('#seopressor-gallery-count').text($('#seopressor-gallery img:visible').data('position') + ' of ' + $($('#content').val()).find('img').length);

                return false;
            });

        $('.seopressor-button-prev').button({
            text : false,
            icons: {
                primary: 'ui-icon-seek-prev'
            }
        }).click(function () {
                if ($('#seopressor-gallery img:visible').data('position') != '2') {
                    $('#seopressor-image-control .seopressor-button-next').button('enable');
                }
                else {
                    // If is the last image in gallery disable button.
                    $(this).button('disable');
                }

                $('#seopressor-gallery img:visible').hide().prev('img').show();
                $('#seopressor-og-image').val($('#seopressor-gallery img:visible').attr('src'));
                $('#seopressor-gallery-count').text($('#seopressor-gallery img:visible').data('position') + ' of ' + $($('#content').val()).find('img').length);

                return false;
            }).button('disable');

        $('#seopressor-image-control').buttonset();

        /*
         * Get the images featured in the content to build the gallery.
         */
        // If this id is present then there aren't a featured image.
        if ($('#seopressor-image-control').length) {
            $($('#content').val()).find('img').each(function (index) {
                $('#seopressor-gallery').append('<img class="ui-helper-hidden" data-position="' + (index + 1) + '" src="' + $(this).attr('src') + '" />');
            });

            $('#seopressor-gallery img[data-position=1]').show();

            $('#seopressor-gallery-count').text('1 of ' + $($('#content').val()).find('img').length);
            $('#seopressor-og-image').val($('#seopressor-gallery img:first').attr('src'));

            if ($($('#content').val()).find('img').length == 1) {
                $('.seopressor-button-next').button('disable');
            }
        }

        if (!$('#seopressor-gallery img').length) {
            $('#seopressor-gallery').closest('td').html('<span class="description">Set a "featured image" or insert an image to the content and update the post.</span>');
        }

        /*
         * Add Tags behaviour.
         */
        $('.seopressor-get-tags', '#seopressor_postbox_below').click(function () {
            var button$ = $(this);

            $.ajax({
                async     : true,
                cache     : false,
                beforeSend: function (xhr) {
                    $('.seopressor-overlay-container', '#seopressor_postbox_below').css('display', 'block');
                },
                data      : {
                    action    : 'seopressor_list',
                    object    : 'tag',
                    post_id   : $('#seopressor-post-id').text(),
                    content   : $('#content').val(),
                    post_title: $('#title').val(),
                    service   : button$.closest('.ui-tabs-panel').find('.seopressor_tag_service').val()
                },
                dataType  : 'json',
                error     : function (a, b, c) {
                    /*
                     * Don't show the message in case that the user cancel the query.'
                     */
                    if (c) {
                        /*
                         * Remove ajax loader for feedback user.
                         */
                        $('.seopressor-overlay-container', '#seopressor_postbox_below').css('display', 'none');

                        /*
                         * Show server message to user.
                         */
                        $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                        $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="SEOPressor Error" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p><strong style="text-transform:capitalize;">' + b + ':</strong> ' + c + '</p></div>').appendTo('body');
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
                },
                success   : function (response_from_server) {
                    /*
                     * Remove ajax loader for feedback user.
                     */
                    $('.seopressor-overlay-container', '#seopressor_postbox_below').css('display', 'none');

                    /*
                     * Check if Tags are empty
                     */
                    if (response_from_server.tags.length==0){
                    	response_from_server.type = 'error';                    	
                    	$('#seop_gettags_msg').show();
                    }
                    
                    // It is a notification.
                    if (response_from_server.type == 'notification') {
                        /*
                         * Clear old tags.
                         */
                        $('.seopressor-tags-wrapper', button$.closest('.ui-tabs-panel')).html('');

                        var tag_wrapper = '<ul>';

                        for (tag in response_from_server.tags) {
                            tag_wrapper += '<li class="seopressor-tag-item">';
                            tag_wrapper += '<label><input type="checkbox" class="seopressor_tag_list_checkbox" name="seopressor_tag_list" value="' + response_from_server.tags[tag] + '" />&nbsp;<span class="seopressor-tag-item-text">' + response_from_server.tags[tag] + '</span></label>';
                            tag_wrapper += '</li>';
                        }

                        tag_wrapper += '</ul>';

                        $('.seopressor-tags-wrapper', button$.closest('.ui-tabs-panel')).html(tag_wrapper);

                        $('.seopressor-tag-item .seopressor_tag_list_checkbox', button$.closest('.ui-tabs-panel')).iCheckbox({
                            switch_container_src: WPPostsRateKeys.plugin_url + 'templates/js/lib/iCheckbox/images/switch-frame.png',
                            class_container     : 'seopressor-checkbox-switcher-container',
                            class_switch        : 'seopressor-checkbox-switch',
                            class_checkbox      : 'seopressor-checkbox-checkbox',
                            switch_speed        : 100,
                            switch_swing        : -13
                        });
                    }
                    else if (response_from_server.type == 'error') {
                        /*
                         * Show message to user.
                         */
                        $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                        $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Error" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>' + response_from_server.message + '</p></div>').appendTo('body');
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
                },
                type      : 'POST',
                url       : ajaxurl
            });
        });

        $('.seopressor-update-tags', '#seopressor_postbox_below').click(function () {
            var button$ = $(this);
            
            /*
             * Get selected tags.
             */
            var selected_tags = [];

            $('.seopressor_tag_list_checkbox:checked', button$.closest('.ui-tabs-panel')).each(function () {
            	var tmp_tag = $(this).val();
            	// Set each Tag in WordPress box too
            	$('#new-tag-post_tag').val(tmp_tag);
            	$('.tagadd').trigger('click');
            	
            	// Add tag to the list for Ajax Call
                selected_tags.push(tmp_tag);
            });

            $.ajax({
                async     : true,
                cache     : false,
                beforeSend: function (xhr) {
                    $('.seopressor-overlay-container', '#seopressor_postbox_below').css('display', 'block');
                },
                data      : {
                    action : 'seopressor_add',
                    object : 'tag',
                    post_id: $('#seopressor-post-id').text(),
                    tags   : selected_tags
                },
                dataType  : 'json',
                error     : function (a, b, c) {
                    /*
                     * Don't show the message in case that the user cancel the query.'
                     */
                    if (c) {
                        /*
                         * Remove ajax loader for feedback user.
                         */
                        $('.seopressor-overlay-container', '#seopressor_postbox_below').css('display', 'none');

                        /*
                         * Show server message to user.
                         */
                        $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                        $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="SEOPressor Error" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p><strong style="text-transform:capitalize;">' + b + ':</strong> ' + c + '</p></div>').appendTo('body');
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
                },
                success   : function (response_from_server) {
                    /*
                     * Remove ajax loader for feedback user.
                     */
                    $('.seopressor-overlay-container', '#seopressor_postbox_below').css('display', 'none');

                    // It is a notification.
                    if (response_from_server.type == 'notification') {
                    }
                    else if (response_from_server.type == 'error') {
                        /*
                         * Show message to user.
                         */
                        $('#seopressor-thickbox-dialog-link,#seopressor-thickbox-dialog-content-container').remove();
                        $('<a class="thickbox ui-helper-hidden" id="seopressor-thickbox-dialog-link" title="Error" href="#TB_inline&height=55&inlineId=seopressor-thickbox-dialog-content-container">thickbox link</a><div id="seopressor-thickbox-dialog-content-container" class="ui-helper-hidden"><p>' + response_from_server.message + '</p></div>').appendTo('body');
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
                },
                type      : 'POST',
                url       : ajaxurl
            });
        });
    }
};

seop_jquery(SEOPressor_postbox);

//To be sure that seopressor code will be executed even when other code generate an exception
SEOPressor_postbox_triggered = false;

function OnErrorResponse(){
    if (document.readyState==="interactive" && !SEOPressor_postbox_triggered) SEOPressor_postbox(seop_jquery);
    //document.readyState==="interactive" means that DOM is ready to interact with it
    //This check is useful to exclude the errors fired before DOMContentLoaded event
}

if (window.addEventListener) window.addEventListener('error', OnErrorResponse);
else window.attachEvent('onerror', OnErrorResponse);

