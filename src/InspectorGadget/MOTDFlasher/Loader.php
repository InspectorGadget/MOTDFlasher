<?php
/**
 * Created by PhpStorm.
 * User: RTG
 * Date: 2/14/2019
 * Time: 10:48 AM
 *
 * .___   ________
 * |   | /  _____/
 * |   |/   \  ___
 * |   |\    \_\  \
 * |___| \______  /
 *              \/
 *
 *1 * All rights reserved InspectorGadget (c) 2019
 */

namespace InspectorGadget\MOTDFlasher;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\TextFormat as TF;

class Loader extends PluginBase {

    public function onEnable(): void { }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        switch(strtolower($command->getName())) {
            case "mtd":
                if (!$sender->isOp() || !$sender->hasPermission("motd.flasher")) {
                    $sender->sendMessage(TF::RED . "You have no permission to use this command!");
                    return true;
                }

                if (!isset($args[0])) {
                    $sender->sendMessage(TF::GREEN . "Usage: /mtd help");
                    return true;
                }

                switch(strtolower($args[0])) {
                    case "help":
                        $messages = array(
                          "/mtd flash",
                        );

                        foreach ($messages as $message) {
                            $sender->sendMessage($message);
                        }
                        return true;
                    break;

                    case "flash":
                        if (!isset($args[1])) {
                            $messages = array(
                                "/mtd flash (motd)",
                                "NOTE: Colours will be auto-translated.",
                                "Available Colours: ",
                                "- {RED}",
                                "- {PURPLE}",
                                "- {DARK_GREEN}",
                                "- {AQUA}",
                                "- {DARK_AQUA}",
                                "- {DARK_RED}",
                                "- {GOLD}",
                                "- {GRAY}",
                                "- {GREEN}",
                                "- {YELLOW}",
                                "- {WHITE}",
                                "- {ITALIC}",
                                "- {RESET}",
                            );

                            foreach ($messages as $message) {
                                $sender->sendMessage($message);
                            }
                            return true;
                        }

                        $motd = implode(" ", array_slice($args, 1));
                        $this->getServer()->getNetwork()->setName($this->translateColours($motd));
                        $sender->sendMessage("[MOTDFlasher] Your MOTD has been flashed to: {$this->translateColours($motd)}");
                        return true;
                    break;
                }
                return true;
            break;
        }
    }

    public function translateColours($message) {
        $message = str_replace("{RED}", TF::RED, $message);
        $message = str_replace("{PURPLE}", TF::DARK_PURPLE, $message);
        $message = str_replace("{DARK_GREEN}", TF::DARK_GREEN, $message);
        $message = str_replace("{AQUA}", TF::AQUA, $message);
        $message = str_replace("{DARK_AQUA}", TF::DARK_AQUA, $message);
        $message = str_replace("{DARK_RED}", TF::DARK_RED, $message);
        $message = str_replace("{GOLD}", TF::GOLD, $message);
        $message = str_replace("{GRAY}", TF::GRAY, $message);
        $message = str_replace("{GREEN}", TF::GREEN, $message);
        $message = str_replace("{YELLOW}", TF::YELLOW, $message);
        $message = str_replace("{WHITE}", TF::WHITE, $message);
        $message = str_replace("{ITALIC}", TF::ITALIC, $message);
        $message = str_replace("{RESET}", TF::RESET, $message);

        return $message;
    }

    public function onDisable(): void { }

}