<?php
class Inventory
{
    protected $id;
    protected $ressources = array();
    
    private $_SQL;

    public function __construct(&$_SQL, $id)
    {
        $this->_SQL = $_SQL;

        $this->id = $id;
    }

    /**
     *  This function get the ressources of the inventory.
     *  Be careful, it's supposed that the id is always correct !
     */
    public function loadFromId()
    {
        // Select all the ressources for this inventory
        $req = 'SELECT ressource_id, amount FROM inventory_ressource WHERE inventory_id = :id';
    
        $rep = $this->_SQL->prepare($req);
        
        $rep->execute(array(':id' => $this->id));
        
        $resultat = $rep->fetchAll();

        if(count($resultat) > 0)
        {
            foreach($resultat as $ressource)
                $this->ressources[$ressource['ressource_id']] = $ressource['amount'];
        }

        return true; 
    }

    public function getRessources()
    {
        return $this->ressources;
    }
}
?>