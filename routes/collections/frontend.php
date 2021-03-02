<?php

/**
 * 
 * Front-End Routes
 */

use MasterStudents\Core\Request;

router()->get("/", array("controller" => "PagesController::index", "name" => "home"));
router()->get("/about", array("controller" => "PagesController::about", "name" => "about"));

router()->get("/contact", array("controller" => "ContactController::index", "name" => "contact.index"));
router()->post("/contact", array("controller" => "ContactController::send", "name" => "contact.send"));

router()->get("/server", array(
    "controller" => function (Request $request) {
        var_dump(server());
    },
    "name" => "server"
));

router()->get("/env", array(
    "controller" => function (Request $request) {
        var_dump(env());
    },
    "name" => "server"
));

router()->get("groups/{group_id}/invite/accept/{token}", array("controller" => "Frontend\GroupsController::inviteAccept", "name" => "groups.invite.accept"));
router()->get("groups/{group_id}/invite/decline/{token}", array("controller" => "Frontend\GroupsController::inviteDecline", "name" => "groups.invite.decline"));