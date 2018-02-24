<?php
if(isset($_SESSION['id']) && ($village !== false))
{
    echo sprintf($_LANGUAGE['FR']['VILLAGE_RESUME'], $village->getName() . ' (' . $village->getArea()->getX() . ' | ' . $village->getArea()->getY() . ')');

    echo '<br /><br />' . $_LANGUAGE['FR']['VILLAGE_AREA'];

    echo '<ul>';

    foreach($village->getAreaRessource() as $ar)
        echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $ar->getRessource()] . ' : ' . $ar->getWorker() . ' ' . $_LANGUAGE['FR']['VILLAGE_WORKER'] . '</li>';

    echo '</ul>';

    echo '<br />' . $_LANGUAGE['FR']['VILLAGE_RESSOURCES'];

    echo '<ul>';

    foreach($village->getInventory()->getRessources() as $id => $amount)
        echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $amount . '</li>';

    echo '</ul>';

    if(!empty($village->getTemple()))
    {
        echo '<br />' . sprintf($_LANGUAGE['FR']['VILLAGE_TEMPLE'], $village->getTemple()->getLevel());

        echo '<ul>';

        foreach($village->getTemple()->getInventory()->getRessources() as $id => $amount)
            echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $amount . '</li>';

        echo '</ul>';
    }

    else
        echo '<br />';
}

else
    header('location : index.php?p=accueil');
?>