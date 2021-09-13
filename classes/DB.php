<?php
	/*	DB class is for DB connection at fly, to avoid require connections and deconnections everytime 
	DB class has static method - STATIC METHODS can be called without prevously constructed instance 
	PDO PHP Database Object will be used. Here Singleton- pattern is used, which means that one class has 
	only one instance in aplication. Singleton pattern assums the instance can check it's alone.
		First property of the object is $_instance. The property will be used to check if database if available,	
	so default value is NULL (not avaiable). Next object properties are:
	- $_pdo - this is SPL PDO Object for DB connection. PDO and mysqli are API for DB. Here PDO will by used.
	PDO has advantage over MySqli as MySqli works only with MariaDB, and PDO works witch ProstageSQL, MicrosfotSQL etc...
	- $_query - it's like prepared_statemnt wich could be executed
	- $_count - for number of result rows.
		"__construct()" is standard PHP method for constructor, it is not good to have this method public 
	to avoid multiconnections. Ff "__construct()" is public it's usage is like "$db = new DB();". 
	Unlike Java constructor method in php isn't named by class, but the name must be "__construct()".
	So it's PDO standard method as well, the template is:
	public PDO::__construct( string $dsn, ?string $username = null, ?string $password = null, ?array $options = null );
		PDOException is SPL class.
		"self" is keyword of PHP like "this", use "self" when there is a need to access something which belongs to a class 
	and use $this when there is a need to access a property belonging to the object of the class.	
		- "keys" are name of Array cell like array(0=>3, 'color' = 'red') - 0 and 'color' are keys
		array_keys - returns the names
	*/
	class DB
	{
		static private $_instance = NULL;
		private $_pdo, $_query, $_error = false, $_results, $_count = 0;
		
		private function __construct()
		{
			try
			{
				$this->_pdo = new PDO(
				'mysql:host='.Config::get('mysql/host').'; dbname='.Config::get('mysql/db'), 
				Config::get('mysql/username'), 
				Config::get('mysql/password') );
				echo"<p>Connected.</p>"; // TEST
			}
			catch(PDOException $e)
			{
				die( $e->getMessage() );
			}
		}
		
		public static function getInstance()
		{
			if( !isset(self::$_instance) )
			{
				self::$_instance = new DB();
			}
			return self::$_instance;
		}
		
		public function query( $sql, $params=array() )
		{
			$this->_error = false;
			if( $this->_query = $this->_pdo->prepare($sql) )
			{
				foreach( $params as $param )
				{
					$i = 1;
					$this->_query->bindValue($i, $param);
					$i++;
				}
				if($this->_query->execute())
				{
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count = $this->_query->rowCount();
					//echo'<p>_count = '.$this->_count.'</p>'; //diatest
					//echo'<p>_result:</p>'; print_r($this->_results); //diatest
				}
				else
				{
					$this->_error = true;
				}
			}
			return $this;
		}
		
		public function error()
		{
			return $this->_error;
		}
		
		public function get_count()
		{
			return $this->_count;
		}
		
		public function action( $action, $table, $where = array() )
		{
			if(count($where)===3) //whereArray should have 3 parameters
			{
				$field = $where[0];
				$operator = $where[1];
				$value = $where[2];
				
				$operators = array("<","<=","=",">=",">");
				
				if( in_array($operator, $operators) )
				{
					$sql = " {$action} FROM {$table} WHERE {$field} {$operator} ? ";
					echo $sql; // diatest
					$this->query($sql, array($value));
				}
				else
				{
					echo'<p>There is not allowed operator</p>'; // diatest
				}
			}
			else
			{
				echo'<p>where is not 3rd parameter.</p>'; //diatest
			}
			return $this;
		}
		
		public function getAll( $table, $where = array() )
		{
			return $this->action("SELECT *", $table, $where);
		}
		
		public function get_results()
		{
			return $this->_results;
		}
		
		public function insert( $table, $fields = array() )
		{
			if(count($fields))
			{
				$keys = array_keys($fields);
				$qmarks = '';
				$i = 0;
				foreach($fields as $field)
				{
					$qmarks .= '?';
					$i++;
					if($i<count($fields))
						$qmarks .= ',';
				}
				$sql = "INSERT INTO {$table} ('".implode("' , '" ,$keys)."') VALUES ({$qmarks})";
				echo '<p>'.$sql.'</p>';
			}
			
			
			return false;
		}
	}

?>