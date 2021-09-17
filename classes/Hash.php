<?php
    /**
     *   The Hash Class generetes hash for password nad salt
     *   salt is additional string added to password to distynguish users with the same password
     *   string is added and then both are hashed
     *   both are must to get the password again
     */
    Class Hash
    {
        public static function generate($string, $salt='')
        {
            return hash('sha256', $string.$salt); // notice salt is added to string
        }

        public static function generateSalt($length)
        {
            //return mcrypt_create_iv($length); DEPRETIATIED AND REMOVED FROM PHP 7.1.0 
            return random_bytes($length);
        }

        public static function makeUnique()
        {
            return self::generate( uniqid() );
        }
    }
?>