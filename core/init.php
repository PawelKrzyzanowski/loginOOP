<?php
    session_start();
    //THIS WILL BE INCLUDED ON EVERY PAGE I'LL CREATE

    $GLOBALS['config'] = array(
        'mysql' => array(
            'host' => '127.0.0.1', /*localhost*/
            'username' => 'root',
            'password' => '',
            'db' => 'loginOOP'
        ), /* database config   => is the separator for associative arrays */
        'remember' => array(
            'cookie_name' => 'hash',  /* cookies if user choose to be remembered */
            'cookie_expiry' => 604800 /* cookies expiry time - month in seconds */
        ),
        'session' => array(
            'session_name' => 'user'
        ) /* session name, token */
    );

    spl_autoload_register(
        function($class)
        {
            require_once('classes/'.$class.'.php');
        }
    );
    /* spl_autoload_register(FUNCTION_WHICH_INCLUDE_PROPER_FILES(CLASS_NAME_WHICH_IS_ACCESSED)) Insted of:
        require_once('classes/Config.php');
        require_once('classes/Cookie.php');
        etc... to handle directory and files rename
        SPL - STANDARD PHP LIBRARY,  NOTICE '.php' in require_once THAHS WHY CLASSES ARE NAMES LIKE FILES
        spl_autoload_register works like: You write: $db = new DB();  --> PHP includes the classes/DB.php
    */
    require_once('functions/sanitize.php');
?>