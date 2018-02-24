<?php
if(!isset($_SESSION['id']))
{
    if(isset($_GET['erreur']) && ($_GET['erreur'] == 1))
        echo '<p>' . $_LANGUAGE['FR']['CONNEXION_ERROR'] . '</p>';

    else
        echo '<p>' . $_LANGUAGE['FR']['CONNEXION'] . '</p>';
    ?>

    <form method="post" action="?p=connexion"> 
        <strong>Nom</strong><input type="text" name="login" maxlength="20" />
        <strong>Passe</strong><input type="password" name="password" />
        <input type="submit" value="<?php echo $_LANGUAGE['FR']['CONNEXION_FORM']; ?>" />
    </form> 

    <?php    
}

else
{    
    echo '<p>' . $_LANGUAGE['FR']['ACCUEIL_MESSAGE'] . '</p>';

    if($compte_erreur)
        echo '<p>' . $_LANGUAGE['FR']['ACCUEIL_ERROR'] . '</p>';

    else
    {
        // Village list and global ressources
        echo $_LANGUAGE['FR']['RESUME_VILLAGES'];
        echo '<ul>';
        
        foreach($_SESSION['data']->getVillages() as $village)
            echo '<li>' . $village->getName() . '</li>';

        echo '</ul><br />';

        echo $_LANGUAGE['FR']['RESUME_RESSOURCES'];
        echo '<ul>';

        foreach($ressources as $id => $amount)
            echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $amount . '</li>';

        echo '</ul><br />';

        // If there is a temple, we can list onformations about it
        if(isset($_SESSION['temple']))
        {
            echo $_LANGUAGE['FR']['RESUME_TEMPLE'];

            echo '  <ul>
                        <li>' . $_LANGUAGE['FR']['RESUME_TEMPLE_VILLAGE'] . ' ' . $village_temple->GetName() . '</li>
                        <li>' . $_LANGUAGE['FR']['RESUME_TEMPLE_NAME'] . ' ' . $village_temple->getTemple()->GetName() . '</li>
                        <li>' . $_LANGUAGE['FR']['RESUME_TEMPLE_LEVEL'] . ' ' . $village_temple->getTemple()->getLevel() . '</li>
                        <li>' . $_LANGUAGE['FR']['RESUME_TEMPLE_RESSOURCES'] . '
                            <ul>';

            foreach($village_temple->getTemple()->getInventory()->getRessources() as $id => $amount)
                echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $amount . '</li>';

            echo '          </ul> 
                        </li> 
                    </ul>';
        }
    }
}
?>