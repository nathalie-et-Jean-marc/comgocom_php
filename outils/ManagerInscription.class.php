<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//require('../../managers/ManagerMembre.class.php');
require '../../dto/RequetesMembre.class.php';
require('Validations.class.php');

class ManagerInscription
{
    private $requete;


    ////////////////  CONSTRUCTEUR /////////////////

    public function __construct()
    {
        //$this->managerMembre = new ManagerMembre();
        $this->requete = new RequetesMembre();
    }


    //////////////  METHODES : page inscription.php /////////////////////

    private function creerTableauInfosInscription($pseudo,$motpasse,$confirm,$mail1,$mail2,$civilite,
    $nom,$prenom,$adresse,$ville,$departement,$codepostal,$pays,$telephone1,$telephone2,$ip)
    {
        $infos = array (
                'pseudo' => $pseudo,
                'motpasse'=> $motpasse,
                'confirm' =>$confirm ,
                'mail1' => $mail1,
                'mail2' => $mail2,
                'civilite' => $civilite,
                'nom' => $nom,
                'prenom' =>$prenom,
                'adresse' => $adresse,
                'ville' => $ville,
                'departement' => $departement,
                'codepostal' => $codepostal,
                'pays' => $pays,
                'telephone1' => $telephone1,
                'telephone2' => $telephone2,
                'ip' => $ip
        );
        return $infos;
    }

