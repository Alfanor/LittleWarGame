<?php
/**
 * @class Round Class
 * @brief This class is the core of the generation Round.
 */
final class Round
{
    /**
     *  @brief This method read the file round_number.
     *  @return returns the value in the file, false in the other case
     */
    static function getRoundNumber()
    {
        $round_number = file_get_contents('round_number');
    
        return $round_number;
    }

    /**
     *  @brief This method add one to the value in the file round_number.
     *  @return returns true on success, false in the other case
     */
    static function incrementRoundNumber()
    {
        $round_number = file_get_contents('round_number');

        if($round_number !== false)
        {
            $round_number++;

            if(file_put_contents('round_number', (string) $round_number))
                return true;

            return false;
        }

        return false;
    }

    /**
     *  @brief This method generate a new round.
     *  @return returns true on success, false in the other case
     */
    static function generateRound()
    {
        $_SQL = SQL::getInstance();

        // We have to update all the village inventory based on the number of worker for each ressource
        // We have to use just some subparts of object to be fast as possible
        $villages = Village::selectVillagesDataForRoundGeneration();

        // Make a big INSERT request with DUPLICATE KEY to UPDATE all inventory data
        $req = 'INSERT INTO inventory_ressource (inventory_id, ressource_id, amount) VALUES ';

        foreach($villages as $village)
        {
            $area_ressources = $village->getAreaRessource();

            foreach($area_ressources as $ar)
            {
                if( ($village == end($villages)) && ($ar == end($area_ressources)) )
                    $req .= '(' . $village->getInventory()->getId() . ', ' . $ar->getRessourceId() . ', ' . $ar->getWorker() . ') ';

                else
                    $req .= '(' . $village->getInventory()->getId() . ', ' . $ar->getRessourceId() . ', ' . $ar->getWorker() . '), ';
            }
        }

        $req .= 'ON DUPLICATE KEY UPDATE amount = amount + VALUES(amount)';

        $rep = $_SQL->prepare($req);

        $rep->execute();

        if($rep->rowCount() > 0)
        {
            // We have to increment the round number
            Round::incrementRoundNumber();

            return true;
        }

        return false;
    }
}
?>