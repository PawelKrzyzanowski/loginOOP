<?php
    require_once('core/init.php');
    /* Eample of Config class usage */
    echo '<br>host...........'.Config::get('mysql/host'); // 127.0.0.1
    echo '<br>dbName.........'.Config::get('mysql/db'); 
	echo '<br>cookieExpiry...'.Config::get('remember/cookie_expiry');
    echo '<br>sessionName....'.Config::get('session/session_name');
	/* Example of DB class usage
	before getInstance declaration: when __construct was public, multiconnections where avialable 
		$db = new DB();
	after getInstance() declaration, __construct = DB() is private method of DB called by getInstance and PDO cretion looks like:*/
	DB::getInstance();
	/*
		$users = DB::getInstance()->query("SELECT userName FROM users");
		$users2 = DB::getInstance()->get('users', array('username','=','Alex'));
		if($users->count)
		{
			foreach($users as $user)
			{
				echo $user->$userName;
			}	
		}
	*/
?>