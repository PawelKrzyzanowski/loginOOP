 <?php
    /** 
     * The Class checks if input exists
     * $_POST and $_GET are global so can be isset here
     * get([INPUT_NAME]) = returns value for given input name if exists
    */
    class Input 
    {
        public static function exists($type = 'post')
        {
            switch($type)
            {
                case 'post':
                    return ( !empty($_POST) ) ? true : false;
                    break;
                case 'get':
                    return ( !empty($_GET) ) ? true : false;
                    break;
                default:
                        return false;
                    break;
            }
        }

        public static function get($item)
        {
            if( isset($_POST[$item]) )
                return $_POST[$item];
            else if( isset($_GET[$item]) )
                return $_GET[$item];
            return ''; //sth must be return if nothing is set
        }
    }
 ?>