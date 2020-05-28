<?php


namespace DaPigGuy\libPiggyEconomy\providers;


use pocketmine\Player;

/**
 * Interface EconomyProvider
 * @package DaPigGuy\libPiggyEconomy\providers
 */
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
	 *
	 * The $money will be null if player is not found.
	 */
    abstract function getMoney(Player $player, callable $callback): void;

	/**
	 * $callback -> function(bool $success): void{}
	 *
	 * If money was given successfully then callable would contain true else false.
	 */
    abstract function giveMoney(Player $player, float $amount, ?callable $callback = null): void;

	/**
	 * $callback -> function(bool $success): void{}
	 *
	 * If money was taken successfully then callable would contain true else false.
	 */
    abstract function takeMoney(Player $player, float $amount, ?callable $callback = null): void;

	/**
	 * $callback -> function(bool $success): void{}
	 *
	 * If money was set successfully then callable would contain true else false.
	 */
    abstract function setMoney(Player $player, float $amount, ?callable $callback = null): void;
}