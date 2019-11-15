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
        $this->currency = $this->multiEconomy->getAPI()->getCurrencies()[strtolower($providerInformation["multieconomy-currency"])] ?? null;
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
     * @return int
     */
    public function getMoney(Player $player): int
    {
        return $this->multiEconomy->getAPI()->getBalance($player->getName(), $this->currency->getLowerName()) ?? $this->currency->getStartingAmount();
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function giveMoney(Player $player, int $amount): void
    {
        $this->multiEconomy->getAPI()->addToBalance($player->getName(), $this->currency->getLowerName(), $amount);
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function takeMoney(Player $player, int $amount): void
    {
        $this->multiEconomy->getAPI()->takeFromBalance($player->getName(), $this->currency->getLowerName(), $amount);
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function setMoney(Player $player, int $amount): void
    {
        $this->multiEconomy->getAPI()->setBalance($player->getName(), $this->currency->getLowerName(), $amount);
    }
}