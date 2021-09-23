<?php
    require_once 'core/init.php';
    $user = new User();
    $user->logout();
    Session::flash('home','Zostałeś pomyślnie wylogowany.');
    Redirect::to('index.php');
?>