<?php


session_start();



    if(isset($_SESSION['tid'])){
        session_unset();

        session_destroy();
        header('Location: Become-A-Tutor.php');
    }else{
        session_unset();

        session_destroy();
        header('Location: Login.php');
    }