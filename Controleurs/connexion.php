<?php
/**
 *  @file
 *  @brief This script job is te find if the member exist and store all data about it
 *  in SESSION to limit the amount of needed SQL request on each page (0 until the 
 *  member ask for some modifications)
 */
if(!empty($_POST['login']) && !empty($_POST['password']))
{
    $_SQL = SQL::getInstance();

    $req = 'SELECT id, login, password FROM member WHERE login = :login';
    
    $rep = $_SQL->prepare($req);
    
    $rep->execute(array(':login' => $_POST['login']));
    
    $resultat = $rep->fetchAll();

    if(count($resultat) == 1)
    {
        if(password_verify($_POST['password'], $resultat[0]['password']))
        {
            // We can store some specific data in SESSION to access it easily
            $_SESSION['id'] = $resultat[0]['id'];

            // Load all member data
            // It's supposed to be the only SQL job until the member ask for an action
            // other than just show some data
            $member = new Member($_SESSION['id']);
            $member->loadAccountDataFromMemberId();

            // It's not possible to have no village
            if(!is_array($member->getVillages()))
            {
                header('Location: index.php?p=deconnexion');
            }
    
            // Store the object in SESSION
            $_SESSION['data'] = $member;

            // We want to know if a new round is generate when the member 
            // is connected to update his session data
            $_SESSION['last_round_update'] = Round::getRoundNumber();

            header('Location: index.php?p=accueil');
            
            exit();
        }

        header('Location: index.php?erreur=1');
        
        exit();
    }

   
    header('Location: index.php?erreur=1');
        
    exit();
}
?>