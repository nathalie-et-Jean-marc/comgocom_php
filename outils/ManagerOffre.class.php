<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//require('../../managers/ManagerMembre.class.php');
include_once '../../dto/RequetesMembre.class.php';
include_once '../../classes/Membre.class.php';
include_once '../../classes/Offre.class.php';
include_once 'ManagerMembre.class.php';
include_once 'Validations.class.php';

class ManagerOffre
{
    private $requete;
    private $managerMembre;

    public function __construct()
    {
        //$this->managerMembre = new ManagerMembre();
        $this->requete = new RequetesMembre();
        $this->managerMembre = new ManagerMembre();
    }


    ///////////////////////////  Fonctions utiles pour inserer un service proposé              ////////////////
    //////////////////////////   Pages : ajouterSonService.php et formulaireAjouterService.php ////////////////


    public function infoAvantInsertServicePropose($idMembre)
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST")
        {
            $infosMembre = $this->managerMembre->lireUnMembreInstancie($idMembre);
            $idPersonne = $this->requete->obtenirIdPersonneByIdMembre($idMembre);
            $infosService = array (
                    'idMembre' => $infosMembre[0]['idMembre'],
                    'pseudo' => $infosMembre[0]['pseudo'],
                    'prenom' => $infosMembre[0]['prenom'],
                    'nom' => $infosMembre[0]['nom'],
                    'idPersonne' => $idPersonne,
                    'typeOffre' => "P",
                    'dpt' =>"",
                    'lieu' => "",
                    'ville' => "",
                    'tagListe' => "",
                    'tagIn' => "",
                    'prix' => "",
                    'description' => '',
                    'typePrix' => "",
                    'password' => ""
             );
            return $infosService;
        }        
    }

    public function infoAvantInsertDemande($idMembre)
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST")
        {
            $infosMembre = $this->managerMembre->lireUnMembreInstancie($idMembre);
            $idPersonne = $this->requete->obtenirIdPersonneByIdMembre($idMembre);
            $infosService = array (
                    'idMembre' => $infosMembre[0]['idMembre'],
                    'pseudo' => $infosMembre[0]['pseudo'],
                    'prenom' => $infosMembre[0]['prenom'],
                    'nom' => $infosMembre[0]['nom'],
                    'idPersonne' => $idPersonne,
                    'typeOffre' => "D",
                    'dpt' =>"",
                    'lieu' => "",
                    'ville' => "",
                    'tagListe' => "",
                    'tagIn' => "",
                    'description' => '',
                    'password' => ""
             );
            return $infosService;
        }        
    }

    public function obtenirTags()
    {
        $this->requete->obtenirTags();
    } 

    private function creerCodeOffre($car)
    {
        $string = "";
        $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        srand((double)microtime()*1000000);
        for($i=0; $i<$car; $i++) {
        $string .= $chaine[rand()%strlen($chaine)];
        }
        return strtoupper($string);        
    }

    private function tableauInfosService($idMembre, $pseudo, $prenom, $nom, $idPersonne,$typeOffre,
        $dpt, $lieu, $ville, $creerOuChoisi, $tag, $tagListe, $tagIn,
        $description, $prix, $typePrix, $codeOffre, $password)
    {
            $infosService = array (
                    'idMembre' => $idMembre,
                    'pseudo' => $pseudo,
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'idPersonne' => $idPersonne,
                    'typeOffre' => $typeOffre,
                    'dpt' => $dpt,
                    'lieu' => $lieu,
                    'ville' => $ville,
                    'creerOuChoisi' => $creerOuChoisi,
                    'tag' => $tag,
                    'tagListe' => $tagListe,
                    'tagIn' => $tagIn,
                    'description' => $description,
                    'prix' => $prix,
                    'typePrix' => $typePrix,
                    'codeOffre' => $codeOffre,
                    'password' => $password
                );
            return $infosService;
    }

    private function infosServiceProposeAffichable($idM)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $idMembre = htmlspecialchars_decode((trim($_POST['idMembre'])));
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudo'])));
            $prenom = htmlspecialchars_decode((trim($_POST['prenom'])));
            $nom = htmlspecialchars_decode((trim($_POST['nom'])));
            
            $idPersonne = htmlspecialchars_decode((trim($_POST['idPersonne'])));
            $typeOffre = htmlspecialchars_decode((trim($_POST['typeOffre'])));
            $dpt = htmlspecialchars_decode((trim($_POST['dpt'])));
            $lieu = htmlspecialchars_decode((trim($_POST['lieu'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $creerOuChoisi = htmlspecialchars_decode((trim($_POST['creerOuChoisi'])));
            $tagListe = htmlspecialchars_decode((trim($_POST['tagListe'])));// on a idTag
            $tagIn =  htmlspecialchars_decode((trim($_POST['tagInput'])));// tag créé : faut récup idtag
            $description = htmlspecialchars_decode((trim($_POST['description'])));
            $prix = htmlspecialchars_decode((trim($_POST['prix'])));
            $typePrix = htmlspecialchars_decode((trim($_POST['typePrix'])));
            $password = "";

            // pour valider les tags !"
            $tag=""; 
            if ($creerOuChoisi == 'cree')
            {
                $tag = (string)$tagIn;
            }
            else if ($creerOuChoisi == 'choisi')
            {
                $tag = (int)$tagListe;
            }

            $codeOffre = $this->creerCodeOffre(10); // crée un code unique et aléatoire à 10 chiffres

            $infosService = $this->tableauInfosService($idMembre, $pseudo, $prenom, $nom, $idPersonne,$typeOffre,
                                                        $dpt, $lieu, $ville, $creerOuChoisi, $tag, $tagListe, $tagIn,
                                                        $description, $prix, $typePrix, $codeOffre, $password);
             return $infosService;
        }

    }

    private function infosServiceProposePourInsert($idM) // public pour tests, à mettre en private après
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $idMembre = htmlspecialchars_decode((trim($_POST['idMembre'])));
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudo'])));
            $prenom = htmlspecialchars_decode((trim($_POST['prenom'])));
            $nom = htmlspecialchars_decode((trim($_POST['nom'])));
            
            $idPersonne = htmlspecialchars_decode((trim($_POST['idPersonne'])));
            $typeOffre = htmlspecialchars_decode((trim($_POST['typeOffre'])));
            $dpt = htmlspecialchars_decode((trim($_POST['dpt'])));
            $lieu = htmlspecialchars_decode((trim($_POST['lieu'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $creerOuChoisi = htmlspecialchars_decode((trim($_POST['creerOuChoisi'])));
            $tagListe = htmlspecialchars_decode((trim($_POST['tagListe'])));// on a idTag
            $tagIn =  htmlspecialchars_decode((trim($_POST['tagInput'])));// tag créé : faut récup idtag
            $description = htmlspecialchars_decode((trim($_POST['description'])));
            $prix = htmlspecialchars_decode((trim($_POST['prix'])));
            $typePrix = htmlspecialchars_decode((trim($_POST['typePrix'])));
            $password = htmlspecialchars_decode((trim($_POST['password'])));

            // pour valider les tags !"
            $tag=""; 
            if ($creerOuChoisi == 'cree')
            {
                $tag = (string)$tagIn;
            }
            else if ($creerOuChoisi == 'choisi')
            {
                $tag = (int)$tagListe;
            }

            $codeOffre = $this->creerCodeOffre(10); // crée un code unique et aléatoire à 10 chiffres

            $infosService = $this->tableauInfosService($idMembre, $pseudo, $prenom, $nom, $idPersonne,$typeOffre,
                                                        $dpt, $lieu, $ville, $creerOuChoisi, $tag, $tagListe, $tagIn,
                                                        $description, $prix, $typePrix, $codeOffre, $password);
             return $infosService;
        }
    }


    private function tableauInfosDemande($idMembre, $pseudo, $prenom, $nom, $idPersonne,$typeOffre,
        $dpt, $lieu, $ville, $creerOuChoisi, $tag, $tagListe, $tagIn,
        $description,$codeOffre, $password)
    {
            $infosService = array (
                    'idMembre' => $idMembre,
                    'pseudo' => $pseudo,
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'idPersonne' => $idPersonne,
                    'typeOffre' => $typeOffre,
                    'dpt' => $dpt,
                    'lieu' => $lieu,
                    'ville' => $ville,
                    'creerOuChoisi' => $creerOuChoisi,
                    'tag' => $tag,
                    'tagListe' => $tagListe,
                    'tagIn' => $tagIn,
                    'description' => $description,
                    'codeOffre' => $codeOffre,
                    'password' => $password
                );
            return $infosService;
    }

    private function infosDemandeAffichable($idM)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $idMembre = htmlspecialchars_decode((trim($_POST['idMembre'])));
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudo'])));
            $prenom = htmlspecialchars_decode((trim($_POST['prenom'])));
            $nom = htmlspecialchars_decode((trim($_POST['nom'])));
            
            $idPersonne = htmlspecialchars_decode((trim($_POST['idPersonne'])));
            $typeOffre = htmlspecialchars_decode((trim($_POST['typeOffre'])));
            $dpt = htmlspecialchars_decode((trim($_POST['dpt'])));
            $lieu = htmlspecialchars_decode((trim($_POST['lieu'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $creerOuChoisi = htmlspecialchars_decode((trim($_POST['creerOuChoisi'])));
            $tagListe = htmlspecialchars_decode((trim($_POST['tagListe'])));// on a idTag
            $tagIn =  htmlspecialchars_decode((trim($_POST['tagInput'])));// tag créé : faut récup idtag
            $description = htmlspecialchars_decode((trim($_POST['description'])));

            $password = "";

            // pour valider les tags !"
            $tag=""; 
            if ($creerOuChoisi == 'cree')
            {
                $tag = (string)$tagIn;
            }
            else if ($creerOuChoisi == 'choisi')
            {
                $tag = (int)$tagListe;
            }

            $codeOffre = $this->creerCodeOffre(5); // crée un code unique et aléatoire à 5 chiffres

            $infosService = $this->tableauInfosDemande($idMembre, $pseudo, $prenom, $nom, $idPersonne,$typeOffre,
                                                        $dpt, $lieu, $ville, $creerOuChoisi, $tag, $tagListe, $tagIn,
                                                        $description,$codeOffre, $password);
            return $infosService;
        }

    }


    private function infosDemandePourInsert($idM) // public pour tests, à mettre en private après
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $idMembre = htmlspecialchars_decode((trim($_POST['idMembre'])));
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudo'])));
            $prenom = htmlspecialchars_decode((trim($_POST['prenom'])));
            $nom = htmlspecialchars_decode((trim($_POST['nom'])));
            
            $idPersonne = htmlspecialchars_decode((trim($_POST['idPersonne'])));
            $typeOffre = htmlspecialchars_decode((trim($_POST['typeOffre'])));
            $dpt = htmlspecialchars_decode((trim($_POST['dpt'])));
            $lieu = htmlspecialchars_decode((trim($_POST['lieu'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $creerOuChoisi = htmlspecialchars_decode((trim($_POST['creerOuChoisi'])));
            $tagListe = htmlspecialchars_decode((trim($_POST['tagListe'])));// on a idTag
            $tagIn =  htmlspecialchars_decode((trim($_POST['tagInput'])));// tag créé : faut récup idtag
            $description = htmlspecialchars_decode((trim($_POST['description'])));

            $password = htmlspecialchars_decode((trim($_POST['password'])));

            // pour valider les tags !"
            $tag=""; 
            if ($creerOuChoisi == 'cree')
            {
                $tag = (string)$tagIn;
            }
            else if ($creerOuChoisi == 'choisi')
            {
                $tag = (int)$tagListe;
            }

            $codeOffre = $this->creerCodeOffre(5); // crée un code unique et aléatoire à 5 chiffres

            $infosService = array (
                    'idMembre' => $idMembre,
                    'pseudo' => $pseudo,
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'idPersonne' => $idPersonne,
                    'typeOffre' => $typeOffre,
                    'dpt' => $dpt,
                    'lieu' => $lieu,
                    'ville' => $ville,
                    'creerOuChoisi' => $creerOuChoisi,
                    'tag' =>$tag,
                    'tagListe' =>$tagListe,
                    'tagIn' => $tagIn,
                    'description' => $description,
                    'codeOffre' => $codeOffre,
                    'password' => $password
                );
            return $infosService;
        }
    }

    public function verifierEtInsertOffreService($idMembre)
    {
        $infosService = $this->infosServiceProposePourInsert($idMembre);
        // on vérifie que le mot de passe est connu
        $passEncrypt = $this->requete->obtenirMotPasseByPseudo($infosService['pseudo']);
        $motPasseOk = $this->managerMembre->verifExistancePass($infosService['password'], $passEncrypt);

      
        // on compte le nombre d'erreur de saisie :
        $nbErreur = $this->nbPbSaisiOffre($infosService['creerOuChoisi'],$infosService['tagListe'], 
                                            $infosService['tagIn'], $infosService['description'], 
                                            $infosService['dpt'], $infosService['ville'], 
                                            $infosService['lieu'], (float)$infosService['prix'], 
                                            $infosService['typePrix']);
       // var_dump($nbErreur);
        
        if( ($nbErreur > 0) | (!$motPasseOk) )
        { 

            $this->msgInvalidSaisiOffre($infosService['creerOuChoisi'],$infosService['tag'], 
                                          $infosService['tagListe'], $infosService['tagIn'],
                                          $infosService['description'], $infosService['dpt'], $infosService['ville'], 
                                          $infosService['lieu'], $infosService['typeOffre'], 
                                          (float)$infosService['prix'], $infosService['typePrix']);
            $infosService = $this->infosServiceProposeAffichable($idMembre);
            //var_dump($infosService );
            return $infosService;
        }
        else
        {
            $idTag = $this->trouverIdTagApresPost($idMembre, $infosService['tagIn'], $infosService['tagListe']);
            $this->requete->insertOffreService($infosService['codeOffre'],  
                                      $infosService['idPersonne'],$idTag, 
                                      $infosService['description'], $infosService['dpt'], 
                                      $infosService['ville'], $infosService['lieu'], 
                                      $infosService['typeOffre'], (float)$infosService['prix'], 
                                      $infosService['typePrix']);
            echo "<h2>offre insérée avec succès !</h2>";
            
         //   echo '<script type="text/javascript">
         //           $( function() {
         //               $( "#dialog-message" ).dialog({
         //                   dialogClass: "no-close",
         //                   resizable: false,
         //                   height: "auto",
         //                   width: 500,
         //                   modal: true,
         //                   buttons: {
         //                       "Ajouter un autre service": function() {
         //                           $( this ).dialog( "close" );
         //                           window.location.href = "ajouterSonService.php";
         //                       },
         //                       "Retour à l\'Acceuil": function() {
         //                           $( this ).dialog( "close" );
         //                           window.location.href = "../../index.php";
         //                       }
         //                   },
         //                   open: function(event,ui) {
         //                       $(this).parent().focus();
         //                   }
         //               });
         //           } );               

         //          // window.location.href = "ajouterSonService.php";
         //         </script> ';
         //   echo '
         //           <div class="ui-button.blueButton" id="dialog-message" title="Enregistrement d\'un service">
         //           <p style="color:blue;">
         //               <span class="ui-icon ui-icon-circle-check" style="float:left; margin:10px 7px 50px 0;"></span>
         //               Votre prosition de service a été enregistrée avec succès.
         //           </p>
         //           <p style="color:blue;">
         //               <b>À bientôt !</b>
         //           </p>
         //           </div> ';
			header('Location:ajouterSonService.php');
            exit(); 
        }
    }

    public function verifierEtInsertDemande($idMembre)
    {
        $infosService = $this->infosDemandePourInsert($idMembre);
        // on vérifie que le mot de passe est connu
        $passEncrypt = $this->requete->obtenirMotPasseByPseudo($infosService['pseudo']);
        $motPasseOk = $this->managerMembre->verifExistancePass($infosService['password'], $passEncrypt);

      
        // on compte le nombre d'erreur de saisie :
        $nbErreur = $this->nbPbSaisiDemande($infosService['creerOuChoisi'],$infosService['tagListe'], 
                                            $infosService['tagIn'], $infosService['description'], 
                                            $infosService['dpt'], $infosService['ville'], 
                                            $infosService['lieu']);
       // var_dump($nbErreur);
        
        if( ($nbErreur > 0) | (!$motPasseOk) )
        { 

            $this->msgInvalidSaisiDemande($infosService['creerOuChoisi'],$infosService['tag'], 
                                          $infosService['tagListe'], $infosService['tagIn'],
                                          $infosService['description'], $infosService['dpt'], $infosService['ville'], 
                                          $infosService['lieu'], $infosService['typeOffre']);
            $infosService = $this->infosDemandeAffichable($idMembre);
            return $infosService;
        }
        else
        {
            $idTag = $this->trouverIdTagApresPost($idMembre, $infosService['tagIn'], $infosService['tagListe']);

            $this->requete->insertDemande($infosService['codeOffre'],  
                                            $infosService['idPersonne'],$idTag, 
                                            $infosService['description'], $infosService['dpt'], 
                                            $infosService['ville'], $infosService['lieu'], 
                                            $infosService['typeOffre']);
           // echo "<h2>offre insérée avec succès !</h2>";
            
         //   echo '<script type="text/javascript">
         //           $( function() {
         //               $( "#dialog-message" ).dialog({
         //                   dialogClass: "no-close",
         //                   resizable: false,
         //                   height: "auto",
         //                   width: 500,
         //                   modal: true,
         //                   buttons: {
         //                       "Ajouter un autre service": function() {
         //                           $( this ).dialog( "close" );
         //                           window.location.href = "ajouterSaDemande.php";
         //                       },
         //                       "Retour à l\'Acceuil": function() {
         //                           $( this ).dialog( "close" );
         //                           window.location.href = "../../index.php";
         //                       }
         //                   },
         //                   open: function(event,ui) {
         //                       $(this).parent().focus();
         //                   }
         //               });
         //           } );               

         //          // window.location.href = "ajouterSonService.php";
         //         </script> ';
         //   echo '
         //           <div class="ui-button.blueButton" id="dialog-message" title="Enregistrement d\'un service">
         //           <p style="color:blue;">
         //               <span class="ui-icon ui-icon-circle-check" style="float:left; margin:10px 7px 50px 0;"></span>
         //               Votre prosition de service a été enregistrée avec succès.
         //           </p>
         //           <p style="color:blue;">
         //               <b>À bientôt !</b>
         //           </p>
         //           </div> ';
			header('Location:ajouterSaDemande.php');
            exit(); 
        }
    }


    private function nbPbSaisiOffre($creerOuChoisi, $tagListe, $tagIn, $description, $dpt, $ville, 
                                    $lieu, $prix, $typePrix)
    {
        $validation = new Validations();
		
        $validation->pbVideErreur($dpt);
        $validation->pbVideErreur($ville);
        if( $creerOuChoisi == "cree")
        {
            $validation->pbVideErreur($tagIn);
        }
        else if( $creerOuChoisi == "choisi")
        {
            $validation->pbListeVide($tagListe);
        }
        $validation->pbDescription($description, 10, 500);
        $validation->pbVideErreur($lieu);
	    $validation->pbErreurPrix($prix);
        $validation->pbVideErreur($typePrix);

        $var = $validation->getErreur();
        return $var;
    }

    private function nbPbSaisiDemande($creerOuChoisi, $tagListe, $tagIn, $description, $dpt, $ville, 
                                    $lieu)
    {
        $validation = new Validations();
		
        $validation->pbVideErreur($dpt);
        $validation->pbVideErreur($ville);
        if( $creerOuChoisi == "cree")
        {
            $validation->pbVideErreur($tagIn);
        }
        else if( $creerOuChoisi == "choisi")
        {
            $validation->pbListeVide($tagListe);
        }
        $validation->pbDescription($description, 10, 500);
        $validation->pbVideErreur($lieu);

        $var = $validation->getErreur();
        return $var;
    }

    private function msgInvalidSaisiOffre($creerOuChoisi, $tag, $tagListe, $tagIn, $description, $dpt, $ville, 
                                                  $lieu, $typeOffre, $prix, $typePrix)
    {
        $validation = new Validations();

        $validation->invalidChaine($dpt,"'Département'", 3, 25);
        $validation->invalidChaine($ville,"'Ville'", 3, 25);		
        $validation->videErreurCheck($creerOuChoisi,"créer", "sélectionner");
        if (!empty($creerOuChoisi)) 
        {
            $type = gettype($tag);
            if ($type == "string")
            {
                $validation->invalidChaine($tag,"'Créer un tag' ", 3, 30);
            }
            else if ($type == "integer" && $tag == 0)
            {
                $validation->messageListeVide($tag," des tags ", 3, 30);
            }
        }       
        $validation->invalidDescription($description, "'Description'", 10, 500);
        $validation->videErreur($lieu,"Lieu élargi");
		$validation->videErreur($typeOffre,"");
		$validation->msgErreurPrix($prix,"'Montant'");
        $validation->videErreur($typePrix,"");
    }

    private function msgInvalidSaisiDemande($creerOuChoisi, $tag, $tagListe, $tagIn, $description, $dpt, $ville, 
                                                  $lieu, $typeOffre)
    {
        $validation = new Validations();

        $validation->invalidChaine($dpt,"'Département'", 3, 25);
        $validation->invalidChaine($ville,"'Ville'", 3, 25);		
        $validation->videErreurCheck($creerOuChoisi,"créer", "sélectionner");
        if (!empty($creerOuChoisi)) 
        {
            $type = gettype($tag);
            if ($type == "string")
            {
                $validation->invalidChaine($tag,"'Créer un tag' ", 3, 30);
            }
            else if ($type == "integer" && $tag == 0)
            {
                $validation->messageListeVide($tag," des tags ", 3, 30);
            }
        }       
        $validation->invalidDescription($description, "'Description'", 10, 500);
        $validation->videErreur($lieu,"Lieu élargi");
		$validation->videErreur($typeOffre,"");
    }


    private function trouverIdTagApresPost($idMembre, $tagCreer, $idTagListe)
    {
        $idTag = 0;
        
        if ($idTagListe != '')
        {
            $idTag = (int)$idTagListe;
        }
        else if ($tagCreer != '')
        {
            $idTag = $this->requete->insertTag($tagCreer);// l'insertion retourne lastInsertId
        }
        return $idTag;
    }

    /////////////////////   Lire tous les services proposés: page servicesProposes.php   ///////////////////////////

    public function nombreTotalService()
    {
        $nb = $this->requete->nombreTotalService();
        return $nb;        
    }

    public function nombreTotalDemande()
    {
        $nb = $this->requete->nombreTotalDemande();
        return $nb;        
    }

    private function instancierServices()
    {
        $retour = $this->requete->obtenirServices();
        while ($data = $retour->fetch(PDO::FETCH_ASSOC))
        {
            $services[] = new Offre($data);
        }
        return $services;
    }

    private function instancierDemande()
    {
        $retour = $this->requete->obtenirDemande();
        while ($data = $retour->fetch(PDO::FETCH_ASSOC))
        {
            $services[] = new Offre($data);
        }
        return $services;
    }

    public function lireInfosServices()
    {
        $tabInfosServices = $this->instancierServices();
        foreach ( $tabInfosServices as $offre )
        {
            $offre_id = $offre->getOffre_id();
            $codeOffre =  $offre->getCodeOffre();
            //$cle =  $offre->getCle();
            $idPersonne =  $offre->getIdPersonne();
            $idTag =  $offre->getIdTag();
            $descriptionOffre =  $offre->getDescriptionOffre();
            $dateOuverture =  $offre->getDateOuverture();
            $dpt =  $offre->getDpt();
            $ville =  $offre->getVille();
            $lieuElargi =  $offre->getLieuElargi();
            $prix =  $offre->getPrix();
            $typePrix =  $offre->getTypePrix();

            $ind = $this->requete->obtenirIndividuServicesByIdOffre($idPersonne);
            $nomTags = $this->requete->obtenirNomTag($idTag);
            $individu = "".$ind['prenom']." ".$ind['nom']."";
            $pseudo = "".$ind['pseudo']."";

            $infos[] = array (
                'offre_id' => $offre_id,
                'codeOffre' => $codeOffre,
                //'cle' => $cle,
                'idPersonne' => $idPersonne,
                'idTag' => $idTag,
                'descriptionOffre' => $descriptionOffre,
                'dateOuverture' => $dateOuverture,
                'dpt' => $dpt,
                'ville' => $ville,
                'lieuElargi' => $lieuElargi,
                'prix' => $prix,
                'typePrix' => $typePrix,
                'tag'=>$nomTags,
                'pseudo'=>$pseudo,
                'individu'=>$individu,                
            );                 
            
        }
        return $infos;
    }

    public function lireInfosDemande()
    {
        $tabInfosServices = $this->instancierDemande();
        foreach ( $tabInfosServices as $offre )
        {
            $offre_id = $offre->getOffre_id();
            $codeOffre =  $offre->getCodeOffre();
            //$cle =  $offre->getCle();
            $idPersonne =  $offre->getIdPersonne();
            $idTag =  $offre->getIdTag();
            $descriptionOffre =  $offre->getDescriptionOffre();
            $dateOuverture =  $offre->getDateOuverture();
            $dpt =  $offre->getDpt();
            $ville =  $offre->getVille();
            $lieuElargi =  $offre->getLieuElargi();
            $prix =  $offre->getPrix();
            $typePrix =  $offre->getTypePrix();

            $ind = $this->requete->obtenirIndividuServicesByIdOffre($idPersonne);
            $nomTags = $this->requete->obtenirNomTag($idTag);
            $individu = "".$ind['prenom']." ".$ind['nom']."";
            $pseudo = "".$ind['pseudo']."";

            $infos[] = array (
                'offre_id' => $offre_id,
                'codeOffre' => $codeOffre,
                //'cle' => $cle,
                'idPersonne' => $idPersonne,
                'idTag' => $idTag,
                'descriptionOffre' => $descriptionOffre,
                'dateOuverture' => $dateOuverture,
                'dpt' => $dpt,
                'ville' => $ville,
                'lieuElargi' => $lieuElargi,
                'tag'=>$nomTags,
                'pseudo'=>$pseudo,
                'individu'=>$individu,                
            );                 
            
        }
        return $infos;
    }

    /// lire un service

    private function instancierUnService($idOffre)
    {
        $retour = $this->requete->obtenirUnServiceByIdOffre($idOffre);
        while ($data = $retour->fetch(PDO::FETCH_ASSOC))
        {
            $service[] = new Offre($data);
        }
        return $service;        
    }

    private function instancierUneDemande($idOffre)
    {
        $retour = $this->requete->obtenirUneDemandeByIdOffre($idOffre);
        while ($data = $retour->fetch(PDO::FETCH_ASSOC))
        {
            $service[] = new Offre($data);
        }
        return $service;        
    }

    public function lireUnService($idOffre)
    {
        $tabInfosService = $this->instancierUnService($idOffre);
        foreach ( $tabInfosService as $offre )
        {
            $offre_id = $offre->getOffre_id();
            $codeOffre =  $offre->getCodeOffre();
            //$cle =  $offre->getCle();
            $idPersonne =  $offre->getIdPersonne();
            $idTag =  $offre->getIdTag();
            $descriptionOffre =  $offre->getDescriptionOffre();
            $dateOuverture =  $offre->getDateOuverture();
            $dpt =  $offre->getDpt();
            $ville =  $offre->getVille();
            $lieuElargi =  $offre->getLieuElargi();
            $prix =  $offre->getPrix();
            $typePrix =  $offre->getTypePrix();

            $ind = $this->requete->obtenirIndividuServicesByIdOffre($idPersonne);
            $nomTags = $this->requete->obtenirNomTag($idTag);
            $individu = "".$ind['prenom']." ".$ind['nom']."";
            $pseudo = "".$ind['pseudo']."";


            $infos[] = array (
                'offre_id' => $offre_id,
                'codeOffre' => $codeOffre,
                //'cle' => $cle,
                'idPersonne' => $idPersonne,
                'idTag' => $idTag,
                'descriptionOffre' => $descriptionOffre,
                'dateOuverture' => $dateOuverture,
                'dpt' => $dpt,
                'ville' => $ville,
                'lieuElargi' => $lieuElargi,
                'prix' => $prix,
                'typePrix' => $typePrix,
                'tag'=>$nomTags,
                'pseudo'=>$pseudo,
                'individu'=>$individu                
            );                 
            
        }
        return $infos;
    }

    public function lireUneDemande($idOffre)
    {
        $tabInfosService = $this->instancierUneDemande($idOffre);
        foreach ( $tabInfosService as $offre )
        {
            $offre_id = $offre->getOffre_id();
            $codeOffre =  $offre->getCodeOffre();
            //$cle =  $offre->getCle();
            $idPersonne =  $offre->getIdPersonne();
            $idTag =  $offre->getIdTag();
            $descriptionOffre =  $offre->getDescriptionOffre();
            $dateOuverture =  $offre->getDateOuverture();
            $dpt =  $offre->getDpt();
            $ville =  $offre->getVille();
            $lieuElargi =  $offre->getLieuElargi();
            $ind = $this->requete->obtenirIndividuServicesByIdOffre($idPersonne);
            $nomTags = $this->requete->obtenirNomTag($idTag);
            $individu = "".$ind['prenom']." ".$ind['nom']."";
            $pseudo = "".$ind['pseudo']."";


            $infos[] = array (
                'offre_id' => $offre_id,
                'codeOffre' => $codeOffre,
                //'cle' => $cle,
                'idPersonne' => $idPersonne,
                'idTag' => $idTag,
                'descriptionOffre' => $descriptionOffre,
                'dateOuverture' => $dateOuverture,
                'dpt' => $dpt,
                'ville' => $ville,
                'lieuElargi' => $lieuElargi,
                'tag'=>$nomTags,
                'pseudo'=>$pseudo,
                'individu'=>$individu                
            );                 
            
        }
        return $infos;
    }

    /////////////////   Lire tous les services proposés d'une personne : page gererSonCompte.php   ////////////////////////

    public function nombreOffrePseudo($pseudo)
    {
        $nbOffre = $this->requete->nombreOffrePseudo($pseudo);
        return $nbOffre;
    }

    private function instancierServicesPseudo($pseudo)
    {
        $retour = $this->requete->obtenirServicesByPseudo($pseudo);
        while ($data = $retour->fetch(PDO::FETCH_ASSOC))
        {
            $services[] = new Offre($data);
        }
        return $services;        
    }

    public function lireInfosServicesPseudo($pseudo)
    {
        $tabInfosServices = $this->instancierServicesPseudo($pseudo);

        foreach ( $tabInfosServices as $offre )
        {
            $idPersonne =  $offre->getIdPersonne();           
            $offre_id = $offre->getOffre_id();
            $codeOffre =  $offre->getCodeOffre();
            $idTag =  $offre->getIdTag();
            $tag = $this->requete->obtenirNomTag($idTag);
            $descriptionOffre =  $offre->getDescriptionOffre();
            $dateOuverture =  $offre->getDateOuverture();
            $dpt =  $offre->getDpt();
            $ville =  $offre->getVille();
            $lieuElargi =  $offre->getLieuElargi();
            $prix =  $offre->getPrix();
            $typePrix =  $offre->getTypePrix();

            $infos[] = array (
                'pseudo' => $pseudo,
                'idPersonne' => $idPersonne,
                'offre_id' => $offre_id,
                'codeOffre' => $codeOffre,
                'tag' => $tag,
                'descriptionOffre' => $descriptionOffre,
                'dateOuverture' => $dateOuverture,
                'dpt' => $dpt,
                'ville' => $ville,
                'lieuElargi' => $lieuElargi,
                'prix' => $prix,
                'typePrix' => $typePrix
            );                 
        }
        return $infos;
    }


    ///// lire un service par idOffre : non utilisé encore

//    public function obtenirInfosUnService($idOffre)
//    {
//        $data = $this->lireUnService($idOffre);
//        $infos;   
//        foreach ($data as $value)
//        {
//            $infos[] = $value;
//        }
//        return $infos;
//    }
//    public function tableauDetailUnService($idOffre)
//    {
//        $tabServices = $this->lireUnService($idOffre);
//        $data = array();
//
//        for ($i=0; $i<count($tabServices); $i++)
//        {   
//            $ind = $this->requete->obtenirIndividuServicesByIdOffre($tabServices[$i]['idPersonne']);
//            $nomTags = $this->requete->obtenirNomTagById($tabServices[$i]['idTag']);
//            $individu = "".$ind['prenom']." ".$ind['nom']."";
//            $pseudo = "".$ind['pseudo']."";
//            $infos = array (
//                'tag'=>$nomTags,
//                'pseudo'=>$pseudo,
//                'individu'=>$individu,
//                'codeOffre' => $tabServices[$i]['codeOffre'],
//                //'cle' => $tabServices[$i]['cle'],
//                'offre_id'=>$tabServices[$i]['offre_id'],
//                'descriptionOffre' => $tabServices[$i]['descriptionOffre'],
//                'dateOuverture' => $tabServices[$i]['dateOuverture'],
//                'département'=>$tabServices[$i]['dpt'],
//                'ville'=>$tabServices[$i]['ville'],
//                'lieuElargi'=>$tabServices[$i]['lieuElargi'],
//                'prix'=>$tabServices[$i]['prix'],
//                'typePrix'=>$tabServices[$i]['typePrix']
//            );
//            array_push($data, $infos);
//        }     
//        return $data;
//    }

    //////////////////////////////////////////   modifier sonService.php ///////////////////////

    public function infosPostModifierOffre()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $offre_id = htmlspecialchars_decode((trim($_POST['offre_id'])));
            $descriptionOffre = htmlspecialchars_decode((trim($_POST['descriptionOffre'])));
            $dpt = htmlspecialchars_decode((trim($_POST['dpt'])));
            $ville = htmlspecialchars_decode((trim($_POST['ville'])));
            $lieuElargi = htmlspecialchars_decode((trim($_POST['lieuElargi'])));
            $prix = htmlspecialchars_decode((trim($_POST['prix'])));
            $typePrix = htmlspecialchars_decode((trim($_POST['typePrix'])));
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudo'])));
            $motpasse = htmlspecialchars_decode((trim($_POST['motPasse'])));
            
            $infos[] = array (
                'offre_id' => $offre_id,
                'descriptionOffre' => $descriptionOffre,
                'dpt' => $dpt,
                'ville' => $ville,
                'lieuElargi' => $lieuElargi,
                'prix' => $prix,
                'typePrix' => $typePrix,
                'pseudo' => $pseudo,
                'motPasse' => $motpasse            
            );
            return $infos;
        }
    }

    private function nbPbSaisiModifierOffre($idOffre, $descriptionOffre, $dpt, $ville, $lieuElargi, $prix, $typePrix)
    {
        $validation = new Validations();
		
        $validation->pbVideErreur($idOffre);
        $validation->pbVideErreur($dpt);
        $validation->pbVideErreur($ville);
        $validation->pbDescription($descriptionOffre, 10, 500);
        $validation->pbVideErreur($lieuElargi);
	    $validation->pbErreurPrix($prix);
        $validation->pbVideErreur($typePrix);

        $var = $validation->getErreur();
        return $var;
    }

    private function msgInvalidSaisieModifierOffre($idOffre, $descriptionOffre, $dpt, $ville, $lieuElargi, $prix, $typePrix)
    {
        $validation = new Validations();

        $validation->videErreur($idOffre,"");
        $validation->invalidDescription($descriptionOffre, "'Description'", 10, 500);
        $validation->invalidChaine($dpt,"'Département'", 3, 25);
        $validation->invalidChaine($ville,"'Ville'", 3, 25);		
        $validation->videErreur($lieuElargi,"Lieu élargi");
		$validation->msgErreurPrix($prix,"'Montant'");
        $validation->videErreur($typePrix,"");
    }

    public function modifierOffre($idOffre, $description, $dpt, $ville, 
                                   $lieuElargi, $prix, $typePrix, $pseudo,$motPasse)
    {
        // on vérifie que le mot de passe est connu
        $passEncrypt = $this->requete->obtenirMotPasseByPseudo($pseudo);
        $motPasseOk = $this->managerMembre->verifExistancePass($motPasse, $passEncrypt);

        // on compte le nombre d'erreur de saisie :
        $nbErreur = $this->nbPbSaisiModifierOffre($idOffre, $description, $dpt, $ville, $lieuElargi, $prix, $typePrix);

        // S'il y a plus de 0 erreur ou que mot de passe n'est pas vrai, on affiche les erreurs.
        if( ($nbErreur > 0) | (!$motPasseOk) )
        { 
            $this->msgInvalidSaisieModifierOffre($idOffre, $description, $dpt, $ville, $lieuElargi, $prix, $typePrix);
        }
        else // sinon, on enregistre les modifications et on retourne à la page de gestion et on quitte le script
        {
            $this->requete->modifierOffre($idOffre, $description, $dpt, $ville, $lieuElargi, $prix, $typePrix);
            header('Location:gererSonCompte.php');
            exit();             
        }
    }

    //////////////////////   supprimer une offre de la liste des offres diponible ////////////////////////

    public function suppressionServiceParUser($idOffre)
    {
        $this->requete->suppressionServiceParUser($idOffre);
    }



    ///////////////////  gestion message sur offre //////////////////////////////////////////////

    private function tableauMsgOffre($idOffre, $msg, $pseudo, $pseudoOffrant)
    {
        $idMembre = $this->managerMembre->obtenirIdMembreByPseudo($pseudo);
            $infos[] = array (
                'idOffre' => $idOffre,
                'msg' => $msg,
                'pseudo' => $pseudo,
                'pseudoOffrant' => $pseudoOffrant,
                'idMembre' => $idMembre
            );
            return $infos;
    }

    public function infosVideMsgOffre($idOffre, $pseudo, $pseudoOffrant)
    {
            $msg = "";
            $infos[] = $this->tableauMsgOffre($idOffre, $msg, $pseudo, $pseudoOffrant);
            return $infos;
    }
    
    public function infosPostMsgOffre()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST))
        {
            $offre_id = htmlspecialchars_decode((trim($_POST['idOffre'])));
            $msg = htmlspecialchars_decode((trim($_POST['msg'])));
            $pseudo = htmlspecialchars_decode((trim($_POST['pseudo'])));
            $pseudoOffrant = htmlspecialchars_decode((trim($_POST['pseudoOffrant'])));
        
            $infos[] = $this->tableauMsgOffre($offre_id, $msg, $pseudo, $pseudoOffrant);
            return $infos;
        }
    }

    private function nbPbSaisieInsertMsgOffre($msg)
    {
        $validation = new Validations();
		
        $validation->pbDescription($msg, 10, 300);

        $var = $validation->getErreur();
        return $var;
    }

    private function msgInvalidSaisieInsertMsgOffre($msg)
    {
        $validation = new Validations();
        $validation->invalidDescription($msg, "'Message'", 10, 300);
    }

    public function verifierEtInsererMsgOffre()
    {
        $infosMsg = $this->infosPostMsgOffre();
        $nbErreur = $this->nbPbSaisieInsertMsgOffre($infosMsg[0][0]['msg']);
        if( $nbErreur > 0 )
        {
            $this->msgInvalidSaisieInsertMsgOffre($infosMsg[0][0]['msg']);
        }
        else
        {
            $this->requete->insererMessageOffre($infosMsg[0][0]['idOffre'], 
                                                $infosMsg[0][0]['idMembre'], 
                                                $infosMsg[0][0]['msg']);
            echo "<script type='text/javascript'>window.location.replace('serviceDetail.php?idOffre=".$infosMsg[0][0]['idOffre']."');</script>";
        }

    }

    public function verifierEtInsererMsgDemande()
    {
        $infosMsg = $this->infosPostMsgOffre();
        $nbErreur = $this->nbPbSaisieInsertMsgOffre($infosMsg[0][0]['msg']);
        if( $nbErreur > 0 )
        {
            $this->msgInvalidSaisieInsertMsgOffre($infosMsg[0][0]['msg']);
        }
        else
        {
            $this->requete->insererMessageOffre($infosMsg[0][0]['idOffre'], 
                                                $infosMsg[0][0]['idMembre'], 
                                                $infosMsg[0][0]['msg']);
            echo "<script type='text/javascript'>window.location.replace('demandeDetail.php?idOffre=".$infosMsg[0][0]['idOffre']."');</script>";
        }
    }

    public function obtenirTousMsgUneOffre($idOffre)
    {
        $data = $this->requete->obtenirTousMsgUneOffre($idOffre);
        $listeMsg = array();
        for ($i=0; $i<count($data); $i++)
        {  
            $idOffre_pseudo = $this->requete->obtenirPseudoAyantCreeService($idOffre);
            $idMembre_pseudo = $this->requete->obtenirPseudoAyantLaisseMsg($data[$i]['idMembre']);

            $msg = array (
                'msgOffre_id' => $data[$i]['msgOffre_id'],
                'idOffre' => $data[$i]['idOffre'],
                'idOffre_pseudo' => $idOffre_pseudo,
                'idMembre' => $data[$i]['idMembre'],
                'idMembre_pseudo' => $idMembre_pseudo,
                'date' => $data[$i]['date'],
                'msg' => $data[$i]['msg'],
            );
            array_push($listeMsg, $msg);       
        }
        return $listeMsg;
    }

}
