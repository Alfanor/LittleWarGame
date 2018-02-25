<?php
if(isset($_SESSION['id']))
{
    $_CSS[] = 'common.css';
    $_CSS[] = 'village.css';

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

    if(!$village)
    {
        header('location : index.php?p=accueil');
        
        exit;
    }

    $error = array('action_1' => false);

    // If there is a village and this village belong to the connected member
    // We have to check for an potential action
    if(isset($_GET['action']))
    {
        // The member want to modify some farmer affectation
        if($_GET['action'] == 1)
        {
            $new_ar = array();
            $old_ar = array();

            // We have to check for the sending values
            foreach($village->getAreaRessource() as $ar)
            {
                if(isset($_POST['change_' . $ar->getRessourceId()]) && is_numeric($_POST['change_' . $ar->getRessourceId()]))
                {
                    $new_ar[$ar->getId()] = new AreaRessource($ar->getId());
                    $new_ar[$ar->getId()]->setWorker($ar->getWorker() + $_POST['change_' . $ar->getRessourceId()]);
                    $new_ar[$ar->getId()]->setRessourceId($ar->getRessourceId());
                }

                else
                {
                    $old_ar[] = $ar;
                }
            }

            // Now we have the data to check and save
            if(!AreaRessource::updateAreaRessourceWorkerListOnVillage($new_ar, $old_ar, $village))
                $error['action_1'] = true;
        }
    }

    $donnees = ob_start();

    require_once('Vues/Template/header.php');
    require_once('Vues/Template/village.php');

    ob_end_flush();
}

else
{
    header('Location : index.php');
}
?>