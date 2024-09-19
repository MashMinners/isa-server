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
        foreach ($IDs->personnelId as $key => $value){
            $query .= StringFormatter::wrapInQuotes($value)." ,";
        }
        $query =  mb_substr($query, 0, -1);
        $query .= ")";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return true;
    }

}