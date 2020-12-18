<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


class Offre
{
    private $offre_id;
    private $codeOffre;
    private $cle;
    private $idPersonne;
    private $idTag;
    private $descriptionOffre;
    private $dateOuverture;
    private $dpt;
    private $ville;
    private $lieuElargi;
    //private $ouverte;
    //private $typeOffre;
    private $prix;
    private $typePrix;


    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

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
                    $this->$method($value);
                }
            }
        }
    }

    // GETTERS :
    // Ils vont servir à hydrater la classe, il faut passer par eux pour respecter le principe d'encapsulation

    public function getOffre_id() { return $this->offre_id ; }
    public function getCodeOffre() { return $this->codeOffre ; }
    public function getCle() { return $this->cle ; }
    public function getIdPersonne() { return $this->idPersonne ; }
    public function getIdTag() { return $this->idTag ; }
    public function getDescriptionOffre() { return $this->descriptionOffre ; }
    public function getDateOuverture() { return $this->dateOuverture ; }
    public function getDpt() { return $this->dpt ; }
    public function getVille() { return $this->ville ; }
    public function getLieuElargi() { return $this->lieuElargi ; }
    //public function getOuverte() { return $this->ouverte ; }
    //public function getTypeOffre() { return $this->typeOffre ; }
    public function getPrix() { return $this->prix ; }
    public function getTypePrix() { return $this->typePrix ; }


    // SETTERS :
/*
  offre_id INT NOT NULL AUTO_INCREMENT,
  codeOffre varchar(50) NULL,
  cle VARCHAR(50) NULL, 
  idPersonne INT NOT NULL,
  idTag INT NOT NULL, 
  descriptionOffre VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_bin NULL,
  dateOuverture TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
  dpt VARCHAR(25) NOT NULL,
  ville varchar(20) NOT NULL,
  lieuElargi varchar(15) NULL,
  ouverte TINYINT(1) DEFAULT 1, 
  typeOffre char(1),            
  prix numeric(15,2) NULL,  
  typePrix VARCHAR(10),
  PRIMARY KEY  (offre_id),
*/    

    private function setOffre_id($newOffre_id)
    {
        $newOffre_id = (int) $newOffre_id;
        $this->offre_id = $newOffre_id;
    }

    private function setCodeOffre($newCodeOffre)
    {
        $newCodeOffre = (string) $newCodeOffre;
        $this->codeOffre = $newCodeOffre;
    }

    private function setCle($newCle)
    {
        $newCle = (string) $newCle;
        $this->cle = $newCle;
    }
    private function setIdPersonne($newIdPersonne)
    {
        $newIdPersonne = (int) $newIdPersonne;
        $this->idPersonne = $newIdPersonne;
    }
    private function setIdMembre($newIdMembre)
    {
        $newIdMembre = (int) $newIdMembre;
        $this->idMembre = $newIdMembre;
    }
    private function setIdTag($newIdTag)
    {
        $newIdTag = (int) $newIdTag;
        $this->idTag = $newIdTag;
    }
    private function setTag($newTag)
    {
        $newTag = (string) $newTag;
        $this->tag = $newTag;
    }
    private function setDescriptionOffre($newDescriptionOffre)
    {
        $newDescriptionOffre = (string) $newDescriptionOffre;
        $this->descriptionOffre = $newDescriptionOffre;
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
    private function setLieuElargi($newLieuElargi)
    {
        $newLieuElargi = (string) $newLieuElargi;
        $this->lieuElargi = $newLieuElargi;
    }
  //  private function set($new)
  //  {
  //      $new = (int) $new;
  //      $this-> = $;
  //  }
  //  private function setTypeOffre($newTypeOffre)
  //  {
  //      $newTypeOffre = (string) $newTypeOffre;
  //      $this->typeOffre = $typeOffre;
  //  }

    private function setDateOuverture($newDateOuverture)
    {
        $newDateOuverture = (string) $newDateOuverture;
        $date = new DateTime($newDateOuverture);
        $uneDate = $date->format('d-m-Y H:i'); // Retourne la date formatée, sous forme de chaîne de caractères, 
                                    // en cas de succès ou FALSE si une erreur survient. 
        if ($uneDate === false)
        {
            echo "Une erreur est survenue avec la date de dernière modification.";
        }
        else
        {
            $newDateOuverture = $uneDate;
            $this->dateOuverture = $newDateOuverture;
        }
    }

    private function setPrix($newPrix)
    {
        $newPrix = (float) $newPrix;
        $stringFormat = (string)number_format($newPrix, 2, '.', '');// $number = 1234.5678; => (string)1234.57
        $newPrix = $stringFormat;

        $this->prix = $newPrix;
    }
    private function setTypePrix($newTypePrix)
    {
        $newTypePrix = (string) $newTypePrix;
        $this->typePrix = $newTypePrix;
    }

}
