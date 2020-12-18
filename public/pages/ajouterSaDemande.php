<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include_once '../../outils/ManagerInfosPersonne.class.php';
    include_once '../../outils/ManagerMembre.class.php';
    include_once '../../outils/ManagerOffre.class.php';
    include_once '../../classes/Identification.class.php';
    $identification = new Identification();     
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Ajouter sa demande</title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="stylesheet" href="../../style/formulaireService.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />
        <link rel="stylesheet" href="../../style/jquery-ui.css">
        <script src="../../script/jquery-1.12.3.js"></script>
        <script src="../../script/jquery-ui.js"></script>
        <script type="text/javascript" src="../../script/formulaire.js"></script>


    </head>
     <body>
        <div class="header";>
            <?php include("../includes/headerPages.php"); ?>
        </div>
        <div class="body">
            <?php
                $identification->verifierIdentification();
            ?>
            <h1 style="margin-left:10px;">Ajoutez la demande de service que vous souhaiteriez recevoir :</h1>


<?php

    $managerInfosPersonne = new ManagerInfosPersonne();
    $managerMembre = new ManagerMembre();
    $managerOffre = new ManagerOffre();

    $estActif = $managerInfosPersonne->mailOk($pseudo);
    if ($estActif === FALSE)
    {
        echo "<h3 style='color:green;text-align:center;margin-top:90px;'>Vous n'avez pas encore validé votre adresse mail !<h3>";
        exit();
    }
    else
    {
        $idMembre = $managerMembre->obtenirIdMembreByPseudo($pseudo);
        $estPersonne = $managerInfosPersonne->estUnePersonne($idMembre);
        if($estPersonne === false)
        {
            echo '<h3 style="margin-left:50px;">Pour proposer vos services, merci de renseigner 
                    les informations complémentaires vous concernant.</h3>';
            // avant insertion :
            echo '<div class="validation">';
            $infosAdrr = $managerInfosPersonne->infosAvantInsertAdrr($idMembre);
            //var_dump($infosAdrr);
                if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
                {
                    $infosAdrr = $managerInfosPersonne->infosPostAdrrPersonne($idMembre);
                    $managerInfosPersonne->verifierEtInscrireAdrrPersDemande($idMembre);
                }
            echo '</div>';
    

            include('formulairePersonne.php');
        }
        else 
        {
            echo '<h3 style="margin-left:50px;">Merci de renseigner les informations 
                    concernant le service que vous proposez.</h3>';
        
            $infosService = $managerOffre->infoAvantInsertDemande($idMembre);
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
            {
                echo '<div class="validation">';         
                //$infosService = $managerOffre->infosDemandePourInsert($idMembre);
                
                $infosService = $managerOffre->verifierEtInsertDemande($idMembre);
                echo '</div>';     
            }


            include('formulaireAjoutDemande.php');
        }
    }
?>
        <h2>coucou</h2>

        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
     </body>
</html>

