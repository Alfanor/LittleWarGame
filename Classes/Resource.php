<?php
/**
 * @class Resource Class
 * @brief This class store information about a specific resource.
 */
class Resource
{
    protected $id; //!<@brief The Resource ID
   
    private $_SQL; //!<@brief Reference on the SQL connexion

    /**
     *  @brief Constructor for the class Resource.
     *  @param $id the Resource ID
     *  @return returns the initialized Resource object
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->_SQL = SQL::getInstance();
    }

    /**
     *  @brief This method define the fields to save when we ask PHP for serialize a Resource object.
     *  @return returns the list of attributes to save
     */
    public function __sleep()
    {
        return array('id');
    }

    /**
     *  @brief This method get an reference on the current SQL instance when PHP deserialize a Resource object.
     */
    public function __wakeup()
    {
        $this->_SQL = SQL::getInstance();
    }

    /**
     * @brief This method create a new resource in the database.
     * @return true on success, false on failure
     */
    public static function createResource($_SQL) {
        $req = 'INSERT INTO resource VALUES(DEFAULT)';
    
        $rep = $_SQL->query($req);

        if($rep->rowCount() == 1) {
            return true;
        }

        return false;
    }

    /**
     *  @brief Getter for Resource ID.
     *  @return returns the Resource ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *  @brief Setter for Resource ID.
     *  @param $id the Resource ID
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
?>