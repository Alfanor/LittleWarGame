<?php
class AreaRessource
{
    protected $id; //!<@brief The AreaRessource ID    
    protected $area; //!<@brief The Area this AreaRessource belong to
    protected $ressource; //!<@brief The Ressource on this AreaRessource
    protected $village; //!<@brief The Village this AreaRessource belong to
    protected $worker; //!<@brief The number of workers on this AreaRessource

    private $_SQL; //!<@brief Reference on the SQL connexion

    /**
     *  @brief Constructor for the class AreaRessource.
     *  @param $id the AreaRessource ID
     *  @return returns the initialized AreaRessource object
     */

    public function __construct($id)
    {
        $this->id = $id;
        $this->_SQL = SQL::getInstance();
    }

    /**
     *  @brief This method load the data about all the Village AreaRessource 
     *  @param id the Village Area ID
     *  @return returns a list of Village if it's succeed, false in the other case
     */
    public static function loadListFromVillageAreaId($id)
    {
        $_SQL = SQL::getInstance();

        $req = 'SELECT  ar.id,
                        ar.ressource_id,
                        vf.worker 
                FROM area_ressource ar
                LEFT JOIN village_farmer vf ON vf.area_ressource_id = ar.id 
                WHERE ar.area_id = :id';

        $rep = $_SQL->prepare($req);
        
        $rep->execute(array(':id' => $id));
        
        $resultat = $rep->fetchAll();

        if(count($resultat) > 0)
        {
            $area_ressources = array();
            $i = 0;

            foreach($resultat as $ar)
            {
                $area_ressources[$i] = new AreaRessource($ar['id']);
                $area_ressources[$i]->setRessource($ar['ressource_id']);
                $area_ressources[$i]->setWorker((!isset($ar['worker']) ? 0 : $ar['worker']));

                ++$i;
            }

            return $area_ressources;
        }

        return false;    
    }

    /**
     *  @brief This method define the fields to save when we ask PHP for serialize a AreaRessource object.
     *  @return returns the list of attribute to save
     */
    public function __sleep()
    {
        return array('id', 'ressource', 'worker');
    }

    /**
     *  @brief This method get an reference on the current SQL instance when PHP deserialize a Area object.
     */
    public function __wakeup()
    {
        $this->_SQL = SQL::getInstance();
    }

    /**
     *  @brief Getter for AreaRessource ID.
     *  @return returns the AreaResource ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *  @brief Getter for AreaRessource ressource.
     *  @return returns the AreaResource ressource
     */
    public function getRessource()
    {
        return $this->ressource;
    }

    /**
     *  @brief Getter for AreaRessource Worker.
     *  @return returns the AreaResource Worker
     */
    public function getWorker()
    {
        return $this->worker;
    }

    /**
     *  @brief Setter for AreaRessource ID.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *  @brief Setter for AreaRessource ressource.
     */
    public function setRessource($ressource)
    {
        $this->ressource = $ressource;
    }

    /**
     *  @brief Setter for AreaRessource Worker.
     */
    public function setWorker($worker)
    {
        $this->worker = $worker;
    }
}
?>