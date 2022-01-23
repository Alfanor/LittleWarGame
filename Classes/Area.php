<?php
/**
 * @class Area Class
 * @brief This class store information about a map Area.
 */
class Area
{
    protected $id; //!<@brief The Area ID
    protected $x; //!<@brief The Area X coordinate
    protected $y; //!<@brief The Area Y coordinate

    private $_SQL; //!<@brief Reference on the SQL connexion

    /**
     *  @brief Constructor for the class Area.
     *  @param $id the Area ID
     *  @return returns the initialized Area object
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->_SQL = SQL::getInstance();
    }

    /**
     *  @brief This method load all information of this Area based on the id attribute.
     *  @return returns true if it succeed, false on the other case
     */
    public function loadFromId()
    {
        // We want to select all informations of this Area but only in the case that this Area exist
        $req = 'SELECT x, y FROM area WHERE id = :id';
       
        $rep = $this->_SQL->prepare($req); 
       
        $rep->execute(array(':id' => $this->id));
        $resultat = $rep->fetchAll();
    
        // If there is no result, the Area not exist
        if(count($resultat) > 0)
        {
            $this->x = $resultat[0]['x']; 
            $this->y = $resultat[0]['y'];   

            return true;
        }

        return false; 
    }

    /**
     *  @brief This method define the fields to save when we ask PHP for serialize an Area object.
     *  @return returns the list of attribute to save
     */
    public function __sleep()
    {
        return array('id', 'x', 'y');
    }

    /**
     *  @brief This method get an reference on the current SQL instance when PHP deserialize an Area object.
     */
    public function __wakeup()
    {
        $this->_SQL = SQL::getInstance();
    }

    /**
     * @brief This method create a new area in the database.
     * @param $x the x coordinate
     * @param $y the y coordinate
     * @return true on success, false on failure
     */
    public static function createArea($x, $y, $_SQL) {
        $req = 'INSERT INTO area(x, y) VALUES(:x, :y)';
    
        $rep = $_SQL->prepare($req);
        
        $rep->execute(array(':x' => $x, ':y' => $y));

        if($rep->rowCount() == 1) {
            return true;
        }

        return false;
    }

    /**
     *  @brief Getter for Area ID.
     *  @return returns the Area ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *  @brief Getter for Area X coordinate.
     *  @return returns the Area X coordinate
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     *  @brief Getter for Area Y coordinate.
     *  @return returns the Area Y coordinate
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     *  @brief Setter for Area ID.
     *  @param $id the Area ID
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *  @brief Setter for Area X coordinate.
     *  @param $x the x coordinate
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     *  @brief Setter for Area Y coordinate.
     *  @param $y the y coordinate
     */
    public function setY($y)
    {
        $this->y = $y;
    }
}
?>