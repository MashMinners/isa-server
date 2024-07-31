<?php

namespace Application\Controllers;

use Application\Models\InformationSystems\IS;
use Application\Models\InformationSystems\ISManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ISController
{
    public function __construct(private ISManager $manager){

    }

    public function list(ServerRequestInterface $request) : ResponseInterface {
        $collection = $this->manager->list();
        return (new JsonResponse($collection));
    }

    public function add(ServerRequestInterface $request) : ResponseInterface {

    }


}