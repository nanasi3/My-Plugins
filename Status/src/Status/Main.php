<?php

namespace Status;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\Task;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§bStatusを起動しました by nanasi");
        date_default_timezone_set('Asia/Tokyo');
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->getScheduler()->scheduleRepeatingTask(new Status($this), 5);
    }

    public function onDisable()
    {
        $this->getLogger()->info("§dStatusを停止しました by nanasi");
    }
}

class Status extends Task {
    public function onRun(int $tick) {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            $economyAPI = EconomyAPI::getInstance();
            $ping = $player->getPing();
            $ping = (int)$ping;
            $x = floor($player->getX());
            $y = floor($player->getY());
            $z = floor($player->getZ());
            $name = $player->getName();
            $gm = $player->getGamemode();
            switch ($gm) {
                case 0:
                    $gm = "サバイバル";
                break;
                case 1:
                    $gm = "クリエイティブ";
                break;
                case 2:
                    $gm = "アドベンチャー";
                break;
                case 3:
                    $gm = "スペクテイター";
                break;
            }
            $world = $player->getLevel()->getFolderName();
            $money = EconomyAPI::getInstance()->myMoney($player);
            $players = count($player->getServer()->getOnlinePlayers());
            $maxplayers = $player->getServer()->getMaxPlayers();
            $item = $player->getInventory()->getItemInHand();
            $id = $item->getId();
            $meta = $item->getDamage();
            $itemname = $item->getName();
            $time = date("G時i分s秒");
            $date = date("Y/m/d");
            
            switch ($player->getDirection()) {
                case 0:
                    $dire = "東";
                break;

                case 1:
                    $dire = "北";
                break;

                case 2:
                    $dire = "西";
                break;

                case 3:
                    $dire = "南";
                break;
            }
            $player->sendTip(
                "
                                                                                       §l§a【{$name}さんのステータス】§r
                                                                                       §e座標: [x:{$x}] [y:{$y}] [z:{$z}] 方角: {$dire}
                                                                                       §b人数: {$players} / {$maxplayers} 人 ワールド: {$world}
                                                                                       §d所持金: {$money}  Ping: {$ping}
                                                                                       §5ゲームモード: {$gm}
                                                                                       §6現在時刻: {$date} {$time}
                                                                                       §8アイテム名: §e{$itemname}:{$id}:{$meta}
            ");
        }
    }
}
