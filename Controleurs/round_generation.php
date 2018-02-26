<?php
if(isset($_SESSION['id']))
{
    $_CSS[] = 'common.css';

    require_once('Vues/Langage/FR/round_generation.php');

    $titre = 'Round Generation';

    $fraud = true;

    // This is just a little protection but it's enough (just change it on production ^^)
    if( isset($_GET['hash_key']) && 
        ($_GET['hash_key'] == '4d52684a2a86a010678c1928f1054bb09589f2941ef14d6ed9d333a86f5afc3935be4e62d18e1b6dc3e0c04f4f44f5cb28f62ee9bede9c8e70724e43944898ee'))
    {
        $fraud = false;

        $erreur = false;

        if(!Round::GenerateRound())
            $erreur = true;   
    }

    $donnees = ob_start();

    require_once('Vues/Template/header.php');
    require_once('Vues/Template/round_generation.php');

    ob_end_flush();
}

else
{
    header('Location : index.php');
}
?>