<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use onebone\coinapi\CoinAPI;
use pocketmine\player\Player;
use pocketmine\Server;

class CoinAPIProvider extends EconomyProvider
{
    private CoinAPI $coinAPI;

    public static function checkDependencies(): bool
    {
        return Server::getInstance()->getPluginManager()->getPlugin("CoinAPI") !== null;
    }

    public function __construct()
    {
        $this->coinAPI = CoinAPI::getInstance();
    }

    public function getMonetaryUnit(): string
    {
        return $this->coinAPI->getMonetaryUnit();
    }

    public function getMoney(Player $player, callable $callback): void
    {
        $callback($this->coinAPI->myCoin($player) ?: 0);
    }

    public function giveMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $ret = $this->coinAPI->addCoin($player, $amount);
        if ($callback) $callback($ret === CoinAPI::RET_SUCCESS);
    }

    public function takeMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $ret = $this->coinAPI->reduceCoin($player, $amount);
        if ($callback) $callback($ret === CoinAPI::RET_SUCCESS);
    }

    public function setMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $ret = $this->coinAPI->setCoin($player, $amount);
        if ($callback) $callback($ret === CoinAPI::RET_SUCCESS);
    }
}