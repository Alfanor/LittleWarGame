<?php
class Member {
    protected $id;
    protected $login;
    protected $password;

    protected $villages;

    private $_SQL;

    public function __construct(&$_SQL, $id)
    {
        $this->_SQL = $_SQL;
        $this->id = $id;
    }

    public function loadAccountDataFromMemberId()
    {
        // We don't care bout member data, $_SESSION already store them
        // So, here, member id is already checked

        // We need to find member village
        // TODO : When a member have several villages, it's important to select only the one with the temple
        $this->villages = Village::loadListFromMemberId($this->_SQL, $this->id);

        if(is_array($this->villages))
            return true;

        return false;  
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getVillages()
    {
        return $this->villages;
    }
}
?>