<?php
	/*	DB class is for DB connection at fly, to avoid require connections and deconnections everytime 
	DB class has static method - STATIC METHODS can be called without prevously constructed instance 
	PDO PHP Database Object will be used 
	Here Singleton- pattern is used, which means that one class has only one instance in aplication 
	Singleton pattern assums the instance can check it's alone */
	class DB
	{
		/* first property of the object is $_instance. The property will be used to check if database if available,	so default value is NULL (not avaiable) */
		static private $_instance = NULL;
		private	$_pdo, $_query, $_error = false, $_results, $_count = 0;
		/* __construct() is standard PHP method for constructor, it is not good to have this method public to avoid multiconnections 
		if __construct() is public it's usage is like $db = new DB(); */
		//public function __construct()
		private function __construct()
		{
			try
			{
				/* __construct() is standard PHP method for constructors, so it's PDO standard method as well, the template is:
				/* public PDO::__construct( string $dsn, ?string $username = null, ?string $password = null, ?array $options = null ); */
				$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').'; dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password') );
				echo"<p>Connected.</p>"; // TEST
			}
			catch(PDOException $e) /* PDOException is SPL class */
			{
				die( $e->getMessage() );
			}
		}//constructPDOInstance()
		
		public static function getInstance()
		{
			/* self is keyword of PHP like this, use self when there is a need to access something which belongs to a class 
			and use $this when there is a need to access a property belonging to the object of the class. */
			if( !isset(self::$_instance) )
			{
				self::$_instance = new DB();
			}//if
			return self::$_instance;
		}//getInstance()
	}

?>