<?php

declare(strict_types=1);

namespace Application\Models\Personnel\DTO;

use Engine\DTO\BaseDTO;

class Personnel extends BaseDTO implements \JsonSerializable
{
    protected string|null $personnelId;
    protected string|null $personnelSurname;
    protected string|null $personnelFirstname;
    protected string|null $personnelSecondname;
    protected string|null $personnelPosition;
    protected string|null $personnelInsuranceIndividualNumber;

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