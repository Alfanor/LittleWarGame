<?php
/**
 * @class Inventory Class
 * @brief This class store all Ressources belonging to another object like a Temple or a Village.
 */
class Inventory
{
    protected $id; //!<@brief The Inventory ID
    protected $ressources = array(); //!<@brief The Ressources list in this inventory
    
    private $_SQL; //!<@brief Reference on the SQL connexion

    /**
     *  @brief Constructor for the class Inventory.
     *  @param $id the Inventory ID
     *  @return returns the initialized Inventory object
     */
    public function __construct($id)
    {
        $this->_SQL = SQL::getInstance();
        $this->id = $id;
    }

    /**
     *  @brief This method load the ressources of this inventory based on the id attribute.
     *  @return returns true if it's succeed, false on the other case
     */
    public function loadFromId()
    {
        // We have to be sure that this Inventory exist
        $req = 'SELECT COUNT(id) as is_exist FROM inventory WHERE id = :id';
        $rep = $this->_SQL->prepare($req); 
       
        $rep->execute(array(':id' => $this->id));
        $resultat = $rep->fetchAll();
    
        if($resultat[0]['is_exist'] > 0)
        {  
            // Select all the ressources for this Inventory
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

        return false; 
    }

    /**
     *  @brief This method define the fields to save when we ask PHP for serialize a Inventory object.
     *  @return returns the list of attribute to save
     */
    public function __sleep()
    {
        return array('id', 'ressources');
    }

    /**
     *  @brief This method get an reference on the current SQL instance when PHP deserialize a Inventory object.
     */
    public function __wakeup()
    {
        $this->_SQL = SQL::getInstance();
    }

    /**
     *  @brief Getter for Inventory ID.
     *  @return returns the Inventory ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *  @brief Getter for Inventory Ressources list.
     *  @return returns the Inventory Ressources list
     */
    public function getRessources()
    {
        return $this->ressources;
    }
}
?>