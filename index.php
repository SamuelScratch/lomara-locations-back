<?php
include_once "./lib/Route.php";
include_once "./lib/SqliteManager.php";

header("Access-Control-Allow-Origin: *");
$route = new Route();
$route->add("/user", "./controller/UserBox.php");
$route->add("/user/{id}", "./controller/UserBox.php");
$route->add("/biens", "./controller/MaisonBox.php");
$route->add("/biens/{id}", "./controller/MaisonBox.php");
$route->add("/admin/{id}", "./controller/AdminBox.php");
$route->add("/admin", "./controller/AdminBox.php");
$route->notFound("./public/index.html");
