<?php

namespace Yazor\MinecraftProtocol\Data\Type;

class ServerState
{
    /**
     * @var bool Whether the server is started or not
     */
    public bool $started;
    /**
     * @var ServerVersion The version that the server is in
     */
    public ServerVersion $version;
}