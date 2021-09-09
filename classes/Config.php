<?php
    // Config Class to handle like: echo Config::get('mysql/host'); //127.0.0.1
    // Config Class access to GLOBALS variable in init.php
    // static method - function accessible directly from API [interfejs programistyczny aplikacji] without intance of the class
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