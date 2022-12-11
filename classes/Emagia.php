<?php

require_once('EmagiaWarrior.php');
require_once('Battle.php');
require_once('helpers/SkillsInitiator.php');
require_once('helpers/Utils.php');

class Emagia
{
    private Hero $hero;
    private EmagiaWarrior $beast;
    private Battle $battle;

    public function __construct()
    {
        echo "Loading ever-green forests of Emagia\n";
        Utils::loading();
    }

    /**
     * Define and initialize characters with a specific range of abilities
     */
    public function loadCharacters()
    {
        echo "\nLoad characters\n";
        Utils::loading();

        $this->hero = new Hero('Orderus I');
        $this->hero->initialize(
            WarriorInitiator::propertiesFromRage(HERO_ABILITIES_RAGE),
            SkillsInitiator::createSkills()
        );

        $this->beast = new EmagiaWarrior('Willy the Beast');
        $this->beast->initialize(WarriorInitiator::propertiesFromRage(BEAST_ABILITIES_RAGE));

        echo $this->hero->getCompleteStats() . $this->beast->getCompleteStats();
    }

    public function startAction()
    {
        echo "\nStarting battle\n";
        Utils::loading(".", 50000);

        $this->battle = new Battle($this->hero, $this->beast);
        $this->battle->start();

        if($this->hero->getHealth()>0 && $this->beast->getHealth()> 0){
            echo "\nOur warriors became BFF";
        }elseif ($this->hero->getHealth()>0){
            echo "\nWINNER.....{$this->hero->getName()}";
        }else{
            echo "\nWINNER.....{$this->beast->getName()}";
        }
    }
}
