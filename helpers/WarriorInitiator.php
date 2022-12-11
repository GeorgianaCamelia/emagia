<?php declare(strict_types=1);

const ATTACK_SKILL = 'ATTACK_SKILL';
const DEFEND_SKILL = 'DEFEND_SKILL';

class WarriorInitiator
{
    public static function propertiesFromRage(array $rageForProperties)
    {
        return [
            'health' => rand($rageForProperties['health'][0], $rageForProperties['health'][1]),
            'strength' => rand($rageForProperties['strength'][0], $rageForProperties['strength'][1]),
            'defence' => rand($rageForProperties['defence'][0], $rageForProperties['defence'][1]),
            'speed' => rand($rageForProperties['speed'][0], $rageForProperties['speed'][1]),
            'luck' => rand($rageForProperties['luck'][0], $rageForProperties['luck'][1]),
        ];
    }
}
