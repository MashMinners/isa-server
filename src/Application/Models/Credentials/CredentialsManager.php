<?php

namespace Application\Models\Credentials;

use Application\Models\Credentials\DTO\Credentials;
use Engine\Database\IConnector;
use Engine\Utilities\StringFormatter;
use Ramsey\Uuid\Uuid;

class CredentialsManager
{
    public function __construct(IConnector $connector){
        $this->pdo = $connector::connect();
    }

    public function getByIS(string $isID){
        $query = ("SELECT * FROM isa_credentials WHERE information_system_id = :isID");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['isID' => $isID]);
        $results = $stmt->fetchAll();
        return $results;
    }

    public function getByPersonnel(string $personnelID){
        $query = ("SELECT * 
                   FROM isa_credentials
                   INNER JOIN isa.isa_information_systems iis on isa_credentials.information_system_id = iis.information_system_id
                   WHERE personnel_id = :personnelID");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['personnelID' => $personnelID]);
        $results = $stmt->fetchAll();
        return $results;
    }

    public function insert(Credentials $credentials) {
        $query = ("INSERT INTO isa_credentials (credential_id, user_name, password, information_system_id, personnel_id) 
                   VALUES (:credentialsId, :userName, :password, :informationSystemId, :personnelId)");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'credentialsId'=>$credentialsId = Uuid::uuid4()->toString(),
            'userName' => $credentials->userName,
            'password' => $credentials->password,
            'informationSystemId' => $credentials->informationSystemId,
            'personnelId' => $credentials->personnelId
        ]);
        return $credentialsId;
    }

    public function delete(string $IDs) : bool {
        $IDs = json_decode($IDs);
        $query = ("DELETE FROM isa_credentials WHERE credential_id IN");
        $query .= "(";
        foreach ($IDs->credentials as $key => $value){
            $query .= StringFormatter::wrapInQuotes($value)." ,";
        }
        $query =  mb_substr($query, 0, -1);
        $query .= ")";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return true;
    }

}