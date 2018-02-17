<?php
class Village
{
    protected $id;    
    protected $name;
    protected $member;
    protected $inventory;
    protected $temple;

    private $_SQL;

    public function __construct(&$_SQL, $id)
    {
        $this->_SQL = $_SQL;
        $this->id = $id;
    }

    public function loadFromId()
    {
        $req = 'SELECT  v.id as v_id, 
                        v.name as v_name, 
                        v.member_id, 
                        v.inventory_id as v_inventory, 
                        t.id as t_id, 
                        t.name as t_name, 
                        t.inventory_id as t_inventory,
                        t.level as t_level 
                FROM village v 
                LEFT JOIN temple t ON t.village_id = v.id 
                WHERE v.id = :id';

        $rep = $this->_SQL->prepare($req);
        
        $rep->execute(array(':id' => $this->id));
        
        $resultat = $rep->fetchAll();

        if(count($resultat) == 1)
        {
            $this->name = $resultat[0]['v_name'];
            $this->inventory = new Inventory($this->_SQL, $resultat[0]['v_inventory']);
            $this->inventory->loadFromId();

            if(isset($resultat[0]['t_id']))
            {
                $this->temple = new Temple($this->_SQL, $resultat[0]['t_id']);
                    
                $this->temple->setName($resultat[0]['t_name']);
                $this->temple->setLevel($resultat[0]['t_level']);
                $this->temple->setInventory(new Inventory($this->_SQL, $resultat[0]['t_inventory']));
    
                if(!$this->temple->GetInventory()->loadFromId())
                    return false;
            }

            return true;
        }

        return false;
    }
    
    public static function loadMenuListFromMemberId(&$_SQL, $id)
    {
        $req = 'SELECT id, name FROM village WHERE member_id = :id';

        $rep = $_SQL->prepare($req);
        
        $rep->execute(array(':id' => $id));
        
        $resultat = $rep->fetchAll();

        if(count($resultat) > 0)
        {
            $villages = array();

            foreach($resultat as $village)
                $villages[$village['id']] = $village['name'];

            return $villages;
        }

        return false;
    }

    public static function loadListFromMemberId(&$_SQL, $id)
    {
        $req = 'SELECT  v.id as v_id, 
                        v.name as v_name, 
                        v.member_id, 
                        v.inventory_id as v_inventory, 
                        t.id as t_id, 
                        t.name as t_name, 
                        t.inventory_id as t_inventory,
                        t.level as t_level 
                FROM village v 
                LEFT JOIN temple t ON t.village_id = v.id 
                WHERE v.member_id = :id';

        $rep = $_SQL->prepare($req);
        
        $rep->execute(array(':id' => $id));
        
        $resultat = $rep->fetchAll();

        if(count($resultat) > 0)
        {
            $villages = array();
            $i = 0;

            foreach($resultat as $village)
            {
                // We store basics data
                $villages[$i] = new Village($_SQL, $village['v_id']);

                $villages[$i]->setName($village['v_name']);

                // We want all ressources
                $villages[$i]->setInventory(new Inventory($_SQL, $village['v_inventory']));
                $villages[$i]->getInventory()->loadFromId();

                // And we want to load the temple if is in this village
                // If there is village with temple, it's always the first
                if(isset($village['t_id']))
                {
                    $_SESSION['temple'] = true;

                    $villages[$i]->setTemple(new Temple($_SQL, $village['t_id']));
                    
                    $villages[$i]->getTemple()->setName($village['t_name']);
                    $villages[$i]->getTemple()->setLevel($village['t_level']);
                    $villages[$i]->getTemple()->setInventory(new Inventory($_SQL, $village['t_inventory']));
        
                    if(!$villages[$i]->getTemple()->GetInventory()->loadFromId())
                        return false;
                }

                ++$i;
            }

            return $villages;
        }

        return false;    
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getInventory()
    {
        return $this->inventory;
    }

    public function getTemple()
    {
        return $this->temple;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setInventory($inventory)
    {
        $this->inventory = $inventory;
    }

    public function setTemple($temple)
    {
        $this->temple = $temple;
    }
}
?>