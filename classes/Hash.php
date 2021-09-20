<?php
    /**
     *   The Hash Class generetes hash for password nad salt
     *   salt is additional string added to password to distynguish users with the same password
     *   string is added and then both are hashed
     *   both are must to get the password again
     *   
     *   generateSatl():
     *   return mcrypt_create_iv($length); DEPRETIATIED AND REMOVED FROM PHP 7.1.0 
     *   I was getting Warning with random_bytes at userSalt VARCHAR(32) warnign:
     *   SQLSTATE[22007]: Invalid datetime format: 1366 Incorect string value [...]
     *   Solution 1:
     *   - the warnigns wanished when VARCHAR type was chagned to VARBINARY(32) - then database was keeping *.bin files in rows and the "Original Length" was unknow? 
     *   I had used length parameter in random_bytes
     *   Solution 2:
     *   - I noticed random_bytes(16) can be used witch bin2hex(), then 32 string ASCII is generated and all ASCII chars has always the same length so 
     *   salt has determined length, ASCII has less chars then UTF_8 so UTF_8 collocation still works
     *   I have choossed second solution to avoid the warnig and kept both columns Pass and Salt the same type
     *   
     */
    Class Hash
    {
        public static function generate($string, $salt='')
        {
            return hash('sha256', $string.$salt); // notice salt is added to string
        }

        public static function generateSalt($length)
        {
            return bin2hex(random_bytes($length));
        }

        public static function makeUnique()
        {
            return self::generate( uniqid() );
        }
    }
?>