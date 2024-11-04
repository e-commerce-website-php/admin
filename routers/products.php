<?php

$router->get("/products", ["ProductGetController", "GetItems"]);
$router->get("/products/create", ["ProductGetController", "Create"]);
$router->get("/products/edit", ["ProductGetController", "Edit"]);

$router->post("/products/create", ["ProductPostController", "Create"]);
$router->post("/products/edit", ["ProductPostController", "Edit"]);

$router->delete("/products/delete", ["ProductDeleteController", "Delete"]);