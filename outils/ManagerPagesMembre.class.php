<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//require('../../managers/ManagerMembre.class.php');
include_once '../../dto/RequetesMembre.class.php';
require '../../classes/Membre.class.php';
require '../../classes/Offre.class.php';
require '../../classes/InfosPersonne.php';
include_once 'Validations.class.php';

class ManagerPagesMembre
{
    private $requete;

    public function __construct()
    {
        //$this->managerMembre = new ManagerMembre();
        $this->requete = new RequetesMembre();
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////     CHANTIER, TESTS NOUVELLES FONCTIONS, LISTE DE TODO /////////////////////////////// 
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    //////////////////////////   MODIFICATION DU TOUTES PRORIETES D'UN MEMBRE    ///////////////////////////////////////


    private function nombreProblemeSaisieModifierMail($mail)
    {
        $validation = new Validations();

        $validation->pbMail($mail);
        $var = $validation->getErreur();
        return $var;
    }
    private function messageErreurSaisieModifierMail($mail)
    {  
        $validation = new Validations();
        $validation->invalidMail($mail, " mail ");
    }



    private function recupererInfosPourSoumettreEncore($idMembre,$mail, $pseudo, $motPasse)
    {
        $infos = array (
                'idMembre' => $idMembre,
                'mail' => $mail,
                'pseudo' => $pseudo,
                'motPasse' => $motPasse
         );
         return $infos;
    }

    // fonction déclarée à l'identique dans ManagerMembre //
    private function verifExistancePass($passSaisi, $passEncrypt)
    {
        $passOk = password_verify($passSaisi, $passEncrypt);
        if (!$passOk)
        {
            echo "<p>Votre mot de passe actuel est incorrecte !</p>";
        }
        return $passOk;
    }

    public function obtenirInfosDuMembreAvantModif($idMembre)
    {
       // $infos = $this->obtenirInfosDuMembre($idMembre);
       // return $infos;
        $data = $this->lireUnMembreInstancie($idMembre);
        $infos;   
        foreach ($data as $value)
        {
            $infos = $value;
        }
        return $infos;
    }

    public function afficherAvantSubmit()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST")
        {
            $idMembre = $_GET['ref'];
            $infos = $this->obtenirInfosDuMembreAvantModif($idMembre);
            return $infos;
        }
    }

    public function obtenirInfosUtilesApresSubmit()
    {
        // l'identifiant et pseudo à réafficher :
        $idMembrePost = htmlspecialchars_decode((trim($_POST['idMembreUpdate'])));
        $pseudoPost =  htmlspecialchars_decode((trim($_POST['pseudoUpdate'])));
        $actuelPassPost = htmlspecialchars_decode((trim($_POST['actuelPassSaisi'])));

        // les valeurs modifiables :

        $mailPost = htmlentities(trim($_POST['mailUpdate']));
        $infos = $this->recupererInfosPourSoumettreEncore($idMembrePost, $mailPost, $pseudoPost, $actuelPassPost);
        return $infos;
    }

    // modification du nom, prenom, mail
    // la function ci-dessous sera à utiliser pour le bac office
    public function verifierSaisieEtModifier()
    { 
        $infos = $this->obtenirInfosUtilesApresSubmit();
        $infosNonModif = $this->obtenirInfosDuMembreAvantModif($infos['idMembre']);
        // on vérifie si le mot de passe saisi et compatible avec celui encrypté: verifExistancePass($passSaisi, $passEncrypt)
        $motPasseOk = $this->verifExistancePass($infos['motPasse'], $infosNonModif['motPasse']);

        // on vérifie le nombre d'erreur :
        $erreur = $this->nombreProblemeSaisieModifierMail($infos['nom'], $infos['prenom'], $infos['mail']);
        if( ($erreur > 0) | (!$motPasseOk) )
        {
            $this->messageErreurSaisieModifierMail($infos['nom'], $infos['prenom'], $infos['mail']);
        }        
        else 
        {
            // on modifie :
            $this->requete->modifierMembre($infosNonModif['idLogin'], $infosNonModif['cle'], 
                                            $infosNonModif['actif'], $infos['mail'], $infosNonModif['idMembre'], 
                                            $infos['nom'], $infos['prenom'], $infosNonModif['isAdmin']);
            // on retourne à la page précédente :
            //echo "c'est modifier !";
            header('Location:sonCompte.php');
            exit();            
        }
    }    

    //////////////////////////   TODO : FAIRE LES PAGES HTML CORRESPONDANTES      



    ///////////////////////////////////////////////  TODO   ///////////////////////////////////////////
    ///// Dans le bac_office mettre en place la suppression d'une offre ///////////////////////////////


    /// pour l'administrateur
    public function supprimerService($idOffre)
    {
        $this->requete->supprimerService($idOffre);
    }

    ///// Dans le bac_office mettre en place lire toutes offres (services et demandes confondues)  ////


    ///// Dans le bac_office mettre en place lire toutes infosPersonnes                            ////

}







