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
        public static function exists($name)
        {
            return isset($_SESSION[$name]);
        }
        public static function delete($name)
        {
            if(self::exists($name))
                unset($_SESSION[$name]);
        }
        public static function get($name)
        {
            if(self::exists($name))
                return $_SESSION[$name];
        }
    }
?>