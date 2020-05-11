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

    public function getMoney(Player $player): float
    {
        return $player->getXpLevel() + $player->getXpProgress();
    }

    public function giveMoney(Player $player, float $amount): void
    {
        $levels = (int)floor($amount);
        $player->addXpLevels($levels);
        $player->addXp((int)(ExperienceUtils::getXpToCompleteLevel($player->getXpLevel()) * ($amount - $levels)));
    }

    public function takeMoney(Player $player, float $amount): void
    {
        $this->giveMoney($player, -$amount);
    }

    public function setMoney(Player $player, float $amount): void
    {
        $levels = (int)floor($amount);
        $player->setXpLevel($levels);
        $player->setXpProgress($amount - $levels);
    }
}