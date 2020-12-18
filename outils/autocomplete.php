<?php

require 'ManagerAutocomplete.class.php';
$managerAutocomplete = new ManagerAutocomplete();




if($_GET['type'] == 'departements'){   

    $data = $managerAutocomplete->getNomsDepartements($_GET['filtreDepartement'].'%');
    echo json_encode($data);
}



if($_GET['type'] == 'villes'){   

    $data = $managerAutocomplete->getVillesFranceParDpt($_GET['filtreVille'].'%', $_GET['filtreDepartement'].'%');
    echo json_encode($data);
} 


if($_GET['type'] == 'codePostal'){   

    $data = $managerAutocomplete->getCodePostalParVille($_GET['filtreCp'].'%', $_GET['filtreV'].'%');
    echo json_encode($data);
} 

