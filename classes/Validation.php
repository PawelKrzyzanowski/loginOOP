<?php
    /** 
     *  Validation Class chcecks if all defined condtitions are met
     *  In terms of properties whanted is:
     *  - checks if the validation is passed or not
     *  - check if there are any errors and store them to output them
     *  - ability to create/or return (Singleton) present instance of datbase when construct the validaton
     */

    class Validation
    {
        private $_hasPassed = false,
                $_errorDescrs = array(),
                $_dbI = NULL;
        
        public function __construct()
        {
            $this->_dbI = DB::getInstance();
            //echo'<p>Printing this from Validation __construct:<br>';
            //print_r($this);
        }

        public function checkInput( $inputData, $inputNames = array(), $displayNames = array() )
        {
            foreach( $inputNames as $inputName => $rules )
            {
                $displayName = $displayNames["{$inputName}"];
                foreach( $rules as $rule => $ruleValue ) 
                {
                    $inputValue = trim($inputData[$inputName]); // trim() deletes whitespaces from ends of the string
                    
                    //echo"{$displayName} {$rule} must be {$ruleValue}<br>"; //TEST
                    //echo"{$inputValue}<br>"; //TEST
                    if($rule === 'required' && empty($inputValue) ) //missing data
                    {
                        //$this->addErrorDescr("{$inpuName} is required.");
                        $this->addErrorDescr("{$displayName} jest wymagany(e).");
                    }
                    else if(!empty($inputValue)) //not missing - check if wrong data
                    {
                        switch($rule) 
                        {
                            case 'min':
                                if( strlen($inputValue) < $ruleValue )
                                {
                                    //$this->addErrorDescr("{$displayName} must be minimum of {$ruleValue} characters.");
                                    $this->addErrorDescr("{$displayName} musi zawierać od {$ruleValue} znaków.");
                                }
                                    
                                break;
                            case 'max':
                                if( strlen($inputValue) > $ruleValue )
                                {
                                    //$this->addErrorDescr("{$displayName} must be maximum of {$ruleValue} characters.");
                                    $this->addErrorDescr("{$displayName} musi zawierać do {$ruleValue} znaków.");
                                }
                                    
                                break;
                            case 'unique':
                                //ruleValue reffers to database table name
                                $this->_dbI->selectAll($ruleValue, array($inputName, '=', $inputValue) ); // INPTUS NAME MUST SAME AS DB COLUMNS NAMES
                                if( $this->_dbI->get_count() > 0 )
                                {
                                    //$this->addErrorDescr("{$inputName} already exists");
                                    $this->addErrorDescr("{$displayName} występuje już w bazie danych.");
                                }
                                break;
                            case 'matches':
                                //ruleValue reffers to another inputName, and inputValue should matche another inputValue
                                if($inputValue != $inputData["{$ruleValue}"])
                                {
                                    //$this->addErrorDescr("{$inputName} must match {$ruleValue}.");
                                    $this->addErrorDescr("{$displayName} musi być taki sam jak {$ruleValue}.");
                                } 
                                break;
                        }
                    }
                }
            }
            if(empty($this->_errorDescrs))
            {
                $this->_hasPassed = true;
            }
            return $this;
        }

        private function addErrorDescr($errorDescr)
        {
            $this->_errorDescrs[] = $errorDescr;     //array_push() equivalent
        }

        public function get_errorDescrs()
        {
            return $this->_errorDescrs;
        }

        public function hasPassed()
        {
            return $this->_hasPassed;
        }
    }
?>