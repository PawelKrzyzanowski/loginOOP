<?php
    Class Redirect
    {
        public static function to($location = null)
        {
            if(is_numeric($location))
            {
                switch($location)
                {
                    case 404:
                        header("HTTP/1.0 404 Not Found");   //This allows to display 404.php with out URL change. Nor actual URL will display as well.
                        include "includes/errors/404.php";
                        exit();
                    break;
                }
            }
            if($location)
            {
                header("Location: {$location}");
                exit();
            }
        }
    }
?>