<?php

declare(strict_types=1);

namespace Application\Models\Personnel;

use Application\Models\Personnel\DTO\Personnel;
use Application\Models\Personnel\DTO\PersonnelISA;
use Engine\Database\IConnector;
use Engine\Utilities\StringFormatter;
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

    /**
     * Создание 1-го пользователя
     * @param Personnel $personnel
     * @return false|string
     */
    public function insertPersonnel (Personnel $personnel) {
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

    public function insertPersonnelStack (array $personnel) {
        //Добавить сразу несколько пользователей
    }

    public function insertISA(PersonnelISA $personnelISA){
        $query = ("INSERT INTO isa_information_systems_personnel (isp_id, personnel_id, information_system_id)
                VALUES ");
        foreach ($personnelISA->isaList as $key => $value){
            $uuid = StringFormatter::wrapInQuotes(Uuid::uuid4()->toString());
            $personnelId = StringFormatter::wrapInQuotes($personnelISA->personnelId);
            $informationSystemId = StringFormatter::wrapInQuotes($value);
            $query .= "(";
            $query .= $uuid.", $personnelId, $informationSystemId";
            $query .= "),";
        }
        $query =  mb_substr($query, 0, -1);
        //return $query;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return true;
    }

    public function delete(array $IDs) : bool {

    }

}