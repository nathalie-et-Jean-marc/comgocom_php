<?php
    include_once 'classes/Identification.class.php';
    $identification = new Identification();
    $pseudo = $identification->getPseudo();
    $admin = $identification->getAdmin();

    echo ' <div style="float:left;margin-left:0%; margin-top:10px;">';
    echo '  <span><a style="float:left;padding-left:10px;" href="#">Accueil</a></span>';
    
    echo '  <span><a style="float:left;padding-left:20px;" href="public/pages/contacts.php">Contacts</a></span>';
    #echo '  <span><a style="float:left;padding-left:20px;" href="wikis/doku.php">Wikis</a></span>';
    echo '  <span><a style="float:left;padding-left:20px;" href="#">Wikis</a></span>';
   
    #echo '  <span><a style="float:left;padding-left:20px;" href="wForum/index.php">Forum</a></span>';    
    echo '  <span><a style="float:left;padding-left:20px;" href="#">Forum</a></span>'; 
/*     echo ' <span><a style="padding-left:10px; padding-right:10px;" 
                href="public/pages/demandesDeServices.php">Demandes de service</a></span>'; */
    echo ' <span><a style="padding-left:10px; padding-right:10px;" 
                href="#">Demandes de service</a></span>';
   
/*     echo ' <span><a style="padding-left:10px; padding-right:10px;" 
            href="public/pages/servicesProposes.php">Services proposés</a></span>';   */  
    echo ' <span><a style="padding-left:10px; padding-right:10px;" 
            href="#">Services proposés</a></span>';  
    echo ' <span><a style="padding-left:10px; padding-right:10px;" 
            href="public/pages/CGU.php">Condition Générale d\'utilisation</a></span>'; 
    if ($admin == "1")  
    {  
        echo '<span><a style="padding-left:10px;" 
                href="public/pages/administration.php">Administration</a></span>';
    }
    echo ' <span><a style="float:left;padding-left:20px; padding-right:10px;" 
            href="public/pages/charte.php">Charte de confidentialité</a></span>';        
    echo ' <div style=" margin-top:10px;color:#00FFFF;">';
/*     echo ' <span><a style="float:left;padding-left:10px; padding-right:10px;" 
                href="public/pages/ajouterSaDemande.php">Ajouter sa demande</a></span>';      */     
    echo ' <span><a style="float:left;padding-left:10px; padding-right:10px;" 
                href="#">Ajouter sa demande</a></span>';        
//     echo ' <span><a style="float:left;padding-left:10px; padding-right:150px;" 
//                 href="public/pages/ajouterSonService.php">Ajouter son service</a></span>';      
    echo ' <span><a style="float:left;padding-left:10px; padding-right:150px;" 
            href="#">Ajouter son service</a></span>';         
    if ($pseudo != "")
    {
        echo '<span>Bienvenue ' . $pseudo . ' !</span>';
        echo '<span><a style="float:right;padding-left:20px;padding-right:5px;" 
                href="public/pages/votreProfil.php">Votre profil</a></span>';
/*         echo '<span><a style="float:right;padding-left:20px;padding-right:5px;" 
                href="#">Votre profil</a></span>'; */
        echo '<span><a style="float:right;padding-left:20px;padding-right:5px;" 
                href="public/pages/gererSonCompte.php">Gérer son compte</a></span>';
        echo '<span><a style="float:right;padding-left:10px;padding-right:10px;" 
                href="public/pages/deconnexion.php">Déconnexion</a></span>';
    }
    else
    {
        echo '<div style="float:right"';
        echo '<span><a style=" padding-right:10px;" 
                href="public/pages/identification.php">S\'identifier</a></span>';
        echo '<span><a style="padding-left:10px;padding-right:20px;" 
                href="public/pages/inscription.php" >S\'inscrire</a></span>';
        echo '</div>';
    }  

    echo ' </div>'; 
    echo ' </div>';
    echo '<div style=clear:both;padding-top:10px;></div>';
?>
