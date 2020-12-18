<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerOffre.class.php';
    $managerOffre = new ManagerOffre();
    //include_once '../../classes/Identification.class.php';
    //$identification = new Identification();
?>
<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>serviceDetail</title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" /> 
        <link rel="stylesheet" href="../../style/serviceDetail.css">

<script type="text/javascript">
        function RedirectServices() {
            window.location="servicesProposes.php";
        }
        function RedirectCommander() {
            window.location="commanderService.php";
        }

</script>
    </head>
 
     <body>
        <div class="header";>
            <?php include("../includes/headerPages.php"); ?>
        </div>

        <div class="body">
<?php
    $identification->verifierIdentification();
    if ($_SERVER["REQUEST_METHOD"] != "POST" && empty($_POST))
    {
            $idOffre = $_GET['idOffre'];
            $infos = $managerOffre->lireUnService($idOffre);

                $idOffre = $codeOffre = $date =  $pseudoService =  $individu =  "";
                $tag =  $description =  $dpt =  $ville =  $lieuElargi =  $prix =  $typePrix = "";
                $pseudoDemande = $pseudo;

            for ($i=0; $i<count($infos); $i++)
            {  
                $idOffre = $infos[$i]['offre_id'];
                $codeOffre = $infos[$i]['codeOffre'];
                $date = $infos[$i]['dateOuverture'];
                $pseudoService = $infos[$i]['pseudo'];
                $individu = $infos[$i]['individu'];
                $tag = $infos[$i]['tag'];
                $description = $infos[$i]['descriptionOffre'];
                $dpt = $infos[$i]['dpt'];
                $ville = $infos[$i]['ville'];
                $lieuElargi = $infos[$i]['lieuElargi'];
                $prix = $infos[$i]['prix'];
                $typePrix = $infos[$i]['typePrix'];
            }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
    {
            $infosPostMsg = $managerOffre->infosPostMsgOffre();
            $idOffre = $infosPostMsg[0][0]['idOffre'];
            $infos = $managerOffre->lireUnService($idOffre);
                $idOffre = $codeOffre = $date =  $pseudoService =  $individu =  "";
                $tag =  $description =  $dpt =  $ville =  $lieuElargi =  $prix =  $typePrix = "";
                $pseudoDemande = $_SESSION['login'];

            for ($i=0; $i<count($infos); $i++)
            {  
                $idOffre = $infos[$i]['offre_id'];
                $codeOffre = $infos[$i]['codeOffre'];
                $date = $infos[$i]['dateOuverture'];
                $pseudoService = $infos[$i]['pseudo'];
                $individu = $infos[$i]['individu'];
                $tag = $infos[$i]['tag'];
                $description = $infos[$i]['descriptionOffre'];
                $dpt = $infos[$i]['dpt'];
                $ville = $infos[$i]['ville'];
                $lieuElargi = $infos[$i]['lieuElargi'];
                $prix = $infos[$i]['prix'];
                $typePrix = $infos[$i]['typePrix'];
            }
    }
?>
            
            <div class="tab">
                <h2>Détail de l'offre :</h2>
                <table>
                <tr hidden>
                    <th>idOffre: </th>
                    <td><?php echo $idOffre;?></td>
                </tr>
                <tr>
                    <th>codeOffre:</th>
                    <td><?php echo $codeOffre;?></td>
                </tr>
                <tr>
                    <th>Pseudo:</th>
                    <td><?php echo $pseudoService;?></td>
                </tr>
                <tr>
                    <th>Personne:</th>
                    <td><?php echo $individu;?></td>
                </tr>
                <tr>
                    <th>Tag:</th>
                    <td><?php echo $tag;?></td>
                </tr>

                <tr>
                    <th>Description:</th>
                    <td><?php echo $description;?></td>
                </tr>
                <tr>
                    <th>Département:</th>
                    <td><?php echo $dpt;?></td>
                </tr>
                <tr>
                    <th>Ville:</th>
                    <td><?php echo $ville;?></td>
                </tr>
                <tr>
                    <th>Lieu élargi:</th>
                    <td><?php echo $lieuElargi;?></td>
                </tr>
                <tr>
                    <th>Prix:</th>
                    <td><?php echo $prix." €";?></td>
                </tr>
                <tr>
                    <th>Type de prix:</th>
                    <td><?php echo $typePrix;?></td>
                </tr>
                <tr>
                    <th>Date de création:</th>
                    <td><?php echo $date;?></td>
                </tr>
                </table> 

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                                    
                    <input hidden type="submit" name="idOffre" value="<?php echo $idOffre ?>" >
                    <input hidden type="submit" name="codeOffre" value="<?php echo $codeOffre;?>" >
                    <input hidden type="submit" name="pseudoService" value="<?php echo $pseudoService ?>"  >
                    <input hidden type="submit" name="pseudoDemande" value="<?php echo $pseudoDemande ?>" id="submit" >
                    <input class="button"  id="retour" value="Retour" onclick="RedirectServices();"/>                 
                    <input style="margin-left:10%;" class="button" id="commander" 
                           name="commander" value="Commander" style=" margin-left:0%;" 
                           onclick="RedirectCommander();"/>
                </form>
            </div>


            <div class="posterMsg">
                <?php
                    $pseudo = $_SESSION['login'];
                //echo $pseudoVisiteur;
                    $pseudoOffrant = $infos[0]['pseudo'];
                //var_dump($pseudoOffrant);
                                        
                    $infosMsg = $managerOffre->infosVideMsgOffre($infos[0]['offre_id'],$pseudo, $infos[0]['pseudo']);
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
                    {
                         $managerOffre->verifierEtInsererMsgOffre();
                    }
                    if ( $pseudo == $pseudoOffrant)
                    {

                        include('msgOffrant.php');
                    }
                    else
                    {
                        include('msgVisiteur.php');
                    }
                ?>
            </div>
            <div class="listeMsg">
            <?php
                $msg = $managerOffre->obtenirTousMsgUneOffre($infos[0]['offre_id']);
                    $nbMsg = count($msg);
                if ($nbMsg < 1)
                {
                    $x = date('d/m/Y');
                    echo " <table> ";
                    echo "   <tr>";
                    echo "     <td>".$x."</td>";                    
                    echo "     <td>Il y a pas encore de message pour cette offre...</td>";
                    echo "  </tr>";
                    echo "</table>";
                }
                else
                {
                    foreach ($msg as $row)
                    {
                        echo " <table> ";
                        echo "   <tr>";
                        echo "     <td>".$row['idMembre_pseudo']."</td>";
                        echo "     <td>".$row['date']."</td>";
                        echo "     <td>".$row['msg']."</td>";
                        echo "  </tr>";
                        echo "</table>";
                    }
                }
            ?>
            </div>
            

            </div>
        <div class="clear"></div>
        </div>


        <div class="clear"></div>
        <div class="footer"><p>&copy; 22020 comgocom.pw<p></div>            
     </body>
</html>




