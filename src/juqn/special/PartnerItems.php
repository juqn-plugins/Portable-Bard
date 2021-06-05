<?php

namespace juqn\special;

use juqn\special\entity\ZombieBard;
use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;

class PartnerItems extends PluginBase implements Listener
{
	
	public function onEnable()
	{
		# Register Listener
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
		# Register entity
		Entity::registerEntity(ZombieBard::class, true);
	}
	
	public function handleInteract(PlayerInteractEvent $event): void
	{
		$action = $event->getAction();
		$block = $event->getBlock();
		$player = $event->getPlayer();
		$item = $event->getItem();
		
		if ($item->getId() == 344 && $item->getCustomName() == "§l§dSwox's Portable Bard§r") {
			$event->setCancelled();
			
			if ($action == $event::RIGHT_CLICK_BLOCK) {
				$nbt = Entity::createBaseNBT($block->add(0, 1, 0));
				$ent = new ZombieBard($player->getLevel(), $nbt, $player->getName());
				$ent->spawnToAll();
			
				$item->setCount($item->getCount() - 1);
				$player->getInventory()->setItemInHand($item);
			}
		}
	}
}
