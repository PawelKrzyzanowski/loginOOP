<?php
    /**
     * Token Class is for CSRF protection - to not allow for passing data thru URL like:
     * localhost/loginOOP/register.php?userName = Pawel
     * which causes 'Pawel' appears in the form.
     * To avoid CSEF attack for each page unique Token will be created, which only the page knows
     */

     
?>