<?php
    /**
     * The put(VARIABLE_NAME, VALUE) sets the valut to the variable and 
     * sets the $_SESSION[VARIABLE_NAME] with the VALUE and
     * returns the $_SESSION variable
     * 
     * The "put" method is used in Token class to pass generated token value to the session
     */
    class Session
    {
        public static function put($name, $value)
        {
            return $_SESSION[$name] = $value;
        }
        public static function has($name)
        {
            return isset($_SESSION[$name]);
        }
        public static function delete($name)
        {
            if(self::has($name))
                unset($_SESSION[$name]);
        }
        public static function get($name)
        {
            if(self::has($name))
                return $_SESSION[$name];
        }
        public static function flash($name, $msg="") //set or flashes session msg to later display
        {
            if( self::has($name) )
            {
                $msg = self::get($name);
                self::delete($name);
                return $msg;
            }
            else 
            {
                self::put($name, $msg); //put returns the value
            }
        }
    }
?>