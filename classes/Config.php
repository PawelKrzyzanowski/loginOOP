<?php
    // Config Class to handle like: echo Config::get('mysql/host'); //127.0.0.1
    // Config Class access to GLOBALS variable in init.php
    //static method - function accessible directly from API [interfejs programistyczny aplikacji] without intance of the class
    class Config
    {
        public static function get($path=null)//DEFAULT VALUE IS NULL
        {
            //CHECK PATH WAS PASSED TO THE FUNCTION
            if($path)
            {
                $config = $GLOBALS['config'];//$config vsrable introduced to not use $GLOBALS['config'] everytime
                $path = explode('/',$path); //$path overload
                //print_r($path); //Array ( [0] => mysql [1] => host )
                foreach($path as $bit)
                {
                    if( isset( $config[$bit] ) )
                    {
                        echo $bit.' ';//mysql host
                        //to print values:
                        $config = $config[$bit];
                        print_r($config);
                    }
                    return $config;
                }
            }
        }
    }
?>