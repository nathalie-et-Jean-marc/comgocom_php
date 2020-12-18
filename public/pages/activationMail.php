<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include_once '../../outils/ManagerMembre.class.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>activation </title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />
    </head>
 
     <body>
        <div class="header">
            <?php include("../includes/headerPages.php"); ?> 
        </div>

        <div class="body">
            <div class="activation">
                <?php 
                    $manager = new ManagerMembre();            
                    $manager->verifierEtActiver();
                ?>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
     </body>
</html>
