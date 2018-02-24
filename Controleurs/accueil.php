<?php
/**
 *  @file
 *  @brief This script manage two case :
 *      1. A new visitor is coming, we have to show the connexion form
 *      2. A member is now connected, we have to show his account resume
 */

$_CSS[] = 'common.css';

require_once('Vues/Langage/FR/accueil.php');
require_once('Vues/Langage/FR/ressource.php');

$titre = 'Accueil';

$compte_erreur = false;
$ressources = array();
$village_temple;

// Here, the visitor is now connected, so it's a Member
if(isset($_SESSION['id']))
{
    // We want to know the global amount of ressources for the member account
    foreach($_SESSION['data']->getVillages() as $village)
    {
        foreach($village->getInventory()->getRessources() as $id => $amount)
        {
            if(!isset($ressources[$id]))
                $ressources[$id] = 0;

            $ressources[$id] += $amount;
        }
    }

    // We need the village temple
    $village_temple = $_SESSION['data']->getVillages()[0];
}

$donnees = ob_start();

require_once('Vues/Template/header.php');
require_once('Vues/Template/accueil.php');
require_once('Vues/Template/footer.php');

ob_end_flush();
?>