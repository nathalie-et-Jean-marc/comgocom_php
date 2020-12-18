<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerOffre.class.php';
    $managerOffre = new ManagerOffre();

    $idOffre = $_GET['idOffre'];    
    $pseudo = $_GET['log'];
    session_start();
    $sessionLog = $_SESSION['login'];
    var_dump($pseudo);
    var_dump($sessionLog);

    if ( $pseudo == $sessionLog)
    {
        $managerOffre->suppressionServiceParUser($idOffre);
        header('Location:gererSonCompte.php');
        exit(); 
    }
    else
    {
        header('Location:identification.php');
        exit(); 
    }
?>
