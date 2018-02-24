<?php
if(isset($_SESSION['id']))
{
    $_CSS[] = 'common.css';

    require_once('Vues/Langage/FR/village.php');
    require_once('Vues/Langage/FR/ressource.php');

    $titre = 'Village';

    $village = false;
    
    // We have to know if the village ID exist
    foreach($_SESSION['data']->getVillages() as $v) {
        if($v->getId() == $_GET['id']) {
            $village = $v;

            break;
        }
    }

    $donnees = ob_start();

    require_once('Vues/Template/header.php');
    require_once('Vues/Template/village.php');
    require_once('Vues/Template/footer.php');

    ob_end_flush();
}

else
{
    header('Location : index.php');
}
?>