//. Define common module



jQuery(document).ready(function($) {

    var formUtil = {
        defaultValidate: {
            required: false,
            email: false,
            password: false,
            minLength: 0,
            maxLength: 0
        },

        /**
         *
         * @param $input
         * @param validate
         * @param options
         * @returns {boolean}
         */
        validateInput: function($input, validate, options) {
            var validate = $.extend({}, this.defaultValidate, validate);
            var options = options || {};

            var $field = $input.closest("div.field");
            var type = $input.attr('type');
            var value = type == 'checkbox' ? $input.is(':checked') : $input.val().trim();

            var ret = true;
            if(validate.required) {
                if(!value) {
                    $field.removeClass("ok");
                    $field.addClass("error");

                    ret = ret && false;
                } else {
                    $field.removeClass("error");
                    $field.addClass("ok");

                    ret = ret && true;
                }
            }
            if(validate.minLength > 0) {
                if(value.length < validate.minLength) {
                    $field.removeClass("ok");
                    $field.addClass("error");

                    ret = ret && false;
                } else {
                    $field.removeClass("error");
                    $field.addClass("ok");

                    ret = ret && true;
                }
            }
            if(validate.maxLength > 0) {
                if(value.length > validate.maxLength) {
                    $field.removeClass("ok");
                    $field.addClass("error");

                    ret = ret && false;
                } else {
                    $field.removeClass("error");
                    $field.addClass("ok");

                    ret = ret && true;
                }
            }

            if(validate.email) {
                if(typeof value == 'string' && value.indexOf('@') != -1) {
                    $field.removeClass("error");
                    $field.addClass("ok");

                    ret = ret && true;
                } else {
                    $field.removeClass("ok");
                    $field.addClass("error");

                    ret = ret && false;
                }
            }
            if(validate.password) {
                //TODO: how to validate password
            }

            return ret;
        }
    };

    //TODO: rename this function
    $('#login-toggle').on('click', function(e) {
        var modalId = '#signinRegisterBox, #signinRegisterBox';
        var $forms = $(modalId);
        if($forms) {
            $forms.each(function () {
                var $form = $(this);
                $form.find('div.field').removeClass('ok').removeClass('error');
                $form.find('div.alert').removeClass('alert-danger').removeClass('.alert-success').addClass('hidden');
                $form.find('div.field input[type="text"]').val('');
                $form.find('div.field input[type="password"]').val('');
                $form.find('div.field input[type="email"]').val('');
                $form.find('div.field select').val('');
                $form.find('div.field input[type="checkbox"]').attr('checked', false);
                //$form.find('div.field input[type="radio"]').attr('checked', false);

                $form.find('div.field.existing-user').hide();
                $form.find('div.field.username').show();
            });
        }

        //Return to next event
        return true;
    });

    $('#id_modal_registration_form').on('blur', 'input.validate, select.validate', function(e){
        var $field = $(e.target || e.srcElement);
        var $form = $field.closest('form');
        var name = $field.attr('name');

        if(name == 'firstname' || name == 'lastname') {
            val = formUtil.validateInput($field, {required: true}, {});
        } else if(name == 'email') {
            var $div = $field.closest('div.field');
            var $hint = $div.find('div.hint .text-hint');
            var val = formUtil.validateInput($field, {required: true, email: true}, {});
            if(!val) {
                $hint.html('Dies ist keine gültige E-Mail-Adresse. Versuche es bitte noch einmal. Wir sagt es nicht weiter.');
                return;
            }

            //. Check existing email
            var email = $field.val();
            var url = $div.closest('form').attr('data-url');
            var requestData = {
                action: 'validateEmail',
                email: email
            };
            //. Submit form
            $.ajax({
                type: 'POST',
                url: url,
                data: requestData,
                dataType: 'json',
                error: function() {
                    //. Print error
                    $div.removeClass("ok").addClass('error');
                    $hint.html('We can not validate your email now!');
                },
                success: function(response) {
                    if(response.code == 200) {
                        //. Validated email
                        $div.removeClass("error").addClass('ok');
                        $hint.html(response.message);

                    } else if(response.code == 409) {
                        //. Email was registered
                        $div.removeClass("ok").addClass('error');
                        $hint.html(response.message);

                    } else {
                        //. Other error
                        $div.removeClass("ok").addClass('error');
                        $hint.html(response.message);
                    }
                }
            });

        } else if(name == 'password') {
            val = formUtil.validateInput($field, {required: true, minLength: 5}, {});
        } else if(name == 'dob_month' || name == 'dob_day' || name == 'dob_year') {

            var again = $field.attr('again');
            if(again != '1') {
                setTimeout(function() {
                    $field.attr('again', '1');
                    $field.blur();
                }, 1000);
                return;
            }
            $field.attr('again', '0');

            var $focused = $(':focus');
            var focusedName = $focused.attr('name');

            if(focusedName == 'dob_month' || focusedName == 'dob_day' || focusedName == 'dob_year') {
                return;
            }

            var $field = $form.find('select[name="dob_month"]').closest('div.field');
            var month = $form.find('select[name="dob_month"]').val();
            var day = $form.find('select[name="dob_day"]').val();
            var year = $form.find('select[name="dob_year"]').val();
            var MAX_DAY = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            var val = true;
            if(month <= 0 || day <= 0 || year <= 0 ||
                month > 12 || day > 31 || year < 1900 || year > 2020) {
                val = false;
            } else {
                var maxDay = MAX_DAY[month];
                if(month == 2) {
                    if(year % 100 == 0 && year % 400 == 0) {
                        maxDay = 29;
                    } else if(year % 4 == 0 && year % 100 != 0) {
                        maxDay = 29;
                    }
                }

                if(day > maxDay) {
                    val = false;
                }
            }

            if(val) {
                $field.removeClass('error');
                $field.addClass('ok');
            } else {
                $field.removeClass('ok');
                $field.addClass('error');
            }
            var birthDay = year + '-' + (month > 9 ? month : "0" + month) + '-' + (day > 9 ? day : "0" + day);

        } else if(name == 'sex') {
            var again = $field.attr('again');
            if(again != '1') {
                setTimeout(function() {
                    $field.attr('again', '1');
                    $field.blur();
                }, 1000);
                return;
            }

            var $focused = $(':focus');
            var focusedName = $focused.attr('name');
            if(focusedName == 'sex') {
                return;
            }

            var $sex = $form.find('input[name="sex"]:checked');
            var $sexField = $form.find('input[name="sex"]').closest('div.field');
            if($sex.length > 0) {
                $sexField.removeClass('error').addClass('ok');
            } else {
                $sexField.removeClass('ok').addClass('error');
            }
        } else if (name == 'agreement') {
            formUtil.validateInput($field, {required: true}, {});
        }
    });

    $('#id_modal_registration_form').on('submit', function(e) {
        e.preventDefault();
        var $form = $(e.target);

        var validated = true;
        var val;

        //1. Validate firstName
        var $firstName = $form.find('input[name="firstname"]');
        var firstName = $firstName.val().trim();
        val = formUtil.validateInput($firstName, {required: true}, {});
        validated = validated && val;

        //2. Validate lastName
        var $lastName =  $form.find('input[name="lastname"]');
        var lastName = $lastName.val().trim();
        val = formUtil.validateInput($lastName, {required: true}, {});
        validated = validated && val;

        //3. Validate email
        //TODO: need validate email
        var $email = $form.find('input[name="email"]');
        var email = $email.val().trim();
        val = formUtil.validateInput($email, {required: true, email: true}, {});
        validated = validated && val;

        //. Validate password
        var $password = $form.find('input[name="password"]');
        var password = $password.val().trim();
        val = formUtil.validateInput($password, {required: true, minLength: 8}, {});
        validated = validated && val;

        //4. Validate birthday
        var $field = $form.find('select[name="dob_month"]').closest('div.field');
        var month = $form.find('select[name="dob_month"]').val();
        var day = $form.find('select[name="dob_day"]').val();
        var year = $form.find('select[name="dob_year"]').val();
        var MAX_DAY = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        var val = true;
        if(month <= 0 || day <= 0 || year <= 0 ||
            month > 12 || day > 31 || year < 1900 || year > 2020) {
            val = false;
        } else {
            var maxDay = MAX_DAY[month];
            if(month == 2) {
                if(year % 100 == 0 && year % 400 == 0) {
                    maxDay = 29;
                } else if(year % 4 == 0 && year % 100 != 0) {
                    maxDay = 29;
                }
            }

            if(day > maxDay) {
                val = false;
            }
        }

        if(val) {
            $field.removeClass('error');
            $field.addClass('ok');
        } else {
            $field.removeClass('ok');
            $field.addClass('error');
        }
        validated = validated && val;
        var birthDay = year + '-' + (month > 9 ? month : "0" + month) + '-' + (day > 9 ? day : "0" + day);

        //5. Validate sex
        var $sex = $form.find('input[name="sex"]:checked');
        var $sexField = $form.find('input[name="sex"]').closest('div.field');
        var sex = 'male';
        if($sex.length > 0) {
            sex = $sex.val();
            $sexField.removeClass('error').addClass('ok');
        } else {
            $sexField.removeClass('ok').addClass('error');
            validated = false;
        }

        //6. Validate has accepted
        var $accept = $form.find('input[name="agreement"]');
        var accepted = $accept.is(':checked');
        val = formUtil.validateInput($accept, {required: true}, {});
        validated = validated && val;

        //. If has field not validated, return
        if(!validated) {
            return false;
        }

        //. Submit form
        var url = $form.attr('data-url');
        if(!url) {
            //Delegate to default form
            return true;
        }

        var requestData = {
            action: 'register',
            firstname: firstName,
            lastname: lastName,
            email: email,
            password: password,
            birthday: birthDay,
            sex: sex
        };

        var $alert = $form.find('div.alert');

        //Show loading
        $alert.removeClass('hidden')
            .removeClass("alert-danger")
            .addClass("alert-success")
            .html('<img src="/wp-content/themes/twentyten/image/ajax-loader.gif"/> Deine Anfrage ist in Bearbeitung. Bitte warte einen Moment.');
            //TODO: @nttuyen - change this text

        //. Submit form
        $.ajax({
            type: 'POST',
            url: url,
            data: requestData,
            dataType: 'json',
            error: function() {
                //. Print error
                $alert.removeClass("hidden");
                $alert.removeClass("alert-success");
                $alert.addClass("alert-danger");
                $alert.html("Can not connect to server, please try again later.");
            },
            success: function(response) {
                if(response.code == 201) {
                    //. Register successfully
                    $alert.removeClass("hidden");
                    $alert.removeClass("alert-danger");
                    $alert.addClass("alert-success");
                    $alert.html(response.message);

                    if(response.data && response.data.loggedIn) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500)
                    }

                } else if(response.code == 409) {
                    //. Email was registered
                    $alert.removeClass("hidden");
                    $alert.removeClass("alert-success");
                    $alert.addClass("alert-danger");
                    $alert.html(response.message);

                    var $field = $email.closest('div.field');
                    $field.removeClass("ok");
                    $field.addClass("error");
                    $field.find('.hint').html(response.message);

                } else {
                    //. Other error
                    $alert.removeClass("hidden");
                    $alert.removeClass("alert-success");
                    $alert.addClass("alert-danger");
                    $alert.html(response.message);
                }
            }
        });

        return false;
    })

    $('#id_modal_login_form').on('blur', 'input.validate, select.validate', function(e){
        var $field = $(e.target || e.srcElement);
        var $form = $field.closest('form');
        var name = $field.attr('name');

        if(name == 'log') {
            formUtil.validateInput($field, {required: true}, {});
        } else if(name == 'pwd') {
            formUtil.validateInput($field, {required: true, password: true}, {});
        }
    });
    $('#id_modal_login_form').on('submit', function(e){
        e.preventDefault();
        var $form = $(e.target);

        var validated = true;
        var val;

        //. Username field
        var $username = $form.find('input[name="log"]');
        var username = $username.val();
        val = formUtil.validateInput($username, {required: true}, {});
        validated = validated && val;

        //. Password
        var $password = $form.find('input[name="pwd"]');
        var password = $password.val();
        val = formUtil.validateInput($password, {required: true, password: true}, {});
        validated = validated && val;

        if(!validated) {
            return false;
        }

        //. Submit form
        var url = $form.attr('data-url');
        if(!url) {
            //Delegate to default form
            return true;
        }

        var $alert = $form.find('div.alert');
        var data = {
            action: 'login',
            username: username,
            password: password
        };

        //Show loading
        $alert.removeClass('hidden')
            .removeClass("alert-danger")
            .addClass("alert-success")
            .html('<img src="/wp-content/themes/twentyten/image/ajax-loader.gif"/> Deine Anfrage ist in Bearbeitung. Bitte warte einen Moment.');

        var $inputFields = $form.find('div.field, div.submit');
        var $socials = $form.closest('div.box-form').find('div.separator, div.social-buttons');

        $inputFields.hide();
        $socials.hide();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            error: function() {
                //. Print error
                $alert.removeClass("hidden");
                $alert.removeClass("alert-success");
                $alert.addClass("alert-danger");
                $alert.html("Can not connect to server, please try again later.");
            },
            success: function(response) {
                if(response.code == 202) {
                    //. Login successfully
                    $alert.removeClass("hidden");
                    $alert.removeClass("alert-danger");
                    $alert.addClass("alert-success");
                    $alert.html(response.message);

                    setTimeout(function() {
                        window.location.reload();
                    }, 0);

                } else if(response.code == 401) {
                    $inputFields.show();
                    $socials.show();

                    //. Wrong username or password
                    $alert.removeClass("hidden");
                    $alert.removeClass("alert-success");
                    $alert.addClass("alert-danger");
                    $alert.html(response.message);

                    //Username field
                    $username.closest('div.field').removeClass('error').removeClass('ok');
                    $password.closest('div.field').removeClass('error').removeClass('ok');

                    //TODO: process existing user here
                    if(response.data.user) {

                        $form.find('div.existing-user').show().html(response.data.existingUserHtml);
                        $form.find('div.username').hide();
                    } else {
                        $form.find('div.existing-user').hide();
                        $form.find('div.username').show();
                    }

                } else {
                    //. Other error
                    $inputFields.show();
                    $socials.show();

                    $form.find('div.existing-user').hide();
                    $form.find('div.username').show();

                    $alert.removeClass("hidden");
                    $alert.removeClass("alert-success");
                    $alert.addClass("alert-danger");
                    $alert.html(response.message);
                }
            }
        });


        return false;
    });

    $('#id_modal_login_form').on('click', 'a.use-other-email', function(e){
        e.preventDefault();
        var $form = $(e.target).closest('#id_modal_login_form');
        $form.find('div.username').show();
        $form.find('div.existing-user').hide();

        return false;
    });

    $('.social-buttons').on('click', 'a.social-login', function(e){
        e.preventDefault();
        var $provider = $(e.target).closest('a.social-login');
        var provider = $provider.attr('provider');
        var $alert = $provider.closest('div.body').find('div.alert');
        var $form = $provider.closest('div.form-login').find('form');

        //. Login with facebook
        if(provider == 'facebook') {
            //Show loading
            $alert.removeClass('hidden')
                .removeClass("alert-danger")
                .addClass("alert-success")
                .html('<img src="/wp-content/themes/twentyten/image/ajax-loader.gif"/> Deine Anfrage ist in Bearbeitung. Bitte warte einen Moment.');

            var $inputFields = $form.find('div.field, div.submit');
            var $names = $form.find('div.name');
            var $socials = $form.closest('div.box-form').find('div.separator, div.social-buttons');
            var $intro = $form.closest('div.modal').find('div.authentication-intro');

            $inputFields.hide();
            $names.hide();
            $socials.hide();
            $intro.css('visibility', 'hidden');

            FB.login(function(response) {
                if (response.authResponse) {
                    var callback = $provider.attr('callback');
                    if(callback) {
                        var accessToken = response.authResponse.accessToken;
                        $.ajax({
                            type: 'POST',
                            url: callback,
                            data: {
                                action: 'facebookCallback',
                                access_token: accessToken
                            },
                            dataType: 'json',
                            error: function() {
                                //. Show form
                                $inputFields.show();
                                $names.css('display', 'inline-block');
                                $socials.show();
                                $intro.css('visibility', 'visible');

                                //. Print error
                                $alert.removeClass('hidden')
                                    .removeClass('alert-success')
                                    .addClass('alert-danger')
                                    .html('<strong>Error:</strong> Can not connect to server, please try again later.');
                            },
                            success: function(response) {
                                if(response.code == 202) {
                                    //. Login successfully
                                    $alert.removeClass("hidden");
                                    $alert.removeClass("alert-danger");
                                    $alert.addClass("alert-success");
                                    $alert.html('<strong>Success:</strong> ' + response.message);
                                    $alert.addClass("hidden");

                                    closeLogin(e);

                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 500);

                                } else {
                                    //. Show form
                                    $inputFields.show();
                                    $socials.show();
                                    $intro.css('visibility', 'visible');

                                    //. Other error
                                    $alert.removeClass("hidden");
                                    $alert.removeClass("alert-success");
                                    $alert.addClass("alert-danger");
                                    $alert.html('<strong>Error:</strong> ' + response.message);
                                }
                            }
                        });
                    }
                } else {
                    //. Show form
                    $inputFields.show();
                    $names.css('display', 'inline-block');
                    $form.find('div.lastname').removeClass('float-right').css('float', 'right');
                    $socials.show();
                    $intro.css('visibility', 'visible');

                    //. Print error
                    $alert.addClass('hidden')
                        .removeClass('alert-success')
                        .removeClass('alert-danger')
                }
            },{scope: 'public_profile,user_friends,email,user_birthday'});
        }

        return false;
    });

    function attachSignin(auth2, elements) {
        $.each(elements, function(index, element) {
            auth2.attachClickHandler(element, {},
                function(googleUser) {
                    var profile = googleUser.getBasicProfile();
                    var authResp = googleUser.getAuthResponse();

                    var $provider = $(element).closest('a.social-login');
                    var provider = $provider.attr('provider');
                    var $alert = $provider.closest('div.form-box').find('div.alert');
                    var $form = $provider.closest('div.form-box').find('form');
                    var callback = $provider.attr('callback');

                    var $inputFields = $form.find('div.field, div.submit');
                    var $names = $form.find('div.name');
                    var $socials = $form.closest('div.box-form').find('div.separator, div.social-buttons');
                    var $intro = $form.closest('div.modal').find('div.authentication-intro');

                    $inputFields.hide();
                    $names.hide();
                    $socials.hide();
                    $intro.css('visibility', 'hidden');

                    if(callback) {
                        $.ajax({
                            type: 'POST',
                            url: callback,
                            data: {
                                action: 'googleCallback',
                                access_token: authResp.access_token,
                                google_id: profile.getId(),
                                email: profile.getEmail(),
                                name: profile.getName(),
                                last_name: profile.getGivenName(),
                                first_name: profile.getFamilyName()
                            },
                            dataType: 'json',
                            error: function() {
                                //. Show form
                                $inputFields.show();
                                $names.css('display', 'inline-block');
                                $socials.show();
                                $intro.css('visibility', 'visible');

                                //. Print error
                                $alert.removeClass('hidden')
                                    .removeClass('alert-success')
                                    .addClass('alert-danger')
                                    .html('<strong>Error:</strong> Can not connect to server, please try again later.');
                            },
                            success: function(response) {
                                if(response.code == 202) {
                                    //. Login successfully
                                    $alert.removeClass("hidden");
                                    $alert.removeClass("alert-danger");
                                    $alert.addClass("alert-success");
                                    $alert.html('<strong>Success:</strong> ' + response.message);
                                    $alert.addClass("hidden");

                                    closeLogin(null);

                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 500);

                                } else {
                                    //. Show form
                                    $inputFields.show();
                                    $socials.show();
                                    $intro.css('visibility', 'visible');

                                    //. Other error
                                    $alert.removeClass("hidden");
                                    $alert.removeClass("alert-success");
                                    $alert.addClass("alert-danger");
                                    $alert.html('<strong>Error:</strong> ' + response.message);
                                }
                            }
                        });
                    }

                }, function(error) {
                    alert(JSON.stringify(error, undefined, 2));
                }
            );
        });
    }
    gapi.load('auth2', function() {
        window.auth2 = gapi.auth2.init({
            client_id: KOS_GOOGLE_CLIENT_API,
            scope: 'profile'
        });
        attachSignin(window.auth2, document.getElementsByClassName('auth-google'));
    });

    $('body').on('click', '[data-action="fullscreen"]', function(e) {
        $('body').toggleClass('full-screen');
    });

    $('.game-action').on('click', 'a[data-action="likeToggle"]', function(e){
        if (!window.LOGGED_IN) {
            //openLogin(e);
            //return;
        }

        var $target = $(e.target).closest('[data-action="likeToggle"]');
        var url = $target.data('url');
        var liked = $target.data('liked');
        var game = $target.data('game');
        var data = {
            action: liked ? 'unfavorite' : 'favorite',
            game: game
        };
        $.ajax({
            type: 'GET',
            url: url,
            data: data,
            dataType: 'json',
            error: function() {
                alert("add to favorite error, please try again");
            },
            success: function(data) {
                if(data.code == 200) {
                    $target.data('liked', !liked);
                    $target.attr('data-liked', !liked + '');

                    $target.find('.icon-cm').toggleClass('icon-cm-heart-yellow-add').toggleClass('icon-cm-heart-yellow-remove');
                }
            }
        });
    });

    $('.category-box-item').on('hover', '[cat-name]', function(e) {
        var $a = $(e.target).closest('[cat-name]');
        var image = $a.attr('game-image');
        if (image) {
            $a.closest('.category-box-item').find('img').attr('src', image);
        }
    });

    //TODO: pagination at favorite menu
    (function() {
        var ITEM_PER_PAGE = 7;
        var $secondary = $('#secondary');
        var $pagin = $secondary.find('ul.pagin');
        var $menu = $secondary.find('ul.menu');

        var $items = $menu.find('li');
        var total = $items.length;
        var pages = Math.ceil(total/ITEM_PER_PAGE);

        function showPage(page) {
            for (var i = 0; i < total; i++) {
                $($items[i]).hide();
            }
            var start = (page - 1)*ITEM_PER_PAGE;
            if (start < 0) start = 0;
            var end = start + ITEM_PER_PAGE;

            for (var i = start; i < end; i++) {
                $($items[i]).show();
            }
        }

        $pagin.html('');
        if (pages > 1) {
            for (var i = 1; i <= pages; i++) {
                var page = i;
                var $item = $('<li data-page="'+i+'"><a href="#">' + i + '</a></li>');
                $item.click(function(e){
                    showPage($(e.target).closest('[data-page]').data('page'));
                });
                $pagin.append($item);
            }
        }
        showPage(1);
    })();
});
