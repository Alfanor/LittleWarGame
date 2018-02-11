<?php
if(!isset($_SESSION['id']))
{
    if(isset($_GET['erreur']) && ($_GET['erreur'] == 1))
        echo '<p>Vous croyez vraiment que vous allez passer en me donnant un nom au hasard ? Vous n\'avez pas intérêt à continuer comme ça mon gars !</p>';

    else
        echo '<p>Hey ! Vous êtes qui vous ? Vous n\'irez pas plus loin tant que vous ne vous serez pas identifié mon gars !</p>';
    ?>

    <form method="post" action="?p=connexion"> 
        <strong>Nom</strong><input type="text" name="login" maxlength="20" />
        <strong>Passe</strong><input type="password" name="password" />
        <input type="submit" value="S'identifier" />
    </form> 

    <?php    
}

else
{    
    echo '<p>Il serait temps de vous mettre à travailler ! Pour le moment vous êtes notre leader, mais si vous continuez à dormir je peux vous dire que vous allez vite finir dans le fleuve ! Voici un rapport de la situation actuelle :</p>';

    if($compte_erreur)
        echo '<p>Hum... En fait votre temple est introuvable ! Vous devriez penser à prier nos dieux pour le retrouver !</p>';

    else
    {
        echo '  <ul>
                    <li>Nom de votre temple : ' . $membre->getTemple()->GetName() . '</li>
                    <li>Niveau de votre temple : ' . $membre->getTemple()->getLevel() . '</li>
                    <li>Ressources que vous possédez : <ul>';

        foreach($membre->getInventory()->getRessources() as $id => $quantite)
            echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $quantite . '</li>';

        echo '</ul>
                    <li>Ressources affectées au temple : <ul>';

        foreach($membre->getTemple()->getInventory()->getRessources() as $id => $quantite)
            echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $quantite . '</li>';

        echo '</ul>  </ul>';
    }
}
?>