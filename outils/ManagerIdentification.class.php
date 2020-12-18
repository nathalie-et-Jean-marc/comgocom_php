<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require '../../dto/RequetesIdentification.class.php';
require('Validations.class.php');

class ManagerIdentification
{
    private $requeteIdentification;
    private $msg1 = "<p style='color:purple'>Vous n'êtes pas identifié...</p>";
    private $msg2 = "<p style='color:purple'>Vous n'êtes plus identifié; veuillez vous identifier à nouveau...</p>";
    private $msg3 = "<p style='color:red'>Pseudo et/ou mot de passe incorrect(s)...</p>";
    private $msg4 = "<p style='color:blue'>Bienvenue </p>";


////   Conctructor ////

    public function __construct()
    {
        $this->requeteIdentification = new RequetesIdentification();
    }




////////////////////////////////////   méthodes pour la page identification.php   ///////////////////////////////

    private function creerTableauInfosIdentification($pseudo, $motpasse)
    {
        $infos = array (
                'pseudo' => $pseudo,
                'motPasse' => $motpasse,
        );
        return $infos;
    }

    private function infosAffichageSubmitIdentification()
    {
        if ( $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudoInput'])));        
            $motPasse = "";
            $infos = $this->creerTableauInfosIdentification($pseudo, $motPasse);
            //var_dump($infos);
            return $infos;
        }
    }

    private function obtenirInfosPostIdentification()
    {
        if ( $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudoInput'])));        
            $motpasse = htmlspecialchars_decode((trim($_POST['passInput'])));
            $infos = $this->creerTableauInfosIdentification($pseudo, $motpasse);
            return $infos;
        }    
    }

    public function infosVideIdentification()
    {
        if ( $_SERVER["REQUEST_METHOD"] != "POST" && empty($_POST))
        {
            $pseudo = "";        
            $motPasse = "";
            $infos = $this->creerTableauInfosIdentification($pseudo, $motPasse);
            return $infos;
        }
    }

  

    public function creerIdentification()
    {
        if ( $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $infos = $this->obtenirInfosPostIdentification();

            $bonPseudo = $this->requeteIdentification->isPseudoExists($infos['pseudo']);// retourne true s'il existe déjà
            $passEncrypt = $this->requeteIdentification->obtenirMotPasseByPseudo($infos['pseudo']);
            $motPasseOk = password_verify($infos['motPasse'], $passEncrypt);
            $estAdmin = $this->requeteIdentification->estAdmin($infos['pseudo']);
            
            if( !$bonPseudo | !$motPasseOk )
            {
                $infos = $this->infosAffichageSubmitIdentification();
                //var_dump($infos);
                echo "".$this->msg3. "</br>" .$this->msg1."";
                return $infos;
            }
            else
            {
                $this->requeteIdentification->updateLastConnect($infos['pseudo']);
                $this->creerCookiesIdentification($infos['pseudo'], (int)$estAdmin);
                $_SESSION['login'] = $infos['pseudo'];
                $_SESSION['admin'] = (int)$estAdmin;
                header('Location: http://comgocom.pw/index.php');
                exit();
            }
        }
    }

	private function creerCookiesIdentification($pseudo, $estAdmin)
    {
        //echo "coucou";
        //echo "</br>";
        $ip = $this->getIP();
        //echo $ip;
        //echo "</br>";
        $var = $pseudo.$estAdmin.$ip;
        //echo "$var";
       // echo "</br>";
        $codeCookie = password_hash($var, PASSWORD_BCRYPT,['cost' => 9]);
       // echo $ip;
        //echo "</br>";
        // comme en commentaire ci-dessous pour le domaine principal
        setcookie("verif", $codeCookie, time()+3600 * 24 * 3, '/', 'comgocom.pw');
        setcookie("pseudo", $pseudo, time()+3600 * 24 * 3, '/', 'comgocom.pw');  
        setcookie("admin", $estAdmin, time()+3600 * 24 * 3, '/', 'comgocom.pw');  
 
    } 

    public function msgInfoCookie()
    {
        $cookie_name = "flag";
        setcookie($cookie_name, "message accepter cookies lu", time()+3600 * 24 * 3, '/', 'comgocom.pw');
        if(!isset($_COOKIE[$cookie_name])) 
        {
            echo '
            <script type="text/javascript">
                function ConfirmMessage() {
                    if (confirm("Pour le bon fontionnement du site nous utilisons des cookies. \nLes cookies sont déactivés lors de la déconnexion : n\'oubliez pas de vous déconnecter avant de quitter le site !")) {  
                        document.location.href="#";
                    }
                    else {
                        document.location.href="../../index.php"; 
                    }
                        
                }
                ConfirmMessage(); 
            </script>
            ';
        }
    }

    private function getIP() //Permet d'avoir l'IP d'un visiteur
    {
        if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];
                    
        return $ip;
    }

}
