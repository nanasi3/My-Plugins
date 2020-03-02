<?php

namespace roulette;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;

class main extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getPluginmanager()->registerEvents($this, $this );
		$this->getLogger()->info("§bRouletteを起動しました by nanasi");
    }
    public function onDisable() {
        $this->getLogger()->info("§dRouletteを停止しました by nanasi");
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) :bool
    {
        switch ($label) {
            case "ro":
               if (empty($args[0])) {
                   return false;
               } else {
                   if (empty($args[1])) {
                       return false;
                   } else {
                    $first = $args[0];
                    $second = $args[1];
                    $prefix = "§l§a[Roulette]§r§b";
                    $random = rand($first, $second);
                    $sender->sendMessage($prefix."Number：".$random);
                   }
               }
            return true;
        }
    }
}