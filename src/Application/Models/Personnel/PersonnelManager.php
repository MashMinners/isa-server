<?php

declare(strict_types=1);

namespace Application\Models\Personnel;

use Application\Models\Personnel\Collections\PersonnelCollection;
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

    /**
     * Валидация объекта сотрудника на то, что он корректно заполнен и соответсвует требованиям
     * @param Personnel $personnel
     * @return bool
     */
    private function validatePersonnel(Personnel $personnel) : bool {
        if(!preg_match("/^[А-Яа-яЁё]+$/u", $personnel->personnelSurname)){return false;}
        if(!preg_match("/^[А-Яа-яЁё]+$/u", $personnel->personnelFirstname)){return false;}
        if(!preg_match("/^[А-Яа-яЁё]+$/u", $personnel->personnelSecondname)){return false;}
        if(!preg_match("/\d{3}-\d{3}-\d{3} \d{2}$/", $personnel->personnelInsuranceIndividualNumber)) {return false;}
        return true;
    }

    /**
     * Поиск наличия дубликатов в БД по конкретному сотруднику
     * @param Personnel $personnel
     * @return bool
     */
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

    /**
     * Удаление сотрудников из системы
     * @param string $IDs
     * @return bool
     */
    public function deletePersonnel(string $IDs) : bool {
        $IDs = json_decode($IDs);
        $query = ("DELETE FROM isa_personnel WHERE personnel_id IN");
        $query .= "(";
        foreach ($IDs->personnelId as $key => $value){
            $query .= StringFormatter::wrapInQuotes($value)." ,";
        }
        $query =  mb_substr($query, 0, -1);
        $query .= ")";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return true;
    }

    public function insertPersonnelStack (PersonnelCollection $collection) {

    }

    /**
     * Добавление пользователю информационных систем, с которыми он работает
     * @param PersonnelISA $personnelISA
     * @return true
     */
    public function addISA(PersonnelISA $personnelISA){
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
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return true;
    }

    public function removeISA(string $IDs) : bool {
        $IDs = json_decode($IDs);
        $query = ("DELETE FROM isa_information_systems_personnel WHERE isp_id IN");
        $query .= "(";
        foreach ($IDs->ispId as $key => $value){
            $query .= StringFormatter::wrapInQuotes($value)." ,";
        }
        $query =  mb_substr($query, 0, -1);
        $query .= ")";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return true;
    }



}