<?php

namespace Application\Controllers;

use Application\Models\Credentials\CredentialsManager;
use Application\Models\Credentials\DTO\Credentials;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CredentialsController
{
    public function __construct(private CredentialsManager $manager)
    {

    }

    public function getByIS(ServerRequestInterface $request) : ResponseInterface {
        //$data = $request->getQueryParams();//file_get_contents('php://input');
        $id = $request->getAttributes()['id'];
        $collection = $this->manager->getByIS($id);
        return new JsonResponse($collection);
    }

    public function getByPersonnel(ServerRequestInterface $request) : ResponseInterface {
        $id = $request->getAttributes()['id'];
        $collection = $this->manager->getByPersonnel($id);
        return new JsonResponse($collection);
    }

    public function create(ServerRequestInterface $request) : ResponseInterface {
        $json = file_get_contents('php://input');
        $personnelId = $this->manager->insert(new Credentials($json));
        $response = (new JsonResponse($personnelId));
        return $response;
    }

    public function update(ServerRequestInterface $request) : ResponseInterface {}


    public function delete(ServerRequestInterface $request) : ResponseInterface {
        $IDs = file_get_contents('php://input');
        $result = $this->manager->delete($IDs);
        $response = new JsonResponse($result);
        return $response;
    }

}