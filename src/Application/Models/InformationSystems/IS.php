<?php

declare(strict_types=1);

namespace Application\Models\InformationSystems;

use Engine\DTO\BaseDTO;

class IS extends BaseDTO implements \JsonSerializable
{
    protected string|null $informationSystemId;
    protected string|null $informationSystemName;
    protected string|null $informationSystemLink;
    protected int|null $isSecured;
    protected string|null $informationSystemImage;

    public function __construct(array|string $data){
        $properties = get_class_vars(self::class);
        foreach ($properties as $name => $value){
            $this->$name = $value;
        }
        $this->init($data);
    }

    public function __get(string $name) : string|int|null {
        return $this->$name;
    }

    public function jsonSerialize() : mixed {
        $properties = get_object_vars($this);
        return $properties;
    }


}