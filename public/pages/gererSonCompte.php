<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerOffre.class.php';
    include_once '../../classes/Identification.class.php';
    $identification = new Identification(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Gérer son compte </title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />
        <link rel="stylesheet" href="../../style/monDataTables.css">
        <script src="../../script/jquery-1.12.3.js"></script>
        <script src="../../script/jquery.dataTables.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#tabServicesPseudo').DataTable( {
                        "info": false,
                     } );
                } );

            function Redirect() {
                 window.location="ajouterSonService.php";
             }
            </script>
    </head>
 
     <body>
        <div class="header">
            <?php include("../includes/headerPages.php");  ?> 
        </div>

        <div class="body">
        <?php
            $identification->verifierIdentification();
        ?>
        <h1>Gérer son compte : <?php echo $pseudo; ?></h1>

<?php
   
    $managerOffre = new ManagerOffre();
    $nbOffre = $managerOffre->nombreOffrePseudo($pseudo);// todo faire de même pour les demandes d'offre !!!!
    if ($nbOffre > 0)
    {
        $infos = $managerOffre->lireInfosServicesPseudo($pseudo);
        //var_dump($infos);
    }
    else
    {
        echo "<h3 style='color:green;text-align:center;margin-top:90px;'>Vous n'avez pas encore créé de service, à bientôt !<h3>";
        exit();
    }
  

?>
<div class="divTable">
<h1 >Les services créés :</h1>

    <table id="tabServicesPseudo" class="display" >

        <thead>
            <tr>
                <th>Code Offre&nbsp;&nbsp; </th>
                <th>Tag</th>
                <th>Description&nbsp; </th>
                <th>Date de création</th>                 
                <th>Département&nbsp;&nbsp; </th>
                <th>Ville</th>
                <th>Lieu élargi&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th>Prix</th>
                <th>Type de prix&nbsp;&nbsp;</th>
                <th class="noSorting">Action&nbsp;</th>
                <th class="noSorting">Action&nbsp;</th>

            </tr>
        </thead>

        <tbody>
        <?php
    $nb=0;
                for ($i=0; $i<count($infos); $i++)
                { 
                    $nb = $nb + 1; 
                    echo " <tr>";
                    echo "                      <td >".$infos[$i]['codeOffre']."</td>";                    
                    echo "                      <td >".$infos[$i]['tag']."</td>";
                    echo "                      <td class='td_size'>".$infos[$i]['descriptionOffre']."</td>";
                    echo "                      <td >".$infos[$i]['dateOuverture']."</td>";
                    echo "                      <td >".$infos[$i]['dpt']."</td>";
                    echo "                      <td >".$infos[$i]['ville']."</td>";
                    echo "                      <td >".$infos[$i]['lieuElargi']."</td>";
                    echo "                      <td class='td_size'>".$infos[$i]['prix']." €</td>";
                    echo "                      <td >".$infos[$i]['typePrix']."</td>";     
                    // ?log='.urlencode($pseudo).'&cle='.urlencode($cle).'
                    echo '    <td ><a href="modifierSonService.php?idOffre='.$infos[$i]['offre_id'].'">Modifier</a></td>';                            
 echo '    <td ><a type="button"  href="supprimerSonService.php?idOffre='.urlencode($infos[$i]['offre_id']).'&log='.urlencode($infos[$i]['pseudo']).'" >Supprimer</a></td>';   
                    echo " </tr>";
                }
        ?>    
        </tbody>   

    </table>
<?php echo "<p style='text-align:center;font-size:18px;'>Nombre d'offres de service actuel :  ".$nb. "</p>";  ?>
    <button id="addService" onclick="Redirect();">Ajoutez un service</button>
</div>
<div id="dialog-confirm"></div>
        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
     </body>
</html>


