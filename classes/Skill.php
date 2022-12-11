<?php declare(strict_types=1);


class Skill
{
    public string $name;
    public int $usagePercentage;
    public string $skillType;
    public string $description;

    public function __construct(string $name, int $usagePercentage, string $skillType, string $description)
    {
        $this->name = $name;
        $this->usagePercentage = $usagePercentage;
        $this->skillType = $skillType;
        $this->description = $description;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsagePercentage(): int
    {
        return $this->usagePercentage;
    }

    public function getSkillType(): string
    {
        return $this->skillType;
    }
}
