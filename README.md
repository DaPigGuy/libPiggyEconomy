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