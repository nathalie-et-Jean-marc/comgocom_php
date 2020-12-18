<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require 'Connexion.class.php';

class RequetesMembre
{

    public function __construct()
    {
       $this->pdo = Database :: connect();
       $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    
    ///////////////////////////////////////////   Nouvelle version insert membre ///////////////////////////


    private function getIdTypeAbonnementIntroMembre()
    {
        //SELECT id FROM type_abonnement WHERE type = "introMembre";
        $baseMembre = $this->pdo->quote("base_membre");
        $sql = "SELECT id FROM type_abonnement WHERE type = $baseMembre;";
        $q = $this->pdo->prepare($sql);
        #$q->execute() or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());
        $q = $this->pdo->query($sql)->fetchColumn();
        return (int)$q;
    }
    private function getIdAbonnementIntroMembre()
    {
        $id_type_intro = $this->getIdTypeAbonnementIntroMembre();
        //SELECT id FROM abonnement WHERE id_type_abo=2;
        $sql = "SELECT id FROM abonnement WHERE id_type_abo=$id_type_intro;";
        $q = $this->pdo->prepare($sql);
        $q = $this->pdo->query($sql)->fetchColumn();
        return (int)$q;
    }

    private function getIdRoleIntroMembre()
    {
        //SELECT id FROM role WHERE role.role='intro_membre';
       
        $sql = "SELECT id FROM role WHERE role.role='intro_membre';";
        $q = $this->pdo->prepare($sql);
        $q = $this->pdo->query($sql)->fetchColumn();
        return (int)$q;
    }

    private function getIdStatutIntroMembre()
    {
        $introMembre = $this->pdo->quote("intro_membre");
        $sql = "SELECT id FROM statut WHERE libelle=$introMembre;";
        $q = $this->pdo->prepare($sql);
        $q = $this->pdo->query($sql)->fetchColumn();
        return (int)$q;
    }
    public function getIdRoleByTypeRole($role)
    {
        $clean_role = $this->pdo->quote($role);
        $sql = "select id from role where role=$clean_role;";
        $q = $this->pdo->prepare($sql);
        $q = $this->pdo->query($sql)->fetchColumn();
        return (int)$q;
    }
    public function getIdStatutByLibelle($libelle)
    {
        $clean_libelle = $this->pdo->quote($libelle);
        $sql = "select id from statut where libelle=$clean_libelle;";
        $q = $this->pdo->prepare($sql);
        $q = $this->pdo->query($sql)->fetchColumn();
        return (int)$q;
    }

    public function updateIdRolePersonne($pseudo, $newIdRole)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $sql = "update personne set id_role= $newIdRole where pseudo = $clean_pseudo ;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          } 
    }   

