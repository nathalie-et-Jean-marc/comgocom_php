<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include_once '../../outils/ManagerMembre.class.php';
?>

<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Modifier ses information personnelles</title>
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="stylesheet" href="../../style/formulaire.css">

        <script>
            function confirmer(){
            var res = confirm("Êtes-vous sûr de vouloir supprimer?");
            if(res){
            // Mettez ici la logique de suppression
            }
        </script>
    </head>
 
     <body>
        <div class="header">
            <?php include("../includes/headerPages.php"); ?> 
        </div>

        <div class="body">
                <?php
                    // if ($_SERVER["REQUEST_METHOD"] != "POST")
                    // {
                    //   $quelMail=$_GET['typeMail'];
                    // }
                    $quelMail=$_GET['typeMail'];
                    $ref=$_GET['ref'];
                    // avant submit :
                    $managerMembre = new ManagerMembre();
                    $managerMembre->supprimerMail($ref,$quelMail);
                    header('Location:votreProfil.php');
                    //exit(); 

                ?>
        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
     </body>
</html>
