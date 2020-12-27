<?php

/**
 * 
 * Web Routes
 */


// Api Routes
require_once ROUTES_PATH . "collections/api.php";

// Auth Routes
require_once ROUTES_PATH . "collections/auth.php";

// Errors Handlers Routes
require_once ROUTES_PATH . "collections/errors.php";

// Front-End Routes
require_once ROUTES_PATH . "collections/frontend.php";


// Admin Routes
require_once ROUTES_PATH . "collections/admin/index.php";

// Teacher Routes
require_once ROUTES_PATH . "collections/teacher/index.php";

// Student Routes
require_once ROUTES_PATH . "collections/student/index.php";
