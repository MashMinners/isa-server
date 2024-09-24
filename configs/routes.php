<?php
//IS
$this->get('/is/list', '\Application\Controllers\ISController::list');
$this->get('/is/personnel/{id}', '\Application\Controllers\ISController::personnel');
$this->post('/is/add/system', '\Application\Controllers\ISController::addSystem');
$this->post('/is/add/personnel', '\Application\Controllers\ISController::addPersonnel');
//Personnel
$this->get('/personnel/list', '\Application\Controllers\PersonnelController::list');
//$this->get('/personnel/is/{id}', '\Application\Controllers\PersonnelController::ISs');
$this->post('/personnel/add', '\Application\Controllers\PersonnelController::create');
$this->delete('/personnel/delete', '\Application\Controllers\PersonnelController::delete');
//$this->post('/personnel/add/systems', '\Application\Controllers\PersonnelController::addISA');
//$this->post('/personnel/remove/systems', '\Application\Controllers\PersonnelController::removeISA');
//Credentials
$this->get('/credentials/get/byIS/{id}', '\Application\Controllers\CredentialsController::getByIS');
$this->get('/credentials/get/byPersonnel/{id}', '\Application\Controllers\CredentialsController::getByPersonnel');
$this->post('/credentials/create', '\Application\Controllers\CredentialsController::create');
$this->delete('/credentials/delete', '\Application\Controllers\CredentialsController::delete');