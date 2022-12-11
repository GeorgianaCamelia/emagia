<?php declare(strict_types=1);

require_once('helpers\WarriorPercentageCheck.php');

class EmagiaWarrior
{
    private string $name;
    protected int $health;
    protected int $strength;
    protected int $defence;
    protected int $speed;
    protected int $luck;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function initialize(array $properties): void
    {
        $this->health = $properties['health'];
        $this->strength = $properties['strength'];
        $this->defence = $properties['defence'];
        $this->speed = $properties['speed'];
        $this->luck = $properties['luck'];
    }

    public function getStats(): string
    {
        return "\nNAME: {$this->getName()} | HEALTH: {$this->getHealth()} | STRENGTH: {$this->getStrength()} | DEFENCE: {$this->getDefence()}";
    }

    public function getCompleteStats(): string
    {
        return "\nNAME: {$this->getName()}\nHEALTH: {$this->getHealth()}\nSTRENGTH: {$this->getStrength()}\nDEFENCE: {$this->getDefence()}\nSPEED: {$this->getSpeed()}\nLUCK: {$this->getLuck()}%\n";
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function getDefence(): int
    {
        return $this->defence;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getLuck(): int
    {
        return $this->luck;
    }

    public function attack(): int
    {
        return $this->getStrength();
    }

    public function defend(): int
    {
        return $this->getDefence();
    }

    public function applyDamage(int $damage): void
    {
        $this->health -= $damage > 0 ? $damage : 0;
    }

    public function amILucky(): bool
    {
        return WarriorPercentageCheck::returnCheck($this->getLuck());
    }
}
