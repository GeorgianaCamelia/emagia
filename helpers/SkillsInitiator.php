<?php declare(strict_types=1);

require_once('classes/Skill.php');

const RAPID_STRIKE = 'Rapid strike';
const MAGIC_WAVE = 'Magic ware';
const MAGIC_SHIELD = 'Magic shield';

class SkillsInitiator
{
    public static function createSkills()
    {
        return [
            new Skill('Rapid strike', 10, ATTACK_SKILL, 'Strike twice in a turn'),
//            new Skill('Magic ware', 5, ATTACK_SKILL, 'Release a magic wave of 50% power'),
            new Skill('Magic shield', 20, DEFEND_SKILL, 'Takes only half of the damage'),
        ];
    }

    public static function checkSkillToApply(array $skills)
    {
        $applySkills = [];
        /**
         * @var Skill $skill
         */
        foreach ($skills as $skill) {
            if (WarriorPercentageCheck::returnCheck($skill->getUsagePercentage())) {
                $applySkills[] = $skill;
            }
        }
        return $applySkills;
    }
}
