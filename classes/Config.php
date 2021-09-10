<?php
    /* Config Class to handle like: echo Config::get('mysql/host'); //127.0.0.1
	Config.php Class is used by DB class to pass database parameters to DB Class instance.
    static method - function accessible directly from API without intance of the class (no constructor). 
	*/
    class Config
    {
        public static function get($path=null)
        {
            if($path)
            {
                $config = $GLOBALS['config'];
                $path = explode('/',$path);
                foreach($path as $bit)
                {
					if( isset( $config[$bit] ) )
                    {
                        $config = $config[$bit];
                    }
                }//foreach
				return $config;
            }//if
			return false;
        }//get
    }//class
?>