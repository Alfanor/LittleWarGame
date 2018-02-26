<?php
/**
 *  @file
 *  @brief This script goal is to insert data for a new server.
 *  Be careful, you need to remove it on production server !
 */
ini_set("display_errors", "1");

error_reporting(E_ALL);

function autoloader($class) {
    include '../Classes/' . $class . '.php';
}

spl_autoload_register('autoloader');

$_SQL = SQL::getInstance();

// Array ressource_id => probability on each area
$ressources = array(1 => 100, 2 => 75, 3 => 50, 4 => 100);

// Array building_id => array(id_inventory, temple_level, population)
$buildings = array(
                        1 => array(1, 0, 0), 
                        2 => array(2, 1, 25),
                        3 => array(3, 2, 75),
                        4 => array(4, 5, 100),
                        5 => array(5, 10, 200),
                        6 => array(6, 10, 200)
                );

// Array inventory_id => array(ressource_id, amount)
$inventories = array(
                        1 => array(1 => 40),
                        2 => array(1 => 30, 2 => 20),
                        3 => array(1 => 20, 2 => 40),
                        4 => array(1 => 30, 2 => 60, 3 => 20),
                        5 => array(1 => 20, 2 => 90),
                        6 => array(1 => 50, 2 => 120)
                    );

// Array level_id => inventory_id
$temple_cost_level = array();

$wood_level_1 = 20;
$stone_level_1 = 10;

for($i = 0; $i < 10; $i++)
{
    $temple_cost_level[$i] = end($buildings)[0] + $i + 1;

    // Populate the inventory :)
    $inventories[end($buildings)[0] + $i + 1] = array(1 => $wood_level_1 * ($i + 1), 2 => $wood_level_1 * ($i + 1));
}

// Map generation
$map_size = 51;

// Array area_id => array(x, y, array(id_ressource))
$area = array();

$id = 0;

for($y = -(floor($map_size / 2)); $y <= floor($map_size / 2); $y++)
{
    for($x = -(floor($map_size / 2)); $x <= floor($map_size / 2); $x++)
    {
        $area_ressource = array();

        foreach($ressources as $key => $probability)
            if(rand(0, 99) <= $probability)
                $area_ressource[] = $key;

        $area[++$id] = array($x, $y, $area_ressource);   
    }
}

// Array member
$member = array(1, 'LittleWarGame', password_hash('LittleWarGame', PASSWORD_DEFAULT));

// Villages
end($inventories);
$key = key($inventories);

$villages = array(
                    1 => array(rand(1, $map_size * $map_size), 1, $key + 1, 'Sparte', 100),
                    2 => array(rand(1, $map_size * $map_size), 1, $key + 2, 'Athènes', 120)
                );

$inventories[$key + 1] = array(1 => 0);
$inventories[$key + 2] = array(1 => 0);

// One temple
end($inventories);
$key = key($inventories);

$temple = array(1 => array(1, $key + 1, 'Temple d\'Arès', 0, 0));

$inventories[$key + 1] = array(1 => 0);

// Go to make ressource request insertion
$req = 'INSERT INTO ressource VALUES ';

end($ressources);
$last_id_ressources = key($ressources);

foreach($ressources as $id => $probability)
{
    if($last_id_ressources == $id)
        $req .= '(' . $id . ', ' . $probability . ')';

    else
        $req .= '(' . $id . ', ' . $probability . '), ';
}

echo $req . '<br />';

// Go to make area and area_ressource request
$req_area = 'INSERT INTO area (id, x, y) VALUES ';
$req_ar = 'INSERT INTO area_ressource (ressource_id, area_id) VALUES ';

end($area);

$last_area_id = key($area);

foreach($area as $area_id => $data)
{
    if($last_area_id == $area_id)
    {
        $req_area .= '(' . $area_id . ', ' . $data[0] . ', ' . $data[1] . ') ';
    }

    else
        $req_area .= '(' . $area_id . ', ' . $data[0] . ', ' . $data[1] . '), ';

    foreach($data[2] as $res_id)
    {
        if( ($last_area_id == $area_id) && (end($data[2]) == $res_id) )
            $req_ar .= '(' . $res_id . ', '. $area_id . ') ';

        else
            $req_ar .= '(' . $res_id . ', ' . $area_id . '), ';
    }
}

