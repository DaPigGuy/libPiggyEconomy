# libPiggyEconomy

libPiggyEconomy is a virion for easy support of multiple economy providers including EconomyAPI, MultiEconomy, & PMMP's XP levels.

You may be wondering, why the absolute garbage name for a virion? Well, blame Aericio.

![](https://cdn.discordapp.com/attachments/305887490613444608/644764172273319936/unknown.png)

## Usage

### Setup
```php
libPiggyEconomy::init()
```

### Using Economy Providers
```php
libPiggyEconomy::getProvider($providerInformation)
```
Provider information is an array with the keys ```provider``` and ```multieconomy-currency```. The latter is optional and used only for MultiEconomy.

#### Economy Provider Methods
|Method|Description|Callback Signature|Callback Description|
---|---|---
|```EconomyProvider::getMonetaryUnit(): string```|Returns symbol of currency|`none`|`none`|
|```EconomyProvider::getMoney(Player $player, callable $callback): void```|Get balance of a player|function(?float $money): void{}|Returns null if player was not found, float otherwise|
|```EconomyProvider::giveMoney(Player $player, int $amount, ?callable $callback = null): void```|Give money to a player|function(bool $success): void{}|Returns true on success, false otherwise|
|```EconomyProvider::takeMoney(Player $player, int $amount, ?callable $callback = null): void```|Take money from a player|function(bool $success): void{}|Returns true on success, false otherwise|
|```EconomyProvider::setMoney(Player $player, int $amount, ?callable $callback = null): void```|Set balance of a player|function(bool $success): void{}|Returns true on success, false otherwise|

### Error Handling

There are several exceptions that can be thrown that you may want to handle in your plugin:
* MissingProviderDependencyException
* UnknownMultiEconomyCurrencyException
* UnknownProviderException

## Examples
config.yml
```yaml
economy:
    provider: multieconomy
    multieconomy-currency: pigcoins
```

AmazingPlugin.php

```php
class AmazingPlugin extends PluginBase{
    public $economyProvider;
    
    public function onEnable(): void{
        $this->saveDefaultConfig();
        libPiggyEconomy::init();
        $this->economyProvider = libPiggyEconomy::getProvider($this->getConfig()->get("economy"));
    }
}
```