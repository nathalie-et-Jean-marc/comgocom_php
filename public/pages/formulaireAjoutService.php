<div class="formulaire">
    <!--<form action="inscription.php" method="post">-->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <legend>Informations concernant le service proposé : </legend>
    <input type="text" hidden name="idMembre" value="<?php echo $infosService['idMembre'] ?>">
    <input type="text" hidden name="pseudo" value="<?php echo $infosService['pseudo'] ?>"/>
    <input type="text" hidden name="nom" value="<?php echo $infosService['nom'] ?>"/>
    <input type="text" hidden name="prenom" value="<?php echo $infosService['prenom'] ?>"/>
    <input type="text" hidden name="idPersonne" value="<?php echo $infosService['idPersonne'] ?>">
    <input type="text" hidden name="typeOffre" value="<?php echo $infosService['typeOffre'] ?>">
    </br>
    <p style="font-weight: bold;margin-left:100px">par le membre :
        <label> <?php echo $infosService['nom'] ?> </label>
        <label><?php echo $infosService['prenom'] ?></label>
    </p>
    <p style="font-weight: bold;margin-left:100px">    de pseudo : 
        <label><?php echo $infosService['pseudo'] ?></label>
    </p>
    </br>
    <p><span class="error">* Champs obligatoires</span></p>
    <p style="font-weight:bold;font-size:25px">Lieu de référence :</p>
    <label style="margin-left:15px; padding:3px;">Département</label>
    <span class="error">*</span> :
    <input style="float:right;margin-right:80px;" type="text" name="dpt" 
            id="chercheDepartements" value="<?php echo $infosService['dpt'] ?>">
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
    </br></br></br>
    <label style="margin-left:15px; padding:3px;">Ville</label>
    <span class="error">* :</span>
    <input style="float:right;margin-right:80px;" type="text" name="ville" 
            id="chercheVilles" value="<?php echo $infosService['ville'] ?>">
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
    <p style="font-weight:bold;font-size:25px">Lieu élargi :</p>
    <label style="margin-left:15px; padding:3px;">Lieu de référence seulement :</label>
    <input style="float:right;margin-right:180px;" type="radio" name="lieu" value="non" checked >

    </br></br>
    
    <label style="margin-left:15px; padding:3px;">À tout le département</label>
    <input style="float:right;margin-right:180px;" type="radio" name="lieu"  value="departement"
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $infosService['lieu'] == 'departement') echo "checked" ?> >

    </br></br>
    <label style="margin-left:15px; padding:3px;">À toute la région</label>            
    <input style="float:right;margin-right:180px;" type="radio" name="lieu"  value="region"
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $infosService['lieu'] == 'region') echo "checked"; ?> >
    </br>
    <p style="font-weight:bold;font-size:25px">Décrire le service </p>
    <label style="font-weight:bold;margin-left:15px">Tag :</label>
    <span class="error">*</span>

    <label style="margin-left:15px">Choisir un tag : </label>
    <input type="radio" name="creerOuChoisi" id="creerOuChoisi" value="choisi" checked 
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $infosService['creerOuChoisi'] == 'cree') echo "disabled"; ?>                     >
    <label style="margin-left:15px">Créer son tag :</label>
    <input type="radio" name="creerOuChoisi" id="creerOuChoisi" value="cree"
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $infosService['creerOuChoisi'] == 'cree') echo "checked"; 
        else if ($_SERVER["REQUEST_METHOD"] == "POST" && $infosService['creerOuChoisi'] == 'choisi') echo "disabled";  ?>       
     >
    
<?php
    if ($_SERVER["REQUEST_METHOD"] != "POST")
    {
?>
    <script type="text/javascript">
        $(function(){
            $.showHideBeforePost();
        });
    </script>
<?php
    }
?>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
?>
    <script type="text/javascript">

    $(function(){
        $.showHideAfterPost();
    });       

    </script>
<?php
    }
?>
    </br></br>
    <div id="tagChoisi" >
    <label style="margin-left:30px;">Choisir un tag</label>

    <select name="tagListe" id="tagListe" style="margin-left:20px">
    <option style="width:160px" value="<?php echo $infosService['tagListe'] ?>" selected></option>
        <?php
            $managerOffre->obtenirTags();
        ?>
    </select>
    
    </div>
    </br></br>
    <div id="tagCree" >
    <label style="margin-left:30px;">Créer un tag</label>
    <input style="margin-left:5px;" name="tagInput" id="tagIn" value="<?php echo $infosService['tagIn'] ?>">
    </div>
    </br></br>
    <label style="font-weight:bold;margin-left:15px">Description : </label>
    <span class="error">*</span>
    </br></br>
    <textarea style="margin-left:15px;" name="description"  rows="4" cols="50"
                ><?php echo $infosService['description'] ?></textarea>
    </br></br>


    <label style="font-weight:bold;margin-left:15px">Prix :</label>
    <span class="error">*</span>
    </br></br>
    <label style="margin-left:30px">Montant :</label>
    <input style="margin-left:20px;width:60px;text-align:right" type="text" name="prix" 
            value="<?php echo $infosService['prix']; ?>" >  €  
    </br></br></br>
    <label style="margin-left:30px">Forfait unique : </label>
    <input type="radio" name="typePrix" value="forfait"  
    <?php if ($_SERVER["REQUEST_METHOD"] != "POST") echo "checked"; ?>
    <?php if (isset($infosService['typePrix']) && $infosService['typePrix'] == 'forfait') echo "checked"; ?> >
    <label style="margin-left:15px">De l'heure :</label>
    <input type="radio" name="typePrix" value="de l'heure" 
    <?php if (isset($infosService['typePrix']) && $infosService['typePrix'] == "de l'heure") echo "checked"; ?> >
    </br></br></br>
    <label style="font-weight:bold;font-size:20px">Mot de passe actuel </label>
    <span class="error">*</span>
    </br></br>
    <input style="margin-left:150px" type="password" name="password"  value="<?php echo $infosService['password'] ?>"
            placeholder="****************" >
    </br></br></br>
    <input type="submit" value="Envoyer" 
    <?php '<script type="text/javascript">location.reload();</script>' ?> 
    >           
    </form>
</div>



