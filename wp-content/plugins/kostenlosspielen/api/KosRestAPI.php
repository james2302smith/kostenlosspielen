<?php

class KosRestAPI {
    private $code = 200;
    private $status = 'OK';
    private $message = 'Successfully';
    private $data = array();

    public function execute($data) {
        $action = $data['action'];
        if(empty($action)) {
            $action = 'default';
        }
        if(!method_exists($this, $action)) {
            $this->code = 501;
            $this->status = 'Not Implemented';
            $this->message = 'Action "'.$action.'" is not implemented';
            $this->data = array();

            return $this->response();
        }

        $this->$action($data);

        return $this->response();
    }

    public function login($data) {
        $username = $data['username'];
        $password = $data['password'];

        if(!$username || !$password) {
            $this->setResponse(412, 'Precondition Failed', 'You must input username and password', array());
            return;
        }

        //$user = get_user_by('login', $username);
        $existingUser = null;
        if ( $existingUser = get_user_by('login', $username) ) {
            if ( get_user_option('use_ssl', $existingUser->ID) ) {
                $secure_cookie = true;
                force_ssl_admin(true);
            }
        }
        if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( /*0 !== strpos($redirect_to, 'https')*/ false ) && ( 0 === strpos($redirect_to, 'http') ) )
            $secure_cookie = false;

        $credentials = array(
            'user_login' => $username,
            'user_password' => $password,
            'remember' => false
        );
        $user = wp_signon($credentials, $secure_cookie);

        if(is_wp_error($user)) {
            $data = array();
            $message = '';
            if($existingUser) {
                $message = '<div class="standard-margin-bottom"><strong>Bitte gib dein Passwort erneut ein</strong></div>';
                $message .= '<div class="standard-margin-top">Das von dir eingegebene Passwort ist falsch. Bitte versuche es noch einmal. (Stelle dabei sicher, dass deine Feststelltaste nicht gedrückt ist.)</div>';
                $message .= '<div class="standard-margin-top">Du hast dein Passwort vergessen? <a href="'.SITE_ROOT_URL.'/wp-login.php?action=lostpassword">Fordere ein neues an.</a></div>';

                $userDisplayName = trim($existingUser->first_name.' '.$existingUser->last_name);
                if(!$userDisplayName) {
                    $userDisplayName = $existingUser->display_name;
                    if(!$userDisplayName) {
                        $userDisplayName = $existingUser->user_login;
                    }
                }
                $data['user'] = array(
                    'name' => $userDisplayName,
                    'email' => $existingUser->user_email,
                    'avatar' => get_avatar($existingUser->ID, 50)
                );

                $existingUserHtml = '';
                $existingUserHtml .= '<div class="text-left standard-margin">';
                $existingUserHtml .= '  <div class="inline-block avatar">';
                $existingUserHtml .=        $data['user']['avatar'];
                $existingUserHtml .= '  </div>';
                $existingUserHtml .= '  <div class="inline-block standard-margin">';
                $existingUserHtml .= '      <div class="name"><strong>'.$data['user']['name'].'</strong></div>';
                $existingUserHtml .= '      <div class="email">'.$data['user']['email'].'</div>';
                $existingUserHtml .= '  <div class="standard-margin-top use-other-email">';
                $existingUserHtml .= '      <a class="use-other-email" href="javascript:void(0)">Verwenden andere e-mail</a>';
                $existingUserHtml .= '  </div>';
                $existingUserHtml .= '  </div>';
                $existingUserHtml .= '</div>';

                $data['existingUserHtml'] = $existingUserHtml;
            } else {
                $message = '';
                $message = '<div class="standard-margin-bottom"><strong>Falsche E-Mail-Adresse</strong></div>';
                $message .= '<div class="standard-margin-top">Die eingegebene E-Mail-Adresse gehört zu keinem Konto.</div>';
                $message .= '<div class="standard-margin-top">Bitte versuche es noch einmal oder';
                $message .= '   <a href="#authentication_modal_form_register" rel="modal:open">erstelle ein neues Konto</a>.</div>';
            }
            $this->setResponse(401, 'Unauthorized', $message, $data);
            return;
        } else {
            $this->setResponse(202, 'Accepted', 'Deine Anfrage ist in Bearbeitung. Bitte warte einen Moment!', array());
            return;
        }
    }

    public function validateEmail($data) {
        $email          = $data['email'];
        //. Validate email
        $user = get_user_by('email', $email);
        if(!$user) {
            $user = username_exists($email);
        }

        if($user) {
            $this->code = 409;
            $this->status = 'Conflict';
            $this->message = 'Wir kennen diese E-Mail-Adresse… Bist du schon bei uns?<br/><a rel="modal:open" href="#authentication_modal_form_login">Logge dich an</a>, oder erstelle ein <a href="'.SITE_ROOT_URL.'/wp-login.php?action=lostpassword">neues Passwort</a>.';
            $this->data = array();
            return;
        } else {
            $this->code = 200;
            $this->status = 'OK';
            $this->message = 'Wir sagt es nicht weiter.';
            $this->data = array();
            return;
        }
    }
    public function register($data) {
        $firstName      = $data['firstname'];
        $lastName       = $data['lastname'];
        $email          = $data['email'];
        $password       = $data['password'];
        $birthDay       = $data['birthday'];
        $sex            = $data['sex'];

        //Validate data
        if(!$firstName || !$lastName || !$email
            || !$password || !$birthDay || !$sex) {

            $this->code = 412;
            $this->status = 'Precondition Failed';
            $this->message = 'Please input these field [firstName, lastName, email, password, birthDay and sex]';
            $this->data = array();
            return;
        }

        //. Validate email
        $user = get_user_by('email', $email);
        if(!$user) {
            $user = username_exists($email);
        }

        if($user) {
            $this->code = 409;
            $this->status = 'Conflict';
            $this->message = 'Wir kennen diese E-Mail-Adresse… Bist du schon bei uns?<br/><a rel="modal:open" href="#authentication_modal_form_login">Logge dich an</a>, oder erstelle ein <a href="'.SITE_ROOT_URL.'/wp-login.php?action=lostpassword">neues Passwort</a>.';
            $this->data = array();
            return;
        }


        $user = array(
            'user_pass'     => $password,
            'user_login'    => esc_sql($email),
            'user_email'    => esc_sql($email),
            'display_name'  => esc_sql($firstName.' '.$lastName),
            'first_name'    => esc_sql($firstName),
            'last_name'     => esc_sql($lastName)
        );
        //wp_create_user($email, $password, $email);
        $userId = wp_insert_user($user);

        if($userId) {
            $this->code = 201;
            $this->status = 'Created';

            //. Add user meta
            add_user_meta($userId, 'sex', $sex);
            add_user_meta($userId, 'birthday', $birthDay);

            //. Auto login
            //$user = get_user_by('id', $userId);
            if ( get_user_option('use_ssl', $userId) ) {
                $secure_cookie = true;
                force_ssl_admin(true);
            }
            if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( /*0 !== strpos($redirect_to, 'https')*/ false ) && ( 0 === strpos($redirect_to, 'http') ) )
                $secure_cookie = false;

            $credentials = array(
                'user_login' => $email,
                'user_password' => $password,
                'remember' => false
            );

            $loggedIn = true;
            if(is_wp_error(wp_signon($credentials, $secure_cookie))) {
                $loggedIn = false;
                $this->message = 'Register new account successfully. You can login and play game now!';

            } else {
                $loggedIn = true;
                $user = wp_get_current_user();
                $this->message = 'Du hast dich erfolgreich registriert. Bitte warte einen Moment bis du weitergeleitet wirst!';
            }
            //wp_set_auth_cookie($userId);
            //wp_set_current_user($userId);

            $this->data = array('user_id' => $userId, 'loggedIn' => $loggedIn, 'user' => $user);

        } else {
            $this->code = 500;
            $this->status = 'Internal Server Error';
            $this->message = 'There are some error when create new user, please try again later!';
            $this->data = array();
        }

        return;
    }

    public function facebookCallback($data) {
        $accessToken = $data['access_token'];
        if(!$accessToken) {
            //. Do not have accessToken
            $this->setResponse(412, 'Precondition Failed', 'Can not get your accessToken, please try again!', array());
            return;
        }

        require_once KOS_PLUGIN_DIR.'/oauth/facebook/facebook.php';
        $fb = new Facebook(array(
            'appId'  => KOS_FACEBOOK_CLIENT_API,
            'secret' => KOS_FACEBOOK_CLIENT_SECRET,
        ));
        $fb->setAccessToken($accessToken);

        try {
            $fbUser = $fb->api('/me');
            $fbId = $fbUser['id'];

            $firstname = $fbUser['first_name'];
            $lastname  = $fbUser['middle_name'].' '.$fbUser['last_name'];
            $email     = $fbUser['email'];
            $birthday  = $fbUser['birthday'];
            $sex       = $fbUser['gender'];

            //. Find user by email
            $userId = null;
            $user = get_user_by('email', $email);
            if(!$user) {
                $userId = username_exists($email);
            } else {
                $userId = $user->ID;
            }

            $isNewUser = false;
            if(!$userId) {
                //. Create user
                $randomPassword = ''.time();
                $user = array(
                    'user_pass'     => $randomPassword,
                    'user_login'    => esc_sql($email),
                    'user_email'    => esc_sql($email),
                    'display_name'  => esc_sql($firstname.' '.$lastname),
                    'first_name'    => esc_sql($firstname),
                    'last_name'     => esc_sql($lastname)
                );
                //wp_create_user($email, $password, $email);
                $userId = wp_insert_user($user);

                if(!is_wp_error($userId)) {
                    //. Add user meta
                    add_user_meta($userId, 'sex', $sex);
                    add_user_meta($userId, 'birthday', $birthday);
                    $isNewUser = true;
                }
            } else {
                //First name
                if(!get_user_meta($userId, 'first_name', true)) {
                    if(!add_user_meta($userId, 'first_name', $firstname, true)) {
                        update_user_meta($userId, 'first_name', $firstname);
                    }
                }
                if(!get_user_meta($userId, 'last_name', true)) {
                    if(!add_user_meta($userId, 'last_name', $lastname, true)) {
                        update_user_meta($userId, 'last_name', $lastname);
                    }
                }
                if(!get_user_meta($userId, 'birthday', true)) {
                    if(!add_user_meta($userId, 'birthday', $birthday, true)) {
                        update_user_meta($userId, 'birthday', $birthday);
                    }
                }
                if(!get_user_meta($userId, 'sex', true)) {
                    if(!add_user_meta($userId, 'sex', $sex, true)) {
                        update_user_meta($userId, 'sex', $sex);
                    }
                }
            }

            if(!is_wp_error($userId) && $userId) {
                if(!add_user_meta($userId, KOS_FACEBOOK_ID_KEY, $fbId, true)) {
                    update_user_meta($userId, KOS_FACEBOOK_ID_KEY, $fbId, true);
                }
                if(!add_user_meta($userId, KOS_FACEBOOK_PROFILE_ACCESSTOKEN_KEY, $accessToken, true)) {
                    update_user_meta($userId, KOS_FACEBOOK_PROFILE_ACCESSTOKEN_KEY, $accessToken, true);
                }

                //. Auto login
                wp_set_auth_cookie($userId);
                $u = wp_set_current_user($userId);

                $this->setResponse(202, 'Accepted', 'Login with facebook success, your browser will refresh soon!', array('isNewUser' => $isNewUser, 'user' => $u));
                return;
            } else {

                $this->code = 500;
                $this->status = 'Internal Server Error';
                $this->message = 'There are some error when process login with facebook, please try again later!';
                $this->data = array();
            }

        } catch(FacebookApiException $e) {

            $this->setResponse(401, 'Unauthorized', 'There are some error when try to retrieve your facebook information, please try again!', array('fb_exception' => $e));
            return;
        }
    }

    private function setResponse($code, $status, $message, $data) {
        $this->code = $code;
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function response() {
        return array(
            'code' => $this->code,
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        );
    }
}