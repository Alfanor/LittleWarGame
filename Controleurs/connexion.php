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