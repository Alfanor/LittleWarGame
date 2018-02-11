<?php
class Temple
{
    protected $id;
    protected $inventory;
    protected $name;
    protected $level;

    private $_SQL;
    
    public function __construct(&$_SQL)
    {
        $this->_SQL = $_SQL;
    }

    public function loadFromMemberId($member_id)
    {
        $req = 'SELECT id, inventory_id, name, level FROM temple WHERE member_id = :member_id';
    
        $rep = $this->_SQL->prepare($req);
        
        $rep->execute(array(':member_id' => $member_id));
        
        $resultat = $rep->fetchAll();

        if(count($resultat) == 1)
        {
            $this->id = $resultat[0]['id'];
            $this->id_membre = $member_id;
            $this->name = $resultat[0]['name'];
            $this->level = $resultat[0]['level'];

            $this->inventory = new Inventory($this->_SQL, $resultat[0]['inventory_id']);

            if($this->inventory->loadFromId())
                return true;

            return false;
        }

        return false;
    } 

    public function getId()
    {
        return $this->id;
    }

    public function getInventory()
    {
        return $this->inventory;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getLevel()
    {
        return $this->level;
    }
}
?>