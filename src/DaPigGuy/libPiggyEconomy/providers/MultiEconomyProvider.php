<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy\providers;

use DaPigGuy\libPiggyEconomy\exceptions\UnknownMultiEconomyCurrencyException;
use pocketmine\Player;
use pocketmine\Server;
use Twisted\MultiEconomy\Currency;
use Twisted\MultiEconomy\MultiEconomy;

/**
 * Class MultiEconomyProvider
 * @package DaPigGuy\libPiggyEconomy\providers
 */
class MultiEconomyProvider extends EconomyProvider
{
    /** @var MultiEconomy */
    private $multiEconomy;
    /** @var Currency */
    private $currency;

    /**
     * @return bool
     */
    public static function checkDependencies(): bool
    {
        return Server::getInstance()->getPluginManager()->getPlugin("MultiEconomy") !== null;
    }

    /**
     * MultiEconomyProvider constructor.
     * @param array $providerInformation
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

    /**
     * @return string
     */
    public function getMonetaryUnit(): string
    {
        return $this->currency->getSymbol();
    }

    /**
     * @param Player $player
     * @return float
     */
    public function getMoney(Player $player): float
    {
        return $this->currency->getBalance($player->getName()) ?? $this->currency->getStartingAmount();
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function giveMoney(Player $player, int $amount): void
    {
        $this->currency->addToBalance($player->getName(), $amount);
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function takeMoney(Player $player, int $amount): void
    {
        $this->currency->removeFromBalance($player->getName(), $amount);
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function setMoney(Player $player, int $amount): void
    {
        $this->currency->setBalance($player->getName(), $amount);
    }
}