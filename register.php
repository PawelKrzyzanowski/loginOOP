<?php
    require_once 'core/init.php';

    if( Input::exists() )
    {
        echo 'Submitted: ';
        echo Input::get('username');

        $validationInstance = new Validation();
        
        $validationInstance->checkInput( $_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password2' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'fullname' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ) );

        if($validationInstance->return_passed())
        {
            //register user
            echo'<p>user registered</p>';
        }
        else
        {
            //output errors
            echo'<p>user registration fails</p>';
            print_r( $validationInstance->return_errors() );
        }
    }
?>
<form action="" method="post">
    <div class="fld">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo Input::get('username') ?>" autocomplete="off">
    </div>
    <div class="fld">
        <label for="password">Password</label>
        <input type="text" name="password" id="password" value="" autocomplete="off">
    </div>
    <div class="fld">
        <label for="password2">Password repeat</label>
        <input type="text" name="password2" id="password2" value="" autocomplete="off">
    </div>
    <div class="fld">
        <label for="fullname">Full name</label>
        <input type="text" name="fullname" id="fullname" value="" autocomplete="off">
    </div>
    <input type="submit" value="Sign up">
</form>


