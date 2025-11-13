<?php

namespace Yazor\MinecraftProtocol\Management\Method;

/**
 * @template TInput
 * @template TOuput
 */
class MinecraftRequest implements \JsonSerializable
{
    /**
     * @var TInput
     */
    private $input;

    public function __construct(private readonly ServerMethod $method)
    {
    }

    /**
     * @param TInput $input
     * @return $this
     */
    public function input($input): self {
        $this->input = $input;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $data = [
            'method' => $this->method->resourceLocation->__toString(),
            'id' => 1,
        ];
        if(!empty($this->input)) $data['params'] = $this->input;

        return $data;
    }
}