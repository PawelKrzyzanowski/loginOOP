<?php
    require_once 'core/init.php';
    if( Input::exists() )
    {
        //echo "Submitted.<br>";
        if( Token::check( Input::get('token') ) ) //CSRF
        {
            $VOI = new Validation();
            $VOI->checkInput( $_POST, 
                array(
                    /* INPUT_NAME => RULE_NAME => RULE_VALUE */
                    'userLogin' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 20,
                        'unique' => 'users' // unique means doesn't repeat in database table: [RULE_NAME] => [DATABASE_TABLE_NAME] 
                    ),
                    'userPass' => array(
                        'required' => true,
                        'min' => 6
                    ),
                    'userPass2' => array(
                        'required' => true,
                        'matches' => 'userPass' //matches means the same as the other input: [RULE_NAME] => [THE_OTHER_INPUT_NAME]
                    ),
                    'userName' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 50
                    )
                ),
                array(  
                    /* INPUT_NAME => DISPLAY_NAME */
                    'userLogin' =>  'Login', 
                    'userPass'  =>  'Hasło', 
                    'userPass2' =>  'Powtórzone hasło', 
                    'userName'  =>  'Imię i nazwisko'
                ) 
            );

            if( $VOI->get_hasPassed() )
            {
                //echo'<p>Validation passed.</p>';
                //echo'<p>Walidacja ukończona pomyślnie.</p>';
                Session::flash('success','Walidacja ukończona pomyślnie.');
                $userI = new User();
                try
                {
                    $userI->create( 
                        array(
                            'userName' => '',
                            'userPass' => '',
                            'userSalt' => '',
                            'userName' => '',
                            'userJoinDate' => '',
                            'userGroup' => ''
                        ) 
                    );
                }
                catch(Exception $e) // User::create() may throw exception
                {
                    die($e->getMessage());
                }
            }
            else
            {
                //echo'<p>Validation has not passed. Errors:<br>';
                $msg = "<p>Walidacja przerwana.<br>";
                foreach( $VOI->get_errorDescrs() as $error )
                {
                    //echo $error."<br>";
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
        <input type="text" name="userPass" id="userPass" value="" autocomplete="off">
    </div>
    <div class="fld">
        <label for="userPass2">Powtórzone hasło</label>
        <input type="text" name="userPass2" id="userPass2" value="" autocomplete="off">
    </div>
    <div class="fld">
        <label for="userName">Imię i nazwisko</label>
        <input type="text" name="userName" id="userName" value="<?php echo escape(Input::get('userName')); ?>" autocomplete="off">
    </div>
    <input type="submit" value="Sign up">
    <input type="hidden" name="token" id="token" value="<?php echo Token::generate(); ?>">
</form>
<?php
    if( isset($msg) )
        echo $msg;
?>


