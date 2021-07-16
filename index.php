<?php
    require_once('core/init.php');
    //EXAMPLE OF USE Config CLASS
    echo Config::get('mysql/host'); // 127.0.0.1
    //echo Config::get('mysql/db'); 
    //echo Config::get('session/session_name');
    //echo Config::get('remember/cookie_expiry');
?>