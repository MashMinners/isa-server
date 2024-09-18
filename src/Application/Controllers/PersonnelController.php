<?php

declare(strict_types=1);

namespace Application\Controllers;

use Application\Models\Personnel\DTO\Personnel;
use Application\Models\Personnel\DTO\PersonnelISA;
use Application\Models\Personnel\PersonnelManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PersonnelController
{
    public function __construct(private PersonnelManager $manager){

    }

    public function list(ServerRequestInterface $request) : ResponseInterface {
        //Выводит список всех сотрудников
        $list = $this->manager->list();
        $response = (new JsonResponse($list));
        return $response;
    }

    public function ISs(ServerRequestInterface $request) : ResponseInterface {
        $id = $request->getAttributes()['id'];
        $collection = $this->manager->getISsByPersonnelId($id);
        return (new JsonResponse($collection));
    }

    public function create(ServerRequestInterface $request) : ResponseInterface {
        $json = file_get_contents('php://input');
        $personnelId = $this->manager->insertPersonnel(new Personnel($json));
        $response = (new JsonResponse($personnelId));
        return $response;
    }

    public function delete(ServerRequestInterface $request) : ResponseInterface {
        $IDs = file_get_contents('php://input');
        $result = $this->manager->deletePersonnel($IDs);
        $response = new JsonResponse($result);
        return $response;
    }

    public function addISA(ServerRequestInterface $request) : ResponseInterface {
        $json = file_get_contents('php://input');
        $result = $this->manager->addISA(new PersonnelISA($json));
        $response = new JsonResponse($result);
        return $response;
    }

    public function removeISA(ServerRequestInterface $request) : ResponseInterface {
        $IDs = file_get_contents('php://input');
        $result = $this->manager->removeISA($IDs);
        $response = new JsonResponse($result);
        return $response;
    }

}