<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


class Membre
{
    private $id;
    private $pseudo ;
    private $motPasse;
    private $cle;
    private $actif;
    private $mail1 ;
    private $mail2 ;
    private $lastConnect;
   # $idMembre = $membre->getMembre_id();
    private $prenom ;
    private $nom ;
    private $adresse;
    private $ville;
    private $departement;
    private $codePostale ;
    private $pays;
    private $telephone1;
    private $telephone2;
    private $civilite;
    private $id_abonnement;
    private $id_type_abo ;
    private $id_role;
    private $type_abonnement;
    private $role; // relatif à la gestion du forum (aspect communautaire du site) : [user_admin;moderator;user_simple;intro_membre] droit plus ou moins élevés pour gérer le site depuis interface web
    private $statut; // relatif au compte et à l'aspect intermédiaire du site : [propriétaire_site ; visiteur;membre;prestaaire;abonne;banni;intro_membre] 
    //private $isAdmin;
    private $date_inscription;
    private $date_modif;
    private $estIdentifie;


    // le constructeur :
    // On implémente le constructeur pour qu'on puisse directement 
    // hydrater notre objet lors de l'instanciation de la classe
    public function __construct(array $donnees)
    {
        //var_dump($donnees);
        $this->hydrate($donnees);
    }


    // Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
        // on récupère le nom des setters correspondants
        // si la clef est placesTotales son setter est setPlacesTotales
        // il suffit de mettre la 1ere lettre de key en Maj et de le préfixer par set
        // la cle placesTotales est le nom du champ de la base de donnes dans notre cas car on fait 
        //une association dans la fonction ManagerMembre->instancierUnMembre avec le retour de la commande select
        // autre exemple la table personne à id il faut que la propriété soit $id et le setter setId, et non setIdPersonne
    public function hydrate(array $donnees)
    {
        if (isset($donnees))
        {
            foreach ($donnees as $key => $value)
            {
                // On récupère le nom du setter correspondant à l'attribut.
                $method = 'set'.ucfirst($key);
                // Si le setter correspondant existe.    
                if (method_exists($this, $method))
                {
                    // method a un « $ » : c’est parce qu' on appelle la variable qui représente la méthode
                    $this->$method($value);
                }
            }
        }
    }
    // explications :
    // cela permet d'éviter de modifier la fonction hydrate dans le cas d'ajout d'une propriété
    // on aurait pu l'écrire ainsi :
                        // public function hydrate(array $donnees)
                        // {
                        //     if (isset($donnees['idLogin']))
                        //     {
                        //         $this->setId($donnees['idLogin']);
                        //     }
                        //     if (isset($donnees['pseudo']))
                        //     {
                        //         $this->setPseudo($donnees['pseudo']);
                        //     }        
                        //     if (isset($donnees['motPasse']))
                        //     {
                        //         $this->setMotPasse($donnees['motPasse']);
                        //     } 
                        //     // etc., pour chaque setter de chaque propriété
                        // }




    // GETTERS :
    // Ils vont servir à hydrater la classe, il faut passer par eux pour respecter le principe d'encapsulation

    public function getIdPersonne() { return $this->id ; }
    public function getPseudo() { return $this->pseudo ; }
    public function getMotPasse() { return $this->motPasse ; }
    public function getCle() { return $this->cle ; }
    public function getActif() { return $this->actif ; }
    public function getMail() { return $this->mail ; }
    public function getLastConnect() { return $this->lastConnect ; }
    public function getMembre_id() { return $this->membre_id ; }
    public function getPrenom() { return $this->prenom ; }
    public function getNom() { return $this->nom ; }
    //public function getIsAdmin() { return $this->isAdmin ; }
    public function getDateInscription() { return $this->date_inscription ; }
    public function getDateModif() { return $this->date_modif ; }
    public function getEstIdentifie() { return $this->estIdentifie ; }
    public function getCodePostal() { return $this->codePostale ; }
    public function getAdresse(){ return $this->adresse ; }
    public function getVille() { return $this->ville ; }
    public function getDepartement() { return $this->departement ; }
    public function getPays() { return $this->pays ; }
    public function getTelephone1() { return $this->telephone1 ; }
    public function getTelephone2() { return $this->telephone2 ; }
    public function getCivilite() { return $this->civilite ; }
    public function getIdAbonnement() { return $this->id_abonnement ; }
    public function getIdTypeAbonnement() { return $this->id_type_abo ; }
    public function getId_role() {return $this->id_role ; }
    public function getRole() { return $this->role ; }
    public function getTypeAbonnement() { return $this->type_abonnement ; }
    public function getStatut() { return $this->statut ; }
    public function getMail1() { return $this->mail1 ; }
    public function getMail2() { return $this->mail2 ; }
    
    // SETTERS :
    // Ils permettent de vérifier le type des données :

    private function setEstIdentifie($newEstIdentifie)
    {
        $newEstIdentifie = (bool) $newEstIdentifie;
        $this->estIdentifie = $newEstIdentifie;
    }

    private function setId($IdPersonne)
    {
        
        $IdPersonne = (int) $IdPersonne;
        $this->id = $IdPersonne;
    }

    private function setPseudo($pseudo)
    {
        $pseudo = (string) $pseudo;
        if ($pseudo != "")
        {
            $this->pseudo = $pseudo;
        }
    }

    private function setMotPasse($motPasse)
    {
        $motPasse = (string) $motPasse;
        $this->motPasse = $motPasse;
    }

    private function setCle($cle)
    {
        $cle = (string) $cle;
        $this->cle = $cle;
    }

    private function setActif($actif)
    {
       // echo "set actif appelé";
        $actif = (int) $actif;
        $this->actif = $actif;
    }

    private function setMail1($email1)
    {
        $email1 = (string) $email1;
        if ($email1 != "")
        {
            $this->mail1 = $email1;
        }
    }

    private function setMail2($email2)
    {
        $email2 = (string) $email2;
        if ($email2 != "")
        {
            $this->mail2 = $email2;
        }
    }

    private function setLastConnect($newLastConnect)
    {
        $newLastConnect = (string)$newLastConnect;
        $date = new DateTime($newLastConnect);
        $uneDate = $date->format('d-m-Y H:i'); // Retourne la date formatée, sous forme de chaîne de caractères, 
                                    // en cas de succès ou FALSE si une erreur survient. 
        if ($uneDate === false)
        {
            echo "Une erreur est survenue avec la date de dernière connexion.";
        }
        else
        {
            $newLastConnect = $uneDate;
            $this->lastConnect = $newLastConnect;
        }
    }

    private function setPrenom($prenom)
    {
        $prenom = (string) $prenom;
        if ($prenom != "")
        {
            $this->prenom = $prenom;
        }
    }

    private function setNom($nom)
    {
        $nom = (string) $nom;
        if ($nom != "")
        {
            $this->nom = $nom;
        }
    }

    // private function setIsAdmin($isAdmin)
    // {
    //     $isAdmin = (int) $isAdmin;
    //     $this->isAdmin = $isAdmin;
    // }

    private function setDate_inscription($inscription)
    {
        $inscription = (string)$inscription;
        $date = new DateTime($inscription);
        $uneDate = $date->format('d-m-Y H:i'); // Retourne la date formatée, 
                                                  // sous forme de chaîne de caractères, 
                                                  // en cas de succès ou FALSE si une erreur survient. 
        if ($uneDate === false)
        {
            echo "Une erreur est survenue avec la date d'inscription.";
        }
        else
        {
            $inscription = $uneDate;
            $this->date_inscription = $inscription;
        }
    }

    private function setDate_modif($newDateLastModif)
    {
        $newDateLastModif = (string)$newDateLastModif;
        $date = new DateTime($newDateLastModif);
        $uneDate = $date->format('d-m-Y H:i'); // Retourne la date formatée, sous forme de chaîne de caractères, 
                                    // en cas de succès ou FALSE si une erreur survient. 
        if ($uneDate === false)
        {
            echo "Une erreur est survenue avec la date de dernière modification.";
        }
        else
        {
            $newDateLastModif = $uneDate;
            $this->date_modif = $newDateLastModif;
        }
    }

    private function setCodePostal($codePostal)
    {
        $codePostal = (string) $codePostal;
        if ($codePostal != "")
        {
            $this->codePostale = $codePostal;
        }
    }

    private function setAdresse($adresse)
    {
        $adresse = (string) $adresse;
        if ($adresse != "")
        {
            $this->adresse = $adresse;
        }
    }  

    private function setVille($ville)
    {
        $ville = (string) $ville;
        if ($ville != "")
        {
            $this->ville = $ville;
        }
    } 

    private function setDepartement($departement)
    {
        $departement = (string) $departement;
        if ($departement != "")
        {
            $this->departement = $departement;
        }
    } 

    private function setPays($pays)
    {
        $pays = (string) $pays;
        if ($pays != "")
        {
            $this->pays = $pays;
        }
    } 

    private function setTelephone1($telephone1)
    {
        $telephone1 = (string) $telephone1;
        if ($telephone1 != "")
        {
            $this->telephone1 = $telephone1;
        }
    } 

    private function setTelephone2($telephone2)
    {
        $telephone2 = (string) $telephone2;
        if ($telephone2 != "")
        {
            $this->telephone2 = $telephone2;
        }
    } 

    private function setCivilite($civilite)
    {
        $civilite = (string) $civilite;
        if ($civilite != "")
        {
            $this->civilite = $civilite;
        }
    } 

    private function setId_abonnement($idAbonnement)
    {
        $idAbonnement= (int) $idAbonnement;
        $this->id_abonnement = $idAbonnement;
    }

    private function setId_type_abo($idTypeAbonnement)
    {
        $idTypeAbonnement= (int) $idTypeAbonnement;
        $this->id_type_abo = $idTypeAbonnement;
    }

    private function setType_abonnement($typeAbonnement)
    {
        $typeAbonnement = (string) $typeAbonnement;
        if ($typeAbonnement != "")
        {
            $this->type_abonnement = $typeAbonnement;
        }
    }

    private function setRole($role)
    {
        $role = (string) $role;
        if ($role != "")
        {
            $this->role = $role;
        }
    }   

    private function setId_role($idRole)
    {
        $idRole = (int) $idRole;
        $this->id_role = $idRole;
    }
    
    private function setStatut($statut)
    {
        $statut = (string) $statut;
        if ($statut != "")
        {
            $this->statut = $statut;
        }
    }  


}
