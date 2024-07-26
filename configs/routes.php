<?php
//Collector
$this->get('/', '\Application\LaunchApprover::approve');
$this->post('/', '\Application\Collector\Controllers\CollectorController::vote');