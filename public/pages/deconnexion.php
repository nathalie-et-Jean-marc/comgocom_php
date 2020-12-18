<?php



    setcookie("verif", "", time() -3600, '/', 'comgocom.pw');
    setcookie("pseudo", '', time() -3600 , '/', 'comgocom.pw');  
    setcookie("admin", '', time() -3600, '/', 'comgocom.pw');

    session_start();
    //session_destroy(); // Destruit la session en cours
    //session_unset();   // Detruit toutes les variables de la session en cours
    unset($_SESSION["login"]);
    unset($_SESSION["admin"]);

    header('location:../../index.php');
    exit;

