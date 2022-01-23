<?php
/**
 * @class Member Class
 * @brief This class is the core of the projet because it store all informations about villages, 
 * so all informations about the member.
 */
class Member {
    protected $id; //!<@brief The Member ID
    protected $login; //!<@brief The Member login
    protected $password; //!<@brief The Member password (hash)

    protected $villages; //!<@brief List of Village object

    private $_SQL; //!<@brief Reference on the SQL connexion

    /**
     *  @brief Constructor for the class Member.
     *  @param $id the Member ID
     *  @return returns the initialized Member object
     */
    public function __construct($id)
    {
        $this->_SQL = SQL::getInstance();
        $this->id = $id;
    }

    /**
     *  @brief This method load all data about this Member to store them in SESSION.
     *      - Village list
     *          - Workers in the Village
     *          - Temple in the Village
     *          - Buildings in the Village
     *  @return returns true if it's succeed, false in the other case
     */
    public function loadAccountDataFromMemberId()
    {
        // Select all villages is like select all Member data
        $this->villages = Village::loadListFromMemberId($this->id);

        if(is_array($this->villages))
            return true;

        return false;  
    }

    /**
     *  @brief This method define the fields to save when we ask PHP for serialize a Member object.
     *  @return returns the list of attribute to save
     */
    public function __sleep()
    {
        return array('id', 'login', 'villages');
    }

    /**
     *  @brief This method get an reference on the current SQL instance when PHP deserialize a Member object.
     */
    public function __wakeup()
    {
        $this->_SQL = SQL::getInstance();
    }

    /**
     * @brief This method create a new member in the database.
     * @param $username the user login
     * @param $password the user password
     * @param $_SQL, an SQL instance
     * @return true on success, false on failure
     */
    public static function createMember($login, $password, $_SQL) {
        $req = 'INSERT INTO member(login, password) VALUES(:login, :password)';
    
        $rep = $_SQL->prepare($req);
        
        $rep->execute(array(':login' => $login, 
                            ':password' => password_hash($password, PASSWORD_BCRYPT)));

        if($rep->rowCount() == 1) {
            return true;
        }

        return false;
    }
    
    /**
     *  @brief Getter for Member ID.
     *  @return returns the Member ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *  @brief Getter for Member Login.
     *  @return returns the Member Login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     *  @brief Getter for Member Village list.
     *  @return returns the Member Village list
     */
    public function getVillages()
    {
        return $this->villages;
    }
}
?>