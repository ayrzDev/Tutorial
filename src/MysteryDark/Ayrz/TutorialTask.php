<?php

declare(strict_types=1);

namespace MysteryDark\Ayrz;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use MysteryDark\Ayrz\Main;
use pocketmine\scheduler\Task;

class TutorialTask extends Task{
	
	public $plugin;
	public $p;
	public $time = 10;
	public $cfg;
	
	public function __construct(Main $plugin, Player $p){
		$this->plugin = $plugin;
		$this->cfg = new Config($this->plugin->getDataFolder(). "Tutorial" . ".yml", Config::YAML);
		$this->p = $p;
	}

	public function onRun(int $currentTick){
			if($this->p instanceof Player){
				$this->p->sendPopup("Second: ".$this->time);
				$this->cfg->set($this->p->getName(), "Active");
				$this->cfg->save();
				$this->p->setGamemode(3);
				$this->time--;
				if($this->time == 10){
					$world = "world";//world name
					if(file_exists($this->plugin->getServer()->getDataPath()."/worlds/" . $world)){
						$this->plugin->getServer()->loadLevel($world);
						$world1 = $this->plugin->getServer()->getLevelByName($world);
						$base = $world1->getSafeSpawn();
						$this->p->teleport($base , 0 , 0);
						$this->p->teleport(new Vector3($base->getX(), $base->getY(), $base->getZ()));
						$this->p->sendMessage("You see the ".$world.".");
					}else{
						$this->p->sendMessage("Not found ".$world." map");
					}
					}
				
				if($this->time == 5){
					$world = "nether";//world name
					if(file_exists($this->plugin->getServer()->getDataPath()."/worlds/" . $world)){
						$this->plugin->getServer()->loadLevel($world);
						$world1 = $this->plugin->getServer()->getLevelByName($world);
						$base = $world1->getSafeSpawn();
						$this->p->teleport($base , 0 , 0);
						$this->p->teleport(new Vector3($base->getX(), $base->getY(), $base->getZ()));
						$this->p->sendMessage("You see the ".$world.".");
					}else{
						$this->p->sendMessage("Not found ".$world." map");
					}
				}
			
				if($this->time == 0){
					$world = "world";
					if(file_exists($this->plugin->getServer()->getDataPath()."/worlds/" . $world)){
						$this->plugin->getServer()->loadLevel($world);
						$world1 = $this->plugin->getServer()->getLevelByName($world);
						$base = $world1->getSafeSpawn();
						$this->p->teleport($base , 0 , 0);
						$this->p->teleport(new Vector3($base->getX(), $base->getY(), $base->getZ()));
						$this->p->sendMessage("tutorial is over now you can start playing.");					
					}else{
						$this->p->sendMessage("Not found ".$world." map");
					}
					$this->cfg->set($this->p->getName(), "Closed");
					$this->cfg->save();
					$this->time = 11;
					$this->p->setGamemode(0);
					$this->p->setImmobile(false);
					$this->plugin->getScheduler()->cancelTask($this->getTaskId());
				}
			}
		}
	}
