<?php

namespace MysteryDark\Ayrz;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\utils\Config;

use pocketmine\scheduler\Task;
use pocketmine\block\Block;
use MysteryDark\Ayrz\TutorialTask;
use MysteryDark\Ayrz\CommandTutorial;
use MysteryDark\Ayrz\formapi\ModalForm;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;


class Main extends PluginBase implements Listener{

	public $cfg;
	private static $instance;


	public function onEnable(){
	  $this->getServer()->getPluginManager()->registerEvents($this, $this);
	  $this->cfg = new Config($this->getDataFolder() . "Tutorial.yml", Config::YAML);
	  $this->getLogger()->info("Tutorial plugin enable");
	  $this->getServer()->getCommandMap()->register("tutorial", new CommandTutorial($this));
	}

	
	public static function getInstance(): Main{
		return self::$instance;
	}

	
	public function onLoad(){
		self::$instance = $this;
	}

	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
        if (!$this->cfg->get($player->getName())) {
            $this->cfg->set($player->getName(), "Active");
            $this->cfg->save();
        }

		if($this->cfg->get($player->getName()) == "Active"){
			$this->menu($player);
			echo "Active";
		}elseif($this->cfg->get($player->getName()) == "Closed"){
			echo "Closed";
		}
	}

	public function menu($p){
		$form = new ModalForm(function(Player $p, $data = null){
			$args = $data;
			if($args === null){
				return true;
			}

			switch($args){
				case 1:
					$p->setImmobile(true);
					$this->getScheduler()->scheduleRepeatingTask(new TutorialTask($this, $p), 20 * 1);
				break;

			}

		});

		$form->setTitle("Tutorial Menu");
		$form->setButton1("Tutorial Start");
		$form->setButton2("Tutorial Skip");
		$form->sendToPlayer($p);
	}
	

}
?>
