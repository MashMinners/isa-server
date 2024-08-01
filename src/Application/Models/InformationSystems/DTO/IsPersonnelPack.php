<?php

declare(strict_types=1);

namespace Application\Models\InformationSystems\DTO;

use Engine\DTO\BaseDTO;

/**
 * DTO для передачи связки  ID персонала и связанной с ним информационной системы
 */
class IsPersonnelPack extends BaseDTO implements \JsonSerializable
{
    protected $personnelId;
    protected $isId;

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