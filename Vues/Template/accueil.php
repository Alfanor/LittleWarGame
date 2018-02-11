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
        echo '  <ul>
                    <li>' . $_LANGUAGE['FR']['RESUME_TEMPLE_NAME'] . ' ' . $membre->getTemple()->GetName() . '</li>
                    <li>' . $_LANGUAGE['FR']['RESUME_TEMPLE_LEVEL'] . ' ' . $membre->getTemple()->getLevel() . '</li>
                    <li>' . $_LANGUAGE['FR']['RESUME_RESSOURCES'] . '<ul>';

        foreach($membre->getInventory()->getRessources() as $id => $amount)
            echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $amount . '</li>';

        echo '  </ul>
                    <li>' . $_LANGUAGE['FR']['RESUME_TEMPLE_RESSOURCES'] . '<ul>';

        foreach($membre->getTemple()->getInventory()->getRessources() as $id => $amount)
            echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $amount . '</li>';

        echo '</ul>  </ul>';
    }
}
?>