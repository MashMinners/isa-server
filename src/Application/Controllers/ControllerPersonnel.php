<?php

declare(strict_types=1);

namespace Application\Controllers;

use Application\Models\Personnel\PersonnelManager;

class ControllerPersonnel
{
    public function __construct(private PersonnelManager $manager){

    }

}