//echo $req_area . '<br />';
//echo $req_ar . '<br />';

// Go to make inventory request insertion
$req_inv = 'INSERT INTO inventory VALUES ';
$req_res = 'INSERT INTO inventory_ressource VALUES ';

end($inventories);

$last_inv_id = key($inventories);
$last_res_id = null;

foreach($inventories as $inv_id => $res)
{
    if($last_inv_id == $inv_id)
    {
        $req_inv .= '(' . $inv_id . ') ';

        end($res);
        $last_res_id = key($res);

    }

    else
        $req_inv .= '(' . $inv_id . '), ';

    foreach($res as $res_id => $amount)
    {
        if( ($last_inv_id == $inv_id) && ($last_res_id == $res_id) )
            $req_res .= '(' . $inv_id . ', '. $res_id . ', ' . $amount . ') ';

        else
            $req_res .= '(' . $inv_id . ', ' . $res_id . ', ' . $amount . '), ';
    }
}

//echo $req_inv . '<br />';
echo $req_res . '<br />';

// Go to make building request
$req_build = 'INSERT INTO building VALUES ';

end($buildings);
$last_building_id = key($buildings);

foreach($buildings as $id => $data)
{
    if($id == $last_building_id)
        $req_build .= '(' . $id . ', ' . $data[0] . ', ' . $data[1] . ', ' . $data[2] . ') '; 

    else
        $req_build .= '(' . $id . ', ' . $data[0] . ', ' . $data[1] . ', ' . $data[2] . '), '; 
}

//echo $req_build . '<br />';

// Go to make Temple cost level request
$req_temple_cost = 'INSERT INTO temple_cost_level VALUES ';

end($temple_cost_level);
$last_temple_id = key($temple_cost_level);

foreach($temple_cost_level as $id => $inv_id)
{
    if($last_temple_id == $id)
        $req_temple_cost .= '(' . $id . ', ' . $inv_id . ')';

    else
        $req_temple_cost .= '(' . $id . ', ' . $inv_id . '), ';
}

//echo $req_temple_cost . '<br />';

// Go to create member
$req_member = 'INSERT INTO member VALUES (' . $member[0] . ', "' . $member[1] . '", "' . $member[2] . '")';

echo $req_member . '<br />';

// Go to create villages
$req_village = 'INSERT INTO village VALUES ';

end($villages);
$last_village_id = key($villages);

foreach($villages as $id => $data)
{
    if($last_village_id == $id)
        $req_village .= '(' . $id . ', ' . $data[0] . ', ' . $data[1] . ', ' . $data[2] . ', "' . $data[3] . '", ' . $data[4] . ') ';

    else
        $req_village .= '(' . $id . ', ' . $data[0] . ', ' . $data[1] . ', ' . $data[2] . ', "' . $data[3] . '", ' . $data[4] . '), ';
}

echo $req_village . '<br />';

// Go to create Temple
$req_temple = 'INSERT INTO temple VALUES (' . key($temple) . ', ' . $temple[1][0] . ', ' . $temple[1][1] . ', "' . $temple[1][2] . '", ' . $temple[1][3] . ', ' . $temple[1][4] . ')';

echo $req_temple . '<br />';

$_SQL->beginTransaction();

try {
    $_SQL->exec($req);
    $_SQL->exec($req_area); // ok
    $_SQL->exec($req_ar);
    $_SQL->exec($req_inv); // ok
    $_SQL->exec($req_res);
    $_SQL->exec($req_build); // ok
    $_SQL->exec($req_temple_cost); // ok
    $_SQL->exec($req_member);
    $_SQL->exec($req_village);
    $_SQL->exec($req_temple);

    $_SQL->commit();
}

catch(PDOException $e) {
    echo 'Pouet : ' . $e->getMessage();
    $_SQL->rollBack();
}
?>