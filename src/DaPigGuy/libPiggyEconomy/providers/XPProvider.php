<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use pocketmine\Player;

/**
 * Class XPProvider
 * @package DaPigGuy\libPiggyEconomy\providers
 */
class XPProvider extends EconomyProvider
{
    /**
     * @return string
     */
    public function getMonetaryUnit(): string
    {
        return "Levels";
    }

    /**
     * @param Player $player
     * @return float
     */
    public function getMoney(Player $player): float
    {
        return (float) $player->getXpLevel();
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function giveMoney(Player $player, int $amount): void
    {
        $player->addXpLevels($amount, false);
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function takeMoney(Player $player, int $amount): void
    {
        $player->subtractXpLevels($amount);
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function setMoney(Player $player, int $amount): void
    {
        $player->setXpLevel($amount);
    }
}