<?php

namespace Yazor\MinecraftProtocol\Data\Type\Text;

/**
 * Translatable text.
 */
class Translatable
{
    public function __construct(public string $translatable, public ?array $options = null)
    {
    }
}