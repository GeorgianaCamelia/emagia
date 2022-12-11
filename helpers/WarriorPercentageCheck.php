<?php declare(strict_types=1);

const MOST_CHANCES = 100;
const  NO_CHANCES = 1;

class WarriorPercentageCheck
{
    /**
     * Used to determine whether or not the warrior is lucky this turn or if one of the skill can be used.
     * @param int $percentageToCheck
     * @return bool
     */
    public static function returnCheck(int $percentageToCheck): bool
    {
        return $percentageToCheck <= rand(NO_CHANCES, MOST_CHANCES) ? true : false;
    }
}
