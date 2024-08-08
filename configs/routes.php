<?php
//IS
$this->get('/is/list', '\Application\Controllers\ISController::list');
$this->get('/is/personnel/{id}', '\Application\Controllers\ISController::personnel');
$this->post('/is/add/system', '\Application\Controllers\ISController::addSystem');
$this->post('/is/add/personnel', '\Application\Controllers\ISController::addPersonnel');
//Personnel
$this->post('/personnel/add', '\Application\Controllers\PersonnelController::create');
