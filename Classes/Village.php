<?php
/**
 * @class Village Class
 * @brief This class is the core of the game because all other objects are link to it.
 */
class Village
{
    protected $id; //!<@brief The Village ID    
    protected $name; //!<@brief The Village name
    protected $member; //!<@brief The Member who own this Village
    protected $inventory; //!<@brief The Inventory of this Village
    protected $temple; //!<@brief The Temple of this village (if there is one)

    private $_SQL; //!<@brief Reference on the SQL connexion

    /**
     *  @brief Constructor for the class Village.
     *  @param $id the Village ID
     *  @return returns the initialized Village object
     */
    public function __construct($id)
    {
        $this->_SQL = SQL::getInstance();
        $this->id = $id;
    }

    /**
     *  @brief This method load the data about this Village :
     *          - Workers in the Village
     *          - Temple in the Village
     *          - Buildings in the Village
     *  @return returns true if it's succeed, false in the other case
     */
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

    /**
     *  @brief This method load the data about all the Member Village :
     *          - Workers in the Village
     *          - Temple in the Village
     *          - Buildings in the Village
     *  @param id the Member ID
     *  @return returns a list of Village if it's succeed, false in the other case
     */
    public static function loadListFromMemberId($id)
    {
        $_SQL = SQL::getInstance();

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
                $villages[$i] = new Village($village['v_id']);

                $villages[$i]->setName($village['v_name']);

                // We want all ressources
                $villages[$i]->setInventory(new Inventory($village['v_inventory']));
                $villages[$i]->getInventory()->loadFromId();

                // And we want to load the temple if is in this village
                // If there is village with temple, it's always the first
                if(isset($village['t_id']))
                {
                    $_SESSION['temple'] = true;

                    $villages[$i]->setTemple(new Temple($village['t_id']));
                    
                    $villages[$i]->getTemple()->setName($village['t_name']);
                    $villages[$i]->getTemple()->setLevel($village['t_level']);
                    $villages[$i]->getTemple()->setInventory(new Inventory($village['t_inventory']));
        
                    if(!$villages[$i]->getTemple()->GetInventory()->loadFromId())
                        return false;
                }

                ++$i;
            }

            return $villages;
        }

        return false;    
    }

    /**
     *  @brief This method define the fields to save when we ask PHP for serialize a Village object.
     *  @return returns the list of attribute to save
     */
    public function __sleep()
    {
        return array('id', 'name', 'member', 'inventory', 'temple');
    }

    /**
     *  @brief This method get an reference on the current SQL instance when PHP deserialize a Village object.
     */
    public function __wakeup()
    {
        $this->_SQL = SQL::getInstance();
    }

    /**
     *  @brief Getter for Village ID.
     *  @return returns the Village ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *  @brief Getter for Village name.
     *  @return returns the Village name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *  @brief Getter for Village Inventory.
     *  @return returns the Village Inventory
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     *  @brief Getter for Village Temple.
     *  @return returns the Village Temple
     */
    public function getTemple()
    {
        return $this->temple;
    }

    /**
     *  @brief Setter for Village name.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *  @brief Setter for Village Inventory.
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     *  @brief Setter for Village Temple.
     */
    public function setTemple($temple)
    {
        $this->temple = $temple;
    }
}
?>