<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include_once '../../outils/ManagerAdministration.class.php'; 
    include_once '../../classes/Identification.class.php';
    $identification = new Identification();
    $identification->verifierIdentification();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Administration</title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="stylesheet" href="../../style/formulaire.css">
        <link rel="stylesheet" href="../../style/tableau.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />
    </head>
     <body>
        <div class="header">
            <?php include("../includes/headerPages.php"); ?> 
        </div>
        <div class="body">
            <h2>Administration</h2>

            <?php
                $managerAdministration = new ManagerAdministration();
                $managerAdministration->afficherTableDesMembres();
            ?>
        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
     </body>
</html>
