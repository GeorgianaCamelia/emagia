<?php declare(strict_types=1);

require_once('EmagiaWarrior.php');
require_once('helpers/Stats.php');

const MAX_TURNS = 20;

class Battle
{
    private int $turns;
    private Hero $hero;
    private EmagiaWarrior $beast;

    protected bool $heroAttacks = false;
    protected bool $luckyDefender;
    protected int $currentAttack;
    protected int $currentDefend;
    protected int $currentDamage;
    protected array $currentSkills;
    protected array $battleTurnStats;

    public function __construct(Hero &$hero, EmagiaWarrior &$beast)
    {
        $this->turns = 0;
        $this->hero = $hero;
        $this->beast = $beast;
    }

    public function start(): void
    {
        $this->heroAttacks = $this->heroAttacksFirst();
        while ($this->turns < MAX_TURNS && $this->isAnyoneAlive()) {
            $this->initTurn();
            echo "\nTURN: {$this->turns}\n";
            if ($this->heroAttacks) {
                echo "\nATTACKER: {$this->hero->getName()}\nDEFENDER: {$this->beast->getName()}";
            } else {
                echo "\nATTACKER: {$this->beast->getName()}\nDEFENDER: {$this->hero->getName()}";
            }
            if ($this->heroAttacks) {
                $this->currentAttack = $this->hero->attack();
                $this->luckyDefender = $this->beast->amILucky();
                if (!$this->luckyDefender) {
                    $this->currentDefend = $this->beast->defend();
                    $this->setDamage($this->calculateDamage($this->currentAttack, $this->currentDefend));
                    echo "\nNORMAL ATT. | {$this->currentAttack} | {$this->currentDefend} | {$this->currentDamage}";
                    // check hero attack skills
                    $this->applyHeroSkills(ATTACK_SKILL);

                    $this->beast->applyDamage($this->currentDamage);
                }
            } else {
                $this->currentAttack = $this->beast->attack();
                $this->luckyDefender = $this->hero->amILucky();
                if (!$this->luckyDefender) {
                    $this->currentDefend = $this->hero->defend();
                    $this->setDamage($this->calculateDamage($this->currentAttack, $this->currentDefend));
                    echo "\nNORMAL ATT. | {$this->currentAttack} | {$this->currentDefend} | {$this->currentDamage}";
                    // check hero defend skills
                    $this->applyHeroSkills(DEFEND_SKILL);

                    $this->hero->applyDamage($this->currentDamage);
                }
            }

//            echo $this->luckyDefender ? "\nLUCKY:true" : "\nLUCKY:false";
//            echo $this->hero->getStats() . "\n" . $this->beast->getStats();
            $this->writeTurnStats();
            $this->goToNextTurn();
            $this->switchPlayers();
        }
    }

    /**
     * Decide if the hero attacks first based on current properties
     * @return bool
     */
    private function heroAttacksFirst(): bool
    {
        if ($this->hero->getSpeed() === $this->beast->getSpeed()) {
            if ($this->hero->getLuck() > $this->beast->getLuck()) {
                return true;
            }
        } elseif ($this->hero->getSpeed() > $this->beast->getSpeed()) {
            return true;
        } else {
            return false;
        }
        return false;
    }

    public function isAnyoneAlive()
    {
        return $this->hero->getHealth() > 0 && $this->beast->getHealth() > 0;
    }

    private function goToNextTurn()
    {
        $this->turns++;
    }

    private function switchPlayers()
    {
        $this->heroAttacks = !$this->heroAttacks;
    }

    private function initTurn()
    {
        $this->luckyDefender = false;
        $this->currentAttack = $this->currentDefend = $this->currentDamage = 0;
        $this->currentSkills = $this->battleTurnStats = [];
    }

    /**
     * For the given skills array, modify current turn values (attack, defend, damage)
     * @param string $skillType
     */
    private function applyHeroSkills(string $skillType)
    {
        $this->currentSkills = $this->hero->getSkillsToApply($skillType);
        /** @var Skill $skill */
        foreach ($this->currentSkills as $skill) {
            switch ($skill->getName()) {
                case RAPID_STRIKE:
                    echo "\nRAPID_STRIKE | {$this->currentAttack} | {$this->currentDefend} | {$this->currentDamage}";
                    $this->addDamage($this->calculateDamage($this->hero->attack(), $this->beast->defend()));
                    $this->currentAttack += $this->hero->attack();
                    $this->currentDefend += $this->beast->defend();
                    echo "\nAFTER SKILL | {$this->currentDamage}";
                    break;
                case MAGIC_WAVE:
                    echo "\nMAGIC_WAVE | {$this->currentAttack} | {$this->currentDefend} | {$this->currentDamage}";
                    $this->addDamage(intdiv($this->hero->attack(), 2));
                    echo "\nAFTER SKILL | {$this->currentDamage}";
                    break;
                case MAGIC_SHIELD:
                    echo "\nMAGIC_SHIELD | {$this->currentAttack} | {$this->currentDefend} | {$this->currentDamage}";
                    $this->setDamage($this->calculateDamage(intdiv($this->currentAttack, 2), $this->currentDefend));
                    echo "\nAFTER SKILL | {$this->currentDamage}";
                    break;
                default:
                    break;
            }
        }
    }

    private function calculateDamage(int $attackValue, int $defendValue): int
    {
        return $attackValue - $defendValue;
    }

    private function setDamage(int $damageValue): void
    {
        $this->currentDamage = $damageValue;
    }

    private function addDamage(int $newAttackValue): void
    {
        $this->currentDamage += $newAttackValue;
    }

    private function writeTurnStats()
    {
        $battleTurnStats = $this->heroAttacks
            ? $this->battleTurnStats[] = $this->getStats($this->hero, $this->beast)
            : $this->getStats($this->beast, $this->hero);

        Stats::writeStatsToConsole($battleTurnStats);
    }

    /**
     * @param EmagiaWarrior|Hero $attacker
     * @param EmagiaWarrior|Hero $defender
     * @return string
     */
    private function getStats($attacker, $defender): string
    {
        $message = "\n'{$attacker->getName()}' STRIKE -----> {$this->currentAttack}";
        if ($this->luckyDefender) {
            $message .= "\n'{$defender->getName()}' MADE A LUCKY ESCAPE";
        }
        $message .= "\n'{$defender->getName()}' BLOCK -----> {$this->currentDefend}";
//        {$attacker->getName()} had been stricken with a total power of {$this->currentAttack}
//        {$defender->getName()} did his best to defend himself using a power of {$this->currentDefend},
        $message .= "\nTotal damage {$this->currentDamage}";
        if ($this->currentSkills) {
            $message .= "\nOur hero, '{$this->hero->getName()}', had the chance to of using:";
            foreach ($this->currentSkills as $skill) {
                $message .= "\n - {$skill->getName()}";
            }
        }
        $message .= "\nWarrior stats:\n{$this->hero->getName()}: {$this->hero->getHealth()}\n{$this->beast->getName()}: {$this->beast->getHealth()}\n";
        return $message;
    }
}
