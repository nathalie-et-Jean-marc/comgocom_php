<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include '../../outils/ManagerInfosPersonne.class.php';
    $managerInfosPersonne = new ManagerInfosPersonne();
    include_once '../../classes/Identification.class.php';
    $identification = new Identification();
    $identification->verifierIdentification();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>modifierInfosPersonne</title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="stylesheet" href="../../style/formulaireService.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />
        <link rel="stylesheet" href="../../style/jquery-ui.css">
        <script src="../../script/jquery-1.12.3.js"></script>
        <script src="../../script/jquery-ui.js"></script>
        <script type="text/javascript" src="../../script/formulaire.js"></script>
     </head>
     <body>
        <div class="header";>
            <?php include("../includes/headerPages.php"); ?>
        </
        <div class="body">
            <h1 style="margin-left:10px;">Modifier ses informations complémentaires</h1>

        <div class="validation">
            <?php
                if ($_SERVER["REQUEST_METHOD"] != "POST" && empty($_POST))
                {
                    $idMembre = $_GET['ref'];
                    $infos = $managerInfosPersonne->obtenirInfosUnePersonne($idMembre);
                }
                else 
                {
                    $infos = $managerInfosPersonne->verifierEtModifierInfosPersonne();
                }
            ?>
        </div>
        <div class="formulaire">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" hidden name="idMembre" value="<?php echo $infos['idMembre'] ?>">
            <legend> Informations complémentaires : </legend>

            </br>
            <p><span class="error">* Champs obligatoires</span></p>
            <label style="font-weight:bold;">Numéro de rue</label>
            </br>
            <input style="width:40px;" type="text" name="numRue" value="<?php echo $infos['numRue'] ?>">
            </br></br>
            <label style="font-weight:bold;">Libellé adresse</label>
            <span class="error">*</span>
            </br>
            <input  style="width:350px;" type="text" name="adrrText" value="<?php echo $infos['adrrText'] ?>">
            </br></br>
            <label style="font-weight:bold;">Département</label>
            <span class="error">*</span>
            </br>
            <input style="width:150px;text-align:center" type="text" name="dpt" id="rechercheDepartements" 
                   value="<?php echo $infos['dpt'] ?>">
            <script language='javascript'>
                $('#rechercheDepartements').autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url : '../../outils/autocomplete.php',
                            dataType: "json",
                                data: {
                                    filtreDepartement: request.term,
                                    type: 'departements'
                                },
                                    success: function( data ) {
                                    response( $.map( data, function( item ) {
                                            return {
                                                    label: item,
                                                    value: item
                                            }
                                    }));
                                }
                        });
                    },
                    autoFocus: true,
                    minLength: 0         
                });
            </script>    
            </br></br>
            <label style="font-weight:bold;">Ville</label>
            <span class="error">*</span>
            </br>
            <input style="width:150px;text-align:center" type="text" name="ville" id="rechercheVilles" 
                   value="<?php echo $infos['ville'] ?>">
                <script language='javascript'>
                    $('#rechercheVilles').autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url : '../../outils/autocomplete.php',
                                dataType: "json",
                                    data: {
                                        filtreVille: request.term,
                                        filtreDepartement : $('#rechercheDepartements').val(),
                                        type: 'villes'
                                    },
                                        success: function( data ) {
                                        response( $.map( data, function( item ) {
                                                return {
                                                        label: item,
                                                        value: item
                                                }
                                        }));
                                    }
                            });
                        },
                        autoFocus: true,
                        minLength: 2         
                    });
                </script>  
            </br></br>
            <label style="font-weight:bold;">Code postal</label>
            <span class="error">*</span>
            </br>
            <input style="width:150px;text-align:center" type="text" name="codePostal" value="<?php echo $infos['codePostal'] ?>">
            </br></br>
            <label style="font-weight:bold;">Téléphone</label>
            <span class="error">*</span>
            </br>
            <input style="width:150px;text-align:center" type="text" name="telephone" value="<?php echo $infos['telephone'] ?>">
            
            </br></br>            
            <label style="font-weight:bold;">Mot de passe actuel</label>
            <span class="error">*</span>
            </br>
            <input style="width:150px;" type="password" name="motPasse" placeholder="**************"  
                   value="<?php echo $infos['motPasse'] ?>">
            </br></br></br>
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

