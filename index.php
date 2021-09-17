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
	$users = DB::getInstance()->query("SELECT userLogin FROM users"); //can be 1 argument
	//$users = DB::getInstance()->action("SELECT *", 'users', array('userName', '=', 'Alex') );
	//$users = DB::getInstance()->selectAll('users', array('userName','=','Alex'));
	if($users->get_error())
	{
		echo'<p>Users query error occured.</p>';
		echo'<p>'.$users->error().'</p>';
	}
	else
	{
		echo'<p>OK</p>';
		if($users->get_count()>0)
		{
			if( $results = $users->get_resultsI() )
			{
				echo'Results:<br>';
				foreach( $users->get_resultsI() as $user )
					echo $user->userLogin.'<br>';
			}
			else
			{
				echo'<p>get_results() failed.</p>';
				echo'<p>'.$users->get_error().'</p>';
			}
		}
		else
		{
			echo'<p>The query returns 0 results.';
		}
	}
	//Example of DB usage - Inserting
	//$userInsert = DB::getInstance()->insert('users', array('userLogin'=>'Felix', 'userPass'=>'somepass', 'userName'=>'Dale', 'userGroup'=>0, 'userSalt'=>'somesalt', 'userJoinDate'=>'2021-09-13') );
	//$user = DB::getInstance()->insert('users', array('userLogin'=>'Dale'));
	//$user = DB::getInstance()->insert('users', array('userLogin'=>'Eric', 'userPass'=>'ericpass'));
	//if($userInsert)	echo'<p>Insert successful</p>';	else echo'<p>Insert unsuccessful</p>';
	//$userUpdate = DB::getInstance()->update('users', 3, array('userName'=>'Casy', 'userPass'=>'newpass', 'userGroup'=>0));
	//if($userUpdate)	echo'<p>Update successful</p>';	else echo'<p>Update unsuccessful</p>';

	//Example of Validation and Session (flash) usage
	if(Session::has('success'))
	{
		echo Session::flash('success');
	}
?>