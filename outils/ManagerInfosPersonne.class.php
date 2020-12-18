<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//require('../../managers/ManagerMembre.class.php');
include_once '../../dto/RequetesMembre.class.php';
include_once '../../classes/InfosPersonne.php';
include_once 'ManagerMembre.class.php';
include_once 'Validations.class.php';

class ManagerInfosPersonne
{
    private $requete;
    private $managerMembre;

    public function __construct()
    {
        $this->requete = new RequetesMembre();
        $this->managerMembre = new ManagerMembre();
    }

    /////////////////////////// Fonction pour créer une personne  ///////////////////////



    public function mailOk($pseudo)
    {
        $var = $this->requete->mailOk($pseudo);
        return $var;
    }

    // public function estUnePersonne($idMembre)
    // {
    //     $var = $this->requete->estUnePersonne($idMembre);
    //     //var_dump($var);        
    //     return $var; 
    // }

    private function tableauInfosAdrPersonne($idMembre, $pseudo, $prenom, $nom, $numRue, 
                                             $adrrText, $dpt, $ville, $codePostal, $telephone, $sexe, $motPasse)
    {
        $infos = array(
            'idMembre' => $idMembre,
            'pseudo' => $pseudo,
            'prenom' => $prenom,
            'nom' => $nom,				
            'numRue' => $numRue,
            'adrrText' => $adrrText,
            'dpt' => $dpt,
            'ville' => $ville,
            'codePostal' => $codePostal,
            'telephone' => $telephone,
            'sexe' => $sexe,
            'motPasse' => $motPasse
        );
        return $infos;
    }

