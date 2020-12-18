<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require 'Connexion.class.php';

class RequetesIdentification
{

    public function __construct()
    {
       $this->pdo = Database :: connect();
    }



    public function isPseudoExists($info)
    {
        // On veut voir si tel pseudo ayant pour id $info existe.  
        if (is_int($info))
        {
            $q = $this->pdo->query("SELECT COUNT(*) FROM personne WHERE id =$info;")->fetchColumn();
        }
        else
        {
        // Sinon, c'est qu'on veut vérifier que le "pseudo" existe ou pas.
        $clean_info= $this->pdo->quote($info);
        $q = $this->pdo->query("SELECT COUNT(*) FROM personne WHERE pseudo=$clean_info;")->fetchColumn();
        }
  
        return (bool)$q;
    }

    public function obtenirMotPasseByPseudo($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $q = $this->pdo->query("select password from personne where pseudo = $clean_pseudo;")->fetchColumn();
        return $q;          
    }

    public function obtenirMotPasseByIdMembre($idMembre)
    {
        $sql ="select login.motPasse from membre join login on membre.idLogin=login.login_id where membre.membre_id=$idMembre;";
        $q = $this->pdo->query($sql)->fetchColumn();
        return (string)$q;  
    }

    public function estAdmin($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $statut = $this->pdo->query("select role.role from personne join role on personne.id_role=role.id where personne.pseudo = $clean_pseudo;")->fetchColumn();
        if($statut === 'user_admin')
        {
            return true;
        }
        else
        {
            return false;
        }   
    } 

    public function obtenirIdMembreByPseudo($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $q= $this->pdo->query("select id from personne where pseudo =$clean_pseudo;")->fetchColumn();
        return $q;
    }         

    public function obtenirCodeCookie($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $q = $this->pdo->query("select codeCookie from login where pseudo=$clean_pseudo")->fetchColumn();
        return (string)$q;  
    }

    public function updateLastConnect($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $sql = "update personne set lastconnect = now() where pseudo = $clean_pseudo";

        $q = $this->pdo->prepare($sql);
        $q->execute() or die('Erreur SQL !'.$sql.'<br />'.mysql_error());    
    }



}
