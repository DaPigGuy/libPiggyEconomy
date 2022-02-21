<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use cooldogedev\BedrockEconomy\api\BedrockEconomyAPI;
use cooldogedev\BedrockEconomy\BedrockEconomy;
use cooldogedev\BedrockEconomy\currency\CurrencyManager;
use pocketmine\player\Player;
use pocketmine\Server;

class BedrockEconomyProvider extends EconomyProvider
{
    private BedrockEconomyAPI $api;
    private CurrencyManager $currency;

    public static function checkDependencies(): bool
    {
        return Server::getInstance()->getPluginManager()->getPlugin("BedrockEconomy") !== null;
    }

    public function __construct()
    {
        $this->api = BedrockEconomy::getInstance()->getAPI();
        $this->currency = BedrockEconomy::getInstance()->getCurrencyManager();
    }

    public function getMonetaryUnit(): string
    {
        return $this->currency->getSymbol();
    }

    public function getMoney(Player $player, callable $callback): void
    {
        $callback($this->api->getPlayerBalance($player->getName()) ?? $this->currency->getDefaultBalance());
    }

    public function giveMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $ret = $this->api->addToPlayerBalance($player->getName(), (int)$amount);
        if ($callback !== null) $callback($ret);
    }

    public function takeMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $ret = $this->api->subtractFromPlayerBalance($player->getName(), (int)$amount);
        if ($callback !== null) $callback($ret);
    }

    public function setMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $ret = $this->api->setPlayerBalance($player->getName(), (int)$amount);
        if ($callback !== null) $callback($ret);
    }
}