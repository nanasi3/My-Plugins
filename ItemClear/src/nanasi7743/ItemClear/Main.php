<?php

namespace nanasi7743\ItemClear;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Plugin\PluginBase;

class main extends PluginBase implements Listener{

  public function onEnable(){
    $this->getLogger()->info("§bプラグインを読み込みました！ by nanasi");
  }

  public function onCommand(CommandSender $player, Command $command, string $label, array $args) : bool{
    switch($label){
      case "clear":
        if(!$sender instanceof Player) {
          $sender->sendMessage("ゲーム内で実行してください");
          return true;
        } else {
          $player = $args[0];
          if ($player instanceof Player) {
                $player->getInventory()->clearAll();
                $sender->sendMessage($args[0]."のインベントリを空にしました");
                $player->sendMessage("インベントリが空になりました");
            } elseif (empty($args[0])) {
            $sender->getInventory()->clearAll();
            $sender->sendMessage("インベントリが空になりました");
          } else {
            $sender->sendMessage("そのようなプレイヤーはいません");
          }
        }
    }
  }
}