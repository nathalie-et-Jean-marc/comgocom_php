<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//require('../../managers/ManagerMembre.class.php');
include_once '../../dto/RequetesMembre.class.php';
include_once '../../outils/ManagerMembre.class.php';
include_once 'Validations.class.php';

class ManagerAdministration
{
    private $requete;
    private $managerMembre;

    public function __construct()
    {
        $this->managerMembre = new ManagerMembre();
        $this->requete = new RequetesMembre();
    }

    ///////////////////////////////////////////   LIRE TOUTES INFOS TOUS MEMBRE   ////////////////////////////

    private function instancierLesMembres()
    {
        $retour = $this->requete->obtenirToutesInfosTousMembres();
        //var_dump($retour);
        // on crée un tableau d'objets:
        while ($data = $retour->fetch(PDO::FETCH_ASSOC))
        {
            $membres[] = new Membre($data);
        }
        return $membres;
    }

    private function lireLesMembresInfos()
    {
        $tabInfosUnMembre = $this->instancierLesMembres();
        foreach ($tabInfosUnMembre as $membre) // ok
        {
            $idLogin = $membre->getLogin_id();
            $pseudo = $membre->getPseudo();
            $motPasse = $membre->getMotPasse();
            $cle = $membre->getCle();
            $actif = $membre->getActif();
            $mail = $membre->getMail();
            $lastConnect = $membre->getLastConnect();
            $idMembre = $membre->getMembre_id();
            $prenom = $membre->getPrenom();
            $nom = $membre->getNom();
            $isAdmin = $membre->getIsAdmin();
            $dateInscription = $membre->getDateInscription();
            $dateModif = $membre->getDateModif();
            $estIdentifie = $membre->getEstIdentifie();

            $infos[] = array (
                'idLogin' => $idLogin,
                'pseudo' => $pseudo,
                'motPasse' => $motPasse,
                'cle' => $cle,
                'actif' => $actif,
                'mail' => $mail,
                'lastConnect' => $lastConnect,
                'idMembre' => $idMembre,
                'prenom' => $prenom,
                'nom' => $nom,
                'isAdmin' => $isAdmin,
                'dateInscription' => $dateInscription,
                'dateModif' => $dateModif,
                'estIdentifie' => $estIdentifie
                );   
        }
        return $infos;
    }


    private function obtenirInfosDesMembres()
    {
        $data = $this->lireLesMembresInfos();
        $infos;   
        foreach ($data as $value)
        {
            $infos[] = $value;
        }
        return $infos;
    }

    public function afficherTableDesMembres()
    {
        //$managerMembre = new ManagerMembre();
        $infos = $this->obtenirInfosDesMembres();
        echo '<table>';
        echo '  <caption>Les membres et leurs informations</caption>';
        echo '      <thead>';
       // echo '        <th> objet</th>';
       // echo '        <th>Id Membre</th>';
        echo '        <th>Nom</th>';
        echo '        <th>Prénom</th>';
        echo '        <th>Pseudo</th>';
        echo '        <th>Email</th>';
        echo '        <th>Administrateur</th>';
        echo '        <th>Inscription</th>';
        echo '        <th>Modification</th> ';                        
        echo '        <th>Dernière connexion</th> ';
        echo '        <th>Modifier</th>';
        echo '        <th>Supprimer</th>';
        echo '    </thead>';
        foreach ($infos as $key=>$membre)
        {
            // l'administrateur ne doit pas pouvoir se supprimer ou modifier son rôle d'administrateur
                if($membre['pseudo'] != 'admin')
                { 
                    echo '<tr>';
                    //echo '<td>' .$key. '</td>';
                    //echo '<td>' .$membre['idMembre']. '</td>';
                    echo '<td>' .$membre['nom']. '</td>';
                    echo '<td>' .$membre['prenom']. '</td>';
                    echo '<td>' .$membre['pseudo']. '</td>';
                    echo '<td>' .$membre['mail']. '</td>';
                    echo ($membre['isAdmin'] == 0) ? '<td>NON</td>' : '<td>OUI</td>';
                    echo '<td>' .$membre['dateInscription']. '</td>';
                    echo '<td>' .$membre['dateModif']. '</td>';
                    echo '<td>' .$membre['lastConnect']. '</td>';
                    echo '<td><a href="modifierAdmin.php?ref='.$membre['idMembre'].'">Modifier</a></td>';
                    echo '<td><a href="supprimerMembre.php?ref='.$membre['idMembre'].'">Supprimer</a></td>';
                    echo '</tr>';
                }
        }
        echo '<table>';
    }

    /////////////////////////////////////////// MODIFIER     ESTADMIN      ////////////////////////////


    public function avantSubmit($idMembre)
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST")
        {
            //$idMembre = $_GET['ref'];
            $infos = $this->managerMembre->obtenirInfosDuMembreAvantModif($idMembre);
            return $infos;
        }
    }

    private function nombreProblemeSaisieModifAdmin($chaine)
    {
        $validation = new Validations();
        $validation->pbListeVide($chaine);
        $var = $validation->getErreur();
        return $var;
    }
    private function messageErreurSaisieModifAdmin($chaine)
    {  
        $validation = new Validations();
        $validation->messageListeVide($chaine, " administrateur ");
    }

    private function tabRecupApresSubmitAdmin($idMembre, $pseudo, $isAdmin)
    {
        $infos = array (
                'idMembre' => $idMembre,
                'pseudo' => $pseudo,
                'isAdmin' => $isAdmin
         );
         return $infos;
    }

    public function infosApresSubmitModifAdmin()
    {
        // On récupère la valeur à modifier :
        $isAdminPost = htmlentities(trim($_POST['boolAdmin']));
        $idMembre = htmlentities(trim($_POST['idMembreUpdate']));
        $pseudo = htmlentities(trim($_POST['pseudoUpdate']));
        $infos = $this->tabRecupApresSubmitAdmin($idMembre, $pseudo, $isAdminPost);
        return $infos;
    }

    public function modifierAdmin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            // On récupère la valeur à modifier :
            $infos = $this->infosApresSubmitModifAdmin();

            // On vérifie le nombre d'erreur : 
            $erreur = $this->nombreProblemeSaisieModifAdmin($infos['isAdmin']);
            if($erreur > 0)
            {
                $this->messageErreurSaisieModifAdmin($infos['isAdmin']);
                echo "<p style='color:purple;'>Veuillez corriger...</p>";
            }
            else
            {
                // On récupère les autres infos du membre, celles exigées par la fonction modifierMembre :
                $infosUtiles = $this->managerMembre->obtenirInfosDuMembreAvantModif($infos['idMembre']);

                // On modifie :            
                $this->requete->modifierMembre($infosUtiles['idLogin'], $infosUtiles['cle'], 
                                                     $infosUtiles['actif'], $infosUtiles['mail'], 
                                                     $infos['idMembre'], $infosUtiles['nom'], 
                                                     $infosUtiles['prenom'], $infos['isAdmin']);
                header('Location:administration.php');
                exit();
            }
        }
    } 

    //////////////////////////   SUPPRESSION D'UN MEMBRE    ///////////////////////////////////////

    public function supprimerMembre($idMembre)
    {
        $this->requete->supprimerMembre($idMembre);
    }




}
