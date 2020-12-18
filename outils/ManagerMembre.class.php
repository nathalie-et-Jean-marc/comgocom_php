<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//require('../../managers/ManagerMembre.class.php');
include_once '../../dto/RequetesMembre.class.php';
include_once '../../classes/Membre.class.php';
include_once 'Validations.class.php';

class ManagerMembre
{
    private $requete;

    public function __construct()
    {
        $this->requete = new RequetesMembre();
    }



    ////////////////////////// page votreProfil.php ///////////////////////////    

    /// Fonctions utiles pour l'affichage du membre (nom, prénom, date d'inscription :

    public function obtenirIdMembreByPseudo($pseudo)
    {
        $idMembre = $this->requete->obtenirIdMembreByPseudo($pseudo);
        return $idMembre;
    }

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

    public function pseudoParSession()// pas utilisée
    {
        //session_start();
        $okSession = $this->is_session_started();
        if ( $okSession === FALSE ) session_start();

        if (isset($_SESSION['login']))
        {
            $pseudo = $_SESSION['login'];
            //echo "<p>".$pseudo."</p>";       
        }
        return $pseudo;
    }

    private function instancierUnMembre($id)
    {
        $retour = $this->requete->obtenirToutesInfosUnMembreById($id);
        
        // on crée un tableau des infos du membre :
        while ($data = $retour->fetch(PDO::FETCH_ASSOC))
        {
            $membre[] = new Membre($data);
        }
        //var_dump($membre);
        return $membre;
    }     

    public function lireUnMembreInstancie($id)
    {
        $tabInfosUnMembre = $this->instancierUnMembre($id);
        foreach ($tabInfosUnMembre as $membre)
        {
            $idPersonne = $membre->getIdPersonne();
            $pseudo = $membre->getPseudo();
            $motPasse = $membre->getMotPasse();
            $cle = $membre->getCle();
            $actif = $membre->getActif();
            $mail1 = $membre->getMail1();
            $mail2 = $membre->getMail2();
            $lastConnect = $membre->getLastConnect();
            $prenom = $membre->getPrenom();
            $nom = $membre->getNom();
            $adresse= $membre->getAdresse();
            $ville = $membre->getVille();
            $departement = $membre->getDepartement();
            $codepostale = $membre->getCodePostal();
            $pays = $membre->getPays();
            $telephone1 = $membre->getTelephone1();
            $telephone2 = $membre->getTelephone2();
            $civilite = $membre->getCivilite();
            $idAbonnement = $membre->getIdAbonnement();
            $idTypeAbonnement = $membre->getIdTypeAbonnement();
            $typeAbonnement = $membre->getTypeAbonnement();
            $role = $membre->getRole();
            $statut = $membre->getStatut();
            //$isAdmin = $membre->getIsAdmin();

            $dateInscription = $membre->getDateInscription();
    
            $dateModif = $membre->getDateModif();
            $estIdentifie = $membre->getEstIdentifie();

            $infos[] = array (
                'idPersonne' => $idPersonne,
                'pseudo' => $pseudo,
                'motPasse' => $motPasse,
                'cle' => $cle,
                'actif' => $actif,
                'mail1' => $mail1,
                'mail2' => $mail2,
                'lastConnect' => $lastConnect,
                'prenom' => $prenom,
                'nom' => $nom,
                'adresse' => $adresse,
                'ville' => $ville ,
                'departement' =>  $departement,
                'codepostale' => $codepostale,
                'pays' => $pays,
                'telephone1' => $telephone1 ,
                'telephone2' => $telephone2,
                'civilite' =>  $civilite,
                'idAbonnement' => $idAbonnement ,
                'idTypeAbonnement' => $idTypeAbonnement,
                'typeAbonnement' => $typeAbonnement,
                'role' => $role,
                'statut' => $statut,
                //'isAdmin' => $isAdmin,
                'dateInscription' => $dateInscription,
                'dateModif' => $dateModif,
                'estIdentifie' => $estIdentifie
                );  
        }
        return $infos;
    }

