<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyEconomy;

use DaPigGuy\libPiggyEconomy\exceptions\UnknownProviderException;
use DaPigGuy\libPiggyEconomy\exceptions\MissingProviderDependencyException;
use DaPigGuy\libPiggyEconomy\providers\EconomyProvider;
use DaPigGuy\libPiggyEconomy\providers\EconomySProvider;
use DaPigGuy\libPiggyEconomy\providers\MultiEconomyProvider;
use DaPigGuy\libPiggyEconomy\providers\XPProvider;

class libPiggyEconomy
{
    /** @var bool */
    public static $hasInitiated = false;

    /** @var EconomyProvider[] */
    public static $economyProviders;

    public static function init(): void
    {
        if (!self::$hasInitiated) {
            self::$hasInitiated = true;

            self::registerProvider(["economys", "economyapi"], EconomySProvider::class);
            self::registerProvider(["multieconomy"], MultiEconomyProvider::class);
            self::registerProvider(["xp", "exp", "experience"], XPProvider::class);
        }
    }

    public static function registerProvider(array $providerNames, string $economyProvider): void
    {
        foreach ($providerNames as $providerName) {
            if (isset(self::$economyProviders[strtolower($providerName)])) continue;
            self::$economyProviders[strtolower($providerName)] = $economyProvider;
        }
    }

    /**
     * @throws UnknownProviderException
     * @throws MissingProviderDependencyException
     */
    public static function getProvider(array $providerInformation): EconomyProvider
    {
        if (!isset(self::$economyProviders[strtolower($providerInformation["provider"])])) throw new UnknownProviderException("Provider " . $providerInformation["provider"] . " not found.");
        $provider = self::$economyProviders[strtolower($providerInformation["provider"])];
        if (!$provider::checkDependencies()) throw new MissingProviderDependencyException("Dependencies for provider " . $providerInformation . " not found.");
        $provider = new $provider($providerInformation);
        return $provider;
    }
}