<?php
class Temple
{
    protected $id;
    protected $inventory;
    protected $name;
    protected $level;

    private $_SQL;
    
    public function __construct($id)
    {
        $this->_SQL = SQL::getInstance();
        $this->id = $id;
    }

    /**
     *  @brief This method define the fields to save when we ask PHP for serialize a Temple object.
     *  @return returns the list of attribute to save
     */
    public function __sleep()
    {
        return array('id', 'inventory', 'name', 'level');
    }

    /**
     *  @brief This method get an reference on the current SQL instance when PHP deserialize a Temple object.
     */
    public function __wakeup()
    {
        $this->_SQL = SQL::getInstance();
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

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setInventory($inventory)
    {
        $this->inventory = $inventory;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }
}
?>