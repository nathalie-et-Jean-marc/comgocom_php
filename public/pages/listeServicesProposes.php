<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

?>


<div>
    <h3>Listes des services proposés</h3>
        <div>
<table id="tabResumerServices" class="display" width="100%" cellspacing="0">        
            <?php
                $infos = $managerPagesMembre->afficherResumerInfoServices();
            ?>      

</table>
        </div>



    </br>
    <a href="ajouterSonService.php">Ajoutez votre service</a>


</div>
