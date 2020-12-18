<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerAdministration.class.php'; 
    include_once '../../classes/Identification.class.php';
    $identification = new Identification();
    $identification->verifierIdentification();
?>


<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Modifier Admin</title>
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
                $managerAdministration = new ManagerAdministration();
                $idMembre = $_GET['ref'];
                $infos = $managerAdministration->avantSubmit($idMembre);
                if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
                {
                    $infos = $managerAdministration->infosApresSubmitModifAdmin();
                    
                    $managerAdministration->modifierAdmin();
                }
            ?>
        </div>
            <div class="formulaire">   
                <form action="modifierAdmin.php?ref=<?php echo $infos['idMembre']; ?>" method="post">
                  <legend>Est administrateur : </legend>
                    </br>
                    <label>Pour le membre : <?php echo $infos['pseudo']; ?> </label>
                    </br></br>
                    <select  name="boolAdmin">
                    <option value=""</option>
                    <option value="un">oui</option>
                    <option value="zero">non</option>
                    </select>
                    </br>                   
                    <input type="text" hidden name="idMembreUpdate" value="<?php echo $infos['idMembre']; ?>">
                    <input type="text" hidden name="pseudoUpdate" value="<?php echo $infos['pseudo']; ?>">
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