    public function infosAvantInsertAdrr($idMembre)
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST")
        {
            $infosMembre = $this->managerMembre->lireUnMembreInstancie($idMembre);
            $numRue = $adrrText = $dpt = $ville = $codePostal = $telephone = $sexe = $motPasse = "";

            $infosAdrr = $this->tableauInfosAdrPersonne($idMembre, $infosMembre[0]['pseudo'], 
                                                        $infosMembre[0]['prenom'], $infosMembre[0]['nom'], 
                                                        $numRue, $adrrText, $dpt, $ville, $codePostal, 
                                                        $telephone, $sexe, $motPasse);
            return $infosAdrr;
        }    
    }

    public function infosPostAdrrPersonne($idM)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            // les valeurs du formulaire :
            $infosMembre = $this->managerMembre->lireUnMembreInstancie($idM);

            $idMembre = htmlspecialchars_decode((trim($_POST['idMembre'])));
            $numRue = htmlspecialchars_decode((trim($_POST['numRue'])));
            $adrrText = htmlspecialchars_decode((trim($_POST['adrrText'])));
            $dpt = htmlspecialchars_decode((trim($_POST['dpt'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $codePostal = htmlspecialchars_decode((trim($_POST['codePostal'])));
            $telephone = htmlspecialchars_decode((trim($_POST['telephone'])));
            $sexe = htmlspecialchars_decode((trim($_POST['sexe'])));
            $motPasse = htmlspecialchars_decode((trim($_POST['motPasse'])));
            $infosAdrr = $this->tableauInfosAdrPersonne($idMembre, $infosMembre[0]['pseudo'], 
                                                        $infosMembre[0]['prenom'], $infosMembre[0]['nom'], 
                                                        $numRue, $adrrText, $dpt, $ville, $codePostal, 
                                                        $telephone, $sexe, $motPasse);

            return $infosAdrr;
        }
    }

    public function verifierEtInscrireAdrrPers($idM)
    {
        $infosAdrr = $this->infosPostAdrrPersonne($idM);
        var_dump($infosAdrr);
        // on vérifie si le mot de passe saisi et compatible avec celui encrypté: verifExistancePass($passSaisi, $passEncrypt)
        $motPasseBdd = $this->requete->obtenirMotPasseByPseudo($infosAdrr['pseudo']);
        $motPasseOk = $this->managerMembre->verifExistancePass($infosAdrr['motPasse'], $motPasseBdd);                

        // on vérifie le nombre d'erreur :
        $erreur = $this->nombreProblemeSaisieAdrr($infosAdrr['numRue'], $infosAdrr['adrrText'],
                                                  $infosAdrr['dpt'], $infosAdrr['ville'], $infosAdrr['codePostal'], 
                                                  $infosAdrr['telephone'], $infosAdrr['sexe']);
        //var_dump($erreur);

        if( ($erreur > 0) | (!$motPasseOk) )
        {        
            $this->messageErreurSaisieAdrr($infosAdrr['numRue'], $infosAdrr['adrrText'], $infosAdrr['dpt'], 
                                           $infosAdrr['ville'], $infosAdrr['codePostal'], 
                                           $infosAdrr['telephone'], $infosAdrr['sexe']);
        }
        else
        {
            $this->requete->insertAdrrPers($idM, $infosAdrr['numRue'], 
                                  $infosAdrr['adrrText'],  $infosAdrr['dpt'],
                                  $infosAdrr['ville'], $infosAdrr['codePostal'], 
                                  $infosAdrr['telephone'], $infosAdrr['sexe']);
            // on informe que l'insertion a réussi: 
            echo "Votre informations ont bien été enregistrées.";
            echo "<script type='text/javascript'>window.location.replace('ajouterSonService.php');</script>";
        }
    }

    public function verifierEtInscrireAdrrPersDemande($idM)
    {
        $infosAdrr = $this->infosPostAdrrPersonne($idM);
        var_dump($infosAdrr);
        // on vérifie si le mot de passe saisi et compatible avec celui encrypté: verifExistancePass($passSaisi, $passEncrypt)
        $motPasseBdd = $this->requete->obtenirMotPasseByPseudo($infosAdrr['pseudo']);
        $motPasseOk = $this->managerMembre->verifExistancePass($infosAdrr['motPasse'], $motPasseBdd);                

        // on vérifie le nombre d'erreur :
        $erreur = $this->nombreProblemeSaisieAdrr($infosAdrr['numRue'], $infosAdrr['adrrText'],
                                                  $infosAdrr['dpt'], $infosAdrr['ville'], $infosAdrr['codePostal'], 
                                                  $infosAdrr['telephone'], $infosAdrr['sexe']);
        //var_dump($erreur);

        if( ($erreur > 0) | (!$motPasseOk) )
        {        
            $this->messageErreurSaisieAdrr($infosAdrr['numRue'], $infosAdrr['adrrText'], $infosAdrr['dpt'], 
                                           $infosAdrr['ville'], $infosAdrr['codePostal'], 
                                           $infosAdrr['telephone'], $infosAdrr['sexe']);
        }
        else
        {
            $this->requete->insertAdrrPers($idM, $infosAdrr['numRue'], 
                                  $infosAdrr['adrrText'],  $infosAdrr['dpt'],
                                  $infosAdrr['ville'], $infosAdrr['codePostal'], 
                                  $infosAdrr['telephone'], $infosAdrr['sexe']);
            // on informe que l'insertion a réussi: 
            echo "Votre informations ont bien été enregistrées.";
            echo "<script type='text/javascript'>window.location.replace('ajouterSaDemande.php');</script>";
        }
    }

    private function nombreProblemeSaisieAdrr($numRue, $libelleAdrr, $dpt, $ville, $codePostal, $telephone, $genre)
    {
        $validation = new Validations();
		
        $validation->pbSaisieNumRue($numRue);
        $validation->pbVideErreur($libelleAdrr);
        $validation->pbVideErreur($dpt);
        $validation->pbVideErreur($ville);		
        $validation->pbSaisieCodePostal($codePostal);
		$validation->pbSaisieTelephone($telephone);
		$validation->pbVideErreurCheck($genre);	

        $var = $validation->getErreur();
        return $var;
    }

    private function messageErreurSaisieAdrr($numRue, $libelleAdrr, $dpt, $ville, $codePostal, $telephone, $genre)
    {  
        $validation = new Validations();

        $validation->mauvaiseSaisieNumRue($numRue, "'Numéro de rue' ");
        $validation->videErreur($libelleAdrr, "'Libellé adresse'");
        $validation->videErreur($dpt, "'Département' ");
        $validation->videErreur($ville, "'Ville' ");		
        $validation->mauvaiseSaisieCodePostale($codePostal, " 'Code postal' ");
		$validation->mauvaiseSaisieTelephone($telephone, "'Téléphone' ");
		$validation->videErreurCheck($genre, "'Homme'", "'Femme'");	
    }

    /////////////////////////////////////  Lire infos personne ////////////////////////////////////////

    private function instancierInfosPersonnes()
    {
        $retour = $this->requete->obtenirInfosPersonnes();
        $infosPersonnes = array();
        while ($data = $retour->fetch(PDO::FETCH_ASSOC))
        {
            $infosPersonnes[] = new InfosPersonne($data);
        }
        return $infosPersonnes;
    }

    private function instancierInfosUnePersonne($idMembre)
    {
        $retour = $this->requete->obtenirInfosUnepersonne($idMembre);
        $infosUnePersonne = array();
        while ($data = $retour->fetch(PDO::FETCH_ASSOC))
        {
            $infosUnePersonne[] = new InfosPersonne($data);
        }
        return $infosUnePersonne;
    }

    // obtenir infos des ou d'une personne

    private function tableauInfosPersonne($personne_id, $idMembre, $numRue, $adrrText, 
                                          $dpt, $ville, $codePostal, $telephone, $photo, 
                                          $sexe, $nbEchange, $dateModif, $motPasse)
    {
            $infos = array(
                'personne_id' => $personne_id, 
                'idMembre' => $idMembre,
                'numRue' => $numRue,
                'adrrText' => $adrrText,
                'dpt' => $dpt,
                'ville' => $ville,
                'codePostal' => $codePostal,
                'telephone' => $telephone,
                'photo' => $photo,
                'sexe' => $sexe,
                'nbEchange' => $nbEchange,
                'dateModif' => $dateModif,
                'motPasse' => $motPasse
            );            
        
        return $infos;
    }

    public function obtenirInfosPersonnes()
    {
        $tabInfosPersonnes = $this->instancierInfosPersonnes();
        foreach ( $tabInfosPersonnes as $infosPersonne)
        {            
            $personne_id = $infosPersonne->getPersonne_id();
            $idMembre = $infosPersonne->getIdMembre();
            $numRue = $infosPersonne->getNumRue();
            $adrrText = $infosPersonne->getAdrrText();
            $dpt = $infosPersonne->getDpt();
            $ville = $infosPersonne->getVille();
            $codePostal = $infosPersonne->getCodePostal();
            $telephone = $infosPersonne->getTelephone();
            $photo = $infosPersonne->getPhoto();
            $sexe = $infosPersonne->getSexe();
            $nbEchange = $infosPersonne->getNbEchange();
            $dateModif = $infosPersonne->getDateModif();
            $motPasse = "";
            
            $infos = $this->tableauInfosPersonne($personne_id, $idMembre, $numRue, $adrrText, 
                                          $dpt, $ville, $codePostal, $telephone, $photo, 
                                          $sexe, $nbEchange, $dateModif, $motPasse);            
        }
        return $infos;
    }

    public function obtenirInfosUnePersonne($idMembre)
    {
        $infosPersonne = $this->instancierInfosUnePersonne($idMembre);
        foreach ( $infosPersonne as $infosPerso)
        {
            $personne_id = $infosPerso->getPersonne_id();
            $idMembre = $infosPerso->getIdMembre();
            $numRue = $infosPerso->getNumRue();
            $adrrText = $infosPerso->getAdrrText();
            $dpt = $infosPerso->getDpt();
            $ville = $infosPerso->getVille();
            $codePostal = $infosPerso->getCodePostal();
            $telephone = $infosPerso->getTelephone();
            $photo = $infosPerso->getPhoto();
            $sexe = $infosPerso->getSexe();
            $nbEchange = $infosPerso->getNbEchange();
            $dateModif = $infosPerso->getDateModif();
            $motPasse = "";
                        
            $infosUnePersonne = $this->tableauInfosPersonne($personne_id, $idMembre, $numRue, $adrrText, 
                                          $dpt, $ville, $codePostal, $telephone, $photo, 
                                          $sexe, $nbEchange, $dateModif, $motPasse);
        }
        return $infosUnePersonne;
    }

    ///// afficher infos  d'une personne

    public function afficherTabInfosUnePersonne($idMembre)
    {
        $infos = $this->obtenirInfosUnePersonne($idMembre);
        // var_dump($infos);       
    

        echo '<table>';
        //echo '  <caption>Les informations actuelles</caption>';
        echo '      <thead>';

        echo '        <th hidden>Id Membre</th>';
        echo '        <th>Numéro de rue</th>';
        echo '        <th>Adresse</th> ';                        
        echo '        <th>Ville</th>';
        echo '        <th>Département</th>';
        echo '        <th>Code postal</th>';
        echo '        <th>Téléphone</th>';
        echo '        <th>Nombre d\'échange</th>';
        echo '        <th>Dernière Modification</th>';
        echo '        <th>Action</th>';
        echo '    </thead>';
        echo '<tr>';
        echo '<td hidden>' .$infos['idMembre']. '</td>';
        echo '<td style="text-align:center">' .$infos['numRue']. '</td>';
        echo '<td>' .$infos['adrrText']. '</td>';
        echo '<td>' .$infos['dpt']. '</td>';
        echo '<td>' .$infos['ville']. '</td>';
        echo '<td>' .$infos['codePostal']. '</td>';
        echo '<td>' .$infos['telephone']. '</td>';
        echo '<td style="text-align:center">' .$infos['nbEchange']. '</td>';
        echo '<td>' .$infos['dateModif']. '</td>';
        echo '<td style="font-weight:bold;"><a href="modifierInfosPersonne.php?ref='.$infos['idMembre'].'">Modifier</a></td>';
        echo '</tr>';
        echo '<table>';
    }


    ///////////////////////   modifier infos d'une personne ////////////////////////////

    private function tableauInfosModifierUnePersonne($idMembre, $numRue, $adrrText, $dpt, 
                                                    $ville, $codePostal, $telephone, $motPasse)
    {
            $infos = array (
                    'idMembre' => $idMembre,        
                    'numRue' => $numRue,
                    'adrrText' => $adrrText,
                    'dpt' => $dpt,
                    'ville' => $ville,
                    'codePostal' => $codePostal,
                    'telephone' => $telephone,
                    'motPasse' => $motPasse
            );
            return $infos;
    }

    public function infosPostModifierUnePersonneAffichable($idMembre, $numRue, $adrrText, $dpt, 
                                                    $ville, $codePostal, $telephone, $motPasse)
    {
            $idMembre = htmlspecialchars_decode((trim($_POST['idMembre'])));
            $numRue = htmlspecialchars_decode((trim($_POST['numRue'])));
            $adrrText = htmlspecialchars_decode((trim($_POST['adrrText'])));
            $dpt = htmlspecialchars_decode((trim($_POST['dpt'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $codePostal = htmlspecialchars_decode((trim($_POST['codePostal'])));
            $telephone = htmlspecialchars_decode((trim($_POST['telephone'])));
            $motPasse = "";
            $infosPost = $this->tableauInfosModifierUnePersonne($idMembre, $numRue, $adrrText, $dpt, 
                                                    $ville, $codePostal, $telephone, $motPasse); 
            return $infosPost;
    }

    private function obtenirInfosPostUnePersonne()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $idMembre = htmlspecialchars_decode((trim($_POST['idMembre'])));
            $numRue = htmlspecialchars_decode((trim($_POST['numRue'])));
            $adrrText = htmlspecialchars_decode((trim($_POST['adrrText'])));
            $dpt = htmlspecialchars_decode((trim($_POST['dpt'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $codePostal = htmlspecialchars_decode((trim($_POST['codePostal'])));
            $telephone = htmlspecialchars_decode((trim($_POST['telephone'])));
            $motPasse = htmlspecialchars_decode((trim($_POST['motPasse'])));

            $infosPost = $this->tableauInfosModifierUnePersonne($idMembre, $numRue, $adrrText, $dpt, 
                                                    $ville, $codePostal, $telephone, $motPasse); 
            return $infosPost;
        }
    }

    private function nombreProblemeSaisieModifPersonne($numRue, $libelleAdrr, $dpt, $ville, $codePostal, $telephone)
    {
        $validation = new Validations();
        
        $validation->pbSaisieNumRue($numRue);
        $validation->pbVideErreur($libelleAdrr);
        $validation->pbVideErreur($dpt);
        $validation->pbVideErreur($ville);      
        $validation->pbSaisieCodePostal($codePostal);
        $validation->pbSaisieTelephone($telephone);

        $var = $validation->getErreur();
        return $var;
    }

    private function messageErreurSaisieModifPersonne($numRue, $libelleAdrr, $dpt, $ville, $codePostal, $telephone)
    {  
        $validation = new Validations();

        $validation->mauvaiseSaisieNumRue($numRue, "'Numéro de rue' ");
        $validation->videErreur($libelleAdrr, "'Libellé adresse'");
        $validation->videErreur($dpt, "'Département' ");
        $validation->videErreur($ville, "'Ville' ");        
        $validation->mauvaiseSaisieCodePostale($codePostal, " 'Code postal' ");
        $validation->mauvaiseSaisieTelephone($telephone, "'Téléphone' ");

    }

    public function verifierEtModifierInfosPersonne()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $infosPost = $this->obtenirInfosPostUnePersonne();
            $motPasseBdd = $this->requete->obtenirMotPasseByIdMembre($infosPost['idMembre']);
            $motPasseOk = $this->managerMembre->verifExistancePass($infosPost['motPasse'], $motPasseBdd);

            // on vérifie le nombre d'erreur :
            // $numRue, $libelleAdrr, $dpt, $ville, $codePostal, $telephone)
            $erreur = $this->nombreProblemeSaisieModifPersonne($infosPost['numRue'], $infosPost['adrrText'],
                                                    $infosPost['dpt'], $infosPost['ville'], 
                                                    $infosPost['codePostal'], 
                                                    $infosPost['telephone']);
            if( ($erreur > 0) | (!$motPasseOk) )
            {        
                $this->messageErreurSaisieModifPersonne($infosPost['numRue'], $infosPost['adrrText'],
                                                        $infosPost['dpt'], $infosPost['ville'], 
                                                        $infosPost['codePostal'], $infosPost['telephone']);
                $infosPost = $this->infosPostModifierUnePersonneAffichable($infosPost['idMembre'], $infosPost['numRue'], 
                                                                        $infosPost['adrrText'], $infosPost['dpt'], 
                                                                        $infosPost['ville'], $infosPost['codePostal'], 
                                                                        $infosPost['telephone'], $infosPost['motPasse']);
                return $infosPost;
            }
            else
            {
                // ($idMembre, $numRue, $adrrText, $dpt, $ville, $codePostal, $telephone)
                $this->requete->modifierInfosUnePersonne($infosPost['idMembre'], $infosPost['numRue'], 
                                                $infosPost['adrrText'], $infosPost['dpt'], 
                                                $infosPost['ville'], $infosPost['codePostal'], 
                                                $infosPost['telephone']);
                // on informe que l'insertion a réussi: 
                echo "<script type='text/javascript'>window.location.replace('votreProfil.php');</script>";
            }        
        }
    }

}
