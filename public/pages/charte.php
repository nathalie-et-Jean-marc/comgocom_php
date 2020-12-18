<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerPagesMembre.class.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>formulaire d'inscription</title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="stylesheet" href="../../style/charte.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />
    </head>
     <body>
        <div class="header";>
            <?php include("../includes/headerPages.php"); ?>
        </div>
        <div class="body">
            
            <div class="boiteCharte"> 
                <h3>Charte de confidentialité</h3>
                <p>Ce site ne collecte pas de données personnelles auprès de ses visiteurs, 
                   à moins que ceux-ci ne remplissent le formulaire d'inscription.
                   Si vous décidez de remplir le formulaire, le propriétaire du site s'engage à maintenir 
                   la confidentialité des informations de ce formulaire et à utiliser ces informations uniquement 
                   pour vous répondre.</p>
                <p>Les informations relatives au formulaire d'inscription ne seront pas 
                       transmises à des sociétés et organismes publicitaires ou commerciales.</p>
                <p>En revanche, le propriétaire du site se réserve le droit 
                   de divulguer les informations relatives au formulaire d'inscription à toute autorité compétente si la loi l'y oblige.</p> 
                 
            </div>      
        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
     </body>
</html>

