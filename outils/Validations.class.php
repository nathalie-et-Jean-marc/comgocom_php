<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Validations
{
    private $erreur = 0;



    public function getErreur() { return $this->erreur; }

    public function setErreur( $nbErreur ) { $this->erreur += $nbErreur; }

    public function messageListeVide($chaine, $etiquette)
    {
        if (empty($chaine)) 
        {
            $var = "<div><p'>Vous devez sélectionner une valeur ";
            $var.= "pour la liste ".$etiquette." !</p></div>";
            echo $var;
        } 
    }
    public function pbListeVide($chaine)
    {
        if (empty($chaine)) 
        {
            $this->erreur += 1;
        } 
        else{
            if($this->erreur >0)
            {
                $this->erreur -= 1;
            }
        }
    }


    public function invalidChaine($chaine,$etiquette, $minimum, $max)
    {
        $minimum = (int) $minimum;
        $max = (int) $max;
        //$this->tailleErreur($chaine,$etiquette, $minimum, $max);
        $this->chiffreErreur($chaine, $etiquette);
        $this->specialCaractErreur($chaine, $etiquette);
    }
    public function pbChaine($chaine, $minimum, $max)
    {
        //$this->pbTailleErreur($chaine, $minimum, $max);
        $this->pbChiffreErreur($chaine);
        $this->pbSpecialCaractErreur($chaine);
    }

    // public function pbAdresse($chaine, $minimum, $max)
    // {
    //     $this->pbTailleErreur($chaine, $minimum, $max);
    // }

    public function invalidMail($chaine, $etiquette)
    {
        $this->videErreur($chaine, $etiquette);
        $this->formeDeMail($chaine, $etiquette);
    }
    public function pbMail($chaine,$etiquette1)
    {
        $this->pbFormeDeMail($chaine);
        $this->formeDeMail($chaine,$etiquette1);
    }
    public function pbMail2($mail1,$mail2,$etiquette1,$etiquette2)
    {
        if($mail2 != "")
        {
            $this->pbFormeDeMail($mail2); 
            $this->formeDeMail($mail2,$etiquette2);
            $this->deuxChainesIdentiques($mail1,$mail2,$etiquette1,$etiquette2);
        }
    }
    public function pbTelephone2($telephone1,$telephone2,$etiquette1,$etiquette2)
    {
        if($telephone2 != "")
        {
            $this->formeTelephoneErreur($telephone2);
            $this->deuxChainesIdentiques($telephone1,$telephone2,$etiquette1,$etiquette2);
        }
    }
    // public function invalidMotPasse($chaine,$etiquette, $minimum, $max)
    // {
    //     $this->tailleErreur($chaine,$etiquette, $minimum, $max);
    // }
    // public function pbMotPasse($chaine, $minimum, $max)
    // {
    //     $this->pbTailleErreur($chaine, $minimum, $max);        
    // }



    public function deuxChainesDifferentes($chaine, $autreChaine, $etiquette)//  si les deux chaines sont différentes
    {
        if($chaine != $autreChaine)
        {
            $var = "<div><p>" .$etiquette." ne correspondent pas !</p></div>";
            echo $var;
        }
    }

    public function deuxChainesIdentiques($chaine, $autreChaine, $etiquette1,$etiquette2)// si les deux chaines sont identiques
    {
        if($chaine == $autreChaine)
        {
            $var = "<div><p>" .$etiquette1." ne peut être identique à " .$etiquette2. " !</p></div>";
            echo $var;
        }
    }

    public function pbDeuxChainesDiff($chaine, $autreChaine)
    {        
        if($chaine != $autreChaine)
        {
            $this->erreur += 1;
        }
/*         else{
            if($this->erreur >0)
            {
                $this->erreur -= 1;
            }
        } */
    }

    public function mauvaiseSaisieTelephone($chaine, $etiquette)
    {
        $this->formeTelephoneErreur($chaine);
    }    

    public function pbSaisieTelephone($chaine)
    {
        $this->pbTelephone($chaine);
    }

    public function mauvaiseSaisieCodePostale($chaine, $etiquette)
    {
        $this->formeCodePostalErreur($chaine);
    }

    public function pbSaisieCodePostal($chaine)
    {
        $this->pbCodePostal($chaine);
    }

    public function mauvaiseSaisieNumRue($chaine, $etiquette)
    {
        $str = "/[0-9]{1,6}/";
        if(!preg_match($str,$chaine))
        {
            $var = "<div><label>Le champ ".$etiquette. " doit comporter uniquement des chiffres ";
            $var.= "(de 1 à 6 chiffres consécutifs)</label></div>";
            echo $var;
        }   
    }
    

    public function pbSaisieNumRue($chaine)
    {
        $str = "/[0-9]{1,6}/";
        if(!preg_match($str,$chaine))
        {
            $this->erreur += 1;
        }   
    }

    public function videErreur($chaine, $etiquette)
    {
        if (empty($chaine)) 
        {
            $var = "<div><p>Le champ ".$etiquette." ne doit pas être vide !</p></div>";
            echo $var;
        } 
    }

    public function pbVideErreur($chaine)
    {
        if (empty($chaine)) 
        {
            $this->erreur += 1;
        }
    }

    public function videErreurCheck($chaine, $etiquette1, $etiquette2)
    {
        if (empty($chaine)) 
        {
            $var = "<div><p>Veuillez choisir ".$etiquette1." ou ".$etiquette2. " !</p></div>";
            echo $var;
        }
        else if ($chaine == "pasRepondu")
        {
            $var = "<div><p>Veuillez choisir ".$etiquette1." ou ".$etiquette2. " !</p></div>";
            echo $var;
        } 
    }

  /*  public function pbVideErreurCheck($chaine)
    {
        if (empty($chaine)) 
        {
            $this->erreur += 1;
        }
        else{
            if($this->erreur >0)
            {
                $this->erreur -= 1;
            }
        }
         else if ($chaine == "pasRepondu")
        {
            $this->erreur += 1;
        }  
    }*/

    private function longStringErreur($string, $etiquette, $max)
    {
        $lenght = strlen($string); 
        if ($lenght >= $max)
        {
            $var = "<div><p> Le champ ".$etiquette."";
            $var.= " est trop long : " .$lenght. " ! Il doit faire moins de " .$max. " caractères.</p></div>";
            echo $var;
        }
    } 


    private function pbLongString($string, $max)
    {
        $lenght = strlen(utf8_decode($string)); 
        if ($lenght >= $max)
        {
            $this->erreur += 1;
            //echo "coucou";
        }
        // else{
        //     if($this->erreur >0)
        //     {
        //         $this->erreur -= 1;
        //     }
        // }
    }

    private function minStringErreur($string, $etiquette, $min)
    {
        $str = strlen($string);
        
        if ($str <= $min )
        {
            $var = "<div><p> Le champ " .$etiquette."";
            $var.= " est trop court! Il doit comporter au  moins " .$min. " caractères.</p></div>";
            echo $var;
        }
    }

    private function pbMinStringErreur($string, $min)
    {
        $str = strlen($string);
       // echo "taille string :".$str."</br>";
      // 27<10 
        if ($str < $min)
        {
            $this->erreur += 1;
        }
        // else{
        //     if($this->erreur >0)
        //     {
        //         $this->erreur -= 1;
        //     }
        // }
    }

    public function invalidDescription($string, $etiquette, $min, $max)
    {
        $this->longStringErreur($string, $etiquette, $max);
        $this->minStringErreur($string, $etiquette, $min);
    }

    public function pbDescription($string, $min, $max)
    {
        $this->pbLongString($string, $max);
        $this->pbMinStringErreur($string, $min);    
    }

    public function pbInvalidNumeric($numeric)
    {
        $bool = is_numeric($numeric);
        if ($bool !== TRUE)
        {
            $this->erreur += 1;
        }
        // else{
        //     if($this->erreur >0)
        //     {
        //         $this->erreur -= 1;
        //     }
        // }
    } // regexp float number with 2 number after dot : ^\d{2}\.\d{2}$

    private function invalidPrix($prix)
    {
        $str = "/^\d+(\.[0-9]{1,2})?$/"; // pas xx.0x ; un ou deux chiffres décimaux
        if(!preg_match($str,$prix))
        {
            echo "<p> Erreur dans la saisie du montant : décimal arrondi au dizième, le point comme séparateur décimal.  </p>";
        }

    }

    private function pbInvalidPrix($prix)
    {
        $str = "/^\d+(\.[0-9]{1,2})?$/"; // pas xx.0x ; un ou deux chiffres décimaux
        if(!preg_match($str,$prix))
        {
           $this->erreur += 1;
        }
    }

    public function msgErreurPrix($prix, $etiquette)
    {
        $this->invalidPrix($prix);
        $this->videErreur($prix, $etiquette);
    }
    public function pbErreurPrix($prix)
    {
       $this->pbInvalidPrix($prix);    
    }

    // private function tailleErreur($chaine,$etiquette, $minimum, $max)
    // {
    //     $minimum = (int) $minimum;
    //     $max = (int) $max;
    
    //     //$str = "/^[\S]{".$minimum.",".$max."}$/";
    //     //if(!preg_match($str,$chaine) && (!empty($chaine))) 
    //     //{
    //     //    $var = "<div><p> Le champ ".$etiquette;
    //     //    $var.= " doit comporter entre ".$minimum. " et ".$max. " caractères.</p></div>";
    //     //    echo $var;
    //     //}
    //     if($chaine < $max && $chaine > $minimum ) 
    //     {
    //         $var = "<div><p> Le champ ".$etiquette;
    //         $var.= " doit comporter entre ".$minimum. " et ".$max. " caractères.</p></div>";
    //         echo $var;
    //     }
    // } 
    public function pbTailleErreur($chaine,$nomChamps, $minimum, $max)
    {
        $minimum = (int) $minimum;
        $max = (int) $max;
        $taille = strlen($chaine);
        
       // $str = "/^[\S]{".$minimum.",".$max."}$/";
       // if(!preg_match($str,$chaine) && (!empty($chaine))) 
       // {
       //     $this->erreur += 1;
       // }
       
        if($taille > $max) 
        {
             $this->erreur += 1;
             echo "<p>". $nomChamps." contient trop de caractères.</p>";
        }
        if($taille < $minimum) 
        {
             $this->erreur += 1;
             echo "<p>". $nomChamps ." ne contient pas assez de caractères.</p>";
        }

    }

    private function chiffreErreur($chaine, $etiquette)
    {
        if(preg_match("/[0-9]/",$chaine))//   
        {
            $var = "<div><label>Le champ ".$etiquette." ne doit pas comporter de chiffres.</label></div>";
            echo $var;
        }
    }

    private function pbChiffreErreur($chaine)
    {
        if(preg_match("/[0-9]/",$chaine))//   
        {
            $this->erreur += 1;
        }
    }

    private function specialCaractErreur($chaine, $etiquette)
    {
        $str = "/[^a-zA-Z0-9\'\-\--\é\è\É\Èç^À]/";
        if(preg_match($str,$chaine))
        {
            $var = "<div><label>le ".$etiquette. "  ne doit pas comporter de blanc ";
            $var.= "ou des caractères spéciaux.</label></div>";
            echo $var;
        }
    }
    private function pbSpecialCaractErreur($chaine)
    {
        $str = "/[^a-zA-Z0-9\'\-\--]/";
        if(preg_match($str,$chaine))
        {
            $this->erreur += 1;
        }

    }

    private function formeDeMail($chaine, $etiquette)
    {
        $regexMail = "/^[^-_\.][a-z0-9-_\.]+[^-_\.]@[^-_\.][a-z0-9-_\.]+[^-_\.]\.[a-z]{2,4}$/";
        if (!preg_match($regexMail,$chaine)) 
        {
            $var = "<div><p>Une erreur dans la forme du mail, ";
            $var.= "exemple: xxxxxx@xxxx.xx ! Voir le champ : " .$etiquette. " </p></div>";
            echo $var;
        }
    }
    private function pbFormeDeMail($chaine)
    {
        $regexMail = "/^[^-_\.][a-z0-9-_\.]+[^-_\.]@[^-_\.][a-z0-9-_\.]+[^-_\.]\.[a-z]{2,4}$/";
        if (!preg_match($regexMail,$chaine)) 
        {
            $this->erreur += 1;
        }

    }

    private function formeTelephoneErreur($chaine)
    {
        #$motif = '/^0[123456789][0-9]{8}$/';
        $motif = "#[0][1-9][- \.?]?([0-9][0-9][- \.?]?){4}$#";
        if (!preg_match($motif, $chaine))
        {
            $var = "<div><p>Une erreur dans la forme du téléphone. ";
            $var.= "exemple: 04 01 01 01 01 ou 06 01 01 01 01</p></div>";
            echo $var;
        }
    }

    private function pbTelephone($chaine)
    {
        $motif = '/^0[1-23456789][0-9]{8}$/';
        if (!preg_match($motif, $chaine))
        {
            $this->erreur += 1;
        }

    }

    public function formeCodePostalErreur($chaine)
    {
        $motif = '/^[0-9]{5,5}$/';
        if (!preg_match($motif, $chaine))
        {
            $var = "<div><p>Une erreur dans la forme du code postal, ";
            $var.= "il doit comporter 5 chiffres sans espace  !</p></div>";
            echo $var;
        }
    }
    private function pbCodePostal($chaine)
    {
        $motif = '/^[0-9]{5,5}$/';
        if (!preg_match($motif, $chaine))
        {
            $this->erreur += 1;
        }

    }
}

