<?php

namespace Application\Models\Personnel\Collections;

use Application\Models\Personnel\DTO\Personnel;

class PersonnelCollection implements \JsonSerializable
{
    private array $personnel = [];

    public function add(Personnel $personnel) {
        $this->personnel[] = $personnel;
    }

    public function remove(){

    }

    public function list(){
        return $this->personnel;
    }

    public function jsonSerialize(): mixed
    {
        $properties = get_object_vars($this);
        return $properties;
    }
}