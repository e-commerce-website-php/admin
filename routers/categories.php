<?php

$router->get("/categories", ["CategoryGetController", "GetItems"]);
$router->get("/categories/create", ["CategoryGetController", "Create"]);

$router->post("/categories/create", ["CategoryPostController", "Create"]);