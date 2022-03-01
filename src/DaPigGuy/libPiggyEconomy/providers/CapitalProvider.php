<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use DaPigGuy\libPiggyEconomy\exceptions\MethodNotImplementedException;
use DaPigGuy\libPiggyEconomy\libPiggyEconomy;
use pocketmine\player\Player;
use pocketmine\Server;
use SOFe\Capital\Analytics\Single\CachedValue;
use SOFe\Capital\Analytics\Single\PlayerInfoUpdater;
use SOFe\Capital\Analytics\Single\Query;
use SOFe\Capital\Capital;
use SOFe\Capital\CapitalException;
use SOFe\Capital\LabelSet;
use SOFe\Capital\Schema\Complete;

class CapitalProvider extends EconomyProvider
{
    private string $version = "0.1.0";
    private string $oracle;
    private Complete $selector;

    public static function checkDependencies(): bool
    {
        return Server::getInstance()->getPluginManager()->getPlugin("Capital") !== null;
    }

    public function __construct()
    {
        Capital::api($this->version, function (Capital $api) {
            $this->selector = $api->completeConfig(libPiggyEconomy::$plugin->getConfig()->get("capital-selector"));
        });
        $this->oracle = libPiggyEconomy::$plugin->getName();
    }

    public function getMonetaryUnit(): string
    {
        return "$";
    }

    public function getMoney(Player $player, callable $callback): void
    {
        Capital::api($this->version, function (Capital $api) use ($callback, $player) {
            $accounts = yield from $api->findAccountsComplete($player, $this->selector);
            $callback($api->getBalance($accounts[0]) ?: 0);
        });
    }

    public function giveMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        Capital::api($this->version, function (Capital $api) use ($callback, $amount, $player) {
            try {
                yield from $api->addMoney($this->oracle, $player, $this->selector, (int)$amount, new LabelSet(["reason" => "some reason"]),);
                if ($callback) $callback(true);
            } catch (CapitalException $e) {
                if ($callback) $callback(false);
            }
        });
    }

    public function takeMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        Capital::api($this->version, function (Capital $api) use ($callback, $amount, $player) {
            try {
                yield from $api->takeMoney($this->oracle, $player, $this->selector, (int)$amount, new LabelSet(["reason" => "some reason"]),);
                if ($callback) $callback(true);
            } catch (CapitalException $e) {
                if ($callback) $callback(false);
            }
        });
    }

    public function setMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $this->getMoney($player, function ($balance) use ($callback, $player, $amount): void {
            $difference = $balance - (int)$amount;
            if ($difference >= 0) {
                $this->takeMoney($player, $difference, fn(?bool $success) => $callback($success));
            } else {
                $this->giveMoney($player, $difference, fn(?bool $success) => $callback($success));
            }
        });
    }
}