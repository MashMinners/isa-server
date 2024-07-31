<?php

declare(strict_types=1);

namespace Application\Models\InformationSystems;

use Engine\Database\IConnector;
use Ramsey\Uuid\Uuid;

class ISManager
{
    public function __construct(IConnector $connector){
        $this->pdo = $connector::connect();
    }

    /**
     * Вывести список всех информационных систем
     * @return ISCollection
     */
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

    /**
     * Добавить одну запись в БД
     * @param IS $is
     * @return string
     */
    public function insert(IS $is){
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

    public function insertGroup(ISCollection $collection){
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

}