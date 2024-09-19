<?php

declare(strict_types=1);

namespace Application\Controllers;

use Application\Models\InformationSystems\DTO\IS;
use Application\Models\InformationSystems\DTO\IsPersonnelPack;
use Application\Models\InformationSystems\ISManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ISController
{
    public function __construct(private ISManager $manager){

    }

    /**
     * Показать список всех информационных систем
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function listIS(ServerRequestInterface $request) : ResponseInterface {
        $collection = $this->manager->list();
        return (new JsonResponse($collection));
    }

    /**
     * Показать всех пользователей выбраной информационной системы
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function listPersonnel(ServerRequestInterface $request) : ResponseInterface {
        $id = $request->getAttributes()['id'];
        $collection = $this->manager->getPersonnelByISId($id);
        return (new JsonResponse($collection));
    }

    public function createIS(ServerRequestInterface $request) : ResponseInterface {
        $json = file_get_contents('php://input');
        $isId = $this->manager->insertSystem(new IS($json));
        $response = (new JsonResponse($isId));
        return $response;
    }

    public function deleteIS(ServerRequestInterface $request) : ResponseInterface {

    }

    public function addPersonnel(ServerRequestInterface $request) : ResponseInterface {
        $json = file_get_contents('php://input');
        $isId = $this->manager->insertPersonnel(new IsPersonnelPack($json));
        $response = (new JsonResponse($isId));
        return $response;
    }

    public function removePersonnel(ServerRequestInterface $request) : ResponseInterface {

    }


}