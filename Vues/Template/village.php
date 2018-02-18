<?php
echo sprintf($_LANGUAGE['FR']['VILLAGE_RESUME'], $village->getName());

if(!empty($village->getTemple()))
{
    echo '<br /><br />' . sprintf($_LANGUAGE['FR']['VILLAGE_TEMPLE'], $village->getTemple()->getLevel());

    echo '<ul>';

    foreach($village->getTemple()->getInventory()->getRessources() as $id => $amount)
        echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $amount . '</li>';

    echo '</ul>';
}

else
    echo '<br />';

echo '<br />' . $_LANGUAGE['FR']['VILLAGE_RESSOURCES'];

echo '<ul>';

foreach($village->getInventory()->getRessources() as $id => $amount)
    echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $amount . '</li>';

echo '</ul><br />';
?>