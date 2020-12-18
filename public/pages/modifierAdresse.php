<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include_once '../../outils/ManagerMembre.class.php';
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
                     $managerMembre = new ManagerMembre();
                    if ($_SERVER["REQUEST_METHOD"] != "POST")
                    {
                          $idPersonne=$_GET['ref'];
                        //  echo $idPersonne;
                        //  echo "</br>";
                        $adresse = $managerMembre->dataAdresse($idPersonne);
                        // var_dump($adresse);
                    }

                   
                    

                    if ($_SERVER["REQUEST_METHOD"] == "POST")
                    {
                         $idPersonne=htmlspecialchars_decode((trim($_POST['idPersonne'])));
                         $adresse = $managerMembre->verifierEtModifierAdresse();
                         // var_dump($adresse);
                    }             

                   

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
                <legend>Modifier : </legend>
                <p><span class="error">* Champs obligatoires</span></p>                
                <label >Adresse</label>
                </br>
                <input type="text" name="adresse" value="<?php echo $adresse['adresse'] ?>">
                <span class="error">*</span><br />
                <label >Ville</label>
                </br>
                <input type="text" name="ville" value="<?php echo $adresse['ville'] ?>">
                <span class="error">*</span><br />
                <label >Département</label>
                </br>
                <input type="text" name="departement" value="<?php echo $adresse['departement'] ?>">
                <span class="error">*</span><br />
                <label >Code Postal</label>
                </br>
                <input type="text" name="codepostal" value="<?php echo $adresse['codepostal'] ?>">
                <span class="error">*</span><br />
                <label >Pays</label>
                </br>
                <input type="text" name="pays" value="<?php echo $adresse['pays'] ?>">
                <span class="error">*</span><br />
             
                <input type="text" hidden name="idPersonne" value="<?php echo $idPersonne ?>">

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
