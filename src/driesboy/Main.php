<?php
namespace driesboy;
//base
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\player\PlayerRespawnEvent;
//config
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
//items
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerItemHeldEvent;
//commands
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandExecutor;
class Main extends PluginBase implements Listener{
	public function onEnable(){
		@mkdir($this->getDataFolder());
                $this->saveDefaultConfig();
                $this->reloadConfig();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function PlayerItemHeld(PlayerItemHeldEvent $ev){
		$player = $ev->getPlayer();
		$item = $ev->getItem();
        	if($item instanceof Item){
        		if($player->getLevel()->getName() === $this->getConfig()->get("workingworlds")){
          		if($item->getID() === $this->getConfig()->get("slot1")){
          			$player->sendPopup($this->getConfig()->get("slot1-Tip"));
          		}
          		if($item->getID() === $this->getConfig()->get("slot2")){
          			$player->sendPopup($this->getConfig()->get("slot2-Tip"));
          		}
          		if($item->getID() === $this->getConfig()->get("slot3")){
          			$player->sendPopup($this->getConfig()->get("slot3-Tip"));
			}
			}
		}
   	}
	public function onPlayerInteract(PlayerInteractEvent $event){
		$p = $event->getPlayer();
		$i = $event->getItem();
		if($p->getLevel()->getName() === $this->getConfig()->get("workingworlds")){
		if($i->getID() === $this->getConfig()->get("slot1")){
			$p->getServer()->dispatchCommand(new ConsoleCommandSender(), str_ireplace("{PLAYER}", $p->getName(), $this->getConfig()->get("slot1-command")));
			if($this->getConfig()->get("ClearItemsAfterUse") === true){
          				$p->getInventory()->clearAll();	
          			}
		}
		if($i->getID() === $this->getConfig()->get("slot2")){
			$p->getServer()->dispatchCommand(new ConsoleCommandSender(), str_ireplace("{PLAYER}", $p->getName(), $this->getConfig()->get("slot2-command")));
			if($this->getConfig()->get("ClearItemsAfterUse") === true){
          				$p->getInventory()->clearAll();	
          			}
		}
		if($i->getID() === $this->getConfig()->get("slot3")){
			$p->getServer()->dispatchCommand(new ConsoleCommandSender(), str_ireplace("{PLAYER}", $p->getName(), $this->getConfig()->get("slot3-command")));
			if($this->getConfig()->get("ClearItemsAfterUse") === true){
          				$p->getInventory()->clearAll();	
			}
		}
		}
	}
	public function onJoin(PlayerJoinEvent $event){
		if($this->getConfig()->get("GiveItemsOnJoin") === true){
			$p = $event->getPlayer();
			$p->getInventory()->setItem(1, Item::get($this->getConfig()->get("slot1"),0,1));
			$p->getInventory()->setHotbarSlotIndex(1,1);
			$p->getInventory()->setItem(2, Item::get($this->getConfig()->get("slot2"),0,1));
			$p->getInventory()->setHotbarSlotIndex(2,2);
			$p->getInventory()->setItem(3, Item::get($this->getConfig()->get("slot3"),0,1));
			$p->getInventory()->setHotbarSlotIndex(3,3);
		}
	}
	public function onRespawn(PlayerRespawnEvent $event){
		$p = $event->getPlayer();
		if($this->getConfig()->get("GiveItemsOnRespawn") === true){
			$p->getInventory()->setItem(1, Item::get($this->getConfig()->get("slot1"),0,1));
			$p->getInventory()->setHotbarSlotIndex(1,1);
			$p->getInventory()->setItem(2, Item::get($this->getConfig()->get("slot2"),0,1));
			$p->getInventory()->setHotbarSlotIndex(2,2);
			$p->getInventory()->setItem(3, Item::get($this->getConfig()->get("slot3"),0,1));
			$p->getInventory()->setHotbarSlotIndex(3,3);
		}
	}
	 public function onWorldChange(EntityLevelChangeEvent $event){
    	$entity = $event->getEntity();
    	if($entity instanceof Player){
    		$origin = $event->getOrigin();
    		if($origin === $this->getConfig()->get("workingworlds")){
    			$entity->getInventory()->clearAll();	
    		}
    		$target = $event->getTarget();
    		if($target === $this->getConfig()->get("workingworlds")){
    			$entity->getInventory()->setItem(1, Item::get($this->getConfig()->get("slot1"),0,1));
			$entity->getInventory()->setHotbarSlotIndex(1,1);
			$entity->getInventory()->setItem(2, Item::get($this->getConfig()->get("slot2"),0,1));
			$entity->getInventory()->setHotbarSlotIndex(2,2);
			$entity->getInventory()->setItem(3, Item::get($this->getConfig()->get("slot3"),0,1));
			$entity->getInventory()->setHotbarSlotIndex(3,3);
		}
	}
	}
}
