<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once '../dto/RequetesMembre.class.php';

class ManagerAutocomplete
{

    private $requete;

    public function __construct()
    {
        $this->requete = new RequetesMembre();
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////    
///////////////////////////////////////////  Gestion affichage des pages ///////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getNomsDepartements($filtreDpt)
    {
        $data = $this->requete->getNomsDepartements($filtreDpt);
        return $data;
    }


    public function getVillesFranceParDpt($filtreVille, $filtreDpt)
    {
        $data = $this->requete->getVillesFranceParDpt($filtreVille, $filtreDpt);
        return $data;
    }

    public function getCodePostalParVille($filtreCodePostal, $filtreVille)
    {
        $data = $this->requete->getCodePostalParVille($filtreCodePostal, $filtreVille);
        return $data;
    }


    public function estUnePersonne($idMembre)
    {
        $bool = $this->requete->estUnePersonne($idMembre);
        return $bool;
    }
}

