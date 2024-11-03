<?php

$router->get("/categories", ["CategoryGetController", "GetItems"]);
$router->get("/categories/create", ["CategoryGetController", "Create"]);
$router->get("/categories/edit", ["CategoryGetController", "Edit"]);

$router->post("/categories/create", ["CategoryPostController", "Create"]);
$router->post("/categories/edit", ["CategoryPostController", "Edit"]);

$router->delete("/categories/delete", ["CategoryDeleteController", "Delete"]);