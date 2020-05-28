<?php
declare(strict_types = 1);

namespace DaPigGuy\libPiggyEconomy\providers;

use Paroxity\ParoxityEcon\ParoxityEcon;
use Paroxity\ParoxityEcon\ParoxityEconAPI;
use pocketmine\Player;
use pocketmine\Server;

class ParoxityEconProvider extends EconomyProvider
{
	/** @var ParoxityEconAPI */
	private $api;

	public static function checkDependencies(): bool
	{
		return Server::getInstance()->getPluginManager()->getPlugin("ParoxityEcon") !== null;
	}

	public function __construct()
	{
		$this->api = ParoxityEconAPI::getInstance();
	}

	public function getMonetaryUnit(): string
	{
		return ParoxityEcon::getMonetaryUnit();
	}

	public function getMoney(Player $player, callable $callback): void
	{
		$this->api->getMoney($player->getUniqueId()->toString(), true, $callback);
	}

	public function giveMoney(Player $player, float $amount, ?callable $callback = null): void
	{
		$this->api->addMoney($player->getUniqueId()->toString(), $amount, true, $callback);
	}

	public function takeMoney(Player $player, float $amount, ?callable $callback = null): void
	{
		$this->api->deductMoney($player->getUniqueId()->toString(), $amount, true, $callback);
	}

	public function setMoney(Player $player, float $amount, ?callable $callback = null): void
	{
		$this->api->setMoney($player->getUniqueId()->toString(), $amount, true, $callback);
	}
}