<?php

// Errors handlers
router()->get("/404", array("controller" => "ErrorsController::handle404", "name" => "error.404"));
