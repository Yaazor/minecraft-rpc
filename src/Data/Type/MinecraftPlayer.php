<?php

namespace Yazor\MinecraftProtocol\Data\Type;

readonly class MinecraftPlayer
{
    public function __construct(private(set) ?string $id, private(set) ?string $name)
    {
    }

    public static function fromUsername(string $username): MinecraftPlayer {
        return new MinecraftPlayer(null, $username);
    }

    public static function fromUuid(string $uuid): MinecraftPlayer {
        return new MinecraftPlayer($uuid, null);
    }

    public function __serialize(): array
    {
        $data = [];
        if($this->id !== null) $data['id'] = $this->id;
        if($this->name !== null) $data['name'] = $this->name;
        return $data;
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }
}