<?php

declare(strict_types=1);

namespace Application\Models\InformationSystems\Collections;

use Application\Models\InformationSystems\DTO\IS;

class ISCollection implements \JsonSerializable
{
    private array $informationSystems;

    public function list(){
        return $this->informationSystems;
    }

    public function add(IS $is){
        $this->informationSystems[] = $is;
    }

    public function remove(){

    }

    public function jsonSerialize() : mixed {
        $properties = get_object_vars($this);
        return $properties;
    }

}