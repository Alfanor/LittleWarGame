<?php
final class Round
{
    static function getRoundNumber()
    {
        $round_number = file_get_contents('round_number');
    
        return $round_number;
    }
}
?>