<?php

foreach($temples as $nomVivi => $contenu)
{
	foreach($contenu as $value => $donnee)
	{
		if($value == "temple")
		{
			echo sprintf($_LANGUAGE['FR']['TEMPLE_ACTUELS'],$donnee->getLevel(),$nomVivi);
		}	
	}
	
	echo "<br/><br/>";
}







?>