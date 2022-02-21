<?php

namespace DaPigGuy\libPiggyEconomy\providers;

use pocketmine\player\Player;

abstract class EconomyProvider
{
    public static function checkDependencies(): bool
    {
        return true;
    }

    public function getMonetaryUnit(): string
    {
        return "$";
    }

    /**
     * $callback -> function(?float $money): void{}
     * $money is null if player wasn't found.
     */
    abstract function getMoney(Player $player, callable $callback): void;

    /**
     * $callback -> function(bool $success): void{}
     * $success is true if money was given successfully, otherwise false.
     */
    abstract function giveMoney(Player $player, float $amount, ?callable $callback = null): void;

    /**
     * $callback -> function(bool $success): void{}
     * $success is true if money was taken successfully, otherwise false.
     */
    abstract function takeMoney(Player $player, float $amount, ?callable $callback = null): void;

    /**
     * $callback -> function(bool $success): void{}
     * $success is true if money was set successfully, otherwise false.
     */
    abstract function setMoney(Player $player, float $amount, ?callable $callback = null): void;
}