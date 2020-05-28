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

    public function getMoney(Player $player, callable $callback): void
    {
        $money = $this->economyAPI->myMoney($player);
        $callback($money === false ? null : $money);
    }

    public function giveMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $ret = $this->economyAPI->addMoney($player, $amount);
        if ($callback !== null) {
            $callback($ret === EconomyAPI::RET_SUCCESS);
        }
    }

    public function takeMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $ret = $this->economyAPI->reduceMoney($player, $amount);
        if ($callback !== null) {
            $callback($ret === EconomyAPI::RET_SUCCESS);
        }
    }

    public function setMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $ret = $this->economyAPI->setMoney($player, $amount);
        if ($callback !== null) {
            $callback($ret === EconomyAPI::RET_SUCCESS);
        }
    }
}