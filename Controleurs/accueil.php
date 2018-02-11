<?php
$_CSS[] = 'common.css';

require_once('Vues/Langage/FR/accueil.php');
require_once('Vues/Langage/FR/ressource.php');

$titre = 'Accueil';

$compte_erreur = false;
$ressources = array();
$village_temple;

if(isset($_SESSION['id']))
{
    $membre = new Member($_SQL, $_SESSION['id']);

    if(!$membre->loadAccountDataFromMemberId())
        $compte_erreur = true;  

    else
    {
        // We want the village id with the temple if there is a temple
        if(isset($_SESSION['temple']))
            $village_temple = $membre->getVillages()[0];

        // We want to know the global amount of ressources for the member account
        foreach($membre->getVillages() as $village)
        {
            foreach($village->getInventory()->getRessources() as $id => $amount)
            {
                if(!isset($ressources[$id]))
                    $ressources[$id] = 0;

                $ressources[$id] += $amount;
            }
        }
    }
}

$donnees = ob_start();

require_once('Vues/Template/header.php');
require_once('Vues/Template/accueil.php');
require_once('Vues/Template/footer.php');

ob_end_flush();
?>