<?php


namespace DaPigGuy\libPiggyEconomy\providers;


use pocketmine\Player;

/**
 * Interface EconomyProvider
 * @package DaPigGuy\libPiggyEconomy\providers
 */
abstract class EconomyProvider
{
    /**
     * @return bool
     */
    public static function checkDependencies(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getMonetaryUnit(): string
    {
        return "$";
    }

    /**
     * @param Player $player
     * @return int
     */
    abstract function getMoney(Player $player): int;

    /**
     * @param Player $player
     * @param int $amount
     */
    abstract function giveMoney(Player $player, int $amount): void;

    /**
     * @param Player $player
     * @param int $amount
     */
    abstract function takeMoney(Player $player, int $amount): void;

    /**
     * @param Player $player
     * @param int $amount
     */
    abstract function setMoney(Player $player, int $amount): void;
}