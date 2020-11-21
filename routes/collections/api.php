<?php

/**
 * 
 * API Routes
 */

router()->get("/api/auth/checkusername", array("controller" => "Auth\AuthController::checkUsername", "name" => "api.auth.checkusername"));
