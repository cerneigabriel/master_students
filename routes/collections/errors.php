<?php

// Errors handlers
router()->get("/404", array("controller" => "ErrorsController::handle404", "name" => "error.404"));
router()->get("/500", array("controller" => "ErrorsController::handle500", "name" => "error.500"));
