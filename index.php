<?php
include_once "./lib/Route.php";
include_once "./lib/SqliteManager.php";

$route = new Route();
$route->add("/", "./controller/HomeBox.php");
$route->add("/user", "./controller/UserBox.php");
$route->add("/user/{id}", "./controller/UserBox.php");
$route->add("/maison", "./controller/MaisonBox.php");
$route->add("/maison/{id}", "./controller/MaisonBox.php");
$route->notFound("./controller/Controller404.php");
