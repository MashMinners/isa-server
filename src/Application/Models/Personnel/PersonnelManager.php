<?php

declare(strict_types=1);

namespace Application\Models\Personnel;

use Engine\Database\IConnector;

class PersonnelManager
{
    public function __construct(IConnector $connector){
        $this->pdo = $connector::connect();
    }

    public function get(string $search) : CounterpartiesCollection{
        $query = ("SELECT * FROM isa_personnel 
                   WHERE counterparties.counterparty_name LIKE '%$search%'");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $collection = new CounterpartiesCollection();
        foreach ($results as $result){
            $collection->add(new Counterparty($result));
        }
        return $collection;
    }

}