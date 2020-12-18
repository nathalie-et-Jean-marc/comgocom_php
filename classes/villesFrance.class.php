<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


class Villes
{
    private $villes = array();

    public function __construct()
    {
        $this->requete = new RequetesMembre();
       
    }


    public function getVilles() 
    { 

       // $retour = $this->requete->nomsVillesFrance();

        while ($retour = $this->requete->nomsVillesFrance())
        {
            $this->villes[] = $retour;
        }

        return $this->villes ; 
    }

}
