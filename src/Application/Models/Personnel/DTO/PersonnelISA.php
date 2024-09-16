<?php

namespace Application\Models\Personnel\DTO;

use Engine\DTO\BaseDTO;

class PersonnelISA extends BaseDTO implements \JsonSerializable
{
    protected string|null $personnelId;
    protected array $isaList = [];

    public function __construct(array|string $data){
        $properties = get_class_vars(self::class);
        foreach ($properties as $name => $value){
            $this->$name = $value;
        }
        $this->init($data);
    }

    public function __get(string $name) : string|int|array|null {
        return $this->$name;
    }

    public function jsonSerialize(): mixed
    {
        $properties = get_object_vars($this);
        return $properties;
    }
}