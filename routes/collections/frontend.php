<?php

/**
 * 
 * Front-End Routes
 */
router()->get("/", array("controller" => "PagesController::index", "name" => "home"));
router()->get("/about", array("controller" => "PagesController::about", "name" => "about"));

router()->get("/contact", array("controller" => "ContactController::index", "name" => "contact.index"));
router()->post("/contact", array("controller" => "ContactController::send", "name" => "contact.send"));

router()->get("/server", array(
    "controller" => function ($request) {
        var_dump(server());
    },
    "name" => "server"
));
