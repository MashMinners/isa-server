<?php

declare(strict_types=1);

namespace Application\Models\Personnel;

use Application\Models\Personnel\DTO\Personnel;
use Engine\Database\IConnector;
use Ramsey\Uuid\Uuid;

class PersonnelManager
{
    public function __construct(IConnector $connector){
        $this->pdo = $connector::connect();
    }

    public function insert (Personnel $personnel) {
        $query = ("INSERT INTO isa_personnel (personnel_id, personnel_surname, personnel_firstname, personnel_secondname, personnel_position)
                   VALUES (:personnelId, :personnelSurname, :personnelFirstname, :personnelSecondname, :personnelPosition)");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'personnelId'=>$personnelId = Uuid::uuid4()->toString(),
            'personnelSurname'=>$personnel->personnelSurname,
            'personnelFirstname'=>$personnel->personnelFirstname,
            'personnelSecondname'=>$personnel->personnelSecondname,
            'personnelPosition'=>$personnel->personnelPosition,
        ]);
        return $personnelId;
    }

}