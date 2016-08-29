function SEOPressor_settings($) {
    if (!SEOPressor_settings_triggered)
    {
       function setCookie(cname, cvalue, days) {
            var dt, expires="";
            dt = new Date();
            if (days !== null) {
                dt.setTime(dt.getTime()+(days*24*60*60*1000));
                expires = "; expires="+dt.toGMTString();
            }

            document.cookie = cname+"="+cvalue+expires;
        }

        function getCookie(c_name) {
            var i,x,y,ARRcookies=document.cookie.split(";");
            for (i=0;i<ARRcookies.length;i++)
            {
                x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
                y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
                x=x.replace(/^\s+|\s+$/g,"");
                if (x==c_name)
                {
                    return unescape(y);
                }
            }
        }

        function CreateVerticalTabs(TagId) {
            $('#' + TagId).tabs({
                active: (getCookie(TagId) || 0),
                activate: function (e, ui) {
                    setCookie(TagId, $(this).find('ul').eq(0).find('li').index(ui.newTab), 7);
                },
                collapsible: false
            }).addClass('ui-tabs-vertical ui-helper-clearfix');
        }
        SEOPressor_settings_triggered = true;
        /*
         * Settings Page behaviour.
         */
        /*
         * Tabs. Horizontal Tabs.
         */
        $('.seopressor-tabs', '.seopressor-page').tabs({
            active: (getCookie("seop-tab1") || 0),
            activate: function (e, ui) {
                setCookie("seop-tab1", $(this).find('ul').eq(0).find('li').index(ui.newTab), 7);
            },
            collapsible: false
        });
        $('.seopressor-tabs').css("visibility", "visible");

        /*
         * Buttons.
         */
        $('.seopressor-button').button();

        /*
         * Tabs. Vertical Tabs.
         */
        CreateVerticalTabs("seopressor-automatic-decorations-tabs");
        CreateVerticalTabs("seopressor-tags-tabs");
        CreateVerticalTabs("seopressor-advanced-tabs");                

        $('.seopressor-tabs-second-lvl', '.seopressor-page').removeClass('ui-corner-top').addClass('ui-corner-left');

        /*
         * Uniform fields.
         */
        $('[type="radio"]', '.seopressor-page').uniform();

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
         * Dropdowns.
         */
        $('select', '.seopressor-page').chosen();

        /*
         * Handler for  seopressor-show-files button.
         */
        $('button#seopressor-show-files').click(function () {
            $('#seopressor-file-list-wrapper').toggle();
            $('button#seopressor-show-files .ui-icon').toggleClass('ui-icon-plus ui-icon-minus');
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
                $('.seopressor-button,.seopressor-submit-tr button[type="submit"], .seopressor-submit-div button[type="submit"]', form$).button('disable');
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
                    // Get selected tab in main tabset for reduce the selectors scope.
                    var selected_tab$ = $('.ui-tabs-panel').not('.ui-tabs-hide');

                    /*
                     * Remove ajax loader and disable button.
                     */
                    $('.seopressor-submit-tr img, .seopressor-submit-div img', selected_tab$).hide();
                    $('.seopressor-button,.seopressor-submit-tr button[type="submit"], .seopressor-submit-div button[type="submit"]', selected_tab$).button('enable');

                    // Clear message dashboard.
                    $('#seopressor-message-container').html('');

                    $('#seopressor-templates-container .seopressor-error-message .seopressor-msg-mark').html(b + ': ' + c);
                    $('#seopressor-templates-container .seopressor-error-message').clone().appendTo('#seopressor-message-container');

                    $('.seopressor-error-message').effect('highlight', {
                        color: '#FF655D'
                    }, 2000, function () {
                    });
                    $('.seopressor-notification-message').effect('highlight', {
                        color: '#BDD1B5'
                    }, 2000, function () {
                    });

                    $.scrollTo(0, 800, {
                        easing: 'swing'
                    });
                }
            },
            success     : function (response_from_server, statusText, xhr, form$) {
                /*
                 * Remove ajax loader and show button.
                 */
                $('.seopressor-submit-tr img, .seopressor-submit-div img', form$).hide();
                $('.seopressor-button,.seopressor-submit-tr button[type="submit"], .seopressor-submit-div button[type="submit"]', form$).button('enable');

                // Clear message dashboard.
                $('#seopressor-message-container').html('');

                if (response_from_server.type == 'notification') {
                    /*
                     * Show server message to user.
                     */
                    $('#seopressor-templates-container .seopressor-notification-message .seopressor-msg-mark').html(response_from_server.message);
                    $('#seopressor-templates-container .seopressor-notification-message').clone().appendTo('#seopressor-message-container');
                    $('.error').hide();
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
                }, 2000, function () {
                });
                $('.seopressor-notification-message').effect('highlight', {
                    color: '#BDD1B5'
                }, 2000, function () {
                });

                $.scrollTo(0, 800, {
                    easing: 'swing'
                });
            },
            type        : 'POST',
            url         : ajaxurl
        });

        /*
         * Wizards.
         */
        $("a[rel^='prettyPhoto']").prettyPhoto({
            overlay_gallery: false,
            social_tools   : false
        });

        api_images = [
            WPPostsRateKeys.plugin_url + 'templates/images/bing-api-steps/1.jpg',
            WPPostsRateKeys.plugin_url + 'templates/images/bing-api-steps/2.jpg',
            WPPostsRateKeys.plugin_url + 'templates/images/bing-api-steps/3.jpg',
            WPPostsRateKeys.plugin_url + 'templates/images/bing-api-steps/4.jpg',
            WPPostsRateKeys.plugin_url + 'templates/images/bing-api-steps/5.jpg',
            WPPostsRateKeys.plugin_url + 'templates/images/bing-api-steps/6.jpg',
            WPPostsRateKeys.plugin_url + 'templates/images/bing-api-steps/7.jpg',
            WPPostsRateKeys.plugin_url + 'templates/images/bing-api-steps/8.jpg'
        ];
        api_titles = [
            '<strong>Step 1:</strong> Go to the Bing Search API page at <a target="_blank" href="https://datamarket.azure.com/dataset/5BA839F1-12CE-4CCE-BF57-A49D98D29A44" title="Windows Azure Marketplace">Windows Azure Marketplace</a>.',
            '<strong>Step 2:</strong> Select the free service of 5,000 transactions/month. This is enough for most users.',
            '<strong>Step 3:</strong> Accept the Terms and Privacy Policy and Sign Up.',
            '<strong>Step 4:</strong> The go to your accounts page at the Bing API page.',
            '<strong>Step 5:</strong> Go to the Accounts Keys page.',
            '<strong>Step 6:</strong> Add and new account and click Save.',
            '<strong>Step 7:</strong> Copy the generated key.',
            '<strong>Step 8:</strong> Paste the generated key into Bing API Key field in SEOPressor and Save Settings.'
        ];
        api_descriptions = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        $('#seopressor-bing-api-get-api-keys-steps-button').click(function () {
            $.prettyPhoto.open(api_images, api_titles, api_descriptions);
        });
    }
};

seop_jquery(SEOPressor_settings);

//To be sure that seopressor code will be executed even when other code generate an exception
SEOPressor_settings_triggered = false;

function OnErrorResponse(){
    if (document.readyState==="interactive" && !SEOPressor_settings_triggered) SEOPressor_settings(seop_jquery);
    //document.readyState==="interactive" means that DOM is ready to interact with it
    //This check is useful to exclude the errors fired before DOMContentLoaded event
}

if (window.addEventListener) window.addEventListener('error', OnErrorResponse);
else window.attachEvent('onerror', OnErrorResponse);
