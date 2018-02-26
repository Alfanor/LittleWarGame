<?php
$start = microtime(true);

error_reporting(E_ALL);

ini_set("display_errors", 1);

function autoloader($class) {
    include 'Classes/' . $class . '.php';
}

spl_autoload_register('autoloader');

session_start();

require_once('Configuration/Page.php');
require_once('Vues/Langage/FR/menu.php');
require_once('Vues/Langage/FR/footer.php');

$_CSS = array();
$_JS = array();

(!empty($_GET['p'])) ? ($page_demandee = $_GET['p']) : ($page_demandee = null);

if(!isset($_SESSION['id']) && in_array($page_demandee, $public_pages))
{
    require_once('Controleurs/' . $page_demandee . '.php');
}

else if(!empty($_SESSION['id']) && in_array($page_demandee, $member_pages))
{
    // First, we have to update SESSION data if it's necessary
    $round_number = Round::getRoundNumber();

    if($_SESSION['last_round_update'] != $round_number)
    {
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
        $_SESSION['last_round_update'] = $round_number;
    }

    require_once('Controleurs/' . $page_demandee . '.php');
}

else
{
    require_once('Controleurs/accueil.php');
}

$end = microtime(true);

require_once('Vues/Template/footer.php');
?>