<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use DaPigGuy\libPiggyEconomy\exceptions\UnknownMultiEconomyCurrencyException;
use pocketmine\Player;
use pocketmine\Server;
use Twisted\MultiEconomy\Currency;
use Twisted\MultiEconomy\MultiEconomy;

class MultiEconomyProvider extends EconomyProvider
{
    /** @var MultiEconomy */
    private $multiEconomy;
    /** @var Currency */
    private $currency;

    public static function checkDependencies(): bool
    {
        return Server::getInstance()->getPluginManager()->getPlugin("MultiEconomy") !== null;
    }

    /**
     * @throws UnknownMultiEconomyCurrencyException
     */
    public function __construct(array $providerInformation)
    {
        /** @var MultiEconomy $multiEconomy */
        $this->multiEconomy = Server::getInstance()->getPluginManager()->getPlugin("MultiEconomy");
        $this->currency = $this->multiEconomy->getCurrencies()[strtolower($providerInformation["multieconomy-currency"])] ?? null;
        if ($this->currency === null) {
            throw new UnknownMultiEconomyCurrencyException("MultiEconomy currency " . $providerInformation["multieconomy-currency"] . " not found.");
        }
    }

    public function getMonetaryUnit(): string
    {
        return $this->currency->getSymbol();
    }

    public function getMoney(Player $player): float
    {
        return $this->currency->getBalance($player->getName()) ?? $this->currency->getStartingAmount();
    }

    public function giveMoney(Player $player, float $amount): void
    {
        $this->currency->addToBalance($player->getName(), $amount);
    }

    public function takeMoney(Player $player, float $amount): void
    {
        $this->currency->removeFromBalance($player->getName(), $amount);
    }

    public function setMoney(Player $player, float $amount): void
    {
        $this->currency->setBalance($player->getName(), $amount);
    }
}