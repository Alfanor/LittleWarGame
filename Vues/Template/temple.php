<?php

foreach($temples as $nomVivi => $contenu)
{
	foreach($contenu as $value => $donnee)
	{
		switch($value)
		{
			case 'village':
				$currentVillage = $donnee;
				break;
			
			case 'temple':
				$currentTemple = $donnee;
				break;
			
			case 'inventory':
				$currentInventory = $donnee;
				break;
		}
	}
	
	echo "Id du temple actuel : ".$currentTemple->getId()."<br/><br/>";
	
	echo sprintf($_LANGUAGE['FR']['TEMPLE_ACTUELS'],$currentTemple->getLevel(),$currentVillage->getName())."<br/><br/>";
	

	
	if(isset($currentInventory))
	{
		echo $_LANGUAGE['FR']['TEMPLE_RESSCONSOMMEES'];	
		
		echo '<ul>';

		foreach($currentInventory->getRessources() as $id => $amount)
			echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $amount . '</li>';

		echo '</ul>';	
	}
	
	
	echo "<br/>".$_LANGUAGE['FR']['TEMPLE_RESSDISPO'];
	
    echo '<ul>';

    foreach($currentTemple->getInventory()->getRessources() as $id => $amount)
        echo '<li>' . $_LANGUAGE['FR']['RESSOURCE_' . $id] . ' : ' . $amount . '</li>';

    echo '</ul>';	
	
	
	
	echo "<br/><br/>";
	
}







?>