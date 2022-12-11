<?php

require_once('Utils.php');

class Stats
{
    public static function writeStatsToConsole(string $turnStats)
    {
        echo $turnStats;
        Utils::loading('');
    }
}
