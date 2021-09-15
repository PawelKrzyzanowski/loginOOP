<?php
    /** 
     *  Validation Class chcecks if all defined condtitions are met
     *  In terms of properties whanted is:
     *  - checks if the validation is passed or not
     *  - check if there are any errors and store them to output them
     *  - ability to create/or return (Singleton) present instance of datbase when construct the validator
     */
    class Validation
    {
        private $_passed = false,
                $_errors = array(),
                $_db = NULL;
        
        public function __construct()
        {
            $this->_db = DB::getInstance();
            echo'<p>Printing this from Validation __construct:<br>';
            print_r($this);
        }

        public function checkInput( $source, $fieldnames = array() )
        {
            foreach( $fieldnames as $fieldname => $rules )
            {
                foreach( $rules as $rule => $rule_value )
                {
                    echo"{$fieldname} {$rule} must be {$rule_value}<br>"; //TEST
                    $value = $source[$fieldname];
                    echo"{$value}<br>"; //TEST

                    if($rule === 'required' && empty($value) )
                    {
                        $this->addError("{$fieldname} is required");
                    }
                    else
                    {
                        //all's right, do nothing
                    }
                }
            }
            if(empty($this->_errors))
            {
                $this->_passed = true;
            }
            return $this;
        }

        private function addError($errorDescr)
        {
            $this->_errors[] = $errorDescr;     //array_push() equivalent
        }

        public function return_errors()
        {
            return $this->_errors;
        }

        public function return_passed()
        {
            return $this->_passed;
        }
    }
?>