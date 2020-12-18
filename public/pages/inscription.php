<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerInscription.class.php';

   /*  function get_ip_address() {
        if ( isset( $_SERVER['HTTP_X_REAL_IP'] ) ) {
            return $_SERVER['HTTP_X_REAL_IP'];
        } elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            // Proxy servers can send through this header like this: X-Forwarded-For: client1, proxy1, proxy2
            // Make sure we always only send through the first IP in the list which should always be the client IP.
            return (string) self::is_ip_address( trim( current( explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ) );
        } elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return '';
    } */

 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>formulaire d'inscription</title>
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
                    $managerInscription = new ManagerInscription();
                    $infos = $managerInscription->afficherAvantInscription();
                    $infos = $managerInscription->verifierEtinscrire();
                ?>
            </div>
            <?php
                if(!empty($_SERVER['HTTP_CLIENT_IP']))
                {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                   # echo "HTTP_CLIENT_IP";
                }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                   # echo "HTTP_X_FORWARDED_FOR";
                }else{
                    $ip = $_SERVER['REMOTE_ADDR'];
                   # echo "REMOTE_ADDR";
                }
                #echo $ip;
            ?>

            <div class="formulaire">
                <!--<form action="inscription.php" method="post">-->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <legend>S'inscrire : </legend>
                <p><span class="error">* Champs obligatoires</span></p>
                <label >Nom</label>
                </br>
                <input type="text" name="nom" value="<?php echo $infos['nom'] ?>">
                <span class="error">*</span><br />
                <label >Prénom</label>
                </br>
                <input type="text" name="prenom" value="<?php echo $infos['prenom'] ?>">
                <span class="error">*</span><br />
                <label >Pseudo</label>
                </br>
                <input type="text" name="pseudo" value="<?php echo $infos['pseudo'] ?>">
                <span class="error">*</span><br />
                <label >Civilité</label>
                </br>
                <input type="text" name="civilite" value="<?php echo $infos['civilite'] ?>">
                <span class="error">*</span><br />
                <label >Email1</label>
                </br>
                <input type="text" name="mail1" value="<?php echo $infos['mail1'] ?>">
                <span class="error">*</span><br />
                <label >Email2</label>
                </br>
                <input type="text" name="mail2" value="<?php echo $infos['mail2'] ?>">
                
                <label >Adresse</label>
                </br>
                <input type="text" name="adresse" value="<?php echo $infos['adresse'] ?>">
                <span class="error">*</span><br />
                <label >Ville</label>
                </br>
                <input type="text" name="ville" value="<?php echo $infos['ville'] ?>">
                <span class="error">*</span><br />
                <label >Département</label>
                </br>
                <input type="text" name="departement" value="<?php echo $infos['departement'] ?>">
                <span class="error">*</span><br />
                <label >Code Postal</label>
                </br>
                <input type="text" name="codepostal" value="<?php echo $infos['codepostal'] ?>">
                <span class="error">*</span><br />
                <label >Pays</label>
                </br>
                <input type="text" name="pays" value="<?php echo $infos['pays'] ?>">
                <span class="error">*</span><br />
                <label >Téléphone1</label>
                </br>
                <input type="text" name="telephone1" value="<?php echo $infos['telephone1'] ?>">
                <span class="error">*</span><br />
                <label >Téléphone2</label>
                </br>
                <input type="text" name="telephone2" value="<?php echo $infos['telephone2'] ?>">
               
                <label>Mot de passe</label>
                </br>
                <input type="password" name="motpasse"  value="<?php echo $infos['motpasse'] ?>">
                <span class="error">*</span><br />
                <label>Confirmation </label>
                </br>
                <input type="password" name="confirm" placeholder="confirmer le mot de passe" 
                       value="<?php echo $infos['confirm'] ?>">
                <span class="error">*</span><br />
                <label >Votre IP est</label>
                </br>
                <input type="text" name="ipvue" value="<?php echo $ip?>" DISABLED>
                <input type='hidden' name='ip' value="<?php echo $infos['ip']?>">
                </br>
                <input type="checkbox" name="CGUok" required value="<?php echo $infos['CGUok']?>"> J'ai lue et j'accepte les <a href="CGU.php" target=_blank>Condition Génerale d'utilisation</a>
                </br>  </br>               
                <input type="submit" value="Envoyer" 
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
