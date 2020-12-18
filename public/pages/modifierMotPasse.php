<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require_once '../../outils/ManagerMembre.class.php';
    $managerMembre = new ManagerMembre();
    include_once '../../classes/Identification.class.php';
    $identification = new Identification();
    $identification->verifierIdentification();
?>


<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>modifier son mot de passe</title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="stylesheet" href="../../style/formulaire.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />
    </head>


    <body>
        <div class="header">
            <?php include("../includes/headerPages.php"); ?> 
        </div>       

        <div class="body">
            <div class="validation">
            <?php
                $infos = $managerMembre->afficherAvantSubmit();
                //var_dump($infos);
                if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
                {
                    $infos = $managerMembre->verifierEtModifierMotPasse();
                }
            ?>
            </div>
            <div class="formulaire">
             <!--<form action="modifierMotPasse.php?ref=<?php echo $infos['idMembre']; ?>" method="post">-->
             <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <legend>Modifier votre mot de passe</legend>
                </br>
                <label>Nouveau mot de passe</label>
                </br>
                <input type="password" name="motPasseUpdate" value="">
                <label>Confirmation</label>
                </br>
                <input type="password" name="confirmUpdate" value="">
                </br>
                <label>Mot de passe actuel</label>
                </br>
                <input type="password" name="actuelPassSaisi" value="">
                </br>
                <input type="text" hidden name="idPersonne" value="<?php echo $infos['idPersonne']; ?>">
                <input type="text" hidden name="pseudo" value="<?php echo $infos['pseudo']; ?>">
                </br>
                <input type="submit" name="update" value="Modifier" 
                    <?php '<script type="text/javascript">location.reload();</script>' ?> 
                />
             </form>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
    </body>
</html>

