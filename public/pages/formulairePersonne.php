    <div>


        <div class="formulaire">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" hidden name="idMembre" value="<?php echo $infosAdrr['idMembre'] ?>">
            <legend> Informations complémentaires : </legend>
            </br>
            <label style="font-weight:bold;">Pour le membre :</label>
            <label> <?php echo $infosAdrr['nom'] ?> </label>
            <label><?php echo $infosAdrr['prenom'] ?></label>
            </br>
            <label style="font-weight: bold;">Pseudo :</label>
            <label><?php echo $infosAdrr['pseudo'] ?></label>
            </br>
            <p><span class="error">* Champs obligatoires</span></p>
            <label style="font-weight:bold;">Numéro de rue</label>
            </br>
            <input style="width:40px;" type="text" name="numRue" value="<?php echo $infosAdrr['numRue'] ?>">
            </br></br>
            <label style="font-weight:bold;">Libellé adresse</label>
            <span class="error">*</span>
            </br>
            <input  style="width:350px;" type="text" name="adrrText" value="<?php echo $infosAdrr['adrrText'] ?>">
            </br></br>
            <label style="font-weight:bold;">Département</label>
            <span class="error">*</span>
            </br>
            <input style="width:150px;" type="text" name="dpt" id="rechercheDepartements" value="<?php echo $infosAdrr['dpt'] ?>">
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
            <input style="width:150px;" type="text" name="ville" id="rechercheVilles" value="<?php echo $infosAdrr['ville'] ?>">
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
            <input style="width:53px;" type="text" name="codePostal" id="rechercheCp" value="<?php echo $infosAdrr['codePostal'] ?>">
                <script language='javascript'>
                    $('#rechercheCp').autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url : '../../outils/autocomplete.php',
                                dataType: "json",
                                    data: {
                                        filtreCp: request.term,
                                        filtreV : $('#rechercheVilles').val(),
                                        type: 'codePostal'
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
            <label style="font-weight:bold;">Téléphone</label>
            <span class="error">*</span>
            </br>
            <input style="width:110px;" type="text" name="telephone" value="<?php echo $infosAdrr['telephone'] ?>">
            </br></br>
            <label style="font-weight:bold;" >Genre</label>
            <span class="error">*</span></br>
            </br>
            <label style="border:1px;border-radius:5px; box-shadow:1px 1px 2px #C0C0C0 inset;
                          background-color:#F2F2F2; margin-left:6px; padding:3px;">Femme</label>            
            <input style="margin-left:50px;" type="radio" name="sexe" 
                <?php if (isset($infosAdrr['sexe']) && $infosAdrr['sexe']=="F") echo "checked"; ?> value="F">

            </br></br>
            <label style="border:1px;border-radius:5px; box-shadow:1px 1px 2px #C0C0C0 inset;
                          background-color:#F2F2F2; margin-left:6px; padding:3px;">Homme</label>
            <input style="margin-left:48px;" type="radio" name="sexe" 
                <?php if (isset($infosAdrr['sexe']) && $infosAdrr['sexe']=="M") echo "checked";?> value="M">
            <input hidden type="radio" name="sexe" value="pasRepondu" 
                <?php if ($infosAdrr['sexe']=="") echo "checked";?> 
                <?php if (isset($infosAdrr['sexe']) && $infosAdrr['sexe']!="pasRepondu") echo "unchecked";?>>
            </br></br>            
            <label style="font-weight:bold;">Mot de passe actuel</label>
            <span class="error">*</span>
            </br>
            <input style="width:150px;" type="password" name="motPasse" placeholder="**************"  
                   value="<?php echo $infosAdrr['motPasse'] ?>">
            </br></br></br>
            <input type="submit" value="Envoyer" 
            <?php '<script type="text/javascript">location.reload();</script>' ?> 
            />           
            </form>
        </div>
    </div>

