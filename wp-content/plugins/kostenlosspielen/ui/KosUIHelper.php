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
        $html[] = '         <span class="common-background icon">icon</span>';
        $html[] = '         <div class="hint">';
        $html[] = '             Bitte deine E-Mail eingeben';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = ' </div>';
        $html[] = ' <div class="field">';
        $html[] = '     <input type="password" name="pwd" id="user_pass" class="validate input standard-margin-left standard-margin-right" validate="password" placeholder="Passwort" />';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <span class="common-background icon">icon</span>';
        $html[] = '         <div class="hint">';
        $html[] = '             Bitte deine Passwort eingeben';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = ' </div>';
        $html[] = ' <div class="submit text-center">';
        $html[] = '     <input type="submit" class="user-auth-button auth-email" value="Einloggen mit E-mail" placeholder="Einloggen" />';
        $html[] = '     <input type="hidden" name="redirect_to" value="'. get_permalink() .'"/>';
        $html[] = ' </div>';
        $html[] = '</form>';

        return implode("\n", $html);
    }

    public static function modal_register_form() {
        $html = array();

        $html[] = '<form action="'.wp_login_url(get_permalink()).'" method="POST" data-url="'.KOS_REST_API_URL.'" id="id_modal_registration_form" class="social-connect-form">';
        $html[] = ' <div class="standard-margin alert hidden">';
        $html[] = '     ';
        $html[] = ' </div>';
        $html[] = '   <div class="field inline-block name firstname">';
        $html[] = '       <input type="text" class="validate input standard-margin-left standard-margin-right name" validate="required" name="firstname" placeholder="Vorname..."/>';
        $html[] = '       <div class="field-hint firstname-hint">';
        $html[] = '         <span class="common-background icon">icon</span>';
        $html[] = '         <div class="hint">';
        $html[] = '             Wie ist dein Vorname ?';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="field inline-block float-right name lastname">';
        $html[] = '       <input type="text" class="validate input standard-margin-left standard-margin-right name" validate="notempty " name="lastname" placeholder="Nachname..."/>';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <span class="common-background icon">icon</span>';
        $html[] = '         <div class="hint firstname-hint">';
        $html[] = '             Wie ist dein Nachname ?';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="field show-hint">';
        $html[] = '       <input type="email" class="validate input standard-margin-left standard-margin-right" validate="email" name="email" placeholder="Deine Email Adresse..."/>';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <span class="common-background icon">icon</span>';
        $html[] = '         <div class="hint">';
        $html[] = '             Dies ist keine gültige E-Mail-Adresse. Versuche es bitte noch einmal. Wir sagt es nicht weiter.';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="field">';
        $html[] = '       <input type="password" class="validate input standard-margin-left standard-margin-right" validate="password" name="password" placeholder="Passwort..."/>';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <span class="common-background icon">icon</span>';
        $html[] = '         <div class="hint">';
        $html[] = '             Du brauchst ein Passwort mit mindestens 5 Zeichen.';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="standard-margin field birthday-field">';
        $html[] = '       <label>Geburtsdatum:</label>';
        $html[] = '       <br/>';
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
        $html[] = '       <select class="validate" validate="not empty" name="dob_day">';
        $html[] = '         <option value="-1" selected="">Tag</option>';
        for($i = 1; $i <= 31; $i ++) {
            $html[] = '     <option value="'.$i.'">'.$i.'</option>';
        }
        $html[] = '       </select>';
        $html[] = '       <select class="validate" validate="notempty" name="dob_year">';
        $html[] = '         <option value="-1" selected="">Jahr</option>';
        $currentYear = intval(date('Y'));
        $startYear = $currentYear - 100;
        for($i = $startYear; $i <= $currentYear; $i++) {
            $html[] = '     <option value="'.$i.'">'.$i.'</option>';
        }
        $html[] = '       </select>';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <span class="common-background icon">icon</span>';
        $html[] = '         <div class="hint">';
        $html[] = '             Wann bist du geboren ? Dann wir die Spiele für dich besonder empfehlen können.';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = '   <div class="standard-margin field sex-field">';
        $html[] = '       <label>Geschlecht:</label>';
        $html[] = '       <br/>';
        $html[] = '       <input type="radio" name="sex" value="male" id="sex-male" class="validate"/>';
        $html[] = '       <label for="sex-male" class="check-label">';
        $html[] = '         <img src="'.SITE_ROOT_URL.'/wp-content/themes/twentyten/image/male.png" />';
        $html[] = '         Männlich';
        $html[] = '       </label>';
        $html[] = '       <input type="radio" name="sex" value="female" id="sex-female" class="validate"/>';
        $html[] = '       <label for="sex-female" class="check-label">';
        $html[] = '         <img src="'.SITE_ROOT_URL.'/wp-content/themes/twentyten/image/female.png" />';
        $html[] = '          Weiblich';
        $html[] = '       </label>';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <span class="common-background icon">icon</span>';
        $html[] = '         <div class="hint">';
        $html[] = '             Wie ist dein Geschlecht ? Dann wir die Spiele für dich besonder empfehlen können.';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = '   </div>';
        $html[] = ' <div class="standard-margin field agreement-field">';
        $html[] = '     <input type="checkbox" name="agreement" value="1" id="agreement-checkbox" class="float-left validate"/>';
        $html[] = '     <label for="agreement-checkbox" class="check-label">';
        $html[] = '         Ich habe die <a href="'.SITE_ROOT_URL.'" target="_blank">Datenschutzregelung und Benutzungsbedingungen</a> gelesen und ihnen zugestimmt.';
        $html[] = '     </label>';
        $html[] = '       <div class="field-hint">';
        $html[] = '         <span class="common-background icon">icon</span>';
        $html[] = '         <div class="hint">';
        $html[] = '             Bitte zugestimmt die Datenschutzregelung und Benutzungsbedingungen';
        $html[] = '         </div>';
        $html[] = '       </div>';
        $html[] = ' </div>';
        $html[] = '   <div class="text-center submit">';
        $html[] = '       <input type="submit" value="Registrieren mit Email" class="user-auth-button auth-email" />';
        $html[] = '   </div>';
        $html[] = '</form>';

        return implode("\n", $html);
    }

    public static function social_login_buttons() {
        $html = array();
        $html[] = '<div class="standard-margin social-login-form">';
        $html[] = ' <div class="text-center standard-margin separator">';
        $html[] = '     <span>ODER</span>';
        $html[] = ' </div>';
        $html[] = ' <div class="social-buttons">';
        $html[] = '     <div class="text-center social-button-facebook">';
        $html[] = '         <a href="javascript:void(0)" title="Facebook" class="user-auth-button auth-facebook social-login" provider="facebook" callback="'.KOS_REST_API_URL.'">';
        $html[] = '             <span class="standard-margin-left">Einloggen mit Facebook</span>';
        $html[] = '         </a>';
        $html[] = '     </div>';
        $html[] = ' </div>';
        $html[] = ' <div class="clear"></div>';
        $html[] = '</div>';
        return implode("\n", $html);
    }
}