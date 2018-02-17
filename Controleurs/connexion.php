<?php
if(!empty($_POST['login']) && !empty($_POST['password']))
{
    $req = 'SELECT id, login, password FROM member WHERE login = :login';
    
    $rep = $_SQL->prepare($req);
    
    $rep->execute(array(':login' => $_POST['login']));
    
    $resultat = $rep->fetchAll();

    if(count($resultat) == 1)
    {
        if(password_verify($_POST['password'], $resultat[0]['password']))
        {
            $_SESSION['login'] = $resultat[0]['login'];
            $_SESSION['id'] = $resultat[0]['id'];

            // Au passage on va récupérer les villages du membre pour les stocker en session
            // et pouvoir les afficher dans le menu sans devoir recharger les informations à chaque page
            $villages = Village::loadMenuListFromMemberId($_SQL, $_SESSION['id']);

            // Il est impossible de ne pas avoir de village
            if($villages === false)
            {
                header('Location : index.php?p=deconnexion');
            }

            $_SESSION['villages'] = $villages;
            
            header('Location: index.php');
            
            exit();
        }

        header('Location: index.php?erreur=1');
        
        exit();
    }

   
    header('Location: index.php?erreur=1');
        
    exit();
}
?>