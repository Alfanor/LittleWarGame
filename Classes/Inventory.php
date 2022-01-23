<?php
/**
 * @class Inventory Class
 * @brief This class store all Ressources belonging to another object like a Temple or a Village.
 */
class Inventory
{
    protected $id; //!<@brief The Inventory ID
    protected $resources = array(); //!<@brief The Resources list in this inventory
    
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
     *  @brief This method load the resources of this inventory based on the id attribute.
     *  @return returns true if it's succeed, false on the other case
     */
    public function loadFromId()
    {
        // We want to select all resources of this Inventory, only in the case that this inventory exist
        $req = 'SELECT  (CASE 
                            WHEN inv.id IS NULL THEN 1
                            ELSE 0
                        END) AS unknow_id, ir.resource_id, ir.amount 
                FROM 
                    inventory AS inv
                LEFT JOIN 
                    inventory_resource AS  ir
                    ON ir.inventory_id = inv.id
                WHERE inv.id = :id';
       
        $rep = $this->_SQL->prepare($req); 
       
        $rep->execute(array(':id' => $this->id));
        $resultat = $rep->fetchAll();
    
        // If there is no result, the inventory not exist
        if(count($resultat) > 0)
        {
            foreach($resultat as $resource)
                $this->resources[$resource['resource_id']] = $resource['amount'];               

            return true;
        }

        return false; 
    }

    /**
     *  @brief This method define the fields to save when we ask PHP for serialize an Inventory object.
     *  @return returns the list of attribute to save
     */
    public function __sleep()
    {
        return array('id', 'resources');
    }

    /**
     *  @brief This method get an reference on the current SQL instance when PHP deserialize an Inventory object.
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
     *  @brief Getter for Inventory Resources list.
     *  @return returns the Inventory Resources list
     */
    public function getResources()
    {
        return $this->resources;
    }
}
?>