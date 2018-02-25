<?php
if(isset($_SESSION['id']) && ($village !== false))
{
    echo sprintf($_LANGUAGE['FR']['VILLAGE_RESUME'], $village->getName() . ' (' . $village->getArea()->getX() . ' | ' . $village->getArea()->getY() . ')');

    echo '<br /><br />' . $_LANGUAGE['FR']['VILLAGE_POPULATION'] . ' ' . $village->getPopulation();

    echo '<br /><br />' . $_LANGUAGE['FR']['VILLAGE_AREA'] . '<br /><br />';

    echo '  <form method="POST" action="?p=village&amp;id=' . $village->getId() . '&amp;action=1">
                <table class="village">
                    <thead>
                        <tr>
                            <td>' . ucfirst($_LANGUAGE['FR']['RESSOURCE']) . '</td>
                            <td>' . ucfirst($_LANGUAGE['FR']['VILLAGE_WORKER']) . '</td>
                            <td>' . ucfirst($_LANGUAGE['FR']['VILLAGE_CHANGE']) . '</td>
                        </tr>
                    </thead>
                    <tbody>';

    foreach($village->getAreaRessource() as $ar)
    {
        echo '<tr>
                <td>' . ucfirst($_LANGUAGE['FR']['RESSOURCE_' . $ar->getRessourceId()]) . '</td>
                <td class="right_text">' . $ar->getWorker() . '</td>
                <td><input type="text" name="change_' . $ar->getRessourceId() . '" /></td>
            </tr>';
    }

    echo '  <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td><input type="submit" value="' . $_LANGUAGE['FR']['VILLAGE_VALIDER'] . '" /></td>
            </tr>';

    echo '</tbody></table></form>';

    if($error['action_1'])
        echo '<br /><span class="error">' . $_LANGUAGE['FR']['VILLAGE_ERREUR_ACTION_1'] . '</span><br />';

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