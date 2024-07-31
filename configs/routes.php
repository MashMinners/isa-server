<?php
//IS
$this->get('/is/list', '\Application\Controllers\ISController::list');
$this->get('/is/add', '\Application\Controllers\ISController::add');

$this->get('/', '\Application\LaunchApprover::approve');
$this->post('/', '\Application\Collector\Controllers\CollectorController::vote');