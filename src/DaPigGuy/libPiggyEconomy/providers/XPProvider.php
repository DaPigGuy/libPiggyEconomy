<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use pocketmine\entity\utils\ExperienceUtils;
use pocketmine\player\Player;

class XPProvider extends EconomyProvider
{
    public function getMonetaryUnit(): string
    {
        return "Levels";
    }

    public function getMoney(Player $player): float
    {
        return $player->getXpManager()->getXpLevel() + $player->getXpManager()->getXpProgress();
    }

    public function giveMoney(Player $player, float $amount): void
    {
        $levels = (int)floor($amount);
        $player->getXpManager()->addXpLevels($levels);
        $player->getXpManager()->addXp((int)(ExperienceUtils::getXpToCompleteLevel($player->getXpManager()->getXpLevel()) * ($amount - $levels)));
    }

    public function takeMoney(Player $player, float $amount): void
    {
        $this->giveMoney($player, -$amount);
    }

    public function setMoney(Player $player, float $amount): void
    {
        $levels = (int)floor($amount);
        $player->getXpManager()->setXpLevel($levels);
        $player->getXpManager()->setXpProgress($amount - $levels);
    }
}