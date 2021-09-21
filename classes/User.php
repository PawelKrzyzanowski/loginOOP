<?php
/*
 *   The User Class is for Users profile management. The User Class just contains DB Class as parameter to distniguish DB and User Class' tasks.
 *     
 *  PARAMETERS
 *  _dboi - database object instance
 *  _scoi - standard class object instance (this is object-fetched query-result - _dboi parameter extracted for simplicity)
 *  
 *  METHODS
 *  create() = DB::insert(), add new user into database
 *  
 */
    Class User
    {
        private $_dboi, $_userSCOI; 
        
        //we can pass $user value or not
        public function __construct( $user = NULL )
        {
            $this->_dboi = DB::getInstance();
        }
        
        public function create($fields = array())
        {
            if(!$this->_dboi->insert('users', $fields))
                throw new Exception("Wystąpił problem podczas tworzenia konta.");
        }

        private function find($value = NULL)
        {
            if($value)
            {
                $login_or_id = is_numeric($value) ? "userID" : "userLogin"; //assumption that login can not be numeric
                $this->_dboi->selectAll('users', array($login_or_id, "=", $value));
                if( $this->_dboi->get_count() )
                {
                    $this->_userSCOI = $this->_dboi->get_FirstResultI(); //assumption that logins do not repeat
                    return true;
                }
            }
            return false;
        }

        public function get_user()
        {
            return $this->_userSCOI;
        }

        public function login($inputLogin = NULL, $inputPass = NULL)
        {
            //Chceck if the user exists
            $isFound = $this->find($inputLogin);
            if($isFound)
            {
                if( $this->_userSCOI->userPass === Hash::generate( $inputPass, $this->_userSCOI->userSalt) )
                {
                    Session::put( Config::get('session/session_name'), $this->_userSCOI->userID); // $_SESSION['user'] = userID
                    return true;
                }
            }
            else
            {
                //Such a login doesn't exists in database
            }
            return false;
        }

    }
?>