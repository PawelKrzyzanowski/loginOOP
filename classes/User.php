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
        private $_dboi, $_userSCOI, $_sessionName, $_isLoggedIn; 
        
        //you can pass $userID value or not
        public function __construct( $userID = NULL ) //userID or userLogin can be passed
        {
            //the construcotr set present user as default and save its ID as $_sessionName parameter
            //the construtor set user of passed ID when argument exists 
            $this->_dboi = DB::getInstance();
            $this->_sessionName = Config::get('session/session_name');
            
            if(!$userID) // executes when userID is NULL
            {
                if( Session::has($this->_sessionName) )     //Chceck if the session had been set by login() and the user is loggedIn
                {
                    if($this->find($this->_sessionName))    //saves the current user data in _userSCOI
                    {
                        $this->_isLoggedIn = true;          //set the login-flag
                    }
                    else
                    {
                        $this->_isLoggedIn = false;
                    } 
                }
            }
            else // executes when some argument is passed thru the constructor()
            {
                $this->find( $userID );                      // saves passed user data in _userSCOI
            }
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
                    $this->_sessionName = Config::get('session/session_name');
                    Session::put( $this->_sessionName , $this->_userSCOI->userID); // $_SESSION['user'] = userID
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