<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


class InfosPersonne
{
    private $personne_id;
    private $idMembre;
    private $numRue;
    private $adrrText;
    private $dpt;
    private $ville;
    private $codePostal;
    private $telephone;
    private $photo;
    private $sexe;
    private $nbEchange;
    private $dateModif;


    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }


    // Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
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

    public function getPersonne_id() { return $this->personne_id ; }
    public function getIdMembre() { return $this->idMembre ; }
    public function getNumRue() { return $this->numRue ; }
    public function getAdrrText() { return $this->adrrText ; }
    public function getDpt() { return $this->dpt ; }
    public function getVille() { return $this->ville ; }
    public function getCodePostal() { return $this->codePostal ; }
    public function getTelephone() { return $this->telephone ; }
    public function getPhoto() { return $this->photo ; }
    public function getSexe() { return $this->sexe ; }
    public function getNbEchange() { return $this->nbEchange ; }
    public function getDateModif() { return $this->dateModif ; }


    private function setPersonne_id($newPersonne_id)
    {
        $newPersonne_id = (int) $newPersonne_id;
        $this->personne_id = $newPersonne_id;
    }
    private function setIdMembre($newIdMembre)
    {
        $newIdMembre = (int) $newIdMembre;
        $this->idMembre = $newIdMembre;
    }
    private function setNumRue($newNumRue)
    {
        $newNumRue = (int) $newNumRue;
        $this->numRue = $newNumRue;
    }
    private function setadrrText($newAdrrText)
    {
        $newAdrrText = (string) $newAdrrText;
        $this->adrrText = $newAdrrText;
    }
    private function setDpt($newDpt)
    {
        $newDpt = (string) $newDpt;
        $this->dpt = $newDpt;
    }
    private function setVille($newVille)
    {
        $newVille = (string) $newVille;
        $this->ville = $newVille;
    }
    private function setCodePostal($newCodePostal)
    {
        $newCodePostal = (string) $newCodePostal;
        $this->codePostal = $newCodePostal;
    }
    private function setTelephone($newTelephone)
    {
        $newTelephone = (string) $newTelephone;
        $this->telephone = $newTelephone;
    }
    private function setPhoto($newPhoto)
    {
        $newPhoto = (string) $newPhoto;
        $this->photo = $newPhoto;
    }
    private function setSexe($newSexe)
    {
        $newSexe = (string) $newSexe;
        $this->sexe = $newSexe;
    }

    private function setNbEchange($newNbEchange)
    {
        $newNbEchange = (int) $newNbEchange;
        $this->nbEchange = $newNbEchange;
    }
    private function setDateModif($newDateLastModif)
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
            $this->dateModif = $newDateLastModif;
        }
    }
}