    public function dataAdresse($id)
    {
        $retour = $this->requete->obtenirAdresse($id);
        $adresse=array();
        while ($row = $retour->fetch(PDO::FETCH_ASSOC))
        {
            $adresse['adresse'] = $row['adresse'];
            $adresse['ville'] = $row['ville'] ;
            $adresse['departement'] =  $row['departement'];
            $adresse['codepostal'] = $row['codepostal'];
            $adresse['pays'] = $row['pays'];
        }
 
        // on crée un tableau des infos du membre :

        //var_dump($adresse);
        return $adresse;
    } 

    public function reafficherAvantModifAdresse()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $idPersonne = htmlspecialchars_decode((trim($_POST['idPersonne'])));
            $adresse = htmlspecialchars_decode((trim($_POST['adresse'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $departement = htmlspecialchars_decode((trim($_POST['departement'])));
            $codepostal = htmlspecialchars_decode((trim($_POST['codepostal'])));
            $pays=htmlspecialchars_decode((trim($_POST['pays'])));

            $infos = $this->creerTableauInfosAdresseAModifier($idPersonne,$adresse,$ville,$departement,$codepostal,$pays);
            // echo " deuxième var_dump </br>";
            // var_dump($infos);
            return $infos;        
        }
    }
    private function creerTableauInfosAdresseAModifier($idPersonne,$adresse,$ville,$departement,$codepostal,$pays)
    {
        $infos = array (
                'idPersonne' => $idPersonne,
                //'id' => $idPersonne,
                'adresse' => $adresse,
                'ville' => $ville,
                'departement' => $departement,
                'codepostal' => $codepostal,
                'pays' => $pays,
        );
        return $infos;
    }

    private function infosAdresseAmodifier()
    {
        // les valeurs du formulaire :
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        { 
            $idPersonne = htmlspecialchars_decode((trim($_POST['idPersonne'])));
            $adresse = htmlspecialchars_decode((trim($_POST['adresse'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $departement = htmlspecialchars_decode((trim($_POST['departement'])));
            $codepostal = htmlspecialchars_decode((trim($_POST['codepostal'])));
            $pays = htmlspecialchars_decode((trim($_POST['pays'])));
   
            $infos = $this->creerTableauInfosAdresseAModifier($idPersonne,$adresse,$ville,$departement,$codepostal,$pays);
            return $infos;
        }
    }
    private function nombreProblemeSaisieModifAdresse($adresse,$ville,$departement,$codepostal,$pays)
    {
        $validation = new Validations();
        $validation->pbSaisieCodePostal($codepostal);
        $validation->pbVideErreur($adresse); 
        $validation->pbVideErreur($ville); 
        $validation->pbVideErreur($departement); 
        $validation->pbVideErreur($pays); 
        $var = $validation->getErreur();

        return $var;
    }
    private function messageErreurSaisieAdresse($adresse,$ville,$departement,$codepostal,$pays)
    {  
        $validation = new Validations();
        $validation->videErreur($codepostal,"Code Postal"); 
        $validation->formeCodePostalErreur($codepostal);
        $validation->videErreur($adresse,"Adresse"); 
        $validation->videErreur($ville, "Ville"); 
        $validation->videErreur($departement, "Département"); 
        $validation->videErreur($pays, "Pays"); 
    }
    public function verifierEtModifierAdresse()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $infos = $this->infosAdresseAmodifier();
             // On compte les erreurs :
            $erreurSaisie = $this->nombreProblemeSaisieModifAdresse($infos['adresse'],$infos['ville'],$infos['departement'],$infos['codepostal'],$infos['pays']);

            if($erreurSaisie > 0)  
            {
                echo "</br>";
                // pour les validations de saisie utilisateur :

                $this->messageErreurSaisieAdresse($infos['adresse'],$infos['ville'],$infos['departement'],$infos['codepostal'],$infos['pays']);
            

                echo "<p style='color:purple;'>Veuillez corriger...</p>";
                $infos = $this->reafficherAvantModifAdresse();
                return $infos;
            }
            else
            { 
                $this->requete->modifierAdresse($infos['idPersonne'],$infos['adresse'],$infos['ville'],$infos['departement'],$infos['codepostal'],
                $infos['pays']);

                //echo "</br><p><a href=../../index.php>Retour à l'index</a></p>";
                header('Location:votreProfil.php');
                exit();     
            } 
        }    
    }

    public function obtenirInfosDuMembre($id)
    {
        $data = $this->lireUnMembreInstancie($id);
        $infos;   
        foreach ($data as $value)
        {
            $infos = $value;
        }
        return $infos;
    }

    public function obtenirInfosDuMembreAvantModif($idMembre)
    {
        $data = $this->lireUnMembreInstancie($idMembre);
        $infos;   
        foreach ($data as $value)
        {
            $infos = $value;
        }
        return $infos;
    }

    public function afficherTableDuMembre($pseudo)
    {
        //$managerMembre = new ManagerMembre();
        $idMembre = $this->obtenirIdMembreByPseudo($pseudo);
        $infos = $this->obtenirInfosDuMembre($idMembre);
        // var_dump($infos);       
        echo '<table>';
        //echo '  <caption>Les informations actuelles</caption>';
        echo '      <thead>';

        echo '        <th hidden>Id Membre</th>';
        echo '        <th>Nom</th>';
        echo '        <th>Prénom</th>';
        echo '        <th>Pseudo</th>';
        echo '        <th>Date Inscription </th>';
        echo '        <th>Dernière Modification</th> '; 
        echo '        <th>Statut</th> '; 
        echo '        <th>Role</th> '; 
        echo '        <th>Abonnement</th> '; 
                  
        echo '    </thead>';
        echo '<tr>';
        echo '<td hidden>' .$infos['idPersonne']. '</td>';
        echo '<td>' .$infos['nom']. '</td>';
        echo '<td>' .$infos['prenom']. '</td>';
        echo '<td>' .$infos['pseudo']. '</td>';
        echo '<td>' .$infos['dateInscription']. '</td>';
        echo '<td>' .$infos['dateModif']. '</td>';
        echo '<td>' .$infos['statut']. '</td>';
        echo '<td>' .$infos['role']. '</td>';
        echo '<td>' .$infos['typeAbonnement']. '</td>';
        echo '</tr>';
        echo '<table>';    
    }

    /// Fonctions utiles pour l'affichage du tableau de modification du mail :

    public function afficherTabMailModif($pseudo, $idMembre)
    {
        //$idMembre = $this->obtenirIdMembreByPseudo($pseudo);
        $infos = $this->obtenirInfosDuMembre($idMembre);
        // var_dump($infos);       
    

        echo '<table>';
        //echo '  <caption>Les informations actuelles</caption>';
        echo '      <thead>';

        echo '        <th hidden>Id Personne</th>';
        echo '        <th>Email1</th>';                       
        echo '        <th>Editer</th>';
        echo '    </thead>';
        echo '<tr>';
        echo '<td hidden>' .$infos['idPersonne']. '</td>';
        echo '<td>' .$infos['mail1']. '</td>';
        echo '<td style="font-weight:bold;"><a href="modifierMail.php?ref='.$infos['idPersonne'].'&amp;typeMail='."mail1".'">Modifier</a></td>';
        echo '</tr>';
        echo '<table>';
        echo '</br>';
        echo '<table>';
        //echo '  <caption>Les informations actuelles</caption>';
        echo '      <thead>';

        echo '        <th hidden>Id Personne</th>';
        echo '        <th>Email2</th>';                       
        echo '        <th>Editer</th>';
        if($infos['mail2'] !== NULL)
        {
            echo '        <th>Supprimer</th>';
        }
        echo '    </thead>';
        echo '<tr>';
        echo '<td hidden>' .$infos['idPersonne']. '</td>';
        echo '<td>' .$infos['mail2']. '</td>';
        if($infos['mail2'] === NULL)
        {
            echo '<td style="font-weight:bold;"><a href="modifierMail.php?ref='.$infos['idPersonne'].'&amp;typeMail='."mail2".'">Ajouter</a></td>';
        }
        else {
            echo '<td style="font-weight:bold;"><a href="modifierMail.php?ref='.$infos['idPersonne'].'&amp;typeMail='."mail2".'">Modifier</a></td>';
            echo '<td style="font-weight:bold;"><a href="supprimerMail.php?ref='.$infos['idPersonne'].'&amp;typeMail='."mail2".'">Supprimer</a></td>';
        }

        echo '</tr>';
        echo '<table>';
    }

    public function afficherTabAdressModif($pseudo, $idMembre)
    {
        //$idMembre = $this->obtenirIdMembreByPseudo($pseudo);
        $infos = $this->obtenirInfosDuMembre($idMembre);
        // var_dump($infos);       
    

        echo '<table>';
        //echo '  <caption>Les informations actuelles</caption>';
        echo '      <thead>';

        echo '        <th hidden>Id Personne</th>';
        echo '        <th>Adresse</th>';                       
        echo '        <th>Ville</th>';
        echo '        <th>Département</th>';     
        echo '        <th>CodePostal</th>';      
        echo '        <th>Pays</th>';                
        echo '        <th>Action</th>';
        echo '    </thead>';
        echo '<tr>';
        echo '<td hidden>' .$infos['idPersonne']. '</td>';
        echo '<td>' .$infos['adresse']. '</td>';
        echo '<td>' .$infos['ville']. '</td>';
        echo '<td>' .$infos['departement']. '</td>';
        echo '<td>' .$infos['codepostale']. '</td>';
        echo '<td>' .$infos['pays']. '</td>';

        echo '<td style="font-weight:bold;"><a href="modifierAdresse.php?ref='.$infos['idPersonne'].'">Modifier</a></td>';
        echo '</tr>';
        echo '</table>';
    }

    ////////////////////////// page modifierMail.php ///////////////////////////

    public function afficherAvantSubmit()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST" && empty($_POST))
        {
            $idMembre = $_GET['ref'];
            $infos = $this->obtenirInfosDuMembre($idMembre);
            return $infos;
        }
    }

    private function compterErreurSaisiAvantModifMail($mail)
    {
        $validation = new Validations();

        $validation->pbMail($mail,"Mail");
        $var = $validation->getErreur();
        return $var;
    }
    private function afficherErreurSaisiAvantModifMail($mail)
    {
        $validation = new Validations();
        $validation->invalidMail($mail, " mail ");
    }

    private function tableauInfosModifierMail($pseudo, $motpasse, $mail)
    {
        $infos = array(
            'pseudo' =>  $pseudo,
            'motPasseSaisi' => $motpasse,
            'mail' =>  $mail,
            'mail1' =>  $mail, 
            'mail2' =>  $mail   
         );
        return $infos;

    }

    private function obtenirInfosPostModifMail()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            // l'identifiant et pseudo à réafficher :
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudoUpdate'])));

            $motpasse = htmlspecialchars_decode((trim($_POST['actuelPassSaisi'])));

            $mail = htmlentities(trim($_POST['mailUpdate']));
          
            $infos = $this->tableauInfosModifierMail($pseudo, $motpasse, $mail);
           // var_dump($infos );
 
            return $infos;
        }
    }

    private function obtenirMailEtPseudoReaffichageModifMail()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $quelMail= htmlspecialchars_decode((trim($_POST['quelMail'])));
            $pseudo =  htmlspecialchars_decode((trim($_POST['pseudoUpdate'])));
            $motpasse = "";
            $mail = htmlentities(trim($_POST['mailUpdate']));
            $infos = $this->tableauInfosModifierMail($pseudo, $motpasse, $mail);

            return $infos;
        }
    }    

    public function verifExistancePass($passSaisi, $passEncrypt)
    {
        $passOk = password_verify($passSaisi, $passEncrypt);
        if (!$passOk)
        {
            echo "<p>Votre mot de passe actuel est incorrect !</p>";
        }
        return $passOk;
    }
    public function supprimerMail($ref,$quelMail)
    { 
    //     echo $ref;
    //     echo $quelMail;
        $this->requete->supprimerMail($ref,$quelMail);

    }
    public function verifierEtModifierMail()
    { 
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $quelMail=htmlentities(trim($_POST['quelMail']));
            //echo $quelMail;

            $infos = $this->obtenirInfosPostModifMail();//infos contient la saisie utilisateur
            //var_dump($infos);
            $motPasseBdd = $this->requete->obtenirMotPasseByPseudo($infos['pseudo']);
                //var_dump($motPasseBdd);
                //var_dump($infos['motPasseSaisi']);
            // on vérifie si le mot de passe saisi et compatible avec celui encrypté: 
            $motPasseOk = $this->verifExistancePass($infos['motPasseSaisi'], $motPasseBdd);

            //on vérifie le nombre d'erreur :
            $erreur = $this->compterErreurSaisiAvantModifMail($infos['mail']);

            if( ($erreur > 0) | (!$motPasseOk) )
            {
                $this->afficherErreurSaisiAvantModifMail($infos['mail']);
                $infos = $this->obtenirMailEtPseudoReaffichageModifMail();
                return $infos;
            }        
            else 
            {
                $quelMail=htmlentities(trim($_POST['quelMail']));

                // on modifie : modifierMembre($idLogin, $cle, $actif, $mail, $membreId, $idAdmin)
                $this->requete->modifierMail($infos['pseudo'], $infos['mail'],$quelMail);
                // on désactive le compte :
                $this->requete->deactiverMailOk($infos['pseudo']);
                $this->requete->supprimerCle($infos['pseudo']);
                $this->envoyerMailApresModif($infos['pseudo'], $infos['mail']);
                //echo "<p style='color:purple;'>Un mail de confirmation vous a été envoyé à l'adresse : ".$infos['mail']."</p>";
                //echo "<a role='button' href='votreProfil.php' >Retour</a>";
                header('Location:votreProfil.php');
                exit();          
            }
        }
    }

    private function envoyerMailApresModif($pseudo, $destinataire)
    {
        $cle = md5(microtime(TRUE)*100000);

        // Préparation du mail contenant le lien d'activation
        $sujet = "Valider Mail" ;
        $entete = "From: inscription@essai.local" ;
        $message = ''.$pseudo. '

        Vous avez modifié votre adresse mail,

        Votre nouvelle clé est : '.$cle.'
        
        Pour valider votre adresse mail, veuillez cliquer sur le lien ci-dessous
        ou copier/coller dans votre navigateur internet.

        
        http://comgocom.pw/public/pages/activationMail.php?log='.urlencode($pseudo).'&cle='.urlencode($cle).'
        
        
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';
        
        mail($destinataire, $sujet, utf8_decode($message), $entete) ; // Envoi du mail

        $this->requete->insererCle($pseudo, $cle);

    }  

    public function verifierEtActiver()
    {
        // Récupération des variables nécessaires à l'activation
        $pseudo = $_GET['log'];
        $cle = $_GET['cle'];

        // Récupération des informations relatives à l'activation d'un compte dans la base de données
        $mailOk = $this->requete->mailOk($pseudo);
        $cleBdd = $this->requete->obtenirCle($pseudo);
        
        if($mailOk)
        {
            echo "<p>Votre adresse mail a été vérifiée : compte est déjà actif !</p>";
            //echo "</br><p><a href=../../index.php>Retour à l'index</a></p>";
        }
        else
        {
            if($cle == $cleBdd)
            {
                $this->requete->devientMailOk($pseudo);

                echo "<p>Votre compte a bien été activé !</p>";

                //echo "<p><a href=../../index.php>Retour à l'index</a></p>";
            }
            else
            {
                echo "<p>Veuillez tenter d'activer votre compte avec le dernier mail d'activation.</p>";
                echo "<p>Celui contenant la clé : ". $cleBdd  ."</p>";
            }
            // on modifie statut et role de l'utilisateur
            $newIdRole = $this->requete->getIdRoleByTypeRole("user_simple");
            $newIdStatut = $this->requete->getIdStatutByLibelle("membre");
            if($newIdRole && $newIdStatut)
            {
                $this->requete->updateIdRolePersonne($pseudo, $newIdRole);
                $this->requete->updateIdStatutPersonne($pseudo, $newIdStatut);
                $this->requete->devientActif($pseudo);
            }
            else
            {
                echo "<p style='color:purple;'> un problème est survenu en base de donnée lors de l'insertion de votre statut membre.</p>";
            }
        }
    }

    ////////////////////////////  page modifierMotPasse.php /////////////////////////////

    private function tabInfosMotPasse($idMembre, $pseudo, $motPasse, $confirm, $actuelPass)
    {
        $infos = array (
                'idMembre' => $idMembre,
                'pseudo' => $pseudo,
                'actuelMotPasse' => $actuelPass,
                'motPasse' => $motPasse,
                'confirm' => $confirm
         );
         return $infos;
    }

    private function recupererInfosApresSubmitMotPasse()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            // infos non modifiable mais utiles :
            $idMembrePost = htmlspecialchars_decode(trim($_POST['idPersonne']));
            $motPasseActuel = htmlspecialchars_decode(trim($_POST['actuelPassSaisi']));
            $pseudo = htmlspecialchars_decode(trim($_POST['pseudo']));

            // les valeurs modifiables :
            $motPassePost = htmlentities(trim($_POST['motPasseUpdate'])); 
            $confirmPost = htmlentities(trim($_POST['confirmUpdate']));
            $infos = $this->tabInfosMotPasse($idMembrePost, $pseudo, $motPassePost, $confirmPost, $motPasseActuel);
            return $infos;
        }     
    }

    private function nombreProblemeSaisieModifierMotPass($motPasse, $confirmation)
    {
        $validation = new Validations();
        $validation->pbMotPasse($motPasse, 6, 15);
        $validation->pbMotPasse($confirmation, 6, 15);
        $validation->pbDeuxChainesDiff($motPasse, $confirmation);
        $var = $validation->getErreur();
        return $var;
    }

    private function messageErreurSaisieModifierMotPass($motPasse, $confirmation)
    { 
        $validation = new Validations(); 
        $validation->invalidMotPasse($motPasse, " nouveau mot de passe", 6, 15);
        $validation->invalidMotPasse($confirmation, " mot de passe de confirmation", 6, 15);
        $validation->deuxChainesDifferentes($motPasse, $confirmation, "Le mot de passe et sa confirmation ");
    }



    public function infosVidePostModifierMotPasse()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            // infos non modifiable mais utiles :
            $idMembrePost = htmlspecialchars_decode(trim($_POST['idPersonne']));
            $motPasseActuel = "";
            $pseudo = htmlspecialchars_decode(trim($_POST['pseudo']));

            // les valeurs modifiables :
            $motPassePost = ""; 
            $confirmPost = "";
            $infos = $this->tabInfosMotPasse($idMembrePost, $pseudo, $motPassePost, $confirmPost, $motPasseActuel);
            return $infos;
        }
    }

    public function verifierEtModifierMotPasse()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {

            // On récupère les infos du submit :
            $infos = $this->recupererInfosApresSubmitMotPasse();

            // On récupère le mot de passe va être modifié :
            $motPasseBdd = $this->requete->obtenirMotPasseByPseudo($infos['pseudo']);

            // on vérifie si le mot de passe saisi et compatible avec celui encrypté: 
            $motPasseOk = $this->verifExistancePass($infos['actuelMotPasse'], $motPasseBdd);

            // on vérifie le nombre d'erreur :
            $erreur = $this->nombreProblemeSaisieModifierMotPass($infos['motPasse'], $infos['confirm']);
            if( ($erreur > 0) | (!$motPasseOk) )
            {
                $this->messageErreurSaisieModifierMotPass($infos['motPasse'], $infos['confirm']);
                $infos = $this->infosVidePostModifierMotPasse();
                return $infos;
            }        
            else 
            {
                // on hashe le mot de passe :
                $passwordHash = password_hash($infos['motPasse'], PASSWORD_BCRYPT,['cost' => 9]);

                // on modifie : 
                $this->requete->modifierMotPasse($infos['idMembre'], $passwordHash);

                // on retourne à la page précédente :
                // echo "c'est modifier !";
                header('Location:votreProfil.php');
                exit();            
            }
        }
    }


}
