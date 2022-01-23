<?php
$start = microtime(true);

error_reporting(E_ALL);

ini_set("display_errors", 1);

spl_autoload_register(function ($classe) {
    include 'Classes/' . $classe . '.php';
});

require_once('Vues/Langage/FR/footer.php');

$_SQL=  SQL::getInstance();

/*********************************/
/*              MAP              */
/*********************************/
$size = 21;
$half_size = 10;

for($i = -$half_size; $i <= $half_size; ++$i) {
    for($j = -$half_size; $j <= $half_size; ++$j) {
        Area::createArea($i, $j, $_SQL);
    }
}

/*********************************/
/*          RESOURCE             */
/*********************************/
$number_resources = 4;

for($i = 0; $i < $number_resources; ++$i) {
    Resource::createResource($_SQL);
}


if(Member::createMember('Alfanor', 'Alfanor', $_SQL)) {
    echo "SUCCESS";
}

else {
    echo "FAILURE";
}


$end = microtime(true);

echo $_LANGUAGE['FR']['FOOTER_EXECUTION'] . ' : ' . ($end - $start);
?>