<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include_once '../../outils/ManagerMembre.class.php';
    include_once '../../classes/Identification.class.php';
    $identification = new Identification();
    $identification->verifierIdentification();
?>

<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Modifier ses information personnelles</title>
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="stylesheet" href="../../style/formulaire.css">

    </head>
 
     <body>
        <div class="header">
            <?php include("../includes/headerPages.php"); ?> 
        </div>

        <div class="body">

            <div class="validation">
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] != "POST")// avant submit :
                        {
                          $quelMail=$_GET['typeMail'];

          
                         // var_dump($infos);
                        }

                        $managerMembre = new ManagerMembre();
                        $infos = $managerMembre->afficherAvantSubmit();
                        // après submit :
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
                        {
                            $infos = $managerMembre->verifierEtModifierMail();

                            //var_dump($infos);
                            $quelMail= htmlspecialchars_decode((trim($_POST['quelMail'])));
                        }    
                    ?>
            
            </div> 
            <?php
                if($quelMail === "mail1")
                {
            ?>
                    <div class="formulaire">
                        <!--<form action="modifierMail.php?ref=<?php echo $infos['idPersonne']; ?>" method="post">-->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <legend> Modifier votre email 1</legend>
                                </br>
                                <input class="saisie" type="text" name="mailUpdate" value="<?php echo $infos['mail1']; ?>"><br />
                                </br>
                                <label>Mot de passe</label><br />
                                <input class="saisie" type="password" 
                                        name="actuelPassSaisi" value="" placeholder="" >
                                <input type="text" hidden name="pseudoUpdate" value="<?php echo $infos['pseudo']; ?>">
                                <input type="text" hidden name="quelMail" value="<?php echo $quelMail; ?>">
                                </br></br>
                                <input type="submit" name="update" value="Modifier" 
                                    <?php '<script type="text/javascript">location.reload();</script>' ?> 
                                />
                        </form>
                    </div> 
            <?php
                }
                else if($quelMail === "mail2")
                {
            ?>
                    <div class="formulaire">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <legend> Modifier votre email 2</legend>
                                </br>
                                <input class="saisie" type="text" name="mailUpdate" value="<?php echo $infos['mail2']; ?>"><br />
                                </br>
                                <label>Mot de passe</label><br />
                                <input class="saisie" type="password" 
                                        name="actuelPassSaisi" value="" placeholder="****************" >
                                <input type="text" hidden name="pseudoUpdate" value="<?php echo $infos['pseudo']; ?>">
                                <input type="text" hidden name="quelMail" value="<?php echo $quelMail; ?>">
                                </br></br>
                                <input type="submit" name="update" value="Modifier" 
                                    <?php '<script type="text/javascript">location.reload();</script>' ?> 
                                />
                        </form>
                    </div> 
            <?php
                }
            ?>

        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
     </body>
</html>
