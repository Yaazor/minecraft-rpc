<?php

namespace Yazor\MinecraftProtocol\Management\Method;

use Symfony\Component\Serializer\Serializer;

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

    /**
     * @var TOuput|null
     */
    private $result = null;

    public function __construct(public readonly ServerMethod $method)
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
        if(!empty($this->input)) $data['params'] = [$this->input];

        return $data;
    }

    public function applyResult(mixed $result, Serializer $serializer): void {
        $unserializeClass = $this->method->outputClassName;

        if($this->method->receives_array) {
            $finalResult = [];
            foreach($result as $item) {
                $finalResult[] = $serializer->deserialize(json_encode($item), $unserializeClass, 'json');
            }
        }else{
            $finalResult = $serializer->deserialize(json_encode($result[0]), $unserializeClass, 'json');
        }

        $this->result = $finalResult;
    }

    /**
     * @return TOuput|null
     */
    public function result() {
        return $this->result;
    }

    private function unserializeItem(string $object, string $className): object {
        return unserialize(
            $object,
            [
                'allowed_classes' => [$className]
            ]
        );
    }
}