<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerInfosPersonne.class.php';
    include_once '../../outils/ManagerMembre.class.php';
    $managerInfosPersonne = new ManagerInfosPersonne();        
    $managerMembre = new ManagerMembre();  
    include_once '../../classes/Identification.class.php';
    $identification = new Identification();       
?>

<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Son compte</title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="stylesheet" href="../../style/sonCompte.css">
        <link rel="stylesheet" href="../../style/tableau.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />

        <script>
        $( function() {
            $( "#accordion" ).accordion({
            heightStyle: "content"
            });
        } );
        </script>
    </head>
 
     <body>
        <div class="header">
            <?php include("../includes/headerPages.php"); ?> 
        </div>
        <div class="body">
        <?php
            $identification->verifierIdentification();
        ?>
            <h1 style="margin-left:10%">Votre profil</h1>
            <div class="infosMembre">

                <div>
                    <h2>Profil :</h2> 
                    <?php
                     
                        $pseudo = $managerMembre->pseudoParSession();
                        $idMembre = $managerMembre->obtenirIdMembreByPseudo($pseudo);   
                        $infos = $managerMembre->obtenirInfosDuMembre($idMembre); 
                        //var_dump($infos); 
                        $managerMembre->afficherTableDuMembre($pseudo);
                    ?>
                </div>
                <div>
                    <h2 >Mail(s) :</h2>
                    <?php
                    // var_dump($infos);
                        $managerMembre->afficherTabMailModif($pseudo, $idMembre);
                    ?>
                </div>
                <div>
                    <h2>Mot de passe :</h2>
                    <table class="modifier">
                        <tr>
                            <th>***************</th>
                            <td><a href="modifierMotPasse.php?ref=<?php echo $idMembre; ?>">Modifier</a></td> 
                        </tr>
                    </table>
                </div>
                <div>
                    <h2>Adresse :</h2>
                        <?php
                        // var_dump($infos);
                            $managerMembre->afficherTabAdressModif($pseudo, $idMembre);
                        ?>
                </div>
            <div>
                    <!--<h3>Informations complémentaires :</h3>-->
<?php
//$estPersonne = $managerInfosPersonne->estUnePersonne($idMembre);
//if($estPersonne)
//{
   // $infosPersonne = $managerInfosPersonne->obtenirInfosUnePersonne($idMembre);
    //var_dump($infosPersonne);
   // $managerInfosPersonne->afficherTabInfosUnePersonne($idMembre);   

//}
//else
//{
    //echo "<p style='color:green;font-size:17px'>Vous ne vous avez pas encore rempli le formulaire d'informations complémentaire.</p>";
    //echo "<a href='ajouterSonService.php>'>Ajoutez votre service</a>  ou  <a href='ajouterSaDemande.php'>Ajoutez votre demande</a>";
//}
?>
                </div>

            </div>


        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
     </body>
</html>
