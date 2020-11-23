<?php

// Errors handlers
router()->get("frontend/error/{code}", array("controller" => "ErrorsController::handle", "name" => "error"));
