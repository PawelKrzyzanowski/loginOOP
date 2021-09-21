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
		private $_pdoI, $_pdoStmI, $_error = false, $_resultsI, $_count = 0;
		
		private function __construct()
		{
			try
			{
				$this->_pdoI = new PDO(
				'mysql:host='.Config::get('mysql/host').'; dbname='.Config::get('mysql/db'), 
				Config::get('mysql/username'), 
				Config::get('mysql/password') );
				//echo"<p>Connected.</p>"; // TEST
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
			if( $this->_pdoStmI = $this->_pdoI->prepare($sql) )
			{
				//echo'<p>Prepared query: <br>';		//test
				//print_r($this->_pdoStmI); echo'<br>';	//test
				$i = 1;
				foreach( $params as $param )
				{
					//echo'binded Value: '.$param.' on $i = '.$i.'<br>';
					$this->_pdoStmI->bindValue($i, $param);
					$i++;
				}
				if($this->_pdoStmI->execute())
				{
					$this->_resultsI = $this->_pdoStmI->fetchAll(PDO::FETCH_OBJ); // returns standard class object instance (parameters as columns)
					$this->_count = $this->_pdoStmI->rowCount();
					//echo'<p>_count = '.$this->_count.'</p>'; //test
					//echo'<p>_result:</p>'; print_r($this->_resultsI); //test
				}
				else
				{
					$this->_error = true;
				}
			}
			return $this;
		}
		
		public function get_error()
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
					//echo $sql; // test
					$this->query($sql, array($value));
				}
				else
				{
					//echo'<p>There is not allowed operator</p>'; // test
				}
			}
			else
			{
				//echo'<p>where is not 3rd parameter.</p>'; //test
			}
			return $this;
		}
		
		public function selectAll( $table, $where = array() )
		{
			return $this->action("SELECT *", $table, $where);
		}
		
		public function get_resultsI()
		{
			return $this->_resultsI;
		}

		public function get_FirstResultI()
		{
			return $this->_resultsI[0];
			//or $this->get_resultsI()[0]; - however that one didn't work
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
					$qmarks .= "?";
					$i++;
					if($i<count($fields))
						$qmarks .= ', ';
				}
				$sql = "INSERT INTO {$table} (`".implode('`, `', $keys) ."`) VALUES ({$qmarks})";
				//echo '<p>'.$sql.'</p>'; //TEST
				if(!$this->query($sql, $fields)->get_error())
				{
					return true;
				}
			}
			return false;
		}

		public function update($table, $id, $fields)
		{
			$set = '';
			$i = 1;
			foreach($fields as $name => $value)
			{
				$set .= "{$name} = ?";
				if($i < count($fields)) 
					$set .= ", ";
				$i++;
			}
			$sql = "UPDATE {$table} SET {$set} WHERE userID={$id}";


			if(!$this->query($sql, $fields)->get_error())
			{
				return true;
			}
			return false;
		}
	}

?>