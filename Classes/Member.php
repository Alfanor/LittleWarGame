<?php
class Member {
    protected $id;
    protected $login;
    protected $password;

    protected $temple;
    protected $inventory;

    private $_SQL;

    public function __construct(&$_SQL, $id)
    {
        $this->_SQL = $_SQL;

        $this->id = $id;
    }

    public function loadAccountDataFromMemberId()
    {
        // We don't care bout member data, $_SESSION already store them
        // So, here, $id is already checked
        $this->temple = new Temple($this->_SQL);
        
        if(!$this->temple->loadFromMemberId($this->id))
            return false;

        $this->inventory = new Inventory($this->_SQL, $_SESSION['inventory_id']);

        if(!$this->inventory->loadFromId())
            return false;

        return true;        
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getTemple()
    {
        return $this->temple;
    }

    public function getInventory()
    {
        return $this->inventory;
    }
}
?>