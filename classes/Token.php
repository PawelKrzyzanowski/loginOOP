<?php
    /**
     * Token Class is for CSRF protection - to not allow for passing data thru URL like:
     * CSRF - Cross-Site Request Forgery 
     * localhost/loginOOP/register.php?userName = Pawel
     * which causes 'Pawel' appears in the form.
     * To avoid CSEF attack for each page unique Token will be created, which only the page knows
     * The Token Class generates the token
     * Token name (string) is defined in core/init.php assures submitting data only from forms
     * 
     * Token implementation user guide:
     * 1. define token_name in core/init.php
     * 2. add hidden input to form witch Token::generate()
     * 3. add Token::check( Input::get('token') ) at the beginning of the script which is processing the input
     * 4. define object for Token in Token Class with these functions as below
     *    - md5() - hahses the string
     *    - uniqid() - returns time-stamp (semi-height probability of unique identifier) based on current time in microseconds
     * 5. add Session Class, define Session Object Session::put() the "put" method pass the token to the session
     * 6. the chceck() method checks if the form-token is the same as the session-token
     *    - thamks to this mechanism only form's data will be submited 
     */

    Class Token
    {
        public static function generate()
        {
            //Session::put(TOKEN_NAME, TOKEN_VALUE)
            return  Session::put(   Config::get('session/token_name')/*get*/, md5(uniqid())/*md5*/ );/*put*/
        }

        public static function check($formToken)
        {
            $tokenName = Config::get('session/token_name');
            //Token is deleted from the session if it's same as the form-token
            if( Session::has($tokenName) && $formToken === Session::get($tokenName) )
            {
                Session::delete($tokenName);
                return true;
            }
            return false;
        }

    }
?>