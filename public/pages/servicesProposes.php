<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerOffre.class.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Services proposés</title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">-->
        <link rel="stylesheet" href="../../style/monDataTables.css">
        <script src="../../script/jquery-1.12.3.js"></script>
        <script src="../../script/jquery.dataTables.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#tabResumerServices').DataTable( {
                        "info":     false,
                     } );
                } );

            function Redirect() {
                 window.location="ajouterSonService.php";
             }

            </script>
    </head>
     <body>
        <div class="header";>
            <?php include("../includes/headerPages.php"); ?>
        </div>
        <div class="body">
            

</br>
<?php
    $managerOffre = new ManagerOffre();
    $nbServices = $managerOffre->nombreTotalService();
    if ($nbServices > 0)
    {
        $infos = $managerOffre->lireInfosServices();
    }
    else
    {
        echo "<h3 style='color:green;text-align:center'>Aucun service n'a été créé pour l'instant, à bientôt !<h3>";
        exit();
    }
?>
<div class="divTable">
    <h1 >Les services proposés</h1>



    <table id="tabResumerServices" class="display" >

        <thead>
            <tr>
                <th hidden>idOffre</th>
                <th>Catégorie</th>
                <th>Pseudo</th>
                <th>Personne</th>                 
                <th>Département</th>
            <th>Ville</th>
                <th>Lieu élargi</th>
                <th>Prix</th>
                <th>Type de prix</th>
                <th class="noSorting">Détail</th>
            </tr>
        </thead>

        <tbody>
        <?php
                for ($i=0; $i<count($infos); $i++)
                {  
                    echo "          <tr>";
                    echo "                      <td hidden >".$infos[$i]['offre_id']."</td>";                    
                    echo "                      <td >".$infos[$i]['tag']."</td>";
                    echo "                      <td >".$infos[$i]['pseudo']."</td>";
                    echo "                      <td >".$infos[$i]['individu']."</td>";
                    echo "                      <td >".$infos[$i]['dpt']."</td>";
                    echo "                      <td >".$infos[$i]['ville']."</td>";
                    echo "                      <td >".$infos[$i]['lieuElargi']."</td>";
                    echo "                      <td class='td_size'>".$infos[$i]['prix']." €</td>";
                    echo "                      <td >".$infos[$i]['typePrix']."</td>";     
                    echo '<td ><a href="serviceDetail.php?idOffre='.$infos[$i]['offre_id'].'">Voir</a></td>';                    
                    echo "          </tr>";
                }
        ?>    
        </tbody>   

    </table>
    <button id="addService" onclick="Redirect();">Créer un service</button>
</div>
        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
     </body>
</html>
