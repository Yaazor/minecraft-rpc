<?php

namespace Yazor\MinecraftProtocol\Data\Type;

class MinecraftPlayer
{
    public ?string $id;
    public ?string $name;

    public function __construct()
    {
    }

    public static function fromUsername(string $username): MinecraftPlayer {
        $player = new MinecraftPlayer();
        $player->name = $username;
        return $player;
    }

    public static function fromUuid(string $uuid): MinecraftPlayer {
        $player = new MinecraftPlayer();
        $player->id = $uuid;
        return $player;
    }

}