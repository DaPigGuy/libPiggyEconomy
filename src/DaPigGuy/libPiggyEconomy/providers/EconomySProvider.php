<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use onebone\economyapi\EconomyAPI;
use pocketmine\Player;
use pocketmine\Server;

class EconomySProvider extends EconomyProvider
{
    /** @var EconomyAPI */
    private $economyAPI;

    public static function checkDependencies(): bool
    {
        return Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI") !== null;
    }

    public function __construct()
    {
        $this->economyAPI = EconomyAPI::getInstance();
    }

    public function getMonetaryUnit(): string
    {
        return $this->economyAPI->getMonetaryUnit();
    }

    public function getMoney(Player $player): float
    {
        return $this->economyAPI->myMoney($player);
    }

    public function giveMoney(Player $player, float $amount): void
    {
        $this->economyAPI->addMoney($player, $amount);
    }

    public function takeMoney(Player $player, float $amount): void
    {
        $this->economyAPI->reduceMoney($player, $amount);
    }

    public function setMoney(Player $player, float $amount): void
    {
        $this->economyAPI->setMoney($player, $amount);
    }
}