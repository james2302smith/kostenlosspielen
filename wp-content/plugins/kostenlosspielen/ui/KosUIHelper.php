<?php

class KosUIHelper {
    public static function modal_login_form() {
        $html = array();

        $html[] = '<form id="id_modal_login_form" action="'.wp_login_url().'" method="POST" data-url="'.KOS_REST_API_URL.'" class="social-connect-form">';
        $html[] = ' <div class="standard-margin alert hidden">';
        $html[] = '     ';
        $html[] = ' </div>';
        $html[] = ' <div class="field existing-user standard-margin">';
        $html[] = '     ';
        $html[] = ' </div>';
        $html[] = ' <div class="field username">';
        $html[] = '     <input type="text" name="log" id="user_login" class="validate input standard-margin-left standard-margin-right" validate="username" placeholder="E-Mail-Adresse" />';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <div class="hint">';
        $html[] = '             <span class="fa fa-warning"></span> <span class="text-hint">Bitte deine E-Mail eingeben</span>';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = ' </div>';
        $html[] = ' <div class="field">';
        $html[] = '     <input type="password" name="pwd" id="user_pass" class="validate input standard-margin-left standard-margin-right" validate="password" placeholder="Passwort" >';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <div class="hint">';
        $html[] = '             <span class="fa fa-warning"></span> <span class="text-hint">Bitte deine Passwort eingeben</span>';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = ' </div>';
        $html[] = ' <p class="forgot-pass"><a href="'.home_url('wp-login.php?action=lostpassword').'" class>Forgot your username or password?</a></p>';
        $html[] = ' <div class="submit text-center">';
        $html[] = '     <input type="submit" class="user-auth-button auth-email" value="LOG IN" placeholder="Einloggen" />';
        $html[] = '     <input type="hidden" name="redirect_to" value="'. get_current_url() .'" >';
        $html[] = ' </div>';
        $html[] = ' <p class="not-a-member"><a onclick="switchRegister(this)" href="javascript:void(0)">NOT A MEMBER YET?</a></p>';
        $html[] = '</form>';

        return implode("\n", $html);
    }

    public static function modal_register_form() {
        $html = array();

        $html[] = '<form action="'.wp_login_url(get_permalink()).'" method="POST" data-url="'.KOS_REST_API_URL.'" id="id_modal_registration_form" class="social-connect-form">';
        $html[] = ' <div class="standard-margin alert hidden">';
        $html[] = '     ';
        $html[] = ' </div>';
        $html[] = '   <div class="field name firstname">';
        $html[] = '       <input type="text" class="validate input standard-margin-left standard-margin-right name" validate="required" name="firstname" placeholder="Vorname..." >';
        $html[] = '       <div class="field-hint firstname-hint">';
        $html[] = '         <div class="hint">';
        $html[] = '             <span class="fa fa-warning"></span> <span class="text-hint">Wie ist dein Vorname ?</span>';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="field float-right name lastname">';
        $html[] = '       <input type="text" class="validate input standard-margin-left standard-margin-right name" validate="notempty " name="lastname" placeholder="Nachname..." >';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <div class="hint firstname-hint">';
        $html[] = '             <span class="fa fa-warning"></span> <span class="text-hint">Wie ist dein Nachname ?</span>';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="field show-hint">';
        $html[] = '       <input type="email" class="validate input standard-margin-left standard-margin-right" validate="email" name="email" placeholder="Deine Email Adresse..." >';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <div class="hint">';
        $html[] = '             <span class="fa fa-warning"></span> <span class="text-hint">Dies ist keine gültige E-Mail-Adresse. Versuche es bitte noch einmal. Wir sagt es nicht weiter.</span>';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="field">';
        $html[] = '       <input type="password" class="validate input standard-margin-left standard-margin-right" validate="password" name="password" placeholder="Passwort..." >';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <div class="hint">';
        $html[] = '             <span class="fa fa-warning"></span> <span class="text-hint">Du brauchst ein Passwort mit mindestens 5 Zeichen.</span>';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="standard-margin field birthday-field row">';
        $html[] = '   <div class="col-xs-4">';
        $html[] = '       <select class="validate" validate="notempty" name="dob_month">';
        $html[] = '         <option value="-1">Monat</opion>';
        $html[] = '         <option value="1">Januar</option>';
        $html[] = '         <option value="2">Februar</option>';
        $html[] = '         <option value="3">März</option>';
        $html[] = '         <option value="4">April</option>';
        $html[] = '         <option value="5">Mai</option>';
        $html[] = '         <option value="6">Juni</option>';
        $html[] = '         <option value="7">Juli</option>';
        $html[] = '         <option value="8">August</option>';
        $html[] = '         <option value="9">September</option>';
        $html[] = '         <option value="10">Oktober</option>';
        $html[] = '         <option value="11">November</option>';
        $html[] = '         <option value="12">Dezember</option>';
        $html[] = '       </select>';
        $html[] = '   </div>';
        $html[] = '   <div class="col-xs-4">';
        $html[] = '       <select class="validate" validate="not empty" name="dob_day">';
        $html[] = '         <option value="-1" selected="">Tag</option>';
        for($i = 1; $i <= 31; $i ++) {
            $html[] = '     <option value="'.$i.'">'.$i.'</option>';
        }
        $html[] = '       </select>';
        $html[] = '   </div>';
        $html[] = '   <div class="col-xs-4">';
        $html[] = '       <select class="validate" validate="notempty" name="dob_year">';
        $html[] = '         <option value="-1" selected="">Jahr</option>';
        $currentYear = intval(date('Y'));
        $startYear = $currentYear - 100;
        for($i = $startYear; $i <= $currentYear; $i++) {
            $html[] = '     <option value="'.$i.'">'.$i.'</option>';
        }
        $html[] = '       </select>';
        $html[] = '   </div>';
        $html[] = '       <div class="field-hint col-xs-12">';
        $html[] = '         <div class="hint">';
        $html[] = '             <span class="fa fa-warning"></span> <span class="text-hint">Wann bist du geboren ? Dann wir die Spiele für dich besonder empfehlen können.</span>';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="standard-margin field sex-field">';
        $html[] = '     <div class="select-gender clearfix">';
        $html[] = '        <input type="radio" name="sex" value="male" id="sex-male" class="validate" checked="checked" />';
        $html[] = '        <input type="radio" name="sex" value="female" id="sex-female" class="validate" />';
        $html[] = '        <label class="button-sex toggle-male" class="button-sex" for="sex-male">Male</label>';
        $html[] = '        <label class="button-sex toggle-female" for="sex-female">Female</label>';
        $html[] = '     </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="standard-margin field sex-field">';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <div class="hint">';
        $html[] = '             <span class="fa fa-warning"></span> <span class="text-hint">Wie ist dein Geschlecht ? Dann wir die Spiele für dich besonder empfehlen können.</span>';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = ' <div class="standard-margin field agreement-field">';
        $html[] = '     ';
        $html[] = '   <div class="checkbox">';
        $html[] = '     <label for="agreement-checkbox" class="check-label"><input type="checkbox" name="agreement" value="1" id="agreement-checkbox" class="float-left validate" >';
        $html[] = '         Ich habe die <a href="'.home_url().'" target="_blank">Datenschutzregelung und Benutzungsbedingungen</a> gelesen und ihnen zugestimmt.';
        $html[] = '     </label>';
        $html[] = '   </div>';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <div class="hint">';
        $html[] = '             <span class="fa fa-warning"></span> <span class="text-hint">Bitte zugestimmt die Datenschutzregelung und Benutzungsbedingungen</span>';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = ' </div>';
        $html[] = '   <div class="text-center submit">';
        $html[] = '       <input type="submit" value="JOIN FOR FREE" class="user-auth-button auth-email" />';
        $html[] = '   </div>';
        $html[] = '   <p class="switch-login"><a onclick="switchLogin(this)" href="javascript:void(0)">ALREADY HAVE AN ACCOUNT?</a></p>';
        $html[] = '</form>';

        return implode("\n", $html);
    }

    public static function social_login_buttons() {
        $html = array();
        $html[] = '<div class="standard-margin social-login-form">';
        $html[] = ' <div class="social-buttons">';
        $html[] = '     <div class="row social-button-facebook">';
        $html[] = '         <div class="col-xs-6">';
        $html[] = '             <a href="javascript:void(0)" title="Facebook" class="btn auth-facebook social-login btn-block" provider="facebook" callback="'.KOS_REST_API_URL.'">';
        $html[] = '                 <i class="fa fa-facebook"></i><span class="standard-margin-left">Facebook</span>';
        $html[] = '             </a>';
        $html[] = '         </div>';
        $html[] = '         <div class="col-xs-6">';
        $html[] = '             <a href="javascript:void(0)" title="Google" class="btn auth-google social-login btn-block" provider="goggle" callback="'.KOS_REST_API_URL.'">';
        $html[] = '                 <i class="fa fa-google-plus"></i><span class="standard-margin-left">Google +</span>';
        $html[] = '             </a>';
        //$html[] = '<div class="g-signin2" data-onsuccess="onSignIn"></div>';
        $html[] = '         </div>';
        $html[] = '     </div>';
        $html[] = ' </div>';
        $html[] = ' <div class="clear"></div>';
        $html[] = '</div>';
        return implode("\n", $html);
    }
}