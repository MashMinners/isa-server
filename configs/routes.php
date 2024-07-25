<?php
//Collector
$this->get('/', '\Application\Collector\Controllers\CollectorController::show');
$this->post('/', '\Application\Collector\Controllers\CollectorController::vote');