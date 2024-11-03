<?php

$router = new Router();

$uri = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];

$router->get("/", ["IndexGetController", "Dashboard"]);

require "auth.php";
require "users.php";
require "categories.php";

$router->route($uri, $method);