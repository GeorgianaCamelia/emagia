<?php declare(strict_types=1);

require_once('classes/Emagia.php');
require_once('classes/Hero.php');
require_once('classes/EmagiaWarrior.php');
require_once('classes/Battle.php');
require_once('helpers/WarriorInitiator.php');
require_once('abilities-definition.php');

$emagia = new Emagia();

$emagia->loadCharacters();
$emagia->startAction();





