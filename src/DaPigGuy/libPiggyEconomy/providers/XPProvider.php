<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use pocketmine\Player;

class XPProvider extends EconomyProvider
{
    public function getMonetaryUnit(): string
    {
        return "Levels";
    }

    public function getMoney(Player $player): float
    {
        return (float) $player->getXpLevel();
    }

    public function giveMoney(Player $player, int $amount): void
    {
        $player->addXpLevels($amount, false);
    }

    public function takeMoney(Player $player, int $amount): void
    {
        $player->subtractXpLevels($amount);
    }

    public function setMoney(Player $player, int $amount): void
    {
        $player->setXpLevel($amount);
    }
}