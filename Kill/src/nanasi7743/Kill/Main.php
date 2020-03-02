<?php

namespace nanasi7743\Kill;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->set = new Config($this->getDataFolder() . "config.yml", CONFIG::YAML, array(
            "減らす金額" => "10000",
            "メッセージ" => "§ckillコマンドを使ったので所持金を減らしました",
            "プレフィックス" => "§l§b[KillCommand]§r",
        ));
        $this->getLogger()->info("§bKillを起動しました by nanasi");
        if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") == null){
            $this->getLogger()->error("§cEconomyAPIが見つかりません　サーバーを停止中");
            $this->getServer()->shutdown();
            }else{
            $this->getLogger()->info("§aEconomyAPIを見つけました");
            }
    }
    public function onDisable() {
        $this->getLogger()->info("§dKillを停止しました by nanasi");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) :bool {
        $player = $event->getPlayer();
        $now = EconomyAPI::getInstance()->myMoney($player);
        $money = $this->config->get("減らす金額");
        $message = $this->config->get("メッセージ");
        $prefix = $this->config->get("プレフィックス");
        if ($event->getCommand() === "kill") {
            if ($now > $money) {
                EconomyAPI::getInstance()->reduceMoney($player, $money);
                $sender->sendMessage($prefix.$message);
            } else {
                $sender->sendMessage($prefix."§d所持金が{$money}より少なかったので減らしませんでした");
            } 
        }
    }
}