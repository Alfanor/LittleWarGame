<?php
class AreaRessource
{
    protected $id; //!<@brief The AreaRessource ID    
    protected $area; //!<@brief The Area this AreaRessource belong to
    protected $ressource_id; //!<@brief The Ressource ID on this AreaRessource
    protected $id_village; //!<@brief The Village this AreaRessource belong to
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
                $area_ressources[$i]->setRessourceId($ar['ressource_id']);
                $area_ressources[$i]->setWorker((!isset($ar['worker']) ? 0 : $ar['worker']));

                ++$i;
            }

            return $area_ressources;
        }

        return false;    
    }

    public static function updateAreaRessourceWorkerListOnVillage($new_ar, $old_ar, $village)
    {
        // We have to be sure that the modification are possibles
        $number_workers = 0;

        foreach($new_ar as $ar)
        {
            if($ar->getWorker() < 0)
                return false;

            $number_workers += $ar->getWorker();
        }

        foreach($old_ar as $ar)
        {
            $number_workers += $ar->getWorker();
        }

        if($number_workers > $village->getPopulation())
            return false;

        $_SQL = SQL::getInstance();

        // If we have enough population and nothing lesser than 0, it's ok
        $req = 'INSERT INTO village_farmer(village_id, area_ressource_id, worker) VALUES ';

        foreach($new_ar as $ar)
        {
            if($ar != end($new_ar))
                $req .= '(' . $village->getId() . ', ' . $ar->getId() . ', ' . $ar->getWorker() . '),';

            else
                $req .= '(' . $village->getId() . ', ' . $ar->getId() . ', ' . $ar->getWorker() . ')' ;
        }

        $req .= ' ON DUPLICATE KEY UPDATE worker = VALUES(worker)';

        $rep = $_SQL->prepare($req);

        $rep->execute();

        if($rep->rowCount() == (count($new_ar) * 2))
        {
            // We have to modify SESSION values
            foreach($_SESSION['data']->getVillages() as &$v)
            {
                if($v->getId() == $village->getId())
                {
                    foreach($v->getAreaRessource() as &$ar)
                    {
                        if(isset($new_ar[$ar->getId()]))
                            $ar->setWorker($new_ar[$ar->getId()]->getWorker());
                    }
                }
            }

            return true;
        }

        return false;
    }

    /**
     *  @brief This method define the fields to save when we ask PHP for serialize a AreaRessource object.
     *  @return returns the list of attribute to save
     */
    public function __sleep()
    {
        return array('id', 'ressource_id', 'worker');
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
     *  @brief Getter for AreaRessource ressource ID.
     *  @return returns the AreaResource ressource ID
     */
    public function getRessourceID()
    {
        return $this->ressource_id;
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
    public function setRessourceID($ressource_id)
    {
        $this->ressource_id = $ressource_id;
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