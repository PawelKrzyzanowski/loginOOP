<?php
    require_once 'core/init.php';
    if( Input::exists() )
    {
        // echo'<p>Submitted</p>';
        if( Token::check( Input::get('token') ) ) //CSRF
        {
            $VOI = new Validation();
            $VOI->checkInput( $_POST, 
                array(
                    /* INPUT_NAME => RULE_NAME => RULE_VALUE */
                    'userLogin' => array(
                        'required' => true
                    ),
                    'userPass' => array(
                        'required' => true
                    ),
                ),
                array(  
                    /* INPUT_NAME => DISPLAY_NAME */
                    'userLogin' =>  'Login', 
                    'userPass'  =>  'Hasło', 
                ) 
            );

            if( $VOI->hasPassed() )
            {
                Session::flash('success','Walidacja ukończona pomyślnie.');
                Session::flash('success');
                $user = new User();
                $login = $user->login(Input::get('userLogin'), Input::get('userPass'));
                if($login)
                {
                    echo"Jesteś zalogowany.";
                }
                else
                {
                    echo"Nie udało się zalogować.";
                }
            }
            else
            {
                $msg = "<p>Walidacja przerwana.<br>";
                foreach( $VOI->get_errorDescrs() as $error )
                {
                    $msg .= $error."<br>";
                }
            }
        }
    }
?>
<form action="" method="post">
    <div class="fld">
        <label for="userLogin">Login</label>
        <input type="text" name="userLogin" id="userLogin" value="<?php echo escape(Input::get('userLogin')); ?>" autocomplete="off">
    </div>
    <div class="fld">
        <label for="userPass">Hasło</label>
        <input type="password" name="userPass" id="userPass" value="" autocomplete="off">
    </div>
    <input type="submit" value="Sign in">
    <input type="hidden" name="token" id="token" value="<?php echo Token::generate(); ?>">
</form>
<?php
    if( isset($msg) )
        echo $msg;
?>