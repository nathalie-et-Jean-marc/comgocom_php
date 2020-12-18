<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include_once '../../classes/Identification.class.php';
?>
<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>index _ Home </title>
        <link rel="stylesheet" href="../../style/masterPage.css"/>
        <link rel="icon" type="image/x-icon" href="../../images/phi.ico" />
    </head>
 
     <body>
        <div class="header";>
            <?php 
                        $identification = new Identification();
                        $pseudo = $identification->getPseudo();
                        $admin = $identification->getAdmin();
            echo '<div class="bandereau">'; # div css class='bandereau' dans masterPage.css
                echo '<div>Tests divers</div>';
            echo '</div>'; # div css class='bandereau'
            
            echo '<div class="lien">';
                    #include("../includes/lienPagesGestionMembre.php");

                    echo ' <div style="float:left;margin-left:0%; margin-top:10px;">';#div bande pour liens
                        echo '  <span><a style="float:left;padding-left:10px;" href="../../index.php">Accueil</a></span>';
                        if ($admin == "1")  
                        {  
                            echo '<span><a style="padding-left:10px;" 
                                    href="administration.php">Administration</a></span>';
                        }
                        echo ' <div style=" margin-top:10px;color:#00FFFF;">';
                            if ($pseudo != "")
                            {
                                echo '<span>Bienvenue ' . $pseudo . ' !</span>';
                                echo '<span><a style="float:right;padding-left:20px;padding-right:5px;" 
                                        href="votreProfil.php">Votre profil</a></span>';
                                echo '<span><a style="float:right;padding-left:20px;padding-right:5px;" 
                                        href="gererSonCompte.php">Gérer son compte</a></span>';
                                echo '<span><a style="float:right;padding-left:10px;padding-right:10px;" 
                                        href="deconnexion.php">Déconnexion</a></span>';
                            }
                            else
                            {
                                echo '<div style="float:right"';
                                echo '<span><a style=" padding-left:10px;padding-right:30px;" 
                                        href="identification.php">S\'identifier</a></span>';
                                echo '<span><a style="padding-left:10px;padding-right:10px;" 
                                        href="inscription.php" >S\'inscrire</a></span>';
                                echo '</div>';
                            }  
                        echo ' </div>';          
                    echo ' </div>';#div bande pour liens
                    echo '<div style=clear:both;padding-top:10px;></div>';            
            echo '</div>';
            ?>
        </div>  <!-- div class='header' -->
        <div class="body">
             
        
        <?php
        #$passwordHash = password_hash("123456", PASSWORD_BCRYPT,['cost' => 9]);

        #echo $passwordHash;
        
        ?>




<!-- $nb = 2567858874.65;
numericForm($nb);

$number = 1234.56;

$var1 = number_format($number, 2, '.', '');

var_dump($var1);

$var2 = (string)$var1;

var_dump($var2); -->


<?php

//(\d+(\.\d+)?) 
// /^[0-9]+(\.[0-9]{2})?/ 
    function numericForm($numeric)
    {
        $str = "/^\d+(\.[1-9]{1,2})?$/"; // pas xx.0x ; un ou deux chiffres décimaux
        if(preg_match($str,$numeric))
        {
            echo "<p> prix ok </p>";
        }
        else
        {
            $var = "<p> Erreur </p>";
            
            echo $var;            
        }
    }


?>

<?php

//   function creerCodeOffre($car)
//    {
//        $string = "";
//        $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
//        srand((double)microtime()*1000000);
//        for($i=0; $i<$car; $i++) {
//        $string .= $chaine[rand()%strlen($chaine)];
//        }
//        return strtoupper($string);
//    }
//
//    $code = creerCodeOffre(5);
//    echo "code = ".$code."</br>";
?>






        

        </div> <!-- div class='body' -->

  
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>            

     </body>
</html>