    public function afficherAvantInscription()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST" && empty($_POST))
        {
            $pseudo = "";
            $motpasse = "";
            $confirm = "";
            $mail1 = "";
            $mail2 = "";
            $civilite="";
            $nom = "";
            $prenom = "";
            $adresse = "";
            $ville = "";
            $departement = "";
            $codepostal ="";
            $pays="";
            $telephone1="";
            $telephone2="";
            $ip="";
 
            $infos = $this->creerTableauInfosInscription($pseudo,$motpasse,$confirm,$mail1,$mail2,$civilite,
            $nom,$prenom,$adresse,$ville,$departement,$codepostal,$pays,$telephone1,$telephone2,$ip);
            return $infos;
        }    
    }

    public function reafficherAvantInscription()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudo'])));
            $motpasse = ""; 
            $confirm = "";
            $mail1 = htmlspecialchars_decode((trim($_POST['mail1'])));
            $mail2 =  htmlspecialchars_decode((trim($_POST['mail2'])));
            $civilite = htmlspecialchars_decode((trim($_POST['civilite'])));
            $nom = htmlspecialchars_decode((trim($_POST['nom'])));
            $prenom = htmlspecialchars_decode((trim($_POST['prenom'])));
            $adresse = htmlspecialchars_decode((trim($_POST['adresse'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $departement = htmlspecialchars_decode((trim($_POST['departement'])));
            $codepostal = htmlspecialchars_decode((trim($_POST['codepostal'])));
            $pays=htmlspecialchars_decode((trim($_POST['pays'])));
            $telephone1=htmlspecialchars_decode((trim($_POST['telephone1'])));
            $telephone2=htmlspecialchars_decode((trim($_POST['telephone2'])));
            $ip=htmlspecialchars_decode((trim($_POST['ip'])));

            $infos = $this->creerTableauInfosInscription($pseudo,$motpasse,$confirm,$mail1,$mail2,$civilite,
            $nom,$prenom,$adresse,$ville,$departement,$codepostal,$pays,$telephone1,$telephone2,$ip);
            return $infos;        
        }
    }

    private function infosAinscrire()
    {
        // les valeurs du formulaire :
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudo'])));
            $motpasse = htmlspecialchars_decode((trim($_POST['motpasse']))); 
            $confirm = htmlspecialchars_decode((trim($_POST['confirm'])));
            $mail1 = htmlspecialchars_decode((trim($_POST['mail1'])));
            $mail2 = htmlspecialchars_decode((trim($_POST['mail2'])));
            $nom = htmlspecialchars_decode((trim($_POST['nom'])));
            $prenom = htmlspecialchars_decode((trim($_POST['prenom'])));
            $civilite = htmlspecialchars_decode((trim($_POST['civilite'])));   
            $adresse = htmlspecialchars_decode((trim($_POST['adresse'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $departement = htmlspecialchars_decode((trim($_POST['departement'])));
            $codepostal = htmlspecialchars_decode((trim($_POST['codepostal'])));
            $pays = htmlspecialchars_decode((trim($_POST['pays'])));
            $telephone1 = htmlspecialchars_decode((trim($_POST['telephone1'])));
            $telephone2 = htmlspecialchars_decode((trim($_POST['telephone2'])));
            $ip=htmlspecialchars_decode((trim($_POST['ip'])));
            
            $infos = $this->creerTableauInfosInscription($pseudo,$motpasse,$confirm,$mail1,$mail2,$civilite,
            $nom,$prenom,$adresse,$ville,$departement,$codepostal,$pays,$telephone1,$telephone2,$ip);
            return $infos;
        }
    }

    private function nombreProblemeExist($pseudo, $nom, $prenom)
    {
        $erreur = 0;
        $pseudoExist = $this->requete->isPseudoExists($pseudo);// retourne true s'il existe déjà
        /*$membreExist = $this->requete->isMembreExists($nom, $prenom,$numSecu);*/ // TODO créer champ numSecu
        $membreExist = $this->requete->isNomPrenomExist($nom, $prenom);
        if($pseudoExist) // si vrai une erreur de plus 
        {
            $erreur += 1; 
        }
        if($membreExist)
        {
            $erreur += 1;
        }
        return $erreur;
    }

    private function messageErreurSaisieExistInscript($pseudo, $nom, $prenom)
    {
        $pseudoExist = $this->requete->isPseudoExists($pseudo);// retourne true s'il existe déjà
        /*$membreExist = $this->requete->isMembreExists($nom, $prenom);*/ // todo valider identité
        $membreExist = $this->requete->isNomPrenomExist($nom, $prenom);
        if($pseudoExist) // si vrai création du message d'erreur
        {
            echo "<div><p style='color:red'>Ce pseudo existe déjà ! Veuillez en choisir un autre...</p></div>";
        }
        if($membreExist)
        {
            $msg = "<div><p style='color:red;'>Ce membre existe déjà ! ";
            $msg.= "Vous vous êtes déjà inscrit sur ce site. Si vous ne retrouvez pas vos identfiant, ";
            $msg.= "contactez l'administreur du site au lien <a href='contacts.php'>Contacts</a></p></div>";
            echo $msg;
        }
    }
    
    // todo validation $ville,$departement $pays => non vide
    private function nombreProblemeSaisieInscript($pseudo,$motpasse,$confirm,$mail1,$mail2,
    $nom,$prenom,$adresse,$codepostal,$telephone1,$telephone2, $ville,$departement,$pays,$civilite)
    {
        $validation = new Validations();
        $validation->pbVideErreur($nom);
        $validation->pbVideErreur($prenom);
        $validation->pbVideErreur($civilite);

        $validation->pbVideErreur($mail1);
        $validation->pbVideErreur($adresse); 
        $validation->pbVideErreur($ville); 
        $validation->pbVideErreur($departement); 
        $validation->pbVideErreur($pays);
        $validation->pbVideErreur($telephone1);
        $validation->pbVideErreur($motpasse);
        $validation->pbVideErreur($confirm);
        $validation->pbVideErreur($pseudo);

        $validation->pbTailleErreur($motpasse,"Mot de Passe", 6, 15);// contient msg erreur
        $validation->pbTailleErreur($confirm,"Confirmation", 6, 15); // contient msg erreur
        $validation->pbDeuxChainesDiff($motpasse, $confirm);
        $validation->pbTailleErreur($nom,"Nom", 2, 20);
        $validation->pbTailleErreur($prenom,"Prénom", 2, 15);
        $validation->pbMail($mail1,"Email 1");
        $validation->pbMail2($mail1,$mail2,"Email 1","Email 2");
        $validation->pbSaisieCodePostal($codepostal); 
        $validation->pbTelephone2($telephone1,$telephone2,"Téléphone 1","Téléphone 2");

        $var = $validation->getErreur();
       
        // echo " nb pb : ";
        // echo $var;
        return $var;
    }

    private function messageErreurSaisieInscript($pseudo,$motpasse,$confirm,$mail1,$mail2,
    $nom,$prenom,$adresse,$codepostal,$telephone1,$telephone2,$ville,$departement,$pays,$civilite)
    {  
        $validation = new Validations();
        $validation->deuxChainesDifferentes($motpasse, $confirm, "Le mot de passe et sa confirmation ");
         $validation->videErreur($nom,"Nom");
         $validation->videErreur($prenom, "Prénom");
         $validation->videErreur($civilite,"Civilité");
        $validation->videErreur($mail1,"Mail 1");
        $validation->videErreur($adresse, "Adresse"); 
        $validation->videErreur($ville, "Ville"); 
        $validation->videErreur($departement, "Département"); 
        $validation->videErreur($pays, "Pays");
        $validation->videErreur($telephone1, "Téléphone 1");
        $validation->videErreur($motpasse, "Mot de passe");
        $validation->videErreur($confirm, "Confirmation");
         $validation->videErreur($pseudo, "pseudo");

        $validation->invalidChaine($nom, " nom ", 2, 20);
        $validation->invalidChaine($prenom, " prénom ", 2, 15);
        $validation->mauvaiseSaisieTelephone($telephone1,"Téléphone 1");
        $validation->formeCodePostalErreur($codepostal);

    }

    private function envoyerMailConfirmation($pseudo, $destinataire, $prenom, $nom, $motpasse)
    {
        $cle = md5(microtime(TRUE)*100000);

        // Préparation du mail contenant le lien d'activation
        $sujet = "Activer votre compte" ;
        $entete = "From: inscription@essai.local" ;
        $message = 'Bienvenue '.$prenom. ' '.$nom.',

        Votre pseudonyme est '.$pseudo.'.

        Votre mot de passe est '.$motpasse.'.

        Votre cle est : '.$cle.'
        
        Pour activer votre compte, veuillez cliquer sur le lien ci dessous
        ou copier/coller dans votre navigateur internet.
        
        http://comgocom.pw/public/pages/activationMail.php?log='.urlencode($pseudo).'&cle='.urlencode($cle).'
        
        
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';
        
        mail($destinataire, $sujet, utf8_decode($message), $entete) ; // Envoi du mail
       
        $this->requete->insererCle($pseudo, $cle);
    }

    public function verifierEtinscrire()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $infos = $this->infosAinscrire();
             // On compte les erreurs :
            $erreurSaisie = $this->nombreProblemeSaisieInscript($infos['pseudo'],$infos['motpasse'],$infos['confirm'],$infos['mail1'],$infos['mail2'],
            $infos['nom'],$infos['prenom'],$infos['adresse'],$infos['codepostal'],$infos['telephone1'],$infos['telephone2'],$infos['ville'],$infos['departement'],$infos['pays'],$infos['civilite']);

            //var_dump($erreurSaisie);
            $erreurSaisieExist = $this->nombreProblemeExist($infos['pseudo'], $infos['nom'], $infos['prenom']);
            $totalErreur = $erreurSaisie + $erreurSaisieExist;

            if($totalErreur > 0)  
            {
                echo "</br>";
                // pour les validations de saisie utilisateur :

                $this->messageErreurSaisieInscript($infos['pseudo'], $infos['motpasse'], $infos['confirm'], 
                                                $infos['mail1'], $infos['mail2'], $infos['nom'],
                                                $infos['prenom'], $infos['adresse'], $infos['codepostal'], 
                                                $infos['telephone1'], $infos['telephone2'],$infos['ville'],$infos['departement'],$infos['pays'],$infos['civilite']);

                $this->messageErreurSaisieExistInscript($infos['pseudo'], $infos['nom'], $infos['prenom']);
                echo "<p style='color:purple;'>Veuillez corriger...</p>";
                $infos = $this->reafficherAvantInscription();
                return $infos;
            }
            else
            { 
                // On hashe le mot de passe avec la fonction php 
                $passwordHash = password_hash($infos['motpasse'], PASSWORD_BCRYPT,['cost' => 9]);
    
                // on enregistre le nouveau mot de passe encrypté :
 
                $reqInsertOk = $this->requete->insertMembreSimple($infos['pseudo'],$passwordHash,$infos['mail1'],$infos['mail2'],
                $infos['nom'],$infos['prenom'],$infos['adresse'],$infos['ville'],$infos['departement'],$infos['codepostal'],
                $infos['pays'],$infos['telephone1'],$infos['telephone2'],$infos['ip']);
                // on envoie un mail de confirmation :
                $this->envoyerMailConfirmation($infos['pseudo'], $infos['mail1'], 
                                               $infos['prenom'], $infos['nom'], $infos['motpasse']);

                if($reqInsertOk)
                {
                    echo "<p style='color:purple;'>Un mail de confirmation vous a été envoyé à l'adresse : ".$infos['mail1']."</p>";
                }
                else
                {
                    echo "<p style='color:purple;'>Désolé, un problème est survenue, veuillez essayer de vous inscrire ultérieurement.</p>";
                }
                
                echo "</br><p><a href=../../index.php>Retour à l'index</a></p>";
                
                exit();     
            } 
        }    
    }

    //////////////  METHODE : page activation.php /////////////////////

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
        }
    }

}
