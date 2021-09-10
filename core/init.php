<?php
    session_start();
    /*
		- This script contains global variable array with all database access configuration parameters.
		So it will be called on every further page. Especialy init.php is used by Config Class witch
		uses singleton pattern to acces to GLOBALS array thru object instance.
		- spl - stands for Standard PHP Library, and spl_autoload_register is it's standard method.
		- spl_autoload_register(FUNCTION_WHICH_INCLUDE_PROPER_FILES(CLASS_NAME_WHICH_IS_ACCESSED)) Insted of:
        require_once('classes/Config.php');
        require_once('classes/Cookie.php'); etc... to handle directory and files rename
		- spl_autoload_register works like: You make connection (write: $db = new DB();)  --> PHP includes the classes/DB.php
		- "=>" is the separator between property name and value and works like "=" for associative arrays.
		- Cookies will be used if user chooses to be rembered.
	*/

    $GLOBALS['config'] = array(
        'mysql' 	=>	array(  'host' => '127.0.0.1',	'username' => 'root',	'password' => '',	'db' => 'loginOOP'   ),
        'remember' 	=> 	array(	'ookie_name' => 'hash',	'cookie_expiry' => 604800	),
        'session' 	=> 	array(	'session_name' => 'user' ) 
    );//GLOBALS array

    spl_autoload_register(
        function($class)
        {
            require_once('classes/'.$class.'.php');
        }
    );
	
    require_once('functions/sanitize.php');
?>