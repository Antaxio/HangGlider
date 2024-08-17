<?php

namespace Antaksio\HandGlider\listeners;

use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\player\Player;
use Antaksio\HandGlider\instance\CustomEffectInstance;
use Antaksio\HandGlider\Main;

class HandGlider implements Listener
{

    public function onHeld(PlayerItemHeldEvent $e)
    {
        if ($this->hasHandGliderPermission($e->getPlayer())) {
            if ($this->isHandGlider($e->getItem())) {
                $effect = new CustomEffectInstance(VanillaEffects::LEVITATION(), 20 * 1000000, -2, false);
                $e->getPlayer()->getEffects()->add($effect);
            } else {
                $e->getPlayer()->getEffects()->remove(VanillaEffects::LEVITATION());
            }
        }
    }

    private function hasHandGliderPermission(Player $player): bool
    {

        if (Main::$config->getNested("permission.enabled")) {
            if ($player->hasPermission("handglider." . Main::$config->getNested("permission.name"))) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    private function isHandGlider(Item $item): bool
    {

        $handglider = $this->nameToItem(Main::$config->get("item"))->getTypeId();

        if ($item->getTypeId() === $handglider) {
            return true;
        } else {
            return false;

        }
    }

    private function nameToItem(string $name): Item
    {
        return StringToItemParser::getInstance()->parse($name);
    }

    public function onJoin(PlayerJoinEvent $e)
    {
        if ($e->getPlayer()->getEffects()->has(VanillaEffects::LEVITATION())) {
            $e->getPlayer()->getEffects()->remove(VanillaEffects::LEVITATION());
        }
    }

    public function onDamage(EntityDamageEvent $e)
    {
        $entity = $e->getEntity();
        if ($entity instanceof Player) {
            if ($e->getCause() === EntityDamageEvent::CAUSE_FALL) {
                if ($this->hasHandGliderPermission($entity)) {
                    if ($this->isHandGlider($entity->getInventory()->getItemInHand())) {
                        $e->cancel();
                    }
                }
            }
        }
    }
}
