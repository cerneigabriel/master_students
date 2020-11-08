<?php

// Errors handlers
$app->router->get("/404", array("controller" => "ErrorsController::handle404", "name" => "error.404"));
