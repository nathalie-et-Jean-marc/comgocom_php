<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerAdministration.class.php'; 
    $idMembre = $_GET['ref'];
    $managerAdministration = new ManagerAdministration();
    $managerAdministration->supprimerMembre($idMembre);

    
    if(isset($_COOKIE['pseudo']) && isset($_COOKIE['admin']) && isset($_COOKIE['verif'])) 
    {    
        //  setcookie("verif", '', time()-3600, '/', 'comgocom.pw');
        //  setcookie("pseudo", '', time()-3600, '/', 'comgocom.pw');  
        //  setcookie("admin", '', time()-3600, '/', 'comgocom.pw');    
        //  setcookie('flag', "", time()-3600, '/', 'comgocom.pw');
        setcookie("verif", '', time()-3600, '/', '.essai.local');
        setcookie("pseudo", '', time()-3600 , '/', '.essai.local');  
        setcookie("admin", '', time()-3600, '/', '.essai.local'); 
        setcookie('flag', "", time()-3600, '/', '.essai.local');
    } 


    header('Location:administration.php');
    exit();
?>