    public function updateIdStatutPersonne($pseudo, $newIdStatut)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $sql = "update personne set id_statut=$newIdStatut where pseudo=$clean_pseudo;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            $this->pdo->commit();
        }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
        } 
    }  

    private function getIdPersonneFromPseudo($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);

        $sql = "SELECT id FROM personne WHERE nom = $clean_pseudo;";
        $q = $this->pdo->prepare($sql);
        $q = $this->pdo->query($sql)->fetchColumn();
        return (int)$q;
    }

    private function insertHistoriqueStatut($idStatut,$idPersonne)
    {
        $sql = "INSERT INTO historique_statut (date,id_statut,id_personne) VALUES (NOW(),$idStatut,$idPersonne)";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            //echo "Erreur : " . $e->getMessage();
          }  
    }

    public function insertMembreSimple($pseudo,$motpassehash,$mail1,$mail2,$nom,$prenom,$adresse,$ville,
    $departement,$codepostal,$pays,$telephone1,$telephone2,$ip)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $clean_motPasse = $this->pdo->quote($motpassehash);
        $clean_nom = $this->pdo->quote($nom);
        $clean_prenom = $this->pdo->quote($prenom);
        $clean_mail1 = $this->pdo->quote($mail1);
        $clean_mail2 = $this->pdo->quote($mail2);
        
        $clean_adresse = $this->pdo->quote($adresse);
        $clean_ville = $this->pdo->quote($ville);
        $clean_departement = $this->pdo->quote($departement);
        $clean_codepostal = $this->pdo->quote($codepostal);
        $clean_pays = $this->pdo->quote($pays);
        $clean_telephone1 = $this->pdo->quote($telephone1);
        $clean_telephone2 = $this->pdo->quote($telephone2);
        $clean_ip = $this->pdo->quote($ip);

        $idAbonnement=$this->getIdAbonnementIntroMembre();
        $idRole = $this->getIdRoleIntroMembre();
        $idStatut = $this->getIdStatutIntroMembre();
        $nonActif=0; // todo créer une cnstante type_etat

        $sql="INSERT INTO personne (pseudo, password, mail1, mail2,  actif, nom, prenom,
              adresse, ville, departement, codepostal, pays, telephone1, telephone2, ip, id_abonnement,id_role,id_statut,date_inscription) 
              VALUES ($clean_pseudo,$clean_motPasse,$clean_mail1,$clean_mail2,$nonActif,$clean_nom,$clean_prenom,
              $clean_adresse,$clean_ville,$clean_departement,$clean_codepostal,$clean_pays,$clean_telephone1,$clean_telephone2,
              $clean_ip , $idAbonnement,$idRole, $idStatut, now());";

              //echo $sql;
              try{
                $this->pdo->beginTransaction();
                $this->pdo->exec($sql);
               // echo 'Entrée ajoutée dans la table personne';
                $this->pdo->commit();
              }
              catch(PDOException $e){
                $this->pdo->rollBack();
                echo "Erreur : " . $e->getMessage();
                return false;
              }

        $idPersonne = $this->getIdPersonneFromPseudo($clean_pseudo);
        $this->insertHistoriqueStatut($idStatut,$idPersonne);
        return true;
    }

    public function  modifierAdresse($idPersonne, $adresse,$ville,$departement,$codepostal,$pays)
    {
        $clean_adresse = $this->pdo->quote($adresse);
        $clean_ville = $this->pdo->quote($ville);
        $clean_departement = $this->pdo->quote($departement);
        $clean_codepostal = $this->pdo->quote($codepostal);
        $clean_pays = $this->pdo->quote($pays);

        $sql="update personne set adresse=$clean_adresse , ville=$clean_ville , departement=$clean_departement,";
        $sql.=" codepostal=$clean_codepostal, pays=$clean_pays where id=$idPersonne;";

              //echo $sql;
              try{
                $this->pdo->beginTransaction();
                $this->pdo->exec($sql);
                $this->pdo->commit();
              }
              catch(PDOException $e){
                $this->pdo->rollBack();
                echo "Erreur : " . $e->getMessage();
                return false;
              }
              return true;
    }

    ///////////////////////////////////////////  Gestions service et offres   //////////////////////////////

    public function obtenirIdPersonneByIdMembre($idMembre)
    {
        $sql="select personne.personne_id from personne";
        $sql.=" join membre on personne.idMembre=membre.membre_id where membre.membre_id=$idMembre;";
        $q = $this->pdo->query($sql)->fetchColumn();
        return (int)$q;

    }

    public function estUnePersonne($idMembre)
    {
        $sql="select personne.personne_id from personne";
        $sql.=" join membre on personne.idMembre=membre.membre_id where membre.membre_id=$idMembre;";
        $q = $this->pdo->query($sql)->fetchColumn();
        return (bool)$q;
    }

    public function getNomsDepartements($filtreDpt)
    {
      
        $result = $this->pdo->prepare("SELECT nom FROM Departements WHERE nom LIKE :paramDepartement");
        $result->execute(array(':paramDepartement' => $filtreDpt));
        $data = array();
        foreach($result as $row)
        {
            array_push($data, $row['nom']);
        }
        return $data;
       
    }
  

    public function getVillesFranceParDpt($filtreVille, $filtreDpt)
    {
        $result = $this->pdo->prepare("SELECT Villes_france.ville_nom_reel FROM Villes_france INNER JOIN Departements ON  Villes_france.departement_code=Departements.num_departement WHERE Villes_france.ville_nom_simple LIKE :paramVille AND Departements.nom LIKE :paramDepartement");
        $result->execute(array(':paramVille' => $filtreVille, ':paramDepartement' => $filtreDpt));
        $data = array();
        foreach($result as $row)
        {
            array_push($data, $row['ville_nom_reel']);
        }   
        return $data;
    }


    public function getCodePostalParVille($filtreCodePostal, $filtreVille)
    {
        $result = $this->pdo->prepare("select ville_code_postal from Villes_france where ville_nom_reel LIKE :paramVille AND ville_code_postal LIKE :paramCp");
        $result->execute(array(':paramCp' => $filtreCodePostal, ':paramVille' => $filtreVille));
        $data = array();
        foreach($result as $row)
        {
            array_push($data, $row['ville_code_postal']);
        }   
        return $data;
    }


    public function insertAdrrPers($idMembre, $numRue, $adrrText, $dpt, $ville, $codePostal, $telephone, $sexe)
    {
        $clean_adrrText = $this->pdo->quote($adrrText);
        $clean_dpt = $this->pdo->quote($dpt);        
        $clean_ville = $this->pdo->quote($ville);       
        $clean_codePostal = $this->pdo->quote($codePostal);
        $clean_telephone = $this->pdo->quote($telephone);
        $clean_sexe = $this->pdo->quote($sexe);

        $sql = "insert into personne (idMembre, numRue, adrrText, dpt, ville, codePostal, telephone, sexe) ";
        $sql.= "values ($idMembre, $numRue, $clean_adrrText, $clean_dpt, $clean_ville, ";
        $sql.= "$clean_codePostal, $clean_telephone, $clean_sexe);";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }
    }   

    // lire infos Personne
    public function obtenirInfosPersonnes()
    {
        $sql="select * from personne;";
        $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());
        return $query;   
    }

    public function modifierInfosUnePersonne($idmembre, $numRue, $adrrText, $ville,$dpt, $codePostal, $telephone)
    {
        $clean_adrrText = $this->pdo->quote($adrrText);
        $clean_dpt = $this->pdo->quote($dpt);
        $clean_ville = $this->pdo->quote($ville);
        $clean_codePostal = $this->pdo->quote($codePostal);
        $clean_telephone = $this->pdo->quote($telephone);

        $sql="update personne set numRue = case when idMembre=$idmembre then $numRue end, ";
        $sql.= "adrrText = case when idMembre=$idmembre then $clean_adrrText end, ";
        $sql.="dpt = case when idMembre=$idmembre then $clean_dpt end, ";
        $sql.="ville = case when idMembre=$idmembre then $clean_ville end, ";
        $sql.="codePostal = case when idMembre=$idmembre then $clean_codePostal end, ";
        $sql.="telephone = case when idMembre=$idmembre then $clean_telephone end, ";
        $sql.="dateModif=now() where idMembre=$idmembre;";
        $q = $this->pdo->prepare($sql);
        $q->execute();
    }

    public function obtenirInfosUnepersonne($idMembre)
    {
        $sql="select * from personne where idMembre=$idMembre;";
        $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());
        return $query;
    }

    public function obtenirTags()
    {
        $sqlprep = $this->pdo->prepare("select tag_id, tagNom from tag;");
        $tab = array();
        $sqlprep->execute($tab);
        //$data = $sqlprep->fetchAll(PDO::FETCH_COLUMN, 0);

        while($row = $sqlprep->fetch())
        {
            echo '<option value="'.$row['tag_id'].'">'.$row['tagNom'].'</option>';
        }
    }

    public function obtenirNomTag($idTag)
    {
        $sql ="select tagNom from tag where tag_id=$idTag;";
        $q = $this->pdo->query($sql)->fetchColumn();
        return (string)$q;
    }


    // pour tester
    public function obtenirTableauTags()
    {
        $sql = "select tag_id, tagNom from tag; ";
        $q = $this->pdo->prepare($sql);
        $q->bindParam(':idTag', $tag_id);
        $q->bindParam(':tagNom',$tagNom);
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }
        // $result = $q->fetchAll();
        //         $result->execute();
        //                 $retour = $result->fetchAll();
        return $data;
    }
    public function creerArrayTags()
    {
        $sqlprep = $this->pdo->prepare("select tag_id, tagNom from tag;");
        $tab = array();
        $sqlprep->execute($tab);

        //$idTags = array();
        //while($row = $sqlprep->fetchAll(PDO::FETCH_COLUMN, 0))
        //{
        //    foreach ($row as $value)
        //    {
        //        array_push($idTags, $value);
        //    }
        //    //echo '<option value="'.$row['tag_id'].'">'.$row['tagNom'].'</option>';
        //}        

        $nomTags = array();
        while($row = $sqlprep->fetchAll(PDO::FETCH_COLUMN, 1))
        {
            foreach ($row as $value)
            {
                array_push($nomTags, $value);
            }
            //echo '<option value="'.$row['tag_id'].'">'.$row['tagNom'].'</option>';
        }        

        //return $idTags;
        return $nomTags;
    }  // fin test  
    
    // insertion offre

    public function insertTag($tag)
    {
        $clean_tag = $this->pdo->quote($tag);
        $sql = "INSERT INTO tag(tagNom) VALUES ($clean_tag);";    
        $q = $this->pdo->prepare($sql);
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
            $idTag = $this->pdo->lastInsertId();
            return $idTag;
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }
    }

    public function obtenirCleLogin($idMembre)
    {
        $sql ="select login.cle from login join membre on membre.idLogin=login.login_id where membre_id=$idMembre;";
        $q = $this->pdo->query($sql)->fetchColumn();
        return (string)$q;
    }

    public function insertOffreService($codeOffre, $idPersonne, $idTag, 
                                       $description, $dpt, $ville, $lieuElargi, 
                                       $typeOffre, $prix, $typePrix)
    {
        $clean_codeOffre = $this->pdo->quote($codeOffre);
        
        $clean_description = $this->pdo->quote($description);
        $clean_dpt = $this->pdo->quote($dpt);
        $clean_ville = $this->pdo->quote($ville);
        $clean_lieuElargi = $this->pdo->quote($lieuElargi);
        $clean_typeOffre = $this->pdo->quote($typeOffre);
        $clean_typePrix = $this->pdo->quote($typePrix);

        $sql ="insert into offre (codeOffre, idPersonne, idTag, descriptionOffre,";
        $sql.= "dpt, ville, lieuElargi, typeOffre, prix, typePrix) VALUES ";
        $sql.= "($clean_codeOffre, $idPersonne, $idTag,";
        $sql.= "$clean_description, $clean_dpt, $clean_ville, $clean_lieuElargi,";
        $sql.= "$clean_typeOffre, $prix, $clean_typePrix);";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }
    }


    public function insertDemande($codeOffre, $idPersonne, $idTag, 
                                  $description, $dpt, $ville, $lieuElargi, 
                                  $typeOffre)
    {
        $clean_codeOffre = $this->pdo->quote($codeOffre);
        
        $clean_description = $this->pdo->quote($description);
        $clean_dpt = $this->pdo->quote($dpt);
        $clean_ville = $this->pdo->quote($ville);
        $clean_lieuElargi = $this->pdo->quote($lieuElargi);
        $clean_typeOffre = $this->pdo->quote($typeOffre);

        $sql ="insert into offre (codeOffre, idPersonne, idTag, descriptionOffre,";
        $sql.= "dpt, ville, lieuElargi, typeOffre) VALUES ";
        $sql.= "($clean_codeOffre, $idPersonne, $idTag,";
        $sql.= "$clean_description, $clean_dpt, $clean_ville, $clean_lieuElargi,";
        $sql.= "$clean_typeOffre);";

        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }
    }

    public function nombreOffrePersonne($idMembre)// pas utilisee incrémentation à la place voir page sonCompte.php
    {
        $id = (int)$idMembre;
        $sql = "select count(offre.offre_id) from offre ";
        $sql.= "join personne on personne.personne_id=offre.idPersonne where personne.idMembre=$idMembre;";
        $q = $this->pdo->query($sql)->fetchColumn();
        //var_dump($q);
        return (int)$q;        
    }

    public function nombreTotalService()
    {
        // select count(offre.offre_id) from offre where codeOffre='P';
        $service = "P";
        $typeOffre = $this->pdo->quote($service);        
        $sql = "select count(offre.offre_id) from offre  where typeOffre=$typeOffre;";
        $q = $this->pdo->query($sql)->fetchColumn();
        //var_dump($q);
        return (int)$q;        
    }

    public function nombreTotalDemande()
    {
        // select count(offre.offre_id) from offre where codeOffre='P';
        $service = "D";
        $typeOffre = $this->pdo->quote($service);        
        $sql = "select count(offre.offre_id) from offre  where typeOffre=$typeOffre;";
        $q = $this->pdo->query($sql)->fetchColumn();
        //var_dump($q);
        return (int)$q;        
    }

    // update service
    // // fonction identique pour modifier les offres_service et les offres_demande
    public function modifierOffre($idOffre, $descriptionOffre, $dpt, $ville, $lieuElargi, $prix, $typePrix)    {
        $clean_description = $this->pdo->quote($descriptionOffre);
        $clean_dpt = $this->pdo->quote($dpt);
        $clean_ville = $this->pdo->quote($ville);
        $clean_lieuElargi = $this->pdo->quote($lieuElargi);
        $clean_typePrix = $this->pdo->quote($typePrix);

        $sql="update offre set descriptionOffre = case when offre_id=$idOffre then $clean_description end,";
        $sql.="dpt = case when offre_id=$idOffre then $clean_dpt end,";
        $sql.="ville = case when offre_id=$idOffre then $clean_ville end,";
        $sql.="lieuElargi = case when offre_id=$idOffre then $clean_lieuElargi end,";
        $sql.="prix = case when offre_id=$idOffre then $prix end,";
        $sql.="typePrix = case when offre_id=$idOffre then $clean_typePrix end,";
        $sql.="dateModif=now() where offre_id=$idOffre;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }   
    }




    //////////////////// read offre ////

    //    private $offre_id;
    //    private $codeOffre;
    //    private $cle;
    //    private $idPersonne;
    //    private $idMembre;
    //    private $idTag;
    //    private $tag;
    //    private $descriptionOffre;
    //    private $dateOuverture;
    //    private $dpt;
    //    private $ville;
    //    private $lieuElargi;
    //    //private $ouverte;
    //    private $typeOffre;
    //    private $prix;
    //    private $typePrix;/

    public function obtenirServices() // on a pas le nom du tag
    {
        $service = "P";
        $typeOffre = $this->pdo->quote($service);        
        $ouverte = 1;

        $sql = "select offre_id, codeOffre, idPersonne, idTag, descriptionOffre, dateOuverture,";
        $sql.= "dpt, ville, lieuElargi, prix, typePrix from offre where typeOffre=$typeOffre and ouverte=$ouverte;";  
        $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());

        return $query;        
    }

    public function obtenirDemande() // on a pas le nom du tag
    {
        $service = "D";
        $typeOffre = $this->pdo->quote($service);        
        $ouverte = 1;

        $sql = "select offre_id, codeOffre, idPersonne, idTag, descriptionOffre, dateOuverture,";
        $sql.= "dpt, ville, lieuElargi, prix, typePrix from offre where typeOffre=$typeOffre and ouverte=$ouverte;";  
        $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());

        return $query;        
    }

    public function obtenirServicesByPseudo($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);        
        $service = "P";
        $typeOffre = $this->pdo->quote($service);        
        $ouverte = 1;

        $sql ="select login.pseudo, offre.offre_id, offre.codeOffre, offre.idTag, offre.idPersonne,";
        $sql.="offre.descriptionOffre, offre.dateOuverture, offre.dpt, offre.ville, offre.lieuElargi,";
        $sql.="offre.prix, offre.typePrix from login join membre on membre.idLogin=login.login_id";
        $sql.=" join personne on personne.idMembre = membre.membre_id";
        $sql.=" join offre on offre.idPersonne = personne.personne_id";
        $sql.=" where login.pseudo =$clean_pseudo and typeOffre=$typeOffre and ouverte=$ouverte ;";
        $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());

        return $query;
    }


    public function nombreOffrePseudo($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);        
        $sql="select count(offre_id) from login join membre on membre.idLogin=login.login_id ";
        $sql.=" join personne on personne.idMembre = membre.membre_id ";
        $sql.=" join offre on offre.idPersonne = personne.personne_id where login.pseudo=$clean_pseudo;";
        $q = $this->pdo->query($sql)->fetchColumn(); 
        //var_dump($q);
        return (int)$q;         
    }

    public function obtenirUnServiceByIdOffre($idOffre)
    {
        $service = "P";
        $typeOffre = $this->pdo->quote($service);        
        $ouverte = 1;
        $sql = "select offre_id, codeOffre, idPersonne, idTag, descriptionOffre, dateOuverture,";
        $sql.= "dpt, ville, lieuElargi, prix, typePrix from offre where typeOffre=$typeOffre ";
        $sql.= " and ouverte=$ouverte and offre_id=$idOffre;"; 
        $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());

        return $query;           
    }

    public function obtenirUneDemandeByIdOffre($idOffre)
    {
        $service = "D";
        $typeOffre = $this->pdo->quote($service);        
        $ouverte = 1;
        $sql = "select offre_id, codeOffre, idPersonne, idTag, descriptionOffre, dateOuverture,";
        $sql.= "dpt, ville, lieuElargi, prix, typePrix from offre where typeOffre=$typeOffre ";
        $sql.= " and ouverte=$ouverte and offre_id=$idOffre;"; 
        $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());

        return $query;           
    }

    public function obtenirIndividuServicesByIdOffre($idOffre)
    {
        $sql ="select login.pseudo, membre.membre_id, membre.prenom, membre.nom, offre.offre_id ";
        $sql.= " from login join membre on membre.idLogin=login.login_id join personne ";
        $sql.= " on personne.idMembre = membre.membre_id join ";
        $sql.= " offre on offre.idPersonne = personne.personne_id where offre.idPersonne =$idOffre;";
        $q = $this->pdo->prepare($sql);
        $q->bindParam(':idMembre', $idMembre);
        $q->bindParam(':pseudo', $pseudo);
        $q->bindParam(':prenom', $prenom);
        $q->bindParam(':nom', $nom);
        //$q->execute() or die('Erreur SQL ! '.$q.'<br />'.mysql_error());
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($q);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }
        $data = $q->fetchAll();
        
        foreach ($data as $value)
        {
            //array_push($tab, $value);            
            return $value;
            
        }


        //todo

        //$retour = $this->pdo->query($sql)->fetchColumn() or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());
        //return $retour;

    }

    // supprimer un service pour l'administrateur ou le batch
    public function supprimerService($idOffre)
    {
        $sql="delete from offre where offre_id=$idOffre;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }    
    }

    public function suppressionServiceParUser($idOffre)
    {
        $ouverte = 0;
        $sql = "update offre set ouverte=$ouverte where offre_id=$idOffre;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }
    }

    ///////////////////////////////////////////  IDENTIFICATION   ///////////////////////////////////////////

    public function isPseudoExists($pseudo)
    {
        // On veut voir si tel pseudo ayant pour id $info existe. 
        $clean_info = $this->pdo->quote($pseudo);
        $q = $this->pdo->query("SELECT COUNT(*) FROM personne WHERE pseudo = $clean_info;")->fetchColumn();
        return (bool)$q;
    }

    public function obtenirMotPasseByPseudo($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $q = $this->pdo->query("select password from personne where pseudo = $clean_pseudo;")->fetchColumn();
        return $q;          
    }

    public function obtenirMotPasseByIdMembre($idMembre)
    {
        $sql ="select login.motPasse from membre join login on membre.idLogin=login.login_id where membre.membre_id=$idMembre;";
        $q = $this->pdo->query($sql)->fetchColumn();
        return (string)$q;  
    }

    public function estAdmin($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $q = $this->pdo->query("select isAdmin from membre join login on membre.idLogin=login_id 
                                    where pseudo=$clean_pseudo;")->fetchColumn();
        //var_dump((bool)$q);
        return (bool)$q;       
    }  

    public function obtenirIdMembreByPseudo($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $q= $this->pdo->query("select id from personne where pseudo = $clean_pseudo;")->fetchColumn();
        return $q;
    }         

    // pour identification par cookie : 
    public function insertCodeCookie($pseudo, $code)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $clean_code = $this->pdo->quote($code);
        $sql = "update login set codeCookie=$clean_code where pseudo=$clean_pseudo;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }    
    }

    public function obtenirCodeCookie($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $q = $this->pdo->query("select codeCookie from login where pseudo=$clean_pseudo")->fetchColumn();
        return (string)$q;  
    }

    // pour le mail de validation :
    public function insererCle($pseudo, $cle)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $clean_cle = $this->pdo->quote($cle);
        $sql = "update personne set cle = $clean_cle  where pseudo = $clean_pseudo;";
         try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table rien du tout';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          } 
    }

    public function obtenirCle($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $q = $this->pdo->query("select cle from personne where pseudo=$clean_pseudo;")->fetchColumn();
        return (string)$q; 
    }

    public function estActif($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $q = $this->pdo->query("select actif from personne where pseudo=$clean_pseudo;")->fetchColumn();
        return (bool)$q;        
    }   
    public function devientActif($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);      
        $sql = "update personne set actif=1 where pseudo=$clean_pseudo;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }      
    }
    // todo function pour trouver quels sont les membres qui ne sont plus actifs.
    // et qui appelle pour chaque compte qui ne devrait plus être actif la fonction deactiverCompte($pseudo)
    /*
MariaDB [comgocom]> select pseudo, actif, lastconnect, date_inscription, id_statut, id_role, id_abonnement from personne;
+----------+-------+---------------------+------------------+-----------+---------+---------------+
| pseudo   | actif | lastconnect         | date_inscription | id_statut | id_role | id_abonnement |
+----------+-------+---------------------+------------------+-----------+---------+---------------+
| hypathie |     1 | 2020-12-15 12:08:33 | 2020-12-10       |         1 |       1 |             1 |
| toto     |     1 | 2020-12-16 16:46:08 | 2020-12-10       |         3 |       3 |             2 |
| tstark   |     1 | 2020-12-16 16:46:29 | 2020-12-10       |         1 |       1 |             2 |
| titi     |     1 | 2020-12-16 16:46:39 | 2020-12-11       |         3 |       3 |             2 |
| popo     |     1 | 2020-12-16 16:46:48 | 2020-12-15       |         3 |       3 |             2 |
| popo74   |     1 | 2020-12-16 16:46:55 | 2020-12-15       |         3 |       3 |             2 |
| F123     |     0 | 2020-12-15 15:06:16 | 2020-12-15       |         7 |       4 |             2 |
| dd14     |     0 | 2020-12-15 15:21:04 | 2020-12-15       |         7 |       4 |             2 |
| oo12     |     0 | 2020-12-15 15:22:03 | 2020-12-15       |         7 |       4 |             2 |
+----------+-------+---------------------+------------------+-----------+---------+---------------+

        condition pour être actif : id_statut < 7 id_role < 4 
        condition pour continuer d'être actif : date de lastconnect - date actuel < à 12 mois 
    */

    public function deactiverCompte($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);      
        $sql = "update personne set actif=0 where pseudo=$clean_pseudo;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }
    }

    public function mailOk($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $q = $this->pdo->query("select mailok from personne where pseudo = $clean_pseudo;")->fetchColumn();
        return (bool)$q;        
    }

    public function devientMailOk($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);      
        $sql = "update personne set mailok = 1 where pseudo = $clean_pseudo;";
         try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }       
    }

    public function deactiverMailOk($pseudo)
    {
/*         $clean_pseudo = $this->pdo->quote($pseudo);      
        $sql = "update membre join login on membre.idLogin=login.login_id set mailOk=0 where login.pseudo=$clean_pseudo;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          } */
    }


    public function supprimerCle($pseudo)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $cleVide = '';
        $clean_cleVide = $this->pdo->quote($cleVide);       
        $sql ="update personne set cle=$clean_cleVide where pseudo=$clean_pseudo;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }
    }

    /////////////////////////////////////////////// CREATE /////////////////////////////////////////////


    public function isMembreExists($nom, $prenom, $numSecu)
    {
    // règles d'affaire : gestion des doublons (prénom et nom) avec numéro de sécu et clé crée à l'inscription 
    // se fait dans un deuxème temps pour membre type_abonnement != de 1 (non admin) et > à 2 (intromembre)
    }

    public function isNomPrenomExist($nom, $prenom)
    {
        $clean_nom = $this->pdo->quote($nom);
        $clean_prenom = $this->pdo->quote($prenom); 
        $q= $this->pdo->query("select count(nom) from personne where nom=$clean_nom AND prenom=$clean_prenom;")->fetchColumn();

        return (bool)$q;
    }




    /////////////////////////////////////////////// READ ////////////////////////////////

    public function obtenirLesPseudos()
    {
 /*        $sql = "select pseudo from login;";
        $q = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());
        $query = $q->fetchAll();
        return $query; */
    }

    // pour l'affichage de tous les membres et de toutes les infos les concernant :
    public function obtenirToutesInfosTousMembres()
    {
        // $sql = "select membre.membre_id, membre.prenom, membre.nom, membre.isAdmin,";
        // $sql.=" membre.dateInscription, membre.dateModif, login.login_id,";
        // $sql.=" login.pseudo, login.motPasse, login.cle, login.actif, login.mail, login.lastConnect from membre";
        // $sql.=" JOIN login on membre.idLogin=login_id;";
        // $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());

        // return $query;
    }



    // pour l'affichage de toutes les infos d'un membre :
    public function obtenirToutesInfosUnMembreById($idPersonne)
    {
        $sql = "select p.*, ab.id_type_abo, tabo.type as type_abonnement, r.role, st.libelle as statut from personne p";
        $sql.= " join statut st on p.id_statut=st.id join role r on p.id_role=r.id join abonnement ab on p.id_abonnement=ab.id";
        $sql.= " join type_abonnement tabo on ab.id_type_abo=tabo.id where p.id=$idPersonne;";
        //$sql = "select p.*,tabo.type as type_abonnement, ab.id_type_abo, r.role, st.libelle as statut from personne p join statut st on p.id_statut=st.id join role r on p.id_role=r.id join abonnement ab on p.id_abonnement=ab.id join type_abonnement tabo on ab.id_type_abo=tabo.id where p.id=2;";
        $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());

        return $query;
    }

    public function obtenirAdresse($idPersonne)
    {
        $clean_IdPersonne= (int)$idPersonne;
        $sql = "select adresse, ville, departement, codepostal, pays from personne where id=$clean_IdPersonne;";
        $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());

        return $query;
    }

    public function obtenirInfosComplementaires($idPersonne)
    {
        $sql = "select p.id_abonnement,tabo.type as type_abonnement , p.id_role,r.role, p.id_statut, st.libelle as statut";
        $sql.= "from personne p";
        $sql.= "join statut st on p.id_statut=st.id";
        $sql.= "join role r on p.id_role=r.id"; 
        $sql.= "join abonnement ab on p.id_abonnement=ab.id ";
        $sql.= "join type_abonnement tabo on ab.id_type_abo=tabo.id where p.id=$idPersonne;";
        $query = $this->pdo->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.mysql_error());

        return $query;
    }

   // public function obtenirToutesInfosUnMembreByPseudo($pseudo)
   // {
   //     $clean_pseudo = $this->pdo->quote($pseudo);
   //     $sql = "select membre.membre_id, membre.prenom, membre.nom, membre.isAdmin,";
   //     $sql.=" membre.dateInscription, membre.dateModif, login.login_id,";
   //     $sql.=" login.pseudo, login.motPasse, login.cle, login.actif, login.mail from membre";
   //     $sql.=" JOIN login on membre.idLogin=login_id where pseudo=$clean_pseudo;";
   //     $query = $this->pdo->query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());

   //     return $query;
   // }

    ////////////////////////////////////////////// UPDATE /////////////////////////////////////

    // Pour modifier un membre :

    // modifier login : on aura instancié un membre by idMembre en utilisant "obtenirIdMembreByPseudo($pseudo)"
    //                  du coup pour modifier que certains des paramètres
    //                  on renverra ceux récupérés qu'on ne souhaite pas modifier
    private function modifierLogin($idLogin, $cle, $actif, $mail)
    {
        // $clean_cle = $this->pdo->quote($cle);
        // $clean_mail = $this->pdo->quote($mail);
        // $sql = "update login set cle= case when login_id=$idLogin then $clean_cle end ";
        // $sql.=",actif= case when login_id=$idLogin then $actif end ";
        // $sql.=",mail=$clean_mail where login_id=$idLogin;";
        // //echo "<p>".$sql."</p>";
        // try{
        //     $this->pdo->beginTransaction();
        //     $this->pdo->exec($sql);
        //     //echo 'Entrée ajoutée dans la table historique_statut';
        //     $this->pdo->commit();
        //   }
        //   catch(PDOException $e){
        //     $this->pdo->rollBack();
        //     echo "Erreur : " . $e->getMessage();
        //   }
    }
    

    // $idLogin, $cle, $actif, $mail, $membreId, $nom, $prenom, $idAdmin
    public function modifierMembre($idLogin, $cle, $actif, $mail, $membreId, $nom, $prenom, $isAdmin)
    {
/*         $this->modifierLogin($idLogin, $cle, $actif, $mail); 

        $clean_isAdmin;
        if ($isAdmin == "zero")
        {
            $clean_isAdmin = 0;
        }
        else if ($isAdmin == "un")
        {
            $clean_isAdmin = 1;
        }
        $clean_nom = $this->pdo->quote($nom);
        $clean_prenom = $this->pdo->quote($prenom);   
        $sql = "update membre set prenom= case when membre_id = $membreId then $clean_prenom end "; 
        $sql.= ",nom = case when membre_id = $membreId then $clean_nom end ";
        $sql.= ",isAdmin = case when membre_id = $membreId then $clean_isAdmin end ";
        $sql.= ",dateModif=now() where membre_id= $membreId;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          } */
    }

    public function modifierMail($pseudo, $mail,$quelMail)
    {
        $clean_pseudo = $this->pdo->quote($pseudo);
        $clean_mail = $this->pdo->quote($mail);        
        $sql="update personne set $quelMail=$clean_mail where pseudo=$clean_pseudo;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }   
    }

    public function supprimerMail($ref,$quelMail)
    {
        $Vide="";  
        $mailVide = $this->pdo->quote($Vide);   
        $sql="update personne set $quelMail=$mailVide where id=$ref;";
        
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }       
    }

    public function modifierMotPasse($idPersonne, $motPasse)
    {
         $clean_motPasse = $this->pdo->quote($motPasse);
        $sql = "update personne set password=$clean_motPasse";
        $sql.= " where id=$idPersonne;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }
    }

    public function updateLastConnect($pseudo)
    {
        // $clean_pseudo = $this->pdo->quote($pseudo);
        // $sql = "update login set lastConnect=now() where pseudo=$clean_pseudo;";
        // try{
        //     $this->pdo->beginTransaction();
        //     $this->pdo->exec($sql);
        //     //echo 'Entrée ajoutée dans la table historique_statut';
        //     $this->pdo->commit();
        //   }
        //   catch(PDOException $e){
        //     $this->pdo->rollBack();
        //     echo "Erreur : " . $e->getMessage();
        //   }   
    }

    //////////////////////////////////////////////  delete  ////////////////////////////////////////////   

    public function supprimerMembre($idMembre)
    {
/* 
        $this->supprimerOffreByIdMembre($idMembre);
        $this->supprimerPersonneByIdMembre($idMembre);

        $sql = "delete login, membre from login inner join membre on membre.idLogin=login_id where membre_id=$idMembre;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          } */
    }

    private function supprimerOffreByIdMembre($idmembre)
    {
  /*       $sql = "delete offre from membre join personne on personne.idmembre = membre.membre_id ";
        $sql.=" join offre on offre.idPersonne=personne.personne_id where membre.membre_id=$idmembre;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          }  */  
    }

    private function supprimerPersonneByIdMembre($idMembre)
    {
/*         $sql = "delete personne from membre join personne on personne.idmembre = membre.membre_id ";
        $sql.= " where membre.membre_id=$idMembre;";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          } */
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////    insert message /////////////////////////////////////////////////////////


    public function insererMessageOffre($idOffre, $idMembre, $msg)
    {
/*         $clean_msg = $this->pdo->quote($msg);
        $sql = "insert into messageOffre (idOffre, idMembre, date, msg) values ($idOffre,$idMembre,now(),$clean_msg);";
        try{
            $this->pdo->beginTransaction();
            $this->pdo->exec($sql);
            //echo 'Entrée ajoutée dans la table historique_statut';
            $this->pdo->commit();
          }
          catch(PDOException $e){
            $this->pdo->rollBack();
            echo "Erreur : " . $e->getMessage();
          } */
    }

    public function obtenirTousMsgUneOffre($idOffre)
    {
/*         $sql = "select * from messageOffre where idOffre=$idOffre order by date DESC ;";// LIMIT 50 ?
        $result = $this->pdo->prepare($sql);
        $result->execute(array());
        $data = array();
        foreach($result as $row)
        {
            array_push($data, $row);
        }
        return $data; */
    }

    public function obtenirPseudoAyantCreeService($idOffre)
    {
/*         $sql = "select login.pseudo from messageOffre join offre on messageOffre.idOffre=offre.offre_id ";
        $sql .= " join personne on offre.idPersonne=personne.personne_id join membre ";
        $sql .= " on personne.idMembre=membre.membre_id join login on membre.idLogin=login.login_id ";
        $sql .= " where offre.offre_id=$idOffre;";
        $q = $this->pdo->query($sql)->fetchColumn();
        return $q; */

    }

    public function obtenirPseudoAyantLaisseMsg($idMembre)
    {
 /*        $sql = "select login.pseudo from membre join login on membre.idLogin=login.login_id ";
        $sql .= " where membre.membre_id=$idMembre;";
        $q = $this->pdo->query($sql)->fetchColumn();
        return $q; */
    }


}
