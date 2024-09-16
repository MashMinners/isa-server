<?php

declare(strict_types=1);

namespace Application\Controllers;

use Application\Models\Personnel\DTO\Personnel;
use Application\Models\Personnel\PersonnelManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PersonnelController
{
    public function __construct(private PersonnelManager $manager){

    }

    public function create(ServerRequestInterface $request) : ResponseInterface {
        $json = file_get_contents('php://input');
        $personnelId = $this->manager->insert(new Personnel($json));
        $response = (new JsonResponse($personnelId));
        return $response;
    }

    public function addIS(ServerRequestInterface $request) : ResponseInterface {

    }

    public function delete(ServerRequestInterface $request) : ResponseInterface {
        $IDs = file_get_contents('php://input');
        $this->manager->delete($IDs);
    }

}