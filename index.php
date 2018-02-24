<?php
error_reporting(E_ALL);

ini_set("display_errors", 1);

function __autoload($classe) {
    include 'Classes/' . $classe . '.php';
}

session_start();

require_once('Configuration/Page.php');
require_once('Vues/Langage/FR/menu.php');

$_CSS = array();
$_JS = array();

(!empty($_GET['p'])) ? ($page_demandee = $_GET['p']) : ($page_demandee = null);

if(in_array($page_demandee, $public_pages))
{
    require_once('Controleurs/' . $page_demandee . '.php');
}

else if(!empty($_SESSION['id']) && in_array($page_demandee, $member_pages))
{
    require_once('Controleurs/' . $page_demandee . '.php');
}

else
{
    require_once('Controleurs/accueil.php');
}
?>