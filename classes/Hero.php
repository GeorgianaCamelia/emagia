<?php declare(strict_types=1);

require_once('EmagiaWarrior.php');
require_once('helpers/SkillsInitiator.php');


class Hero extends EmagiaWarrior
{
    private array $skills;

    public function initialize(array $properties, array $skills = []): void
    {
        parent::initialize($properties);
        $this->skills = $skills;
    }

    public function getSkills(string $skillType): array
    {
        return $skillType
            ? array_filter($this->skills, function (Skill $skill) use ($skillType) {
                return $skill->getSkillType() === $skillType;
            })
            : $this->skills;
    }

    public function getSkillsToApply(string $skillType)
    {
        return SkillsInitiator::checkSkillToApply($this->getSkills($skillType));
    }
}
