<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require '../../outils/ManagerPagesMembre.class.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>formulaire d'inscription</title>
        <link rel="stylesheet" href="../../style/masterPage.css">
        <link rel="stylesheet" href="../../style/contact.css">
        <link rel="icon" type="image/x-icon" href="../../images/hypathieIco.ico" />

    </head>
     <body>
        <div class="header";>
            <?php include("../includes/headerPages.php"); ?>
        </div>
        <div class="body">
            <div class="boiteContacts">
                <h2>Contacts</h2>
                
                <p>Pour toutes questions, n'hésitez pas à nous contacter par mail. </p>
                    <table>
                        <tr>
                            <td class="titre">domaine.comgocom@gmail.com</td>
                            <!-- <td class="info">hypathie chez gmx point fr</td> -->
                        </tr>
                    </table>
                    <p>À bientôt !</p>
<!--                 <p>Pour nous éviter les robots, merci de translittérer l'adresse mail, 
                    comme indiqué dans l'exemple ci-dessous.</p>
                <p>Pour joindre monsieur Toto, l'expression <span>"toto chez bla point com"</span> 
                    correspondrait à l'adresse mail : <span>toto@bla.com</span>.</p> -->

            </div>   

<?php
//echo date('Y m d H:i:s', $_SESSION['time']);
//
//unset($_SESSION["time"]);
//
//var_dump($_SESSION['time']);
//
//echo '<br/>session coucou '.$_SESSION['coucou'].'<br/>';
//session_destroy();
//
//var_dump($_SESSION['time']);
//
//echo '<br /><a href="../../index.php">index</a>';
?>

        </div>
        <div class="footer">
            <p>&copy; 2020 comgocom.pw<p>
        </div>
     </body>
</html>
