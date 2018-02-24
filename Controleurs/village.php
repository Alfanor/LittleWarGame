<?php
if(isset($_SESSION['id']))
{
    $_CSS[] = 'common.css';

    require_once('Vues/Langage/FR/village.php');
    require_once('Vues/Langage/FR/ressource.php');

    $titre = 'Village';

    $erreur = false;

    $membre = new Member($_SQL, $_SESSION['id']);

    // On récupère les données du vilage
    $village = new Village($_SQL, $_GET['id']);
    
    if(!$village->loadFromId())
        $erreur = true;

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