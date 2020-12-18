<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerIdentification.class.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>formulaire d'identification</title>
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
                    $managerIdentification = new ManagerIdentification();
                    $infos = $managerIdentification->infosVideIdentification();
                    $infos = $managerIdentification->creerIdentification();
                    
                ?>
            </div>
            <div class="formulaire">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <legend>S'identifier : </legend>
                        <p><span class="error">* Champs obligatoires</span></p>
                        <label>Pseudonyme</label>
                        </br>
                        <input type="text" name="pseudoInput" value="<?php echo $infos['pseudo'] ?>">
                        <span class="error">*</span><br />
                        <label>Mot de passe</label>
                        </br>
                        <input type="password" name="passInput" value="<?php echo $infos['motpasse'] ?>"
                               placeholder="**************"
                        >
                        <span class="error">*</span><br />
                        <input type="submit" name="connexion" value="Connexion" 
                        <?php '<script type="text/javascript">location.reload();  </script>' ?> 
                        />
                </form>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
    </body>

</html>
<?php
    $managerIdentification->msgInfoCookie();
?>

