<?php
/**
 *  The User Class just contains DB Class as parameter
 *  The User Class is for Users profile management
 *  current user profile manage to distingush and a little simplify 
 *  from other queries direcly made from DB Class
 *  
 */
    Class User
    {
        private $_db;
        //we can pass $user value or not
        public function __construct( $user = NULL )
        {
            $this->_db = DB::getInstance();
        }
        
        public function create($fields = array())
        {
            if(!$this->_db->insert('users', $fields))
                throw new Exception("Wystąpił problem podczas tworzenia konta.");
        }


    }
?>