<?php

declare(strict_types=1);

namespace Application\Models\InformationSystems;

use Application\Models\InformationSystems\Collections\ISCollection;
use Application\Models\InformationSystems\Collections\IsPersonnelCollection;
use Application\Models\InformationSystems\DTO\IS;
use Application\Models\InformationSystems\DTO\IsPersonnelPack;
use Application\Models\Personnel\DTO\Personnel;
use Engine\Database\IConnector;
use Ramsey\Uuid\Uuid;

class ISManager
{
    public function __construct(IConnector $connector){
        $this->pdo = $connector::connect();
    }
    public function list(){
        $query = ("SELECT * FROM isa_information_systems");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $collection = new ISCollection();
        foreach ($results as $result){
            $collection->add(new IS($result));
        }
        return $collection;
    }

    public function getPersonnelByISId(string $isId){
        $query = ("SELECT ip.personnel_id, ip.personnel_surname, ip.personnel_firstname, ip.personnel_secondname, ip.personnel_position
                   FROM isa_personnel ip
                   INNER JOIN isa_information_systems_personnel iisp ON ip.personnel_id = iisp.personnel_id                   
                   WHERE (iisp.information_system_id = :isId)");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'isId' => $isId
        ]);
        $results = $stmt->fetchAll();
        $collection = new IsPersonnelCollection();
        foreach ($results as $result){
            $collection->add(new Personnel($result));
        }
        return $collection;
    }
    public function insertSystem(IS $is){
        $query = ("INSERT INTO isa_information_systems (information_system_id, information_system_name, information_system_link, is_secured, information_system_image)
                   VALUES (:informationSystemId, :informationSystemName, :informationSystemLink, :isSecured, :informationSystemImage)");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'informationSystemId'=>$informationSystemId = Uuid::uuid4()->toString(),
            'informationSystemName'=>$is->informationSystemName,
            'informationSystemLink'=>$is->informationSystemLink,
            'isSecured'=>$is->isSecured,
            'informationSystemImage'=>$is->informationSystemImage,
        ]);
        return $informationSystemId;
    }
    public function insertSystems(ISCollection $collection){
        $query = ("INSERT INTO isa_information_systems (information_system_id, information_system_name, information_system_link, is_secured, information_system_image)
                   VALUES ");
        $query .= '(';
        foreach ($collection->list()() as $item){
            $item['informationSystemId'] = Uuid::uuid4()->toString();
            $query .= $item;
        }
        $query .= ')';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }
    public function insertPersonnel(IsPersonnelPack $pack){
        $query = ("INSERT INTO isa_information_systems_personel (isp_id, personnel_id, information_system_id)
                   VALUES (:ispId, :personnelId, :informationSystemId)");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'ispId'=>$informationSystemId = Uuid::uuid4()->toString(),
            'personnelId'=>$pack->personnelId,
            'informationSystemId'=>$pack->informationSystemId
        ]);
        return $informationSystemId;
    }



}