<?php

namespace MysteryDark\Ayrz;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\Player;

use pocketmine\scheduler\Task;

use MysteryDark\Ayrz\TutorialTask;
use MysteryDark\Ayrz\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class CommandTutorial extends Command {

	private $plugin;

	public function __construct(Main $plugin){
		parent::__construct("tutorial", "Continue to know the server better.");		
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $p, string $label, array $args){
		if($p instanceof Player){
			$this->plugin->menu($p);
		}
	}
}
?>
