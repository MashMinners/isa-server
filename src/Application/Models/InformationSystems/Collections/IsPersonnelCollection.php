<?php

namespace Application\Models\InformationSystems\Collections;

use Application\Models\InformationSystems\DTO\IS;
use Application\Models\Personnel\DTO\Personnel;

class IsPersonnelCollection implements \JsonSerializable
{
    private array $personnel;

    public function list(){
        return $this->personnel;
    }

    public function add(Personnel $personnel){
        $this->personnel[] = $personnel;
    }

    public function remove(){

    }

    public function jsonSerialize() : mixed {
        $properties = get_object_vars($this);
        return $properties;
    }

}