<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use pocketmine\entity\utils\ExperienceUtils;
use pocketmine\Player;

class XPProvider extends EconomyProvider
{
    public function getMonetaryUnit(): string
    {
        return "Levels";
    }

    public function getMoney(Player $player, callable $callback): void
    {
    	$callback($player->getXpLevel() + $player->getXpProgress());
    }

    public function giveMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $levels = (int)floor($amount);
        $levelsAdded = $player->addXpLevels($levels);
        $xpAdded = $player->addXp((int)(ExperienceUtils::getXpToCompleteLevel($player->getXpLevel()) * ($amount - $levels)));
        if($callback !== null){
	        ($levelsAdded && $xpAdded) ? $callback(true) : $callback(false);
        }
    }

    public function takeMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $this->giveMoney($player, -$amount, $callback);
    }

    public function setMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $levels = (int)floor($amount);
        $levelSet = $player->setXpLevel($levels);
        $progressSet = $player->setXpProgress($amount - $levels);
	    if($callback !== null){
		    ($levelSet && $progressSet) ? $callback(true) : $callback(false);
	    }
    }
}