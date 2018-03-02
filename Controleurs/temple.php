<?php

/**
 *  @file
 *  @brief This script manage two case :
 *      1. It allow a member to see the different temple he possessed
 *      2. For each temple, he can see how much ressources and workers are allowed to it's construction 
 *		   The cost of the next level of construction 
 */
 
$_CSS[] = 'common.css';

require_once('Vues/Langage/FR/accueil.php');
require_once('Vues/Langage/FR/ressource.php');
require_once('Vues/Langage/FR/temple.php');

$titre = 'Temple';

$temples = array();


if(isset($_SESSION['id']))
{	
    // We want to know the informations of all member's temples
    foreach($_SESSION['data']->getVillages() as $village)
    {
		$villageTemple = $village->getTemple();
		
		// If there is a temple in this village
		if(!empty($villageTemple))
		{

			$_SQL = SQL::getInstance();

			$req = 'SELECT temple_id, level_id, inventory_id FROM temple_running_level WHERE temple_id = :id';

			$rep = $_SQL->prepare($req);

			$rep->execute(array(':id' => $village->getTemple()->getId()));

			$resultat = $rep->fetchAll();
			
			if(count($resultat) == 1)
			{
				$runningLvlInventory = new Inventory($resultat[0]['inventory_id']);
				$runningLvlInventory->loadFromId();
			}
			
			$temples[$village->getName()]['village'] = $village;
			$temples[$village->getName()]['temple'] = $village->getTemple();			
			$temples[$village->getName()]['inventory'] = $runningLvlInventory;
		}			
    }		

}


$donnees = ob_start();

require_once('Vues/Template/header.php');
require_once('Vues/Template/temple.php');
require_once('Vues/Template/footer.php');

ob_end_flush();

?>