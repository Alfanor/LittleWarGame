<?php
$_CSS[] = 'common.css';

require_once('Vues/Langage/FR/accueil.php');
require_once('Vues/Langage/FR/ressource.php');

$titre = 'Accueil';

$compte_erreur = false;

if(isset($_SESSION['id']))
{
    $membre = new Member($_SQL, $_SESSION['id']);

    if(!$membre->loadAccountDataFromMemberId())
        $compte_erreur = true;  
}

$donnees = ob_start();

require_once('Vues/Template/header.php');
require_once('Vues/Template/accueil.php');
require_once('Vues/Template/footer.php');

ob_end_flush();
?>