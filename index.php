<?php
include_once "./lib/Route.php";
include_once "./lib/SqliteManager.php";

header("Access-Control-Allow-Origin: *");
$route = new Route();
$route->add("/user", "./controller/UserBox.php");
$route->add("/user/{id}", "./controller/UserBox.php");
$route->add("/biens", "./controller/MaisonBox.php");
$route->add("/biens/{id}", "./controller/MaisonBox.php");
$route->add("/equipements/{maison_id}", "./controller/EquipementApiBox.php");

session_start();
if (isset($_SESSION["user_id"])){
    $route->add("/admin/{id}", "./controller/AdminBox.php");
    $route->add("/admin/{maison_id}/image", "./controller/ImageBox.php");
    $route->add("/admin/{maison_id}/equipement", "./controller/EquipementBox.php");
    $route->add("/admin/{maison_id}/image/{image_id}", "./controller/ImageBox.php");
    $route->add("/admin", "./controller/AdminBox.php");
}
else {
    $route->add("/admin", "./controller/LoginBox.php");
    $route->add("/login", "./controller/LoginBox.php");
}
$route->add("/logout", "./controller/LogoutBox.php");

$route->notFound("./public/index.html");
