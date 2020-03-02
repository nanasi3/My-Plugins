<?php

namespace nanasi7743\Message;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    private $join = "";
    private $quit = "";

	public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§bMessageを起動しました by nanasi");
        // Configで{name}を使いたいので変更お願い致しますことに致します
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
            
            "Join" => "", 
            "Quit" => "",
        ));
    }
    public function onDisable() {
        $this->getLogger()->info("§dMessageを停止しました by nanasi");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) :bool {
		switch($label){
			case "setm":
				if(empty($args[0])){
					return false;
				}
				
				if($args[0] === "join"){
					if(empty($args[1])) {
                        return false;
                    } elseif (isset($args[1])) {
                        $join = $args[1];
                        $prefix = "§l§a[Message]§r§b";
                        $sender->sendMessage($prefix."参加メッセージを変更しました");
                        $this->config->set("Join", $join);
                        $this->config->save();
                    }
				}elseif($args[0] === "quit"){
					if(empty($args[1])) {
                        return false;
                    } elseif (isset($args[1])) {
                       $quit = $args[1];
                       $prefix = "§l§a[Message]§r§b";
                       $sender->sendMessage($prefix."退出メッセージを変更しました");
                       $this->config->set("Quit", $quit);
                       $this->config->save();
                    }
				}else{
					return false;
				}
			return true;
		}
	}

    public function onJoin(PlayerJoinEvent $event) {
    	$player = $event->getPlayer();
        $name = $player->getName(); 
        $event->setJoinMessage($this->config->get("Join")); 
    }

    public function onQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
        $event->setQuitMessage($this->config->get("Quit"));
    }
}
   