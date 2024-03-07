<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use cooldogedev\BedrockEconomy\api\type\AsyncAPI;
use cooldogedev\BedrockEconomy\BedrockEconomy;
use cooldogedev\BedrockEconomy\api\BedrockEconomyAPI;
use cooldogedev\BedrockEconomy\currency\Currency;
use cooldogedev\BedrockEconomy\libs\SOFe\AwaitGenerator\Await;
use pocketmine\player\Player;
use pocketmine\Server;

class BedrockEconomyProvider extends EconomyProvider
{
    private AsyncAPI $api;
    private Currency $currency;

    public static function checkDependencies(): bool
    {
        return Server::getInstance()->getPluginManager()->getPlugin("BedrockEconomy") !== null;
    }

    public function __construct()
    {
        $this->api = BedrockEconomyAPI::ASYNC();
        $this->currency = BedrockEconomy::getInstance()->getCurrency();
    }

    public function getMonetaryUnit(): string
    {
        return $this->currency->symbol;
    }

    public function getMoney(Player $player, callable $callback): void
    {
        Await::f2c(
            fn () => yield from $this->api->get($player->getXuid(), $player->getName()),
            fn (array $result) => $callback($result['amount']),
            fn () => $callback($this->currency->defaultAmount)
        );
    }

    public function giveMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        Await::f2c(
            fn () => yield from $this->api->add($player->getXuid(), $player->getName(), (int)$amount, 0),
            $callback,
            fn () => $callback ? $callback(false) : null
        );
    }

    public function takeMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        Await::f2c(
            fn () => yield from $this->api->subtract($player->getXuid(), $player->getName(), (int)$amount, 0),
            $callback,
            fn () => $callback ? $callback(false) : null
        );
    }

    public function setMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        Await::f2c(
            fn () => yield from $this->api->set($player->getXuid(), $player->getName(), (int)$amount, 0),
            $callback,
            fn () => $callback ? $callback(false) : null
        );
    }
}
