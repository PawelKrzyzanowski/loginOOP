<?php
    require_once('core/init.php');
    /* Eample of Config class usage */
    echo '<br>host...........'.Config::get('mysql/host'); // 127.0.0.1
    echo '<br>dbName.........'.Config::get('mysql/db'); 
	echo '<br>cookieExpiry...'.Config::get('remember/cookie_expiry');
    echo '<br>sessionName....'.Config::get('session/session_name');
	/* Example of DB class usage - quering 
	"$db = new DB();" - before getInstance declaration: when __construct() was public */
	//$users = DB::getInstance()->query("SELECT userName FROM users WHERE userName = ?", array('Alex') );
	$users = DB::getInstance()->query("SELECT userName FROM users"); //can be 1 argument
	//$users = DB::getInstance()->action("SELECT *", 'users', array('userName', '=', 'Alex') );
	//$users = DB::getInstance()->getAll('users', array('userName','=','Alex'));
	if($users->error())
	{
		echo'<p>Users query error occured.</p>';
		echo'<p>'.$users->error().'</p>';
	}
	else
	{
		echo'<p>OK</p>';
		if($users->get_count()>0)
		{
			if( $results = $users->get_results() )
			{
				echo'Results:<br>';
				foreach( $users->get_results() as $user )
					echo $user->userName.'<br>';
			}
			else
			{
				echo'<p>get_results() failed.</p>';
				echo'<p>'.$users->error().'</p>';
			}
		}
		else
		{
			echo'<p>The query returns 0 results.';
		}
	}
	//Example of DB usage - Inserting
	$user = DB::getInstance()->insert('users', array('userName'=>'Dale', 'userPass'=>'somepass', 'salt'=>'somesalt') );
	
	
?>