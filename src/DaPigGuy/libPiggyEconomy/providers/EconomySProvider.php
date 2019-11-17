<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use onebone\economyapi\EconomyAPI;
use pocketmine\Player;
use pocketmine\Server;

/**
 * Class EconomySProvider
 * @package DaPigGuy\libPiggyEconomy\providers
 */
class EconomySProvider extends EconomyProvider
{
    /** @var EconomyAPI */
    private $economyAPI;

    /**
     * @return bool
     */
    public static function checkDependencies(): bool
    {
        return Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI") !== null;
    }

    public function __construct()
    {
        $this->economyAPI = EconomyAPI::getInstance();
    }

    /**
     * @return string
     */
    public function getMonetaryUnit(): string
    {
        return $this->economyAPI->getMonetaryUnit();
    }

    /**
     * @param Player $player
     * @return float
     */
    public function getMoney(Player $player): float
    {
        return $this->economyAPI->myMoney($player);
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function giveMoney(Player $player, int $amount): void
    {
        $this->economyAPI->addMoney($player, $amount);
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function takeMoney(Player $player, int $amount): void
    {
        $this->economyAPI->reduceMoney($player, $amount);
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function setMoney(Player $player, int $amount): void
    {
        $this->economyAPI->setMoney($player, $amount);
    }
}