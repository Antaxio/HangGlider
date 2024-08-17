<?php

namespace Antaksio\HandGlider;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use Antaksio\HandGlider\listeners\HandGlider;

class Main extends PluginBase implements Listener {
    use SingletonTrait;

    public static Config $config;
    
    public function onLoad(): void
    {
        self::setInstance($this);
    }

    public function onEnable(): void
    {
        $this->getServer()->getLogger()->info("§aLe plugin HandGlider by antaksio est activé!");
        $this->saveDefaultConfig();
        self::$config = $this->getConfig();
        Server::getInstance()->getPluginManager()->registerEvents(new HandGlider(), $this);
    }
}
