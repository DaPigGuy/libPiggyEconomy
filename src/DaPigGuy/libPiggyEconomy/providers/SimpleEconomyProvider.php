<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use NhanAZ\SimpleEconomy\Main as SimpleEconomy;
use pocketmine\player\Player;
use pocketmine\Server;

class SimpleEconomyProvider extends EconomyProvider
{
    private SimpleEconomy $plugin;

    public static function checkDependencies(): bool
    {
        return Server::getInstance()->getPluginManager()->getPlugin("SimpleEconomy") !== null;
    }

    public function __construct()
    {
        $plugin = SimpleEconomy::getInstance();
        assert($plugin !== null);
        $this->plugin = $plugin;
    }

    public function getMonetaryUnit(): string
    {
        return $this->plugin->getFormatter()->getSymbol();
    }

    public function getMoney(Player $player, callable $callback): void
    {
        $balance = $this->plugin->getMoney($player->getName());
        $callback($balance ?? (float) $this->plugin->getDefaultBalance());
    }

    public function giveMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $success = $this->plugin->addMoney($player->getName(), (int) $amount);
        if ($callback !== null) {
            $callback($success);
        }
    }

    public function takeMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $success = $this->plugin->reduceMoney($player->getName(), (int) $amount);
        if ($callback !== null) {
            $callback($success);
        }
    }

    public function setMoney(Player $player, float $amount, ?callable $callback = null): void
    {
        $success = $this->plugin->setMoney($player->getName(), (int) $amount);
        if ($callback !== null) {
            $callback($success);
        }
    }
}
