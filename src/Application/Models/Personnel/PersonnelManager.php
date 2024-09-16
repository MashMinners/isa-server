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

    private function validatePersonnel(Personnel $personnel) : bool {
        if(!preg_match("/^[А-Яа-яЁё]+$/u", $personnel->personnelSurname)){return false;}
        if(!preg_match("/^[А-Яа-яЁё]+$/u", $personnel->personnelFirstname)){return false;}
        if(!preg_match("/^[А-Яа-яЁё]+$/u", $personnel->personnelSecondname)){return false;}
        if(!preg_match("/\d{3}-\d{3}-\d{3} \d{2}$/", $personnel->personnelInsuranceIndividualNumber)) {return false;}
        return true;
    }

    private function checkPersonnelForDuplicate(Personnel $personnel) : bool {
        $query = ("SELECT personnel_id FROM isa_personnel WHERE personnel_insurance_individual_number = :personnelInsuranceIndividualNumber");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['personnelInsuranceIndividualNumber' => $personnel->personnelInsuranceIndividualNumber]);
        return $stmt->rowCount()>0 ? true : false;
    }

    public function insert (Personnel $personnel) {
       if (!$this->validatePersonnel($personnel)) {return false;}
       if ($this->checkPersonnelForDuplicate($personnel)) {return false;}
       $query = ("INSERT INTO isa_personnel (personnel_id, personnel_surname, personnel_firstname, personnel_secondname, personnel_position, personnel_insurance_individual_number)
                VALUES (:personnelId, :personnelSurname, :personnelFirstname, :personnelSecondname, :personnelPosition, :personnelInsuranceIndividualNumber)");
       $stmt = $this->pdo->prepare($query);
       $stmt->execute([
           'personnelId'=>$personnelId = Uuid::uuid4()->toString(),
           'personnelSurname'=>$personnel->personnelSurname,
           'personnelFirstname'=>$personnel->personnelFirstname,
           'personnelSecondname'=>$personnel->personnelSecondname,
           'personnelPosition'=>$personnel->personnelPosition,
           'personnelInsuranceIndividualNumber' => $personnel->personnelInsuranceIndividualNumber
       ]);
       return $personnelId;
    }

    public function delete(array $IDs) : bool {

    }

}