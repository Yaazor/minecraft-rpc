<?php

namespace Yazor\MinecraftProtocol\Management\Method;

use Yazor\MinecraftProtocol\Data\ResourceLocation;
use Yazor\MinecraftProtocol\Data\Type\MinecraftPlayer;
use Yazor\MinecraftProtocol\Data\Type\ServerState;

/**
 * @template TInput
 * @template TOutput
 */
class ServerMethod
{
    /**
     * @var ServerMethod<MinecraftPlayer, ServerState>
     */
    public static ServerMethod $ALLOWLIST;


    public static ServerMethod $SERVER;

    private array $paths = [];

    private function __construct(public readonly ResourceLocation $resourceLocation, private(set) ?string $inputClassName, private(set) ?string $outputClassName, private(set) bool $receives_array =  false)
    {

    }

    /**
     * @param class-string<TOutput>|null $outputClassName
     * @param class-string<TInput>|null $inputClassName
     * @return self<TInput, TOutput>
     */
    public static function create(ResourceLocation $resourceLocation, ?string $inputClassName = null, ?string $outputClassName = null, bool $receives_array = false): object {
        return new self($resourceLocation, $inputClassName, $outputClassName, $receives_array);
    }

    /**
     * @return MinecraftRequest<TInput, TOutput>
     */
    public function createRequest(): MinecraftRequest {
        return new MinecraftRequest($this);
    }

    /**
     * @template TI
     * @template TO
     * @param string $path
     * @param class-string<TI>|null $inputClassName
     * @param class-string<TO>|null $outputClassName
     * @param bool $takes_array
     * @param bool $receives_array
     * @return self<TI, TO>
     */
    public function withPath(string $path, ?string $inputClassName = null, ?string $outputClassName = null, bool $takes_array = false, bool $receives_array = false): object {
        $location = $this->resourceLocation->withParam($path);
        $method = new self($location, $inputClassName, $outputClassName, $takes_array);
        $this->paths[$path] = $method;
        return $this;
    }

    public function getPath(string $path): ?ServerMethod {
        return $this->paths[$path] ?? null;
    }

    public static function initiate(): void
    {
        self::$ALLOWLIST = self::create(
            ResourceLocation::read("minecraft:allowlist"),
            null,
            MinecraftPlayer::class, true
        );

        self::$ALLOWLIST
            ->withPath("/set", MinecraftPlayer::class, MinecraftPlayer::class, true, true)
            ->withPath("/add", MinecraftPlayer::class, MinecraftPlayer::class, true, true)
            ->withPath("/remove", MinecraftPlayer::class, MinecraftPlayer::class, true, true)
            ->withPath("/clear", null, MinecraftPlayer::class, false, true);

        self::$SERVER = self::create(ResourceLocation::read("minecraft:server"))
            ->withPath('/status', null, ServerState::class)
            ->withPath('/stop');

    }

}