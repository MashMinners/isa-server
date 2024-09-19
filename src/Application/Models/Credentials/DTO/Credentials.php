<?php

namespace Application\Models\Credentials\DTO;

use Engine\DTO\BaseDTO;

class Credentials extends BaseDTO implements \JsonSerializable
{
    protected string|null $credentialsId;
    protected string|null $userName;

    protected string|null $password;

    protected string|null $informationSystemId;
    protected string|null $personnelId;

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