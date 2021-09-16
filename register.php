<?php
    require_once 'core/init.php';

    if( Input::exists() )
    {
        //echo 'Submitted: ';
        //echo Input::get('userLogin');

        $VOI = new Validation(); //VOI contains DBOI and PDOI

        $VOI->checkInput( $_POST, 
            array(
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
            array('userLogin' => 'Login', 'userPass' => 'Hasło', 'userPass2' => 'Powtórzone hasło', 'userName' => 'Imię i nazwisko') 
        );

        if( $VOI->get_hasPassed() )
        {
            //register user
            //echo'<p>Validation passed.</p>';
            echo'<p>Walidacja ukończona pomyślnie.</p>';
        }
        else
        {
             
            //output errors
            //echo'<p>Validation has not passed. Errors:<br>';
            //echo'<p>Walidacja przerwana.<br>';
            $msg = "<p>Walidacja przerwana.<br>";
            foreach( $VOI->get_errorDescrs() as $error )
            {
                //echo $error."<br>";
                $msg .= $error."<br>";
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
</form>
<?php
    if( isset($msg) )
        echo $msg;
?>


