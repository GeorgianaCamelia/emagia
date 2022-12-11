<?php


class Utils
{
    public static function loading(string $loadingSign = "※", int $loadingTime = 10000)
    {
        for ($i = 0; $i < 100; $i++) {
            echo $loadingSign;
            usleep($loadingTime);
        }
    }
}
