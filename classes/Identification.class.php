<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Identification
{

    private $admin;
    private $pseudo;


////   Conctructor ////

    public function __construct()
    {
        $this->setIdentification();
    }

//// GETTERS ////

    public function getPseudo() { return $this->pseudo ; }
    public function getAdmin() { return $this->admin ; }

//// SETTERS ////

    private function setPseudo($newPseudo)
    {
        $newPseudo = (string) $newPseudo;
        $this->pseudo = $newPseudo;
    }
    private function setAdmin($newAdmin)
    {
        $newAdmin = (int) $newAdmin;
        $this->admin = $newAdmin;
    }


//// méthode pour le constructeur :

    private function is_session_started()
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }

    private function setSessionSarted()
    {
        if ( $this->is_session_started() === FALSE ) session_start();
    }

    private function getIP() //Permet d'avoir l'IP d'un visiteur
    {
        if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];
                    
        return $ip;
    }

    private function  verfierCookie()
    {
        $ok = false;
        if(isset($_COOKIE['pseudo']) && isset($_COOKIE['admin']) && isset($_COOKIE['verif'])) 
        {
            $pseudo = $_COOKIE['pseudo'];
            $estAdmin = $_COOKIE['admin'];
            $ip = $this->getIP();

            $codeCookieNavigateur = $_COOKIE['verif'];
            $codeCookie = $pseudo.$estAdmin.$ip;
            $ok = password_verify($codeCookie, $codeCookieNavigateur);
        }
      //  else
      //  {
      //      // on supprime les cookies :
      //       setcookie("verif", '', time() - 3600, '/', 'comgocom.pw');
      //       setcookie("pseudo", '', time() - 3600, '/', 'comgocom.pw');  
      //       setcookie("admin", '', time() - 3600, '/', 'comgocom.pw');                 
      //      //setcookie("verif", '', time() - 3600, '/', '.essai.local.net');
      //      //setcookie("pseudo", '', time() - 3600, '/', '.essai.local.net');  
      //      //setcookie("admin", '', time() - 3600, '/', '.essai.local.net');
      //      $ok = false;
      //  }
        return $ok;
    }

    private function setIdentification()
    {
        $this->setSessionSarted();
        $cookiesOk = $this->verfierCookie();
        if ( isset($_SESSION['login']) && !empty($_SESSION['login']) 
             && isset($_SESSION['admin']) && !empty($_SESSION['admin']) )
        {
            $this->setPseudo($_SESSION['login']);
            $this->setAdmin($_SESSION['admin']);
 
        }
        else if ($cookiesOk)
        {
            $_SESSION['login'] = $_COOKIE['pseudo'];
            $_SESSION['admin'] = $_COOKIE['admin'];
            $this->setPseudo($_COOKIE['pseudo']);
            $this->setAdmin($_COOKIE['admin']);
        }
        else
        {
            $this->setPseudo("");
            $this->setAdmin(0);
        }
    }

    public function verifierIdentification()
    {
        $var = $this->verfierCookie();
        if (!$var)
        {
            // echo "<p style='color:green'>vous n'êtes pas identifié</p>";
            $this->pathRequest();            
        }
    }


    // à utiliser en new Identification->pathRequest à la place du master page des liens
    public function pathRequest()
    {
        $path = $_SERVER['REQUEST_URI'];
        if ($path != "/public/pages/identification.php")
        {
            header('Location: http://comgocom.pw/public/pages/identification.php');
            exit();
        }
    }


}
