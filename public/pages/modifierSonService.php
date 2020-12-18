<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerOffre.class.php';
    $managerOffre = new ManagerOffre();
    include_once '../../classes/Identification.class.php';
    $identification = new Identification();
?>
<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>modifierSonService</title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" /> 
        <link rel="stylesheet" href="../../style/formulaireService.css">
        <link rel="stylesheet" href="../../style/jquery-ui.css">
        <script src="../../script/jquery-1.12.3.js"></script>
        <script src="../../script/jquery-ui.js"></script>
        <script type="text/javascript" src="../../script/formulaire.js"></script>
    </head>
 
     <body>
        <div class="header";>
            <?php include("../includes/headerPages.php"); ?>
        </div>

        <div class="body">
<?php
    $identification->verifierIdentification();

    $offre_id = $description =  $dpt =  $ville =  $lieuElargi =  $prix =  $typePrix = "";
    $pseudolog = $pseudo;

    if ($_SERVER["REQUEST_METHOD"] != "POST")
    {
        $idOffre = $_GET['idOffre'];
       // var_dump($idOffre);
        $infos = $managerOffre->lireUnService($idOffre);
        //var_dump($infos);

        for ($i=0; $i<count($infos); $i++)
        {  
            $idOffre = $infos[$i]['offre_id'];
            $description = $infos[$i]['descriptionOffre'];
            $dpt = $infos[$i]['dpt'];
            $ville = $infos[$i]['ville'];
            $lieuElargi = $infos[$i]['lieuElargi'];
            $prix = $infos[$i]['prix'];
            $typePrix = $infos[$i]['typePrix'];
            $pseudo = $pseudolog;
            $motPasse = "";
        }
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
    {
        $infos = $managerOffre->infosPostModifierOffre();
        for ($i=0; $i<count($infos); $i++)
        {  
            $idOffre = $infos[$i]['offre_id'];
            $description = $infos[$i]['descriptionOffre'];
            $dpt = $infos[$i]['dpt'];
            $ville = $infos[$i]['ville'];
            $lieuElargi = $infos[$i]['lieuElargi'];
            $prix = $infos[$i]['prix'];
            $typePrix = $infos[$i]['typePrix'];
            $pseudo = $infos[$i]['pseudo'];
            $motPasse = $infos[$i]['motPasse'];
        }
        $managerOffre->modifierOffre($idOffre, $description, $dpt, $ville, 
                                           $lieuElargi, $prix, $typePrix, $pseudo,$motPasse);
    }
?>
            
            <div class="formulaire">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <legend>Modifier cette offre : </legend>
                    <input hidden type="text" name="offre_id" value="<?php echo $idOffre ?>">
                    <input hidden type="text" name="pseudo" value="<?php echo $pseudo ?>">				
                    </br>
                    <p><span class="error">* Champs obligatoires</span></p>
                    </br>
                    <p style="font-weight:bold;font-size:25px">Description : <span class="error"> *</span></p>
                    </br>
                    <textarea style="margin-left:15px;" name="descriptionOffre"  rows="4" cols="50"
                                ><?php echo $description ?></textarea>
                    </br>
                    <p style="font-weight:bold;font-size:25px">Lieu  :</p>

                    <label style="margin-left:15px;">Département : </label>
                    <input style="float:right;margin-right:80px;margin-top:-8px;text-align:center" type="text" name="dpt" 
                            id="chercheDepartements" value="<?php echo $dpt ?>"/>
                    <span class="error">*</span><br />
                    <script type="text/javascript">
                        $('#chercheDepartements').autocomplete({
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
                    </br>

                    <label style="margin-left:15px;">Ville: </label>
                    <input style="float:right;margin-right:80px;margin-top:-8px;text-align:center" type="text" name="ville" 
                            id="chercheVilles" value="<?php echo $ville ?>"/>
                    <span class="error">*</span><br /> 
                        <script type="text/javascript">
                            $('#chercheVilles').autocomplete({
                                source: function( request, response ) {
                                    $.ajax({
                                        url : '../../outils/autocomplete.php',
                                        dataType: "json",
                                            data: {
                                                filtreVille: request.term,
                                                filtreDepartement : $('#chercheDepartements').val(),
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
                    </br>

                    <p style="font-weight:bold;font-size:25px">Lieu élargi : <span class="error"> *</span></p>
                    </br>                    
                    <label style="margin-left:15px; padding:3px;">Lieu de référence seulement :</label>
                    <input style="float:right;margin-right:180px;" type="radio" name="lieuElargi" value="non" 
                    <?php if ($lieuElargi == 'non') echo "checked" ?> />
                    </br></br>    
                    <label style="margin-left:15px; padding:3px;">À tout le département</label>
                    <input style="float:right;margin-right:180px;" type="radio" name="lieuElargi"  value="departement"
                        <?php if ($lieuElargi == 'departement') echo "checked" ?> />
                    </br></br>
                    <label style="margin-left:15px; padding:3px;">À toute la région</label>            
                    <input style="float:right;margin-right:180px;" type="radio" name="lieuElargi"  value="region"
                    <?php if ($lieuElargi == 'region') echo "checked"; ?> />
                    </br>
                    </br>
                    <p style="font-weight:bold;font-size:25px">Montant: </p>
                    <span style="float:right;margin-right:130px;margin-top:-25px" class="error"> *</span>
                    <span style="float:right;margin-right:145px;margin-top:-25px"> €</span>
                    <input style="float:right;margin-right:160px;margin-top:-30px;width:100px;text-align:center" 
                            type="text" name="prix" value="<?php echo $prix ?> " />
                        
                    </br>
                    <p style="font-weight:bold;font-size:25px">Type de prix: <span class="error">*</span><br /></p>
                    <label style="margin-left:30px">Forfait unique : </label>
                    <input type="radio" name="typePrix" value="forfait"  
                    <?php if ($typePrix == 'forfait') echo "checked"; ?> />
                    <label style="margin-left:15px">De l'heure :</label>
                    <input type="radio" name="typePrix" value="de l'heure" 
                    <?php if ($typePrix == "de l'heure") echo "checked"; ?> />
                    
                    </br>			
                    <p style="font-weight:bold;font-size:25px">Mot de passe actuel : </p>

                    <input style="margin-left:150px;" type="password" 
                            name="motPasse"  value="<?php echo $motPasse ?>" placeholder="****************" >
                    <span class="error">*</span>
                    </br>
                    </br>
                    </br>                                                    

                    <input type="submit" name="modifierService" value="Modifier" 
                        <?php '<script type="text/javascript">location.reload();</script>' ?>
                    />
                </form>
            </div>

        </div>


        <div class="clear"></div>
        <div class="footer"><p>&copy; 2020 comgocom.pw<p></div>            
     </body>
</html>




