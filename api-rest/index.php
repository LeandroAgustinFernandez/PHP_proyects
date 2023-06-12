<?php 
require_once 'config/config.php';
require_once 'controller/router.controller.php';
require_once 'controller/courses.controller.php';
require_once 'controller/clients.controller.php';
require_once 'models/clients.models.php';
require_once 'models/courses.models.php';

$routes = new RouterController();
$routes->index();

?